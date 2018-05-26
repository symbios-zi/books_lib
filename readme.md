# Simple library API



### SETUP
To setup infrastructure you should follow step described below: <br>
1. Run ```composer install``` in the application dir
2. Copy .env.example to .env
3. Go to dir **.docker** ```cd .docker``` and run ```docker-compose up -d```
4. Run `docker-compose exec app php artisan migrate`
5. Run `docker-compose exec app php artisan db:seed --class="AuthorSeeder"`


### TESTS
To start tests u should run command ```./vendor/bin/phpunit``` inside **app** container <br>
You can connect to this container using command ```docker-compose exec app bash```

### API

[POST] ```/api/v1/scan``` <br>
[GET]  ```/api/v1/books```        - accept parameters: from_year, to_year, author_full_name <br>
[GET]  ```/api/v1/cds```          - accept parameters: from_year, to_year, author_full_name <br>
[GET]  ```/v1/authors/average```  - accepts parameter: author_full_name <br>

### LOGS
All operations of storing data will be logged into file storage/logs/scan.log