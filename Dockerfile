FROM dunglas/frankenphp:php8.4-alpine

RUN install-php-extensions imap opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

COPY src/ /app/src/
COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80

ENTRYPOINT ["frankenphp"]
CMD ["run", "--config", "/etc/caddy/Caddyfile"]
