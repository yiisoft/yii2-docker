FROM php:7.1.2-apache

RUN apt-get update \
    && apt-get -y install \
            libicu52 \
            libicu-dev \

            # Required by composer
            git \
            zlib1g-dev \
        --no-install-recommends \

    # Required extension
    && docker-php-ext-install -j$(nproc) intl \

    # Additional common extensions
    && docker-php-ext-install -j$(nproc) opcache \
    && pecl install apcu-5.1.8 && docker-php-ext-enable apcu \

    # Required by composer
    && docker-php-ext-install -j$(nproc) zip \

    # Cleanup to keep the images size small
    && apt-get purge -y \
        icu-devtools \
        libicu-dev \
        zlib1g-dev \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*

# Add Yii2 config
COPY docker-yii2-php.conf /etc/apache2/conf-available/
RUN sed -i 's#DocumentRoot.*#DocumentRoot /var/www/html/web#' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/^#AddDefault/AddDefault/' /etc/apache2/conf-available/charset.conf \
    && sed -i 's/ServerTokens OS/ServerTokens Prod/' /etc/apache2/conf-available/security.conf \
    && sed -i 's/ServerSignature On/ServerSignature Off/' /etc/apache2/conf-available/security.conf \
    && a2disconf docker-php \
    && a2enconf docker-yii2-php \
    && a2enmod rewrite

# Install composer
COPY install-composer /install-composer
RUN /install-composer && rm /install-composer
