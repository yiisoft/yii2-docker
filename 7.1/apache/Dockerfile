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

# Add Yii2 config
RUN { \
        echo '<Directory /var/www/html/web>'; \
        echo '  Require all granted'; \
        echo '  # use mod_rewrite for pretty URL support'; \
        echo '  RewriteEngine on'; \
        echo '  # If a directory or a file exists, use the request directly'; \
        echo '  RewriteCond %{REQUEST_FILENAME} !-f'; \
        echo '  RewriteCond %{REQUEST_FILENAME} !-d'; \
        echo '  # Exclude static file types'; \
        echo '  RewriteCond %{REQUEST_URI} !\.(css|gif|ico|jpg|js|map|png|svg|ttf|woff|woff2)$'; \
        echo '  # Otherwise forward the request to index.php'; \
        echo '  RewriteRule . index.php'; \
        echo '</Directory>'; \
    } | tee /etc/apache2/conf-available/yii2-php.conf \
    && sed -i 's#DocumentRoot.*#DocumentRoot /var/www/html/web#' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/ServerTokens OS/ServerTokens Prod/' /etc/apache2/conf-available/security.conf \
    && sed -i 's/ServerSignature On/ServerSignature Off/' /etc/apache2/conf-available/security.conf \
    && a2enconf yii2-php \
    && a2enmod rewrite

# Install composer
COPY install-composer /install-composer
RUN /install-composer && rm /install-composer
