#!/bin/bash

DOCKER_BE = symfony-api-platform-be
OS := $(shell uname)

ifeq ($(OS),Darwin)
	UID = $(shell id -u)
else ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

up: ## Up the containers
	docker-compose up -e U_ID=${UID} -d

run: ## Start the containers
	docker network create symfony-api-platform-network || true
	docker-compose up -e U_ID=${UID} -d

stop: ## Stop the containers
	docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install

# Backend commands
composer-install: ## Installs composer dependencies
	docker exec -e U_ID=${UID}  --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

migrations: ## Runs the migrations
	 docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n

be-logs: ## Tails the Symfony dev log
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log
# End backend commands

ssh-be: ## ssh's into the be container
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix tests --rules=@Symfony

generate-ssh-keys: ## Generates SSH keys for the JWT library
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} mkdir -p config/jwt
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} openssl genrsa -passout pass:767b453a97ac019714eb7ccbce781d16 -out config/jwt/private.pem -aes256 4096
	docker exec -e U_ID=${UID} -it --user ${UID} ${DOCKER_BE} openssl rsa -pubout -passin pass:767b453a97ac019714eb7ccbce781d16 -in config/jwt/private.pem -out config/jwt/public.pem