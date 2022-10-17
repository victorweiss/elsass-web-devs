#!make

appContainer = 'ewd_app'

.DEFAULT_GOAL := help
.PHONY: help
help:
	@echo "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m"
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' Makefile| sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: start
start: ## Start coding
	docker-compose up -d
	docker-compose --profile yarn up -d
	docker-compose logs -f

.PHONY: stop
stop: ## Stop coding
	docker-compose down

.PHONY: install
install: ## /!\ [SERVER] Install
	docker-compose --env-file .env.prod.local up -d --build
	docker exec -t $(appContainer) bash -c "bash /opt/docker-start.sh"
	docker-compose --profile yarn up -d --build
