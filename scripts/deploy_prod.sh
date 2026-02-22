#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/root/practica-tienda}"
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.prod.yml}"
APP_CONTAINER="${APP_CONTAINER:-tienda_app}"
CHECK_URL="${CHECK_URL:-http://127.0.0.1/tienda}"

cd "$PROJECT_DIR"

echo "[1/5] Git sync"
git pull --ff-only

echo "[2/5] Build app image"
docker compose -f "$COMPOSE_FILE" build app

echo "[3/5] Restart app container"
docker compose -f "$COMPOSE_FILE" up -d app

echo "[4/5] Clear Laravel caches"
docker exec "$APP_CONTAINER" php artisan optimize:clear --no-ansi

echo "[5/5] Verify storefront assets"
html="$(curl -fsSL "$CHECK_URL")"

if grep -q 'cdn.jsdelivr.net/npm/bootstrap' <<<"$html"; then
  echo "ERROR: storefront still renders Bootstrap CDN links"
  exit 1
fi

if ! grep -q '/build/assets/.*\.css' <<<"$html"; then
  echo "ERROR: storefront is not rendering Vite CSS assets"
  exit 1
fi

echo "OK: storefront renders Vite assets and no Bootstrap CDN."
