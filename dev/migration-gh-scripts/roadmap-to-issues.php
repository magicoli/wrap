<?php
/**
 * Convert ROADMAP.md to GitHub Issues
 * Usage: php scripts/roadmap-to-issues.php [PROJECT_NUMBER] [--dry-run]
 */

// Get command line arguments
$projectNumber = $argv[1] ?? null;
$dryRun = in_array('--dry-run', $argv);

if (!$projectNumber) {
    echo "Usage: php scripts/roadmap-to-issues.php PROJECT_NUMBER [--dry-run]\n";
    echo "Example: php scripts/roadmap-to-issues.php 1 --dry-run\n";
    echo "\nTo find your project number, run: gh project list\n";
    exit(1);
}

echo ($dryRun ? "DRY RUN - " : "") . "Converting ROADMAP.md to GitHub Issues...\n";
echo "Project Number: $projectNumber\n\n";

// Read and parse the roadmap
$roadmapFile = __DIR__ . '/../ROADMAP.md';
if (!file_exists($roadmapFile)) {
    die("Error: ROADMAP.md not found at $roadmapFile\n");
}

$roadmapContent = file_get_contents($roadmapFile);
$issues = parseRoadmap($roadmapContent);

echo "Found " . count($issues) . " issues to create\n\n";

// Create labels first
createLabels($dryRun);

// Check for existing issues
if (!$dryRun) {
    echo "Checking for existing issues...\n";
    $existingIssues = shell_exec('gh issue list --json title --jq ".[].title"');
    $existingTitles = array_filter(explode("\n", trim($existingIssues)));
}

// Create issues
foreach ($issues as $index => $issue) {
    echo "(" . ($index + 1) . "/" . count($issues) . ") ";
    
    // Skip if issue already exists (only in real mode)
    if (!$dryRun && in_array($issue['title'], $existingTitles)) {
        echo "Skipping: {$issue['title']} (already exists)\n";
        continue;
    }
    
    createGitHubIssue($issue, $projectNumber, $dryRun);
    
    if (!$dryRun) {
        sleep(1); // Rate limiting
    }
}

echo "\n" . ($dryRun ? "DRY RUN COMPLETE" : "ALL ISSUES CREATED") . "\n";

function parseRoadmap($content) {
    $issues = [];
    $lines = explode("\n", $content);
    $currentPhase = '';
    $currentPriority = 'medium';
    $issueDescription = '';
    $issueTitle = '';
    $tasks = [];
    $collectingTasks = false;
    
    foreach ($lines as $line) {
        $line = rtrim($line);
        
        // Phase headers (## 1. Legacy Preservation...)
        if (preg_match('/^## (\d+)\. (.+)$/', $line, $matches)) {
            // Save previous issue if exists
            if ($issueTitle && $currentPhase) {
                $issues[] = createIssueArray($issueTitle, $issueDescription, $currentPhase, $currentPriority, $tasks);
            }
            
            $currentPhase = normalizePhase($matches[2]);
            $issueTitle = trim($matches[2]);
            $issueDescription = '';
            $tasks = [];
            $currentPriority = 'medium';
            $collectingTasks = true;
            continue;
        }
        
        // Section headers with priority (### Bootstrap Layout Migration (HIGH PRIORITY))
        if (preg_match('/^### (.+?) \((HIGH|MEDIUM|LOW) PRIORITY\)$/', $line, $matches)) {
            // Save previous issue if exists
            if ($issueTitle && $currentPhase) {
                $issues[] = createIssueArray($issueTitle, $issueDescription, $currentPhase, $currentPriority, $tasks);
            }
            
            $issueTitle = trim($matches[1]);
            $currentPriority = strtolower($matches[2]);
            $issueDescription = '';
            $tasks = [];
            $collectingTasks = true;
            continue;
        }
        
        // Top-level tasks (  - [ ] ...) become project items
        if (preg_match('/^  - \[ \] (.+)$/', $line, $matches) && $collectingTasks) {
            $tasks[] = trim($matches[1]);
            continue;
        }
        
        // Sub-tasks (    - [ ] ...) also become project items with indentation
        if (preg_match('/^    - \[ \] (.+)$/', $line, $matches) && $collectingTasks) {
            $tasks[] = "↳ " . trim($matches[1]); // Use arrow to show hierarchy
            continue;
        }
        
        // Regular descriptive content goes into description
        if (trim($line) && !preg_match('/^(#|  - \[|\s*$)/', $line) && $collectingTasks) {
            if (empty($tasks)) { // Only add to description if we haven't started collecting tasks
                $issueDescription .= trim($line) . "\n";
            }
        }
    }
    
    // Don't forget the last issue
    if ($issueTitle && $currentPhase) {
        $issues[] = createIssueArray($issueTitle, $issueDescription, $currentPhase, $currentPriority, $tasks);
    }
    
    return $issues;
}

function normalizePhase($phaseName) {
    $phase = strtolower(trim($phaseName));
    $phase = preg_replace('/[^a-z0-9]+/', '-', $phase);
    $phase = trim($phase, '-');
    
    // Map to shorter names
    $phaseMap = [
        'legacy-preservation-foundation' => 'foundation',
        'legacy-features-fixes-deployable-individually' => 'fixes',
        'legacy-features-migration-following-needs' => 'migration',
        'new-features' => 'new-features',
        'infrastructure' => 'infrastructure',
        'interfaces' => 'interfaces',
        'testing-documentation' => 'testing'
    ];
    
    return $phaseMap[$phase] ?? $phase;
}

