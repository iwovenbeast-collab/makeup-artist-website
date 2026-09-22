#!/bin/bash

set -e

# Railway can end up with multiple Apache MPMs enabled.
# PHP's Apache module requires mpm_prefork.
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_prefork 2>/dev/null || true

a2enmod mpm_prefork

# Railway provides PORT at runtime.
PORT="${PORT:-80}"

sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

sed -i "s/<VirtualHost \*:[0-9]\+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

echo "Starting Apache on port ${PORT}"

apache2ctl -t

exec apache2-foreground
