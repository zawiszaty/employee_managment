# shellcheck disable=SC2091
until $(curl --output /dev/null --silent --head --fail http://localhost:9999/healtcheck); do
    printf '.'
    sleep 5
done