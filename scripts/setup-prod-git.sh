#!/usr/bin/env bash
# Однократная настройка git на проде: не трогать права и владельца при pull.
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$REPO_ROOT"

git config core.fileMode false
git config core.autocrlf false
git config pull.rebase false
git config fetch.prune true

echo "Git настроен для prod:"
echo "  core.fileMode=false  (git не меняет chmod при checkout/pull)"
echo "  core.autocrlf=false"
