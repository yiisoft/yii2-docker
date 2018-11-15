# Running framework tests

Get the source and place it into a host-volume folder for mounting it into the container.

    git clone https://github.com/yiisoft/yii2 _host-volumes/yii2
    
Enter the container with 

    docker-compose run --rm -w /yii2 php bash    

Go into the container and install packages

>     composer install

Run the tests

>     vendor/bin/phpunit tests/framework/ --exclude db

Switching to another framework version

>     git checkout 2.0.12


## Using a specific PHP version

    DOCKERFILE_FLAVOUR=debian PHP_BASE_IMAGE_VERSION=7.1.2-fpm docker-compose build
    DOCKERFILE_FLAVOUR=debian PHP_BASE_IMAGE_VERSION=7.1.2-fpm docker-compose run --rm php bash
