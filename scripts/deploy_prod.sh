#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="${PROJECT_DIR:-/root/practica-tienda}"
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.prod.yml}"
APP_CONTAINER="${APP_CONTAINER:-tienda_app}"
CHECK_URL="${CHECK_URL:-http://127.0.0.1/tienda}"

cd "$PROJECT_DIR"

echo "[1/4] Git sync"
git pull --ff-only

echo "[2/4] Build app image"
docker compose -f "$COMPOSE_FILE" build app

echo "[3/4] Restart app and web"
docker compose -f "$COMPOSE_FILE" up -d app web

echo "[4/4] Clear Laravel caches"
docker exec "$APP_CONTAINER" php artisan optimize:clear --no-ansi

echo "[verify] Storefront assets"
html="$(curl -fsSL "$CHECK_URL")"

if grep -q 'cdn.jsdelivr.net/npm/bootstrap' <<<"$html"; then
  echo "ERROR: storefront still renders Bootstrap CDN links"
  exit 1
fi

if ! grep -q '/build/assets/.*\.css' <<<"$html"; then
  echo "ERROR: storefront is not rendering Vite CSS assets"
  exit 1
fi

while read -r asset; do
  [ -n "$asset" ] || continue
  code="$(curl -fsSL -o /dev/null -w '%{http_code}' "$asset")"
  if [ "$code" != "200" ]; then
    echo "ERROR: asset not reachable ($code): $asset"
    exit 1
  fi
done < <(grep -o 'http://[^" ]*/build/assets/[^" ]*\.\(css\|js\)' <<<"$html" | head -n 6)

echo "OK: storefront renders Vite assets and no Bootstrap CDN."
