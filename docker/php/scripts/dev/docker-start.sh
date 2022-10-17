#!/bin/bash

cd /var/www/app

composer install

composer dump-env dev
php bin/console cache:warmup

php bin/console doctrine:migration:migrate -n

php-fpm
