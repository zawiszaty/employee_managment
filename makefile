.Phony: start
start:
	docker-compose up -d
	docker-compose exec -T php sh ./.docker/wait_for_nginx.sh
.Phony: php
php:
	docker-compose exec php /bin/bash

.Phony: test
test:
	docker-compose exec -T php php composer.phar test