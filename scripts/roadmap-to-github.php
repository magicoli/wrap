<?php
/**
 * Script to convert ROADMAP.md to GitHub Issues
 * Usage: php scripts/roadmap-to-github.php [--dry-run]
 */

$dryRun = in_array('--dry-run', $argv);

// Read the roadmap file
$roadmapContent = file_get_contents(__DIR__ . '/../ROADMAP.md');

// Parse the roadmap structure
$issues = parseRoadmap($roadmapContent);

// Create GitHub issues
foreach ($issues as $issue) {
    createGitHubIssue($issue, $dryRun);
}

function parseRoadmap($content) {
    $issues = [];
    $lines = explode("\n", $content);
    $currentPhase = '';
    $currentSection = '';
    $currentPriority = 'medium';
    $issueBody = '';
    $issueTitle = '';
    
    foreach ($lines as $line) {
        // Detect phase headers
        if (preg_match('/^## (\d+)\. (.+)$/', $line, $matches)) {
            $currentPhase = strtolower(str_replace(' ', '-', trim($matches[2])));
            continue;
        }
        
        // Detect section headers with priority
        if (preg_match('/^### (.+) \((HIGH|MEDIUM|LOW) PRIORITY\)$/', $line, $matches)) {
            $currentSection = trim($matches[1]);
            $currentPriority = strtolower($matches[2]);
            $issueTitle = $currentSection;
            $issueBody = '';
            continue;
        }
        
        // Detect major tasks (top-level checkboxes)
        if (preg_match('/^  - \[ \] (.+)$/', $line, $matches)) {
            // If we have a previous issue, save it
            if ($issueTitle && $currentSection) {
                $issues[] = createIssueArray($issueTitle, $issueBody, $currentPhase, $currentPriority);
            }
            
            $issueTitle = trim($matches[1]);
            $issueBody = '';
            continue;
        }
        
        // Collect sub-tasks as issue body
        if (preg_match('/^    - \[ \] (.+)$/', $line, $matches)) {
            $issueBody .= "- [ ] " . trim($matches[1]) . "\n";
            continue;
        }
        
        // Add descriptive text to body
        if (trim($line) && !preg_match('/^(#|  - \[|\s*$)/', $line)) {
            $issueBody .= trim($line) . "\n";
        }
    }
    
    // Don't forget the last issue
    if ($issueTitle && $currentSection) {
        $issues[] = createIssueArray($issueTitle, $issueBody, $currentPhase, $currentPriority);
    }
    
    return $issues;
}

function createIssueArray($title, $body, $phase, $priority) {
    $labels = ["phase:$phase", "priority:$priority"];
    
    // Detect if it's deployable
    if (strpos($body, 'Deploy independently') !== false) {
        $labels[] = 'deployable';
    }
    
    // Detect if it's high priority foundation work
    if ($phase === 'legacy-preservation-&-foundation') {
        $labels[] = 'foundation';
    }
    
    return [
        'title' => $title,
        'body' => trim($body),
        'labels' => $labels
    ];
}

function createGitHubIssue($issue, $dryRun = false) {
    $title = escapeshellarg($issue['title']);
    $body = escapeshellarg($issue['body']);
    $labels = implode(',', $issue['labels']);
    
    $command = "gh issue create --title $title --body $body --label '$labels'";
    
    if ($dryRun) {
        echo "Would create issue: {$issue['title']}\n";
        echo "Labels: " . implode(', ', $issue['labels']) . "\n";
        echo "Body preview: " . substr($issue['body'], 0, 100) . "...\n";
        echo "Command: $command\n\n";
    } else {
        echo "Creating issue: {$issue['title']}\n";
        $result = shell_exec($command . ' 2>&1');
        echo "Result: $result\n";
        
        // Small delay to avoid rate limiting
        sleep(1);
    }
}

echo $dryRun ? "DRY RUN - No issues will be created\n" : "Creating GitHub issues...\n";
echo "Found " . count($issues) . " issues to create\n\n";