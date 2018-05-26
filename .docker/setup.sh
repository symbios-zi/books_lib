#!/bin/bash

#copy env to docker and application. At this time I will use one file for both cases
cp ../.env.example ../.env
cp ../.env.example ./.env

docker-compose up -d --build

composer install -d=../

#migrate tables
docker-compose exec app php artisan migrate

#seed sample data
docker-compose exec app php artisan db:seed --class="AuthorSeeder"