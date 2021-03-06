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

### Requests

Please, do not forget to use proper `Accept` and `Content-Type` headers to obtain proper response:

```text
POST /questions HTTP/1.1
Host: localhost:8888
Content-Type: application/json
Accept: application/json
cache-control: no-cache
{
    "text": "What is the answer?",
    "createdAt": "2019-06-01T00:00:00+00:00",
    "choices": [
        {
            "text": "Choice 1"
        },
        {
            "text": "Choice 2"
        },
        {
            "text": "Choice 3"
        }
    ]
}
```

Currently the **content negotiation** supports only `application/json`.

## Configuration

### Setup storage Type

The application supports two different types of storage, CSV or JSON. To switch between them you just need to change this configuration:

```php
[
    'settings.dataSource.type' => 'csv',
];
```

### Setup translation

The application is using [Stichoza/google-translate-php](https://github.com/Stichoza/google-translate-php) for translation. It is possible to customize timeout settings. If there is a timeout, the original text will be returned.

```php
[
    'settings.translation.timeoutInSeconds' => 3,
];
``` 

You can also use your custom translation class:

```php
use Questions\Infrastructure\Translation\TranslatorInterface;

class MyTranslator implements TranslatorInterface
{
    public function translate(string $text, string $toLang): string
    {
         //Custom translator logic...
    }
}
```

And then change the class identifier:

```php
[
    'settings.translation.class' => MyTranslator::class,
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