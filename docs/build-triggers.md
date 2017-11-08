## Building

Repo maintainers can trigger the build of a specific version via GitLab API

    curl -X POST \
         -F token=${GITLAB_TOKEN} \
         -F ref=feature/refactoring \
         -F "variables[DOCKERFILE_FLAVOUR]=alpine" \
         -F "variables[PHP_BASE_IMAGE_VERSION]=7.0.4" \
         -F "variables[TEST_YII_VERSION]=2.0.10" \
         https://gitlab.com/api/v4/projects/2858803/trigger/pipeline    

This can also be used to test pre-releases of PHP or other flavors, if there is a Dockerfile available for them.
