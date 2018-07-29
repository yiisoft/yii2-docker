#!/bin/sh
set -e

# Set permissions based on ENV variable (debian only)
if [ -x "$(command -v usermod)" ] ; then
    usermod -u ${PHP_USER_ID} www-data
fi

# Enable xdebug by ENV variable
if [ 0 -ne "${PHP_ENABLE_XDEBUG:-0}" ] ; then
    docker-php-ext-enable xdebug
    echo "Enabled xdebug"
fi

export PS1="\e[0;35mphd \e[0;37m\u container \h \e[0;32m\w \e[0;0m\n$ "

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    if [ -x "$(command -v apache2-foreground)" ]; then
        set -- apache2-foreground "$@"
    elif [ -x "$(command -v php-fpm)" ]; then
        set -- php-fpm "$@"
    else
        set -- php "$@"
    fi
fi

exec "$@"
