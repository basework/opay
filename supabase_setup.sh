#!/usr/bin/env bash
set -euo pipefail

# supabase_setup.sh
# Usage:
#   export DATABASE_URL="postgres://user:pass@host:5432/dbname"
#   ./supabase_setup.sh
# The script will apply supabase_init.sql using psql.

SQL_FILE="supabase_init.sql"

if [ -z "${DATABASE_URL-}" ]; then
  echo "ERROR: DATABASE_URL environment variable is not set."
  echo "Set it to your Supabase/Postgres connection string, e.g.:"
  echo "  export DATABASE_URL=\"postgres://user:pass@host:5432/dbname\""
  exit 1
fi

if ! command -v psql >/dev/null 2>&1; then
  echo "ERROR: psql not found. Install PostgreSQL client or use supabase CLI."
  exit 1
fi

echo "Applying SQL schema from ${SQL_FILE} to ${DATABASE_URL%%@*}..."

# psql accepts the full connection string as first arg
psql "$DATABASE_URL" -v ON_ERROR_STOP=1 -f "$SQL_FILE"

echo "Schema applied successfully."
