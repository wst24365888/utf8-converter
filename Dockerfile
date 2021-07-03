# ref: https://ithelp.ithome.com.tw/articles/10246065

FROM php:7.4-alpine

WORKDIR /src

# environment
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN apk add --no-cache unzip

# install packages
COPY composer.* ./
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader && composer clear-cache

# source code
COPY . .
RUN composer run post-autoload-dump

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]