FROM php:8.4-fpm-alpine

RUN apk add --no-cache nginx imap-dev openssl-dev krb5-dev \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY src/ /app/src/
COPY nginx.conf /etc/nginx/http.d/default.conf

RUN mkdir -p /run/nginx

EXPOSE 80

CMD php-fpm -D && nginx -g 'daemon off;'
