# Backend test project

## Running the tests

Before running the tests the following commands should be run:

1. php bin/console doctrine:database:create --env=test
2. php bin/console doctrine:migration:migrate --env=test

It was not automated in any way as it is expected to happen in an automated way if ci would be set up.

To run the tests run `composer run test`.
