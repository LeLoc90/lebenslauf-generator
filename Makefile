install: ## Install
	@docker compose up -d
	@composer install --optimize-autoloader
	@composer dump-autoload
	@npm install
	@$(MAKE) cache

create-database: ## Create Database
	@php bin/console doctrine:database:create

validate-database: ## Create Database
	@php bin/console doctrine:schema:validate

drop-database: ## Delete Database
	@php bin/console doctrine:database:drop --force

database: ## Delete Database
	@$(MAKE) drop-database
	@$(MAKE) create-database

migrations: ## Create migrations
	@php bin/console doctrine:migrations:diff

migrate: ## Run migrations
	@php bin/console doctrine:migrations:migrate -n

migrate-rollback: ## Rollback migrations
	@php bin/console doctrine:migrations:migrate prev -n

fixtures: ## Load sample Data
	@docker compose exec  php php bin/console doctrine:fixtures:load -n

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
	@docker compose stop

recreate: ## recreate containers
	@$(MAKE) stop
	@docker compose rm -f
	@docker compose build
	@$(MAKE) start
