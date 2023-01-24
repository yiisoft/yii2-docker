# Build on GitLab

## Configuration

Example build configuration

```yaml
image: docker:latest

services:
  - docker:dind

variables:
  DOCKERFILE_FLAVOUR: debian
  PHP_BASE_IMAGE_VERSION: fpm
  PHP_IMAGE_NAME: yiiframework/php
  TEST_YII_VERSION: 11b14ea7df25c37ae262ce6b20167fe30a407367

before_script:
  - env
  - apk add --no-cache git curl docker-compose
  - git clone https://github.com/yiisoft/yii2 _host-volumes/yii2
  - git -C _host-volumes/yii2 checkout ${TEST_YII_VERSION}
  - cp .env-dist .env
  - docker info

build:
  environment:
    name: ${DOCKERFILE_FLAVOUR}/php-${PHP_BASE_IMAGE_VERSION}
  script:
    - docker-compose build
    - docker-compose run --rm php-min php -v
    - docker-compose run --rm php-min php /tests/requirements.php
    - docker-compose run --rm php-dev php /tests/requirements.php
    - docker-compose run --rm -w /yii2 php-dev composer install
    - docker-compose run --rm -w /yii2 php-dev php -d error_reporting="E_ALL ^ E_DEPRECATED" vendor/bin/phpunit tests/framework/ --exclude db
```
## Triggers

Repo maintainers can trigger the build of a specific version via GitLab API

    curl -X POST \
         -F token=${GITLAB_YII2_DOCKER_TOKEN} \
         -F ref=master \
         -F "variables[DOCKERFILE_FLAVOUR]=debian" \
         -F "variables[PHP_BASE_IMAGE_VERSION]=7.1.3-apache" \
         -F "variables[TEST_YII_VERSION]=2.0.11" \
         https://gitlab.com/api/v4/projects/2858803/trigger/pipeline    

This can also be used to test pre-releases of PHP or other flavors, if there is a Dockerfile available for them.

> Tokens are managed under [GitLab settings](https://gitlab.com/yiisoft/yii2-docker/settings/ci_cd).
