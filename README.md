# Backend test project

## Design

For the data storage MySQL was used as there was already experience with running it.
We used PHP and Symfony framework for the development of the API along with doctrine.

Several parts of the code could be better developed but due to time constraints they were not.
For example:

* Validation of the Car's entity date property should be done through a custom validation constraint.
* Better data handling with fixtures should be done in the tests
* Docker automation should be improved to run all the necessary commands at the start of the container
* All the endpoints for colours should have been created

## How to run the project

You need to have docker installed. Just run `docker-compose -f docker-compose.yml up`

In order for the project to run we need to run the following command inside the container the first time after we start it:

```sh
php /var/www/backend_test/bin/console doctrine:database:create ; \
php /var/www/backend_test/bin/console doctrine:migrations:migrate ; \
php /var/www/backend_test/bin/console doctrine:database:create --env=test ; \
php /var/www/backend_test/bin/console doctrine:migrations:migrate --env=test ;
```

In order to connect to the container and run the command, open powershell and run `docker exec -ti php sh`

## Running the tests

Before running the tests the following commands should be run:

1. php bin/console doctrine:database:create --env=test
2. php bin/console doctrine:migration:migrate --env=test

We cover above the way to run the commands in the docker container and propably you have already done it.

It was not automated in any way as it is expected to happen in an automated way if ci would be set up.

To run the tests run `composer run test`.
