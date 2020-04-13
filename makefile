.Phony: start
start:
	mkdir -p web/private
	docker-compose up -d
	docker-compose exec -T php sh ./.docker/wait_for_nginx.sh
	make db

.Phony: php
php:
	docker-compose exec php /bin/bash

.Phony: test
test:
	docker-compose exec -T php php composer.phar test

.Phony: env
env:
	cp .env.dist .env

.Phony: db
db:
	docker-compose exec php ./bin/console d:d:c --if-not-exists
	docker-compose exec php ./bin/console d:m:m -n
