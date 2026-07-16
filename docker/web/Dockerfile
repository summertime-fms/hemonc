FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libicu-dev \
        libxml2-dev \
        libonig-dev \
        msmtp \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        intl \
        opcache \
        exif \
        bcmath \
        soap \
        sockets \
        mbstring \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

COPY php-bitrix.ini /usr/local/etc/php/conf.d/zzz-bitrix.ini
COPY apache-bitrix.conf /etc/apache2/conf-enabled/zzz-bitrix.conf

WORKDIR /var/www/html
