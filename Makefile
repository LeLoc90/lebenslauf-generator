install: ## Install
	@docker compose up -d
	@composer install --optimize-autoloader
	@composer dump-autoload
	@npm install --force
	@$(MAKE) cache

update: ## Update
	@composer update --optimize-autoloader
	@composer dump-autoload
	@$(MAKE) cache

cache: ## Clears the cache.
	@php bin/console cache:clear

enter: ## Enter php container
	@bash

start: ## Start Containers
	@docker compose up -d
	symfony server:start -d --no-tls --port=8500
	npm run dev-server
	symfony server:log

stop: ## Stop Containers
	@#docker compose stop
	symfony server:stop

recreate: ## recreate containers
	@$(MAKE) stop
	@docker compose rm -f
	@docker compose build
	@$(MAKE) start
