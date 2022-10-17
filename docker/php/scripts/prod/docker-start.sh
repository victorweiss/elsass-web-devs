#!/bin/bash

APP_ENV=prod

cd /var/www/app

composer install --no-dev --optimize-autoloader
composer dump-env $APP_ENV
composer dump-autoload --no-dev --classmap-authoritative

php bin/console doctrine:migration:migrate -n

php bin/console cache:clear -n --env=$APP_ENV --no-debug

php bin/console assets:install --symlink public
