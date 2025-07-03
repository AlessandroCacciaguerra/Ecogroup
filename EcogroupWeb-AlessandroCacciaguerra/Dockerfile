FROM php:8.2-fpm

RUN apt-get update && apt-get upgrade -y && apt install npm -y
RUN apt-get install -y libzip-dev && docker-php-ext-install zip
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN pecl install redis && docker-php-ext-enable redis

WORKDIR www/ecogroup

COPY ./ecogroup /www/ecogroup

EXPOSE 8080
