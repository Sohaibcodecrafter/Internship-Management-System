#!/bin/bash
set -e

# Strictly enforce only mpm_prefork is loaded
rm -f /etc/apache2/mods-enabled/mpm_*
a2enmod mpm_prefork
# Inject Railway's dynamic PORT into Apache configuration (with fallback to 80)
TARGET_PORT=${PORT:-80}
sed -i "s/Listen 80/Listen ${TARGET_PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${TARGET_PORT}>/" /etc/apache2/sites-available/000-default.conf

# Start Apache in the foreground
exec apache2-foreground
