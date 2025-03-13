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

create-database: ## Create Database
	@symfony console doctrine:database:create

drop-database: ## Delete Database
	@symfony console doctrine:database:drop --force

create-migration:
	@symfony console doctrine:migrations:diff

migrate: ## Run migrations
	@symfony console doctrine:migrations:migrate -n

fixtures: ## Load sample Data
	@symfony console doctrine:fixtures:load -n

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
