<h1 align="center">Szaming app</h1>

<p align="center">
 <a href="https://travis-ci.org/aso824/szaming">
    <img src="https://travis-ci.org/aso824/szaming.svg?style=flat-square">
 </a>
 
 <a href="https://github.styleci.io/repos/140011227">
    <img src="https://github.styleci.io/repos/140011227/shield?style=flat-square" alt="StyleCI">
 </a>
</p>

<p align="center">
 Order food together, never forget about payments.
</p>

## Installation

Like any other Laravel based project:

    composer install
    cp .env.example .env
    php artisan key:generate
    nano .env               # Set database fields
    php artisan migrate
    
If you aren't familiar with Apache/Nginx, just use built-in server:

    php artisan serve

## Contributing

Feel free to send pull request, you'll never be ignored.

## License

The Szaming app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
