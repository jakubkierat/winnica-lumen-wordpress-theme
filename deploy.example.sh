#!/usr/bin/env bash
#
# Przykładowy skrypt wdrożenia motywu na serwer przez SSH + rsync.
# To jest SZABLON do dostosowania pod konkretny hosting - nie uruchamiaj
# tego bez podmiany danych poniżej. Pokazuje typowy przepływ pracy
# "commit → rsync po SSH → wyczyszczenie cache", z jakim można się
# spotkać przy utrzymaniu stron na WordPressie.
#
# Użycie:
#   ./deploy.example.sh
#
# Wymagania: dostęp SSH z kluczem (bez hasła) do serwera docelowego.

set -euo pipefail

# --- Konfiguracja (dostosuj do swojego środowiska) -------------------------
REMOTE_USER="deploy"
REMOTE_HOST="example-serwer.pl"
REMOTE_PORT="22"
REMOTE_THEME_PATH="/var/www/winnicalumen.pl/wp-content/themes/winnica-lumen"
LOCAL_THEME_PATH="./theme/"

# --- 1. Synchronizacja plików motywu przez SSH -----------------------------
echo "Wysyłanie plików motywu na ${REMOTE_HOST}..."
rsync -avz --delete \
  -e "ssh -p ${REMOTE_PORT}" \
  --exclude ".git" \
  --exclude ".DS_Store" \
  "${LOCAL_THEME_PATH}" \
  "${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_THEME_PATH}"

# --- 2. Wyczyszczenie cache po stronie serwera (np. object cache / OPcache) -
echo "Czyszczenie cache na serwerze..."
ssh -p "${REMOTE_PORT}" "${REMOTE_USER}@${REMOTE_HOST}" \
  "wp cache flush --path=/var/www/winnicalumen.pl || true"

# --- 3. Uwaga nt. Cloudflare ------------------------------------------------
# Jeśli domena jest spięta z Cloudflare (proxy DNS, cache statycznych
# zasobów), po wdrożeniu warto też wyczyścić cache CDN, np.:
#   curl -X POST "https://api.cloudflare.com/client/v4/zones/<ZONE_ID>/purge_cache" \
#     -H "Authorization: Bearer <API_TOKEN>" \
#     -H "Content-Type: application/json" \
#     --data '{"purge_everything":true}'
# (token/ID celowo nie są tu wpisane - trzymaj je w zmiennych środowiskowych
# CI/CD, nigdy w repozytorium).

echo "Gotowe."
