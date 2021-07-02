FROM php:7.4-cli

WORKDIR /src

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . .

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]