#!/usr/bin/env bash
# ==============================================================================
# UKM Toko Sembako - Automated Production Backup Script
# Backs up MySQL database and wp-content with timestamping and retention policy.
# ==============================================================================

set -euo pipefail

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"
BACKUP_DIR="${PROJECT_ROOT}/backups"
TIMESTAMP="$(date +'%Y%m%d_%H%M%S')"
BACKUP_NAME="ukm_toko_backup_${TIMESTAMP}"
DB_FILE="${BACKUP_DIR}/${BACKUP_NAME}.sql"
ARCHIVE_FILE="${BACKUP_DIR}/${BACKUP_NAME}.tar.gz"
RETENTION_DAYS=7

# Ensure backup directory exists
mkdir -p "${BACKUP_DIR}"

echo "[1/4] Starting database export..."
cd "${PROJECT_ROOT}"
wp db export "${DB_FILE}" --allow-root > /dev/null

echo "[2/4] Compressing database and wp-content files..."
tar -czf "${ARCHIVE_FILE}" -C "${PROJECT_ROOT}" "wp-content" -C "${BACKUP_DIR}" "${BACKUP_NAME}.sql"

# Remove plain SQL file after archiving
rm -f "${DB_FILE}"

echo "[3/4] Verifying backup integrity..."
if [[ -f "${ARCHIVE_FILE}" && -s "${ARCHIVE_FILE}" ]]; then
    ARCHIVE_SIZE=$(du -h "${ARCHIVE_FILE}" | cut -f1)
    echo "Backup verified successfully: ${ARCHIVE_FILE} (${ARCHIVE_SIZE})"
else
    echo "Backup failed or file is empty!" >&2
    exit 1
fi

echo "[4/4] Applying retention policy (cleaning backups older than ${RETENTION_DAYS} days)..."
find "${BACKUP_DIR}" -type f -name "ukm_toko_backup_*.tar.gz" -mtime +"${RETENTION_DAYS}" -delete

echo "Backup process completed successfully."
