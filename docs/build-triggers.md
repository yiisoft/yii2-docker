## Building

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