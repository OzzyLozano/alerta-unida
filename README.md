# run laravel project
  php artisan serve --host=example.test
  # runs project at: http://example.test:8000

# tinker commands
  php artisan tinker
  DB::select('<SQL Query>');
  # allows to run sql querys on the projects database

# artisan commands
  php artisan make:model <name>
  php artisan make:migration <name>
  php artisan make:controller <name>
  php artisan migrate
  php artisan route:list
  # shows all the project routes


## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
