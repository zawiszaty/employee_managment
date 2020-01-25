#!/bin/bash
printf 'Wait: '
until $(curl --output /dev/null --silent --head --fail http://localhost/healtcheck); do
    printf '.'
    sleep 1
done
printf '\nSuccess!!!'