#!/bin/bash

APP_ENV=prod

cd /var/www/app

composer install --no-dev --optimize-autoloader
composer dump-env $APP_ENV
composer dump-autoload --no-dev --classmap-authoritative

php bin/console doctrine:migration:migrate -n

php bin/console ckeditor:install --clear=skip
php bin/console elfinder:install
php bin/console assets:install

php bin/console cache:clear -n --env=$APP_ENV --no-debug
