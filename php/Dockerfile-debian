# PHP Docker image for Yii 2.0 Framework runtime
# ==============================================

ARG PHP_BASE_IMAGE_VERSION
FROM php:${PHP_BASE_IMAGE_VERSION}

# Install system packages for PHP extensions recommended for Yii 2.0 Framework
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
        soap \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        imagick \
        mongodb \
        xdebug

# Disable xdebug by default (see PHP_ENABLE_XDEBUG)
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Environment settings
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    PHP_USER_ID=33 \
    PHP_ENABLE_XDEBUG=0 \
    PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    TERM=linux

# Add configuration files
COPY image-files/ /

# Add GITHUB_API_TOKEN support for composer
RUN chmod 755 \
        /usr/local/bin/docker-php-entrypoint \
        /usr/local/bin/composer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --version=2.1.3 \
        --filename=composer.phar \
        --install-dir=/usr/local/bin && \
    composer clear-cache


# Enable mod_rewrite for images with apache
RUN if command -v a2enmod >/dev/null 2>&1; then \
        a2enmod rewrite headers \
    ;fi

# Install Yii framework bash autocompletion
RUN mkdir /etc/bash_completion.d && \
    curl -L https://raw.githubusercontent.com/yiisoft/yii2/master/contrib/completion/bash/yii \
         -o /etc/bash_completion.d/yii

# Application environment
WORKDIR /app
