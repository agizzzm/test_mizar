## Installation

Clone project:

```bash
git clone https://ateshabaev@bitbucket.org/ateshabaev/php-task-symfony-boilerplate.git
```

With docker:

> Make sure you have docker & docker-compose installed (https://docs.docker.com/get-docker/).

```bash
docker-compose up -d
docker-compose exec -T php composer install --no-interaction
docker-compose exec -T php php yii migrate
```

This will start all the required services (check docker-compose.yml for the list of services), clear cache & apply
migrations.

Without Docker:

- Install PostgreSQL or other database
- Install PHP and required dependencies for sql, etc (see .docker/php/Dockerfile for list of dependencies)
- Install & configure Nginx or Apache
- Make sure you change environment variables in `.env` file

## Run Application

See application be URL: [http://localhost:10000](http://localhost:10000).

If port `10000` doesn't work, check `APP_PORT` variable in `.env` for the correct port.  

## Create company (CLI mode)
docker-compose exec -T php php yii company/create --name=testcompany --url=https://google.ru

## REST API 
[docs here](REST.md) 