# Questions Api

A simple API to handle questions.

## Features

* Create new questions and related choices.
* List questions.
* Translated listed question by a valid ISO-639-1 code.

## Install

```
composer install
```

**Note**: Db files will be created by composer post-install.

### Initialize application

```
php -S localhost:8888 -t public
```

Access the application [here](http://localhost:8888).

### OpenApi documentation

View it using [Swagger Editor](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gabrielfs7/questions-api/master/doc/openapi.yaml).

## Configuration

The application supports two different types of storage, CSV or JSON. To switch between them you just need to change this configuration:

```php
[
    'settings.dataSource.type' => 'csv',
];
```

Configurations per environment are located [here](/config). 

## Tests

The application uses BDD tests. You can run them by:

```
bin/behat
```

## Standards

Run the php-cs-fixer to make sure application code will follow the standards.

```
bin/php-cs-fixer fix --verbose src/
```