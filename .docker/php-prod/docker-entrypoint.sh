#!/bin/sh
set -e

bin/console doctrine:database:create --no-interaction --if-not-exists

bin/console doctrine:migrations:migrate --no-interaction

chown -R www-data:www-data /var/www/stadex-symfony

exec docker-php-entrypoint "$@"