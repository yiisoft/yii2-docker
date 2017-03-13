FROM php:7.0.16-fpm-alpine

RUN apk add --update --no-cache \
        # Runtime dependencies
        icu-libs \
        libpng \
        jpeg \
        freetype

RUN apk add --update --no-cache --virtual .build-deps \
        # Build dependencies (will be removed after extensions are built)
        icu-dev \
        jpeg-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        freetype-dev \
        # Required for APC on 5.6 and 7.0
        autoconf \
        gcc \
        g++ \
        make \
    && pecl install apcu \
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

RUN docker-php-ext-enable apcu

# Required by composer
RUN apk add --no-cache \
        git \
        zlib-dev
# Install composer
COPY install-composer /install-composer
RUN /install-composer && rm /install-composer
