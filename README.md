<p align="center">
    <a href="https://www.docker.com/" target="_blank">
        <img src="https://www.docker.com/sites/default/files/mono_vertical_large.png" height="100px">
    </a>
    <h1 align="center">Yii2 PHP Docker Image</h1>
    <br>
</p>

This is the repo of the official [yii2](http://www.yiiframework.com/)
[docker image](https://hub.docker.com/r/yiisoft/yii2-php/) for PHP.

## Status

This is still work in progress. The images are not yet available on docker hub.

## Setup

    cp .env-dist .env

## Building

    docker-compose build

## Testing

    docker-compose run --rm php php /tests/requirements.php
        
## Using a specific PHP version

    DOCKERFILE_FLAVOUR=debian PHP_BASE_IMAGE_VERSION=7.1.2-fpm docker-compose build
    DOCKERFILE_FLAVOUR=debian PHP_BASE_IMAGE_VERSION=7.1.2-fpm docker-compose run --rm php php /tests/requirements.php   