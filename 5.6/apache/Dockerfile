FROM php:5.6.30-apache

RUN apt-get update \
    && apt-get -y install \
            libicu-dev \
        --no-install-recommends \

    # Required extension
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) mbstring \

    # Additional common extensions
    && docker-php-ext-install -j$(nproc) opcache \
    && pecl install apcu-4.0.11 && docker-php-ext-enable apcu \

    # Cleanup to keep the images size small
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*
