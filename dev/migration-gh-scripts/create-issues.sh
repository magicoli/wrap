#!/bin/bash
# Easy wrapper for roadmap-to-issues.php
# Usage: ./scripts/create-issues.sh [--dry-run]

set -e

echo "WRAP Roadmap to GitHub Issues Converter"
echo "======================================"

# Check if gh CLI is installed and authenticated
if ! command -v gh &> /dev/null; then
    echo "Error: GitHub CLI (gh) is not installed."
    echo "Install it from: https://cli.github.com/"
    exit 1
fi

if ! gh auth status &> /dev/null; then
    echo "Error: Not authenticated with GitHub CLI."
    echo "Run: gh auth login"
    exit 1
fi

# Check if we're in a git repository
if ! git rev-parse --is-inside-work-tree &> /dev/null; then
    echo "Error: Not in a git repository."
    exit 1
fi

# Get project number
echo "Finding your GitHub projects..."

# Try the simple format first
if gh project list >/dev/null 2>&1; then
    echo "Available projects:"
    gh project list
    echo ""
    echo "Note: Use the number from the first column"
else
    echo "Error: Unable to list projects."
    echo "Make sure you have created a project first:"
    echo "  gh project create --title 'WRAP 5.5 Modernization'"
    exit 1
fi

echo ""
read -p "Enter project number to use: " PROJECT_NUM

if [ -z "$PROJECT_NUM" ]; then
    echo "Error: Project number is required."
    exit 1
fi

# Simple validation - just check if it's a number
if ! [[ "$PROJECT_NUM" =~ ^[0-9]+$ ]]; then
    echo "Error: Project number must be a number."
    exit 1
fi

echo "Using project number: $PROJECT_NUM"

# Ask for confirmation unless dry-run
if [[ "$1" == "--dry-run" ]]; then
    echo ""
    echo "Running in DRY RUN mode - no issues will be created"
    php scripts/roadmap-to-issues.php "$PROJECT_NUM" --dry-run
else
    echo ""
    echo "This will create multiple GitHub issues from your ROADMAP.md"
    read -p "Continue? (y/N): " -n 1 -r
    echo
    
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        echo "Creating issues..."
        php scripts/roadmap-to-issues.php "$PROJECT_NUM"
        echo ""
        echo "✓ Done! Check your project: https://github.com/users/$(gh api user --jq .login)/projects/$PROJECT_NUM"
    else
        echo "Cancelled."
        exit 1
    fi
fi
