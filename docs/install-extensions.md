## Installing additional extensions

*Note: Alpine images are not officially supported*

### Composer asset plugin

    RUN composer global require "fxp/composer-asset-plugin:^1.4.2"

### mcrypt

#### Debian

```
RUN apt-get update && \
    apt-get -y install \
        libmcrypt-dev && \
    docker-php-ext-install \
        mycrypt        
```


### APC

*TBD*

    RUN pecl install apcu
    RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/pecl-apcu.ini

---

    RUN docker-php-ext-enable \
        imagick

### memcache

#### Debian (PHP 7)     
     
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
     
### Xdebug
   
        
### oci8 / pdo_oci
You need to download the oracle instant client for your distro here: https://www.oracle.com/technetwork/topics/linuxx86-64soft-092277.html

#### Debian
Put the basic, devel and odbc rpm packages in a folder (oracle_instant_client in this example)

    RUN mkdir /opt/oracle
    COPY oracle_instant_client/ /opt/oracle

    ENV LD_LIBRARY_PATH=/usr/lib/oracle/18.3/client64/lib/${LD_LIBRARY_PATH:+:$LD_LIBRARY_PATH}
    ENV ORACLE_HOME=/usr/lib/oracle/18.3/client64
    ENV C_INCLUDE_PATH=/usr/include/oracle/18.3/client64/
    
    RUN apt-get update && \
        apt-get install --no-install-recommends --assume-yes --quiet \
            rpm \
            libaio1 \
            alien \
            build-essential \
            apt-transport-https \
            libmcrypt-dev \
            zlib1g-dev \
            libxslt-dev \
            libpng-dev && \
        rm -rf /var/lib/apt/lists/*
        alien -i /opt/oracle/oracle-instantclient18.3-basic-18.3.0.0.0-1.x86_64.rpm && \
        alien -i /opt/oracle/oracle-instantclient18.3-devel-18.3.0.0.0-1.x86_64.rpm && \
        echo "/usr/lib/oracle/18.3/client64/lib/" > /etc/ld.so.conf.d/oracle.conf && \
        chmod o+r /etc/ld.so.conf.d/oracle.conf && \
        ln -s /usr/include/oracle/18.3/client64 $ORACLE_HOME/include && \
        docker-php-ext-install pdo oci8 pdo_oci && \
        rm -rf /opt/oracle


### igbinary
Add faster serialization with the [igbinary](https://github.com/igbinary/igbinary) library.

#### Debian

    RUN pecl install igbinary && \
        docker-php-ext-enable igbinary


### MsSQL

    RUN apt-get update \
        && apt-get install -y gnupg2
    RUN curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
    RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
    RUN apt-get update \
        && apt-get install -y \
          msodbcsql17 \
          unixodbc-dev
    RUN pecl install sqlsrv pdo_sqlsrv \
        && docker-php-ext-enable sqlsrv pdo_sqlsrv
