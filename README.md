## About Project

This is a Laravel project, to simulate transferring funds between wallets. There is a simple web based frontend, and another API based backend.

## Build and Run Project

This project dockerized to use independent of your OS and covers all requirements. Check your docker & docker-compose version by `docker -v` and `docker-compose -v`. If needed, install them on your system.

- Now running `docker-compose up -d` will populate the webapp on containers, include Nginx server, App container and MySQL DB server.
- Now make a copy from _.env.example_ to _.env_ file. Current values for DB works fine, but in real world example, don't use those simple values for passwords, and change them in _docker-compose.yml_ before running docker.
- Run `docker exec -it app composer install` to install composer dependencies.
- Run `docker exec -it app php artisan key:generate` to set your application key to a random string.
- Run `docker exec -it app php artisan migrate` to make tables in MySQL DB.
- If you want, you can run `docker exec -it app php artisan db:seed` to fill DB with sample data.
- Finally, you can see the result at [http://localhost:8080/](http://localhost:8080/) on your browser.

You can see the most important codes in _app/Http/Controllers/*_ for the web based codes, _app/Http/Controllers/API/*_ for API based codes, _routes/web.php_ for web routes, _routes/api.php_ for REST API routes and _resources/views_ for blade views.

To access APIs, use these methods/endpoints:
```
GET       | api/wallets       | index (get data about all user's wallets)
GET       | api/wallet        | index (get data about specific user's wallet ID)
POST      | api/transfer      | transfer (Send funds from user's wallet ID to another wallet ID for any user)
```
You can check them in an API builder like PostMan. This is a cURL example for POST request:

`curl --location --request POST ...`

If you want to interact with images, you can use something like this for Laravel part: `docker exec -it app composer ...` or `docker exec -it app php artisan ...`.

Make this repository better by your ideas and issues.