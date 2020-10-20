## About Project

This is a Laravel project, to simulate transferring funds between wallets, a simple API based backend.

## Build and Run Project

This project dockerized to use independent of your OS and covers all requirements. Check your docker & docker-compose version by `docker -v` and `docker-compose -v`. If needed, install them on your system.

- Now running `docker-compose up` will populate the webapp on containers, include Nginx server, App container and MySQL DB server. Please wait until this message: _/usr/sbin/mysqld: ready for connections_
- Now make a copy from _.env.example_ to _.env_ file. Current values for DB works fine, but in real world example, don't use those simple values for passwords, and change them in _docker-compose.yml_ before running docker.
- Run `docker exec -it app composer install` to install composer dependencies.
- Run `docker exec -it app php artisan key:generate` to set your application key to a random string.
- Run `docker exec -it app php artisan migrate` to make tables in MySQL DB.
- Run `docker exec -it app php artisan passport:install` to create the encryption keys.
- If you want, you can run `docker exec -it app php artisan db:seed` to fill DB with sample data for users and wallets. You need to register yourself, store a wallet to start transactions.
- Finally, you can see the result at [http://localhost:8080/](http://localhost:8080/) on your browser.

You can see the most important codes in _app/Http/Controllers/API/*_ and _routes/api.php_.

To access APIs, use these methods/endpoints:
```
POST         | api/register                | register a new user and login and reach access token
POST         | api/login                   | login a user and reach access token

POST         | api/wallets                 | store a new wallet for auth user
GET          | api/wallets/{wallet}        | collect data about specific wallet of auth user
GET          | api/wallets                 | collect all data about all wallets of auth user and some data of other wallets

POST         | api/transfer                | Send funds from specific wallet of auth user to another wallet for any user
GET          | api/transactions            | collect data about all transactions of specific wallet of auth user
```
API access is possible with a token, and you can access it via register and then login. You need to use it as Bearer Token in other requests. You can check them in an API builder like PostMan. This is a cURL example for transfer fund from wallet ID 16 to wallet ID 8, and amount 50 units:

```
curl --location --request POST 'http://localhost:8080/api/transfer?from=16&to=8&amount=50' \
--header 'Authorization: Bearer eyJ0eXAiOi...EgPl3E8' \
```

Make this repository better by your ideas and issues.