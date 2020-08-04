demo:

    composer install --no-dev
    php app.php tests/input.txt

tests:

    composer install
    vendor/bin/phpunit tests
