FROM php:7.1.2-apache

RUN apt-get update \
    && apt-get -y install \
            libicu-dev \

            # Required by composer
            git \
            zlib1g-dev \
        --no-install-recommends \

    # Required extension
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) mbstring \

    # Additional common extensions
    && docker-php-ext-install -j$(nproc) opcache \
    && pecl install apcu-5.1.8 && docker-php-ext-enable apcu \

    # Required by composer
    && docker-php-ext-install -j$(nproc) zip \

    # Cleanup to keep the images size small
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*

# Install composer
COPY install-composer /install-composer
RUN /install-composer && rm /install-composer
