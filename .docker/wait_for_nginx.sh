#!/bin/bash
printf 'Wait for nginx: '

until curl --output /dev/null --silent --head --fail http://localhost/healtcheck; do
    printf '.'
    sleep 1
done

printf '\nSuccess!!!'

