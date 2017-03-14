FROM php:7.0.16-fpm-alpine

RUN apk add --update --no-cache \
        # Runtime dependencies
        icu-libs \
        libpng \
        jpeg \
        freetype \
    && apk add --update --no-cache --virtual .build-deps \
        # Build dependencies (will be removed after extensions are built)
        icu-dev \
        jpeg-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        freetype-dev \
        # Required for APC
        autoconf \
        gcc \
        g++ \
        make \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure \
        gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
        # Required extensions
        intl \
        mbstring \
        # Additional common extensions
        opcache \
        gd \
        zip \
    # Cleanup to keep the images size small
    && apk del .build-deps
