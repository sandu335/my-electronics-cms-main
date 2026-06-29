#!/usr/bin/env bash
# Simple backup script: dumps MySQL (if available) or copies sqlite, and zips public/images
set -e
WORKDIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$WORKDIR"
mkdir -p storage/backups
TIMESTAMP=$(date +%Y%m%dT%H%M%S)
BACKUP_DIR=storage/backups/$TIMESTAMP
mkdir -p "$BACKUP_DIR"

# backup DB
if [ -n "$DB_CONNECTION" ] && [ "$DB_CONNECTION" = "mysql" ]; then
  echo "Attempting mysqldump..."
  mysqldump --user="$DB_USERNAME" --password="$DB_PASSWORD" --host="$DB_HOST" "$DB_DATABASE" > "$BACKUP_DIR/db.sql" || echo "mysqldump failed"
elif [ -f database/database.sqlite ]; then
  echo "Copying sqlite database"
  cp database/database.sqlite "$BACKUP_DIR/database.sqlite"
else
  echo "No known DB to backup"
fi

# backup images
if [ -d public/images ]; then
  echo "Archiving public/images"
  tar -czf "$BACKUP_DIR/images.tar.gz" -C public images
fi

echo "Backup saved to $BACKUP_DIR"
