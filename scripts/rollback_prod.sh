#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/root/practica-tienda}"
DEPLOY_SCRIPT="${DEPLOY_SCRIPT:-/usr/local/bin/deploy_tienda.sh}"
TARGET="${1:-}"

if [ -z "$TARGET" ]; then
  echo "Uso: $0 <commit|tag|branch>"
  echo "Ejemplo: $0 HEAD~1"
  exit 1
fi

cd "$PROJECT_DIR"

echo "[1/4] Fetch refs"
git fetch --all --prune

echo "[2/4] Resolve target"
TARGET_COMMIT="$(git rev-parse --verify "${TARGET}^{commit}")"
CURRENT_COMMIT="$(git rev-parse HEAD)"
echo "Current: $CURRENT_COMMIT"
echo "Target : $TARGET_COMMIT"

if [ "$CURRENT_COMMIT" = "$TARGET_COMMIT" ]; then
  echo "Target already deployed."
  exit 0
fi

echo "[3/4] Reset repo to target"
git reset --hard "$TARGET_COMMIT"

echo "[4/4] Redeploy target"
"$DEPLOY_SCRIPT"

echo "OK: rollback completed to $TARGET_COMMIT"
