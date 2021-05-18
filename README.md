# Techinfor

## Initialization project

### without Make:
1. Install dependencies:
    ```
    composer install
    ```
2. Configure environment variables: DATABASE_URL
3. Database:
    ```
    php bin/console doctrine:database:create --> create your database
    php bin/console doctrine:schema:update -f --> update your schema of database
    ```
4. Drivers for tests end-to-end:
    ```
    vendor/bin/bdi detect drivers
    ```
### with Make:
1. Database:
    ```
    make db
    ```
2. Database tests:
    ```
    make db env=test
    ```
3. Coding style:
    ```
    make phpcs
    make phpcbf
    ```