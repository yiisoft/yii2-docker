### memcache

Example `Dockerfile` commands for PHP 7 (Alpine)

    # memcache
    ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev git
    RUN set -xe \
     && apk add libmemcached \
     && apk add --no-cache \
         --virtual .memcached-deps \
         $MEMCACHED_DEPS \
     && curl https://codeload.github.com/php-memcached-dev/php-memcached/zip/php7 -o /tmp/memcached.zip \
     && mkdir -p /usr/src/php/ext \
     && unzip /tmp/memcached.zip -d /usr/src/php/ext \
     && docker-php-ext-configure /usr/src/php/ext/php-memcached-php7 \
         --disable-memcached-sasl \
     && docker-php-ext-install /usr/src/php/ext/php-memcached-php7 \
     && rm -rf /usr/src/php/ext/php-memcached-php7 /tmp/memcached.zip \
     && apk del .memcached-deps

Example `Dockerfile` commands for PHP 7 (Debian)     
     
    # memcache
    ENV MEMCACHED_DEPS libmemcached-dev git
    RUN set -xe \
     && apt-get update \
     && apt-get install -y $MEMCACHED_DEPS \
     && curl https://codeload.github.com/php-memcached-dev/php-memcached/zip/php7 -o /tmp/memcached.zip \
     && mkdir -p /usr/src/php/ext \
     && unzip /tmp/memcached.zip -d /usr/src/php/ext \
     && docker-php-ext-configure /usr/src/php/ext/php-memcached-php7 \
         --disable-memcached-sasl \
     && docker-php-ext-install /usr/src/php/ext/php-memcached-php7 \
     && rm -rf /usr/src/php/ext/php-memcached-php7 /tmp/memcached.zip
     