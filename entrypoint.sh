#!/bin/sh

#sleep 120
# comment those commands, after the first run:
php artisan key:generate
php artisan migrate

php artisan serve --host 0.0.0.0


