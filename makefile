.Phony: start
start:
	docker-compose up -d
	docker-compose exec -T php sh ./.docker/wait_for_nginx.sh
.Phony: php
php:
	docker-compose exec php /bin/bash