#!/bin/bash
set -e

# Strictly enforce only mpm_prefork is loaded
rm -f /etc/apache2/mods-enabled/mpm_*
# Inject Railway's dynamic PORT and explicitly bind to all IPv4 and IPv6 interfaces
TARGET_PORT=${PORT:-8080}
sed -i "s/Listen 80/Listen 0.0.0.0:${TARGET_PORT}\nListen [::]:${TARGET_PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${TARGET_PORT}>/" /etc/apache2/sites-available/000-default.conf
a2enmod mpm_prefork
# Start Apache in the foreground
exec apache2-foreground
