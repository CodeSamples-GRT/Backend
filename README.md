# Laravel Chat

Simple chat using Laravel Reverb WebSocket server and Vue.js (with Inertia).

## How to start with Laravel Sail

1. Make sure you have [Docker](https://www.docker.com/) installed (`docker --version`).
2. In your Terminal, run `cp .env.example.sail .env`, set up configs if it's necessary.
3. Run the next command to install Composer dependencies:
    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```
4. Run `sail up -d` to start all Docker containers in the background.
5. Run `sail artisan key:generate` to set the `APP_KEY` in `.env`.
6. Run `sail artisan migrate --seed` to make migrations with seeders.
7. Run `sail npm install && sail npm run build` to install and build the frontend.

## How to start with the manual installation

1. Make sure you have PHP 8.3, MySQL 8.0, Composer and Node 20 installed.
2. In your Terminal, run `cp .env.example .env` and set up configs (DB, Reverb) in `.env`.
3. Run `composer install` to install Composer dependencies.
4. Run `php artisan key:generate` to set the `APP_KEY` in `.env`.
5. Run `php artisan migrate --seed` to make migrations with seeders.
6. Run `php artisan serve` to start a web server. You can use a custom port by adding `--port=<PORT_NUMBER>` at the end.
7. Run `php artisan queue:work` (in the new Terminal window) to start a queue.
8. Run `php artisan reverb:start` (in the new Terminal window) to start Reverb server.
9. Run `npm install && npm run build` (in the new Terminal window) to install and build the frontend.

## Usage

Open [http://127.0.0.1](http://127.0.0.1) in your browser. You can log in with the test credentials:

* email - `alex@test.com`, password - `password`,
* email - `bob@test.com`, password - `password`.

Or, you can also register as a new user [here](http://127.0.0.1/register).

After that, go to the "**Chat**" [page](http://127.0.0.1/chats/general) and send your first message.
