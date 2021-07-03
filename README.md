# utf8-converter

## Usage

1. Clone this project.

2. `cp .env.example .env`, then configure the password of mysql in `.env`.

3. `cp docker-compose.yml.example docker-compose.yml`, then configure the password of mysql in `docker-compose.yml`.

4. `make build` if you are in linux shell. If not, use `docker-compose up --build -d`.

5. `make migrate` if you are in linux shell. If not, use `docker exec -it utf8-converter-app php artisan migrate`.

6. The process will run on port 8001.
