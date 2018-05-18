# illuminate-uqueue-testing
Test Lumen-project based on https://github.com/mingalevme/illuminate-uqueue


Input:

```bash
docker run --name postgres-lumen-uqueue -e POSTGRES_PASSWORD=postgres -d -p 54320:5432 postgres:9.5
docker run --name redis-lumen-uqueue -d -p 63790:6379 redis

cd /tmp
git clone git@github.com:mingalevme/illuminate-uqueue-testing.git
cd illuminate-uqueue-testing
composer install
phpunit
cd -
rm -rf illuminate-uqueue-testing
```

And output from phpunit:

```php
PHPUnit 7.1.5 by Sebastian Bergmann and contributors.

.....                                                               5 / 5 (100%)

Time: 235 ms, Memory: 18.00MB

OK (5 tests, 23 assertions)
```
