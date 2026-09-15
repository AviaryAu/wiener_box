#!/bin/sh

set -eu

cd "$(dirname "$0")"

export COMPOSER_MAX_PARALLEL_HTTP="${COMPOSER_MAX_PARALLEL_HTTP:-4}"

for attempt in 1 2 3; do
    if composer install --no-dev --no-interaction --prefer-dist --download-only --no-scripts --no-progress; then
        break
    fi

    if [ "$attempt" -eq 3 ]; then
        printf '%s\n' 'Composer downloads failed after 3 attempts; stopping the build.' >&2
        exit 1
    fi

    printf 'Composer downloads failed (attempt %s/3); retrying in %s seconds.\n' "$attempt" "$((attempt * 10))" >&2
    sleep "$((attempt * 10))"
done

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

npm ci --include=dev --no-audit
npm run build
