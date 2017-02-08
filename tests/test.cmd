cd %~dp0
docker exec -it guzzlehttp_php_1 bash -c "phpunit --bootstrap vendor/autoload.php tests"
