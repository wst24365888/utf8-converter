shell:
	docker exec -it utf8-converter-app bash || exit 0

tinker:
	docker exec -it utf8-converter-app php artisan tinker || exit 0

migrate:
	docker exec -it utf8-converter-app php artisan migrate || exit 0

update-packages:
	docker exec -it utf8-converter-app composer update --with-all-dependencies

mysql:
	docker exec -it utf8-converter-db mysql -u root -p || exit 0

build:
	docker-compose --build

rebuild:
	docker-compose up --build -d

up:
	docker-compose up -d

down:
	docker-compose down