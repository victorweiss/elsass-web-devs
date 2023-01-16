#!/bin/bash

cd /var/www/app

composer install

composer dump-env dev
php bin/console cache:warmup

php bin/console doctrine:migration:migrate -n

php bin/console ckeditor:install
php bin/console elfinder:install
php bin/console assets:install

php-fpm
