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

These Docker images are built on top of the official PHP Docker image, they contain additional PHP extensions required to run Yii 2.0 framework.
The `Dockerfile`(s) of this repository are design to build various versions by using *build arguments*.



## Setup

    cp .env-dist .env
    
Adjust the versions in `.env` if you want to build a specific version. 

> **Note:** Please make sure to use a matching combination of `DOCKERFILE_FLAVOUR` and `PHP_BASE_IMAGE_VERSION`


## Configuration

- `PHP_ENABLE_XDEBUG` whether to load an enable Xdebug, defaults to `0` (false)
- `PHP_USER_ID` (Debian only) user ID, when running commands as webserver (`www-data`)


## Building

    docker-compose build


## Testing

    docker-compose run --rm php php /tests/requirements.php


## Documentation

More information can be found in the [docs](/docs) folder.


## FAQ

- Error code `139` on Alpine for PHP `5.6-7.1` results from a broken ImageMagick installation         

