<p align="center">
    <h1 align="center">Yii2 PHP Docker Image</h1>
    <br>
</p>

[![Build Status](https://github.com/yiisoft/yii2-docker/actions/workflows/docker-image.yml/badge.svg)](https://github.com/yiisoft/yii2-docker/actions/workflows/docker-image.yml)

This is the repo of the official [Yii 2.0 Framework](http://www.yiiframework.com/) image on [DockerHub](https://hub.docker.com/r/yiisoftware/yii2-php/) for PHP.

## About

These Docker images are built on top of the official PHP Docker image, they contain additional PHP extensions required to run Yii 2.0 framework, but no code of the framework itself.
The `Dockerfile`(s) of this repository are designed to build from different PHP-versions by using *build arguments*.

### Available versions for `yiisoftware/yii2-php`

The following images are built on a *weekly* basis for **arm64** and **amd64**. For regular commits on **master** we only build images for **amd64** suffixed with `-latest`/`-latest-min`.

Minimal images

```
8.5-apache-min, 8.5-fpm-min, 8.5-fpm-nginx-min
8.4-apache-min, 8.4-fpm-min, 8.4-fpm-nginx-min
8.3-apache-min, 8.3-fpm-min, 8.3-fpm-nginx-min
8.2-apache-min, 8.2-fpm-min, 8.2-fpm-nginx-min
8.1-apache-min, 8.1-fpm-min, 8.1-fpm-nginx-min
```

Development images

```
8.5-apache, 8.5-fpm, 8.5-fpm-nginx
8.4-apache, 8.4-fpm, 8.4-fpm-nginx
8.3-apache, 8.3-fpm, 8.3-fpm-nginx
8.2-apache, 8.2-fpm, 8.2-fpm-nginx
8.1-apache, 8.1-fpm, 8.1-fpm-nginx
```

> **Warning:** PHP 8.1 is end of life and gets no security fixes from the PHP project anymore. The `8.1-*` images are still rebuilt, but remain affected by CVE-2026-109618 and CVE-2026-109619 (PHP2Shell). Do not expose them to untrusted traffic, upgrade to 8.2 or later.

#### Deprecated or EOL versions

No longer rebuilt, no security fixes from PHP (e.g. CVE-2026-109618, CVE-2026-109619).

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

    cp .env-dist .env

Adjust the versions in `.env` if you want to build a specific version.

> **Note:** Please make sure to use a matching combination of `DOCKERFILE_FLAVOUR` and `PHP_BASE_IMAGE_VERSION`

## Configuration

- `GITHUB_API_TOKEN` access key for repositories on GitHub
- `GITLAB_ACCESS_TOKEN` access key for repositories in GitLab
- `PHP_ENABLE_XDEBUG` whether to load an enable Xdebug, defaults to `0` (false)  *not available in `-min` images*
- `PHP_USER_ID` (Debian only) user ID, when running commands as webserver (`www-data`), see also [#15](https://github.com/yiisoft/yii2-docker/issues/15)

### Upload limits

Request bodies are limited to 64M (`post_max_size=64M`, `upload_max_filesize=60M`, nginx `client_max_body_size 64M`, Apache `LimitRequestBody 67108864`). Previous images allowed 512M, the limit was lowered as a mitigation for CVE-2026-109618. If your application needs larger uploads, raise all values together, e.g. with an additional ini file in `/usr/local/etc/php/conf.d/` and a matching web server setting.

## Building

    docker-compose build

## Testing

    docker-compose run --rm php php /tests/requirements.php

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
