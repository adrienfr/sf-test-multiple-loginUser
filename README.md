# sf-test-multiple-loginUser

## Test
```bash
composer install
php bin/console --env=test doctrine:database:create
php bin/console --env=test doctrine:schema:create
bin/phpunit tests
```
