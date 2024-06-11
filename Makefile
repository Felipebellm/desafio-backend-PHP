build:
	docker-compose up -d
	docker-compose exec app composer install
	cp .env.example .env
	docker-compose exec app chmod -R 755 .
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan session:table
	docker-compose exec app php artisan migrate
	docker-compose exec app composer require guzzlehttp/guzzle symfony/dom-crawler
	docker-compose exec app php artisan serve

test: