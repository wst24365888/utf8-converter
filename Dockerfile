# ref: https://ithelp.ithome.com.tw/articles/10246065

FROM php:8.0.8-fpm-alpine3.13

WORKDIR /src

# Install mysql driver.
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install composer.
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN apk add --no-cache unzip

# Install packages.
COPY composer.* ./
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader && composer clear-cache

# Copy source code.
COPY . .
RUN composer run post-autoload-dump

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]