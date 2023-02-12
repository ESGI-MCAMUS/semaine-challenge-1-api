turboinstall: build start

start:
	docker-compose up --detach

stop:
	docker-compose stop

down:
	docker-compose down --remove-orphans --volumes --timeout 0

restart:
	docker-compose restart

fixture:
	docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

cache:
	docker-compose exec php bin/console cache:clear --no-warmup

composer:
	rm -rf vendor/* && docker-compose exec php composer install

createMigration:
	docker-compose exec php bin/console make:migration

migrate:
	docker-compose exec php bin/console doctrine:migrations:migrate

bdd:
	docker-compose exec php bin/console d:s:u --force

build:
	docker-compose build --pull --no-cache

resetDb:
	docker-compose exec php bin/console doctrine:schema:drop --force && docker-compose exec php bin/console doctrine:schema:create && docker-compose exec php bin/console doctrine:fixtures:load --no-interaction
