# Simple library API

### SETUP
To setup infrastructure you should follow step described below: <br>
1. Change dir to .docker ```cd .docker```
2. Run command ```chmod +x``` and after ```./setup.sh```

### TESTS
To start tests u should run command ```./vendor/bin/phpunit``` inside app container

### API

[POST] ```/api/v1/scan``` <br>
[GET]  ```/api/v1/books```        - accept parameters: from_year, to_year, author_full_name <br>
[GET]  ```/api/v1/cds```          - accept parameters: from_year, to_year, author_full_name <br>
[GET]  ```/v1/authors/average```  - accepts parameter: author_full_name <br>

### LOGS
All operations of storing data will be logged into file storage/logs/scan.log