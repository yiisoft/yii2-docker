#!/bin/bash
#
# Use like:
#
#     ./run.sh <image> <type:(http|fcgi)> <flavour:(min|common)>

if [ -z $1 ]; then
    echo 'No image supplied'
    exit 1
fi
if [ -z $2 ]; then
    echo 'No type supplied'
    exit 1
fi
if [ -z $3 ]; then
    echo 'No flavour supplied'
    exit 1
fi

echo "testing $1"

if [ $3 = "min" ]; then
    QUERY='flavour=min'
elif [ $3 = "common" ]; then
    QUERY='flavour=common'
else
    echo >&2 "Invalid flavour $3"
    exit 1
fi


if [ $2 = "http" ]; then
    ID=$(docker run -d -p 80:80 -v $PWD:/var/www/html --name test $1)
    sleep 3
    RESULT=$(curl -s "http://localhost/checker.php?$QUERY")
elif [ $2 = "fcgi" ]; then
    ID=$(docker run -d -p 9000:9000 -v $PWD:/var/www/html --name test $1)
    sleep 3
    RESULT=$(REQUEST_METHOD=GET \
        SCRIPT_NAME="checker.php" \
        SCRIPT_FILENAME='/var/www/html/web/checker.php' \
        QUERY_STRING="$QUERY" \
        cgi-fcgi -bind -connect 127.0.0.1:9000 | tail -1)
else
    echo >&2 "Invalid type $2"
    exit 1
fi

if [ "$RESULT" != "OK" ]; then
    echo >&2 "failed"
    echo >&2 "$RESULT"
    $(docker stop test)
    $(docker rm test)
    exit 1
fi

$(docker stop test)
$(docker rm test)
echo "passed"
exit 0
