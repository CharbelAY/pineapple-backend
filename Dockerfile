FROM php:7.4

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /src/app

COPY . .

EXPOSE 8080

#CMD bash -c "composer install && php -S 0.0.0.0:8080"