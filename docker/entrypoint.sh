#!/bin/sh
set -e

echo "=== MISSION KIDS Container Initializing ==="

# Ensure database directory and audio cache exist and are writable
mkdir -p /app/database /app/public/audio/miko/cache
chmod -R 777 /app/database /app/public/audio/miko/cache

# Run migration to ensure all tables (worlds, missions, etc.) exist and are seeded
echo "Running database auto-bootstrap & migration..."
php /app/database/migrate.php || echo "Migration notice: continuing startup"

# Ensure permissions after potential database file creation
chmod -R 777 /app/database /app/public/audio/miko/cache

echo "=== MISSION KIDS Ready to Serve ==="

exec "$@"
