#!/bin/bash
cd /var/www/app
composer install

sudo chown -R www-data:www-data /var/www/app/var/log /var/www/app/var/cache

php /var/www/app/bin/console d:m:m -q