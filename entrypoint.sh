#!/bin/bash
set -e

# Strictly enforce only mpm_prefork is loaded
rm -f /etc/apache2/mods-enabled/mpm_*
a2enmod mpm_prefork
# Start Apache in the foreground
exec apache2-foreground
