FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install intl mysqli mbstring zip

RUN a2enmod rewrite

WORKDIR /var/www/html
