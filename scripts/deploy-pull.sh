#!/usr/bin/env bash
# Безопасный pull на проде: только fast-forward, без смены владельца/прав.
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$REPO_ROOT"

if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "Не git-репозиторий: $REPO_ROOT" >&2
  exit 1
fi

# На всякий случай — если setup-prod-git.sh ещё не запускали.
git config core.fileMode false 2>/dev/null || true
git config core.autocrlf false 2>/dev/null || true

BRANCH="${1:-$(git symbolic-ref --short HEAD 2>/dev/null || echo main)}"

echo ">>> git fetch origin"
git fetch origin "$BRANCH"

echo ">>> git pull --ff-only origin $BRANCH"
git pull --ff-only origin "$BRANCH"

echo ">>> Готово. Права на файлы git не менял (core.fileMode=false)."
