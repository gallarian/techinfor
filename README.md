# Techinfor

## Initialization project

### without Make:
1. Install dependencies:
    ```
    composer install
    ```
2. Configure environment variables: DATABASE_URL
3. Run commands:
    ```
    php bin/console doctrine:database:create --> create your database
    php bin/console doctrine:schema:update -f --> update your schema of database
    ```
4. Run tests:
    ```
    vendor/bin/bdi detect drivers
    php bin/phpunit
    ```