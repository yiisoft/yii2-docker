FROM php:7.1.2-fpm-alpine

RUN apk add --update --no-cache \
        # Runtime dependencies
        icu-libs \
        libpng \
        libjpeg-turbo \
        freetype \
    && apk add --update --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        # Build dependencies (will be removed after extensions are built)
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        freetype-dev \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure \
        gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
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
