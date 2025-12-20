#!/usr/bin/env sh
set -eu

PORT_VALUE="${PORT:-8080}"

# Update Apache configs to listen on the Render-provided PORT
sed -ri "s/Listen 80/Listen ${PORT_VALUE}/" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT_VALUE}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground
