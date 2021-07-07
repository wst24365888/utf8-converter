shell:
	docker exec -it utf8-converter-app /bin/sh || exit 0

tinker:
	docker exec -it utf8-converter-app php artisan tinker || exit 0

migrate:
	docker exec -it utf8-converter-app php artisan migrate

crontab:
	docker exec -itd utf8-converter-app php artisan schedule:work

stop-crontab:
	docker exec -itd utf8-converter-app /bin/sh ./stop-crontab.sh

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