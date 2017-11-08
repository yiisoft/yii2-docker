# Running framework tests

Get the source and place it into a host-volume folder for mounting it into the container.

    git clone https://github.com/yiisoft/yii2 _host-volumes/app

Go into the container and install packages

>     composer install

Run the tests

>     vendor/bin/phpunit tests/framework/ --exclude db

Switching to another framework verion

>     git checkout 2.0.12