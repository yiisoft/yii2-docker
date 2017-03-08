FROM php:7.0.16-apache

RUN apt-get update \
    && apt-get -y install \
            libicu-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libpng12-dev \
            libfreetype6-dev \
        --no-install-recommends \

    # Required extension
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) mbstring \

    # Additional common extensions
    && docker-php-ext-install -j$(nproc) opcache \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install apcu-5.1.8 && docker-php-ext-enable apcu \

    # Cleanup to keep the images size small
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*
