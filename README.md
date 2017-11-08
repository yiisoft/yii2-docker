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


This is the repo of the official [yii2](http://www.yiiframework.com/)
[docker image](https://hub.docker.com/r/yiisoft/yii2-php/) for PHP.

> ### Status
> This is still work in progress. The images are not yet available on docker hub.


## Setup

    cp .env-dist .env
    
Adjust the versions in `.env` if you want to build a specific version. 

> **Note:** Please make sure to use a matching combination of `DOCKERFILE_FLAVOUR` and `PHP_BASE_IMAGE_VERSION`
   

## Building

    docker-compose build

## Testing

    docker-compose run --rm php php /tests/requirements.php

## Documentation

More information can be found in the [docs](/docs) folder.
                
## FAQ

- Error code `139` on Alpine for PHP `5.6-7.1` results from a broken ImageMagick installation         

