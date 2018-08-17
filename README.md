<p align="center">
    <a href="https://www.docker.com/" target="_blank">
        <img src="https://www.docker.com/sites/default/files/mono_vertical_large.png" height="100px">
    </a>
    <h1 align="center">Yii2 PHP Docker Image</h1>
    <br>
</p>

**Stable**
[![Build Status](https://travis-ci.org/yiisoft/yii2-docker.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-docker)
**Development**
[![pipeline status](https://gitlab.com/yiisoft/yii2-docker/badges/master/pipeline.svg)](https://gitlab.com/yiisoft/yii2-docker/commits/master)


This is the repo of the official [Yii 2.0 Framework](http://www.yiiframework.com/) image on [DockerHub](https://hub.docker.com/r/yiisoftware/yii2-php/) for PHP.

> ### Status
> This is still work in progress. The images available on docker hub are in **public preview** state.

## About

These Docker images are built on top of the official PHP Docker image, they contain additional PHP extensions required to run Yii 2.0 framework, but no code of the framework itself.
The `Dockerfile`(s) of this repository are designed to build from different PHP-versions by using *build arguments*.



## Setup

    cp .env-dist .env
    
Adjust the versions in `.env` if you want to build a specific version. 

> **Note:** Please make sure to use a matching combination of `DOCKERFILE_FLAVOUR` and `PHP_BASE_IMAGE_VERSION`


## Configuration

- `PHP_ENABLE_XDEBUG` whether to load an enable Xdebug, defaults to `0` (false)
- `PHP_USER_ID` (Debian only) user ID, when running commands as webserver (`www-data`), see also [#15](https://github.com/yiisoft/yii2-docker/issues/15)
- `APACHE_ENABLE_REWRITE` whether to load or enable apache2 mod_rewrite, defaults to `1` (true)



## Building

    docker-compose build


## Testing

    docker-compose run --rm php php /tests/requirements.php

## Xdebug

To enable Xdebug, set `PHP_ENABLE_XDEBUG=1` in .env file

Xdebug is configured to call ip 10.254.254.254 on 9005 port (not use standard port to avoid conflicts),
so you have to configure your IDE to receive connections from that ip.

The port 9005 is enabled in docker-compose.apache.yml and to activate ip 10.254.254.254 locally, on MacOS the command is: 

    ifconfig lo0 alias 10.254.254.254

## MySQL and PhpMyAdmin support

If you want to add mysql and phpmyadmin support, copy .env-dist.mysql-and-phpmyadmin file instead .env-dist

    cp .env-dist.mysql-and-phpmyadmin .env

the rebuild:

    docker-compose build

You have other settings that can be changed:

- `MYSQL_HOST` host to connect to mysql server
- `MYSQL_DATABASE` name of a databased created at boot
- `MYSQL_ROOT_PASSWORD` password of root user
- `MYSQL_USER` username of user created at boot
- `MYSQL_PASSWORD` password of user created at boot    

To test MySQL and PhpMyAdmin support, start the services

    docker-compose up -d

To connect to PhpMyAdmin, go to http://localhost:8888 and type:

- `mysql` as server
- `root` as username (or dev)
- `root` as password (or dev)

These values can be changed inside `.env-dist.mysql-and-phpmyadmin` file.

To test mysql connection inside the php container, connect to it

    docker exec -it yii2apache_php_1 bash

(adjust yii2apache_php_1 with php container name if is different)

and then try to connect to mysql:

    mysql -h mysql -u root -proot

and you should enter inside mysql console.

Now you can connect to mysql also from Yii app.

## Documentation

More information can be found in the [docs](/docs) folder.


## FAQ

- Error code `139` on Alpine for PHP `5.6-7.1` results from a broken ImageMagick installation         