function createIssueArray($title, $description, $phase, $priority, $tasks = []) {
    $labels = ["phase:$phase", "priority:$priority"];
    
    // Add special labels based on content
    if (stripos($description, 'deploy independently') !== false) {
        $labels[] = 'deployable';
    }
    
    if ($phase === 'foundation') {
        $labels[] = 'foundation';
    }
    
    if (stripos($title, 'FIRST TASK') !== false || stripos($description, 'FIRST TASK') !== false) {
        $labels[] = 'first-task';
    }
    
    return [
        'title' => trim($title),
        'description' => trim($description),
        'tasks' => $tasks,
        'labels' => $labels,
        'phase' => $phase,
        'priority' => $priority
    ];
}

function createLabels($dryRun) {
    $labels = [
        // Phases
        ['name' => 'phase:foundation', 'color' => '0052cc', 'description' => 'Legacy preservation and foundation setup'],
        ['name' => 'phase:fixes', 'color' => 'd93f0b', 'description' => 'Legacy feature fixes'],
        ['name' => 'phase:migration', 'color' => 'fbca04', 'description' => 'Legacy feature migration'],
        ['name' => 'phase:new-features', 'color' => '0e8a16', 'description' => 'New features development'],
        ['name' => 'phase:infrastructure', 'color' => '5319e7', 'description' => 'Infrastructure and core classes'],
        ['name' => 'phase:interfaces', 'color' => 'f9d0c4', 'description' => 'Web and CLI interfaces'],
        ['name' => 'phase:testing', 'color' => 'c2e0c6', 'description' => 'Testing and documentation'],
        
        // Priorities
        ['name' => 'priority:high', 'color' => 'd93f0b', 'description' => 'High priority task'],
        ['name' => 'priority:medium', 'color' => 'fbca04', 'description' => 'Medium priority task'],
        ['name' => 'priority:low', 'color' => '0e8a16', 'description' => 'Low priority task'],
        
        // Special
        ['name' => 'deployable', 'color' => 'bfd4f2', 'description' => 'Can be deployed independently'],
        ['name' => 'foundation', 'color' => '0052cc', 'description' => 'Foundation/setup task'],
        ['name' => 'first-task', 'color' => 'b60205', 'description' => 'Must be completed first']
    ];
    
    echo "Creating labels...\n";
    
    foreach ($labels as $label) {
        $command = sprintf(
            'gh label create "%s" --color "%s" --description "%s" 2>/dev/null || true',
            $label['name'],
            $label['color'],
            $label['description']
        );
        
        if ($dryRun) {
            echo "Would create label: {$label['name']}\n";
        } else {
            shell_exec($command);
            echo "Created label: {$label['name']}\n";
        }
    }
    
    echo "\n";
}

function createGitHubIssue($issue, $projectNumber, $dryRun = false) {
    // Create body with description + task checklist
    $body = trim($issue['description']);
    if (!empty($issue['tasks'])) {
        if ($body) $body .= "\n\n";
        $body .= "## Tasks\n\n";
        foreach ($issue['tasks'] as $task) {
            $body .= "- [ ] " . $task . "\n";
        }
    }
    
    $title = escapeshellarg($issue['title']);
    $bodyEscaped = escapeshellarg($body);
    $labels = implode(',', $issue['labels']);
    
    if ($dryRun) {
        echo "Would create: {$issue['title']}\n";
        echo "  Labels: " . implode(', ', $issue['labels']) . "\n";
        if (!empty($issue['tasks'])) {
            echo "  With " . count($issue['tasks']) . " checklist items\n";
        }
        echo "\n";
        return;
    }
    
    // Create the issue
    $createCommand = sprintf(
        'gh issue create --title %s --body %s --label "%s"',
        $title,
        $bodyEscaped,
        $labels
    );
    
    echo "Creating: {$issue['title']}... ";
    $result = shell_exec($createCommand . ' 2>&1');
    
    if (strpos($result, 'https://github.com') !== false) {
        echo "✓ Created\n";
        
        // Extract issue URL and add to project
        if (preg_match('/https:\/\/github\.com\/[^\/]+\/[^\/]+\/issues\/(\d+)/', $result, $matches)) {
            $issueUrl = trim($result);
            $addToProjectCommand = sprintf(
                'gh project item-add %d --url "%s" 2>/dev/null',
                $projectNumber,
                $issueUrl
            );
            
            shell_exec($addToProjectCommand);
            echo "  ✓ Added to project with " . count($issue['tasks']) . " checklist items\n";
        }
    } else {
        echo "✗ Failed: $result\n";
    }
}

function createProjectItem($taskTitle, $projectNumber, $parentLabels) {
    $taskTitle = escapeshellarg($taskTitle);
    $labels = array_filter($parentLabels, fn($label) => !str_starts_with($label, 'priority:'));
    $labels[] = 'task';
    $labelsString = implode(',', $labels);
    
    // Create as a draft issue that can be converted to a task item
    $command = sprintf(
        'gh project item-add %d --title %s --body "" 2>/dev/null',
        $projectNumber,
        $taskTitle
    );
    
    $result = shell_exec($command);
    echo "    ✓ Added task: " . trim($taskTitle, "'") . "\n";
}
