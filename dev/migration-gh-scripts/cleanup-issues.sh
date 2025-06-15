#!/bin/bash
# Delete all issues in the repository
# Usage: ./scripts/cleanup-issues.sh

echo "WARNING: This will delete ALL issues in this repository!"
echo "Current issues:"
gh issue list

echo ""
read -p "Are you sure you want to delete all issues? (y/N): " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Deleting all issues..."
    gh issue list --json number --jq '.[].number' | while read -r issue_num; do
        echo "Deleting issue #$issue_num..."
        gh issue delete "$issue_num" --yes
    done
    echo "✓ All issues deleted"
else
    echo "Cancelled."
fi