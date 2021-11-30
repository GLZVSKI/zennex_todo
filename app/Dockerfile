FROM php:7.4-apache

WORKDIR /var/www/html/

RUN apt-get update && apt-get upgrade

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/