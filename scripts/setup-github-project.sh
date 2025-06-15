#!/bin/bash
# Quick setup script for WRAP GitHub Project
# Usage: ./scripts/setup-github-project.sh

echo "Setting up WRAP 5.5 GitHub Project..."

# 1. Create the project linked to this repository
echo "Creating GitHub Project for repository..."
REPO_OWNER=$(gh repo view --json owner --jq .owner.login)
REPO_NAME=$(gh repo view --json name --jq .name)
echo "Repository: $REPO_OWNER/$REPO_NAME"

gh project create --title "WRAP 5.5 Modernization" --owner "$REPO_OWNER/$REPO_NAME"

# 2. Get project number (should be repository project now)
echo "Getting project details..."
PROJECT_NUM=$(gh project list --owner "$REPO_OWNER/$REPO_NAME" --format json | jq -r '.[0].number')
echo "Project number: $PROJECT_NUM"

# 3. Create essential labels
echo "Creating labels..."
gh label create "phase:foundation" --color "0052cc" --description "Legacy preservation and foundation setup"
gh label create "phase:fixes" --color "d93f0b" --description "Legacy feature fixes"
gh label create "phase:migration" --color "fbca04" --description "Legacy feature migration"
gh label create "phase:new-features" --color "0e8a16" --description "New features development"
gh label create "phase:infrastructure" --color "5319e7" --description "Infrastructure and core classes"
gh label create "phase:interfaces" --color "f9d0c4" --description "Web and CLI interfaces"
gh label create "phase:testing" --color "c2e0c6" --description "Testing and documentation"

gh label create "priority:high" --color "d93f0b" --description "High priority task"
gh label create "priority:medium" --color "fbca04" --description "Medium priority task"
gh label create "priority:low" --color "0e8a16" --description "Low priority task"

gh label create "deployable" --color "bfd4f2" --description "Can be deployed independently"
gh label create "foundation" --color "0052cc" --description "Foundation/setup task"

# 4. Create the first few critical issues
echo "Creating initial issues..."

# Foundation phase - the absolute first task
gh issue create \
  --title "Move all current code to legacy/ folder" \
  --body "**FIRST TASK** - Move legacy-wrap.php, bin/, contrib/, css/, doc/, download.php, images/, inc/, js/, modules/, themes/ to legacy/ folder.

**Requirements:**
- [ ] Keep exact same file structure in legacy/ (no reorganization, no renaming)
- [ ] Update main entry point wrap.php to include legacy code from new location
- [ ] Update only minimal necessary file paths in legacy code
- [ ] Test thoroughly: ensure all current functionality works exactly as before

**This must be completed before any other development work.**" \
  --label "phase:foundation,priority:high,foundation" \
  --project $PROJECT_NUM

gh issue create \
  --title "Create folder structure for standalone engine" \
  --body "Create the new folder structure for the modern engine:

- [ ] \`engine/\` - Main engine folder (standalone, third-party ready)
- [ ] \`engine/core/\` - Core classes (application, config, container)
- [ ] \`engine/data/\` - Data models and file operations
- [ ] \`engine/auth/\` - User management and authentication
- [ ] \`engine/api/\` - RESTful API for external integrations
- [ ] \`webui/\` - Web interface components (separate from engine)
- [ ] \`cli/\` - Command line tools (separate from engine)" \
  --label "phase:foundation,priority:high,foundation" \
  --project $PROJECT_NUM

gh issue create \
  --title "Setup autoloading with Composer" \
  --body "Setup modern PHP autoloading:

- [ ] Create \`engine/composer.json\` for engine-specific dependencies
- [ ] Update main \`composer.json\` with PSR-4 autoloading for \`Wrap\\\` namespace
- [ ] Add namespace mapping: \`\"Wrap\\\\\": \"engine/\"\`
- [ ] Create autoloader bootstrap in \`engine/autoload.php\`" \
  --label "phase:foundation,priority:high,foundation" \
  --project $PROJECT_NUM

# High priority fixes
gh issue create \
  --title "Bootstrap Layout Migration" \
  --body "Modernize responsive layout system to fix current mobile/responsive issues:

- [ ] Extract current layout generation from legacy code
- [ ] Create \`webui/template.php\` - Bootstrap-based template engine
- [ ] Create \`webui/asset_manager.php\` - Handle CSS/JS dependencies
- [ ] Replace inline styles with Bootstrap classes
- [ ] Implement proper responsive grid system
- [ ] Test mobile/tablet compatibility
- [ ] Deploy independently - improves user experience immediately" \
  --label "phase:fixes,priority:high,deployable" \
  --project $PROJECT_NUM

gh issue create \
  --title "Modern Video Player" \
  --body "Replace hand-made player with robust solution:

**New features:**
- [ ] A user experience closer to websites like YouTube (true page-wide or full screen, seamless previous/next navigation)
- [ ] Like/Favorite/List button, as a tool for team work
- [ ] Multiple video formats (mp4, webm, ogg) configurable site-wide
- [ ] Multiple video resolutions
- [ ] Video download button (light or large)
- [ ] Thumbnail update button (editors/admin)

**General improvements:**
- [ ] Evaluate alternative to current video player library
- [ ] Create \`webui/video_player.php\` - Player management
- [ ] Extract video metadata handling to \`engine/data/video.php\`
- [ ] Implement proper video format support
- [ ] Add subtitle support (replace current buggy implementation)
- [ ] Add playlist functionality
- [ ] Test cross-browser compatibility
- [ ] Deploy independently - fixes current player issues" \
  --label "phase:fixes,priority:high,deployable" \
  --project $PROJECT_NUM

echo "GitHub Project setup complete!"
echo "Project URL: https://github.com/$(gh repo view --json owner,name | jq -r '.owner.login + \"/\" + .name')/projects/$PROJECT_NUM"