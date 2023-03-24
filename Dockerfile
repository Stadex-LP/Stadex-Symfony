FROM php:8.2-fpm as php-prod

# Set Symfony in production mode
ENV APP_ENV=prod

# Set PHP in production mode with Symfony performance settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY .docker/php-prod/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY .docker/php-prod/conf.d/app.prod.ini $PHP_INI_DIR/conf.d/

COPY .docker/php-prod/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN mkdir -p /var/run/php

COPY .docker/php-prod/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

# Install PHP Extensions
RUN apt update \
    && apt install -y zlib1g-dev g++ git zip libzip-dev libicu-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/stadex-symfony

# Copy source
COPY ./bin/ ./bin/
COPY ./config/ ./config/
COPY ./migrations ./migrations
COPY ./public/ ./public/
COPY ./src/ src/
COPY ./templates/ ./templates/
COPY ./.env .
COPY ./composer.json .
COPY ./composer.lock .
COPY ./symfony.lock .

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress; \
	composer clear-cache

RUN mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]


FROM nginx:1.23-alpine as nginx-prod

COPY .docker/nginx-prod/conf.d/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/stadex-symfony

COPY --from=php-prod /var/www/stadex-symfony/public public/