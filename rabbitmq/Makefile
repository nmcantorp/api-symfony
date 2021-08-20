#!/bin/bash

RABBIT = symfony-api-platform-rabbitmq
UID = $(shell id -u)

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	docker-compose up -d -e U_ID=${UID} 

stop: ## Stop the containers
	docker-compose stop -e U_ID=${UID} 

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	docker-compose build -e U_ID=${UID} 

ssh: ## ssh's into the container
	docker exec -it --user ${UID} ${RABBIT} bash -e U_ID=${UID} 