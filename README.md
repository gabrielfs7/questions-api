# Questions Api

A simple API to handle questions.

### Install

```
composer install
```

### Initialize application

```
php -S localhost:8888 -t public
```

Access the application [here](http://localhost:8888).

### OpenApi documentation

View it using [Swagger Editor](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gabrielfs7/questions-api/master/doc/openapi.yaml).

### Run tests

```
bin/behat
```

### Code Standards

Run code fixer:

```
bin/php-cs-fixer fix --verbose src/
```