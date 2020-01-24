.Phony: start
start:
	docker-compose up -d
	docker-compose exec php ./.docker/entrypoint.sh
.Phony: php
php:
	docker-compose exec php /bin/bash