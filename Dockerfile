FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install \
    && a2enmod rewrite \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
