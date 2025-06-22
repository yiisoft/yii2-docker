<p align="center">
    <h1 align="center">Track management</h1>
    <br>
</p>

[![Build Status](https://github.com/yiisoft/yii2-docker/actions/workflows/docker-image.yml/badge.svg)](https://github.com/yiisoft/yii2-docker/actions/workflows/docker-image.yml)

This demo application based on the official [Yii 2.0 Framework](http://www.yiiframework.com/) image on [DockerHub](https://hub.docker.com/r/yiisoftware/yii2-php/) for PHP.

## About

These Docker images are built on top of the official PHP Docker image, they contain additional PHP extensions required to run Yii 2.0 framework, but no code of the framework itself.
The `Dockerfile`(s) of this repository are designed to build from different PHP-versions by using *build arguments*.

### Available versions for `yiisoftware/yii2-php`

The following images are built on a *weekly* basis for **arm64** and **amd64**. For regular commits on **master** we only build images for **amd64** suffixed with `-latest`/`-latest-min`.

Minimal images

```
8.3-apache-min, 8.3-fpm-min, 8.3-fpm-nginx-min
8.2-apache-min, 8.2-fpm-min, 8.2-fpm-nginx-min
8.1-apache-min, 8.1-fpm-min, 8.1-fpm-nginx-min
```

Development images

```
8.3-apache, 8.3-fpm, 8.3-fpm-nginx
8.2-apache, 8.2-fpm, 8.2-fpm-nginx
8.1-apache, 8.1-fpm, 8.1-fpm-nginx
```

#### Deprecated or EOL versions

```
8.0-*
7.4-*
7.3-*
7.2-*
7.1-*
7.0-*
5.6-*
```

## Setup

    cp .env.example .env

Adjust the versions in `.env` if you want to build a specific version. See .env-dist for details.

> **Note:** Please make sure to use a matching combination of `DOCKERFILE_FLAVOUR` and `PHP_BASE_IMAGE_VERSION`

## Configuration

- `GITHUB_API_TOKEN` access key for repositories on GitHub
- `GITLAB_ACCESS_TOKEN` access key for repositories in GitLab
- `PHP_ENABLE_XDEBUG` whether to load an enable Xdebug, defaults to `0` (false)  *not available in `-min` images*
- `PHP_USER_ID` (Debian only) user ID, when running commands as webserver (`www-data`), see also [#15](https://github.com/yiisoft/yii2-docker/issues/15)

## Building

    docker-compose build

## Run services 

docker-compose up

## Testing application requirements

    docker-compose run --rm php-dev php /tests/requirements.php

## Apply DB migration

docker-compose run --rm php-dev yii migrate

## Backoffice 

http://localhost:8202/track 

## REST API

http://localhost:8202/api/tracks secured, use Bearer 101-token for development 

#### POST new track
```
curl -i -X POST \
   -H "Authorization:Bearer 101-token" \
   -H "Content-Type:application/json" \
   -d \
'{
  "track_number": "9876KJGJG8698769",
  "status": "new"
}' \
 'http://localhost:8202/api/tracks'
 ```


#### PATCH existing track
```
curl -i -X PATCH \
   -H "Authorization:Bearer 101-token" \
   -H "Content-Type:application/json" \
   -d \
'{
  "status": "completed"
}' \
 'http://localhost:8202/api/tracks/1'
 ```

#### Delete track 

```
curl -i -X DELETE \
   -H "Authorization:Bearer 101-token" \
 'http://localhost:8202/api/tracks/1'
 ```


#### filter tracks by status

```
curl -i -X GET \
   -H "Authorization:Bearer 101-token" \
   -H "Content-Type:application/json" \
 'http://localhost:8202/api/tracks?filter%5Bstatus%5D=new'
 ```

 #### Bulk update 

```
curl -i -X PATCH \
   -H "Authorization:Bearer 101-token" \
   -H "Content-Type:application/json" \
   -d \
'[
  {
    "status": "completed",
    "id":2
  },
  {
    "status": "in_progress",
    "id":3
  }
]' \
 'http://localhost:8202/api/tracks/bulkupdate'
 ```

### UNIT tests 
current settings & best practices uses separate database to run tests isolated from development & production, so you need to prepare db or change settings in [test_db](https://github.com/ioncode/TrackCOD/blob/8bf943365db799d436b0efd5d26cc654ad2c5c7b/_host-volumes/app/config/test_db.php)

connect to db service, using password `root` 
```
docker-compose run --rm db mysql -h db -u root -p
```
create database & user for tests 
```
create database test;
CREATE USER 'test' IDENTIFIED BY 'test';
GRANT ALL ON test.* TO 'test';
exit;
```
apply migrations on test db 
```
docker-compose run --rm php-dev php tests/bin/yii migrate
```


run all tests (including framework base tests)
```
docker-compose run --rm php-dev /app/vendor/bin/codecept run
```

#### Track unit tests for model & REST API controller 
```
docker-compose run --rm php-dev /app/vendor/bin/codecept run unit :Track
```




### Xdebug

To enable Xdebug, set `PHP_ENABLE_XDEBUG=1` in .env file

Xdebug is configured to call ip `xdebug.remote_host` on `9005` port (not use standard port to avoid conflicts),
so you have to configure your IDE to receive connections from that ip.

## Documentation

More information can be found in the [docs](/docs) folder.

## FAQ

- We do not officially support Alpine images, due to numerous issues with PHP requirements and because framework tests are not passing.
- Depending on the (Debian) base-image (usually PHP <7.4) you might need to set `X_LEGACY_GD_LIB=1`
- test
