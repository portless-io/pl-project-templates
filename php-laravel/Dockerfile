FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan optimize:clear && php artisan serve
