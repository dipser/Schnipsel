# Commandline startup

Terminal Tab 1:
```bash
cd ~
mkdir Laravel
composer create-project laravel/laravel <appname>
cd <appname>
composer require laravel/ui --dev
php artisan ui vue --auth
npm install
php artisan serve
```

Terminal Tab 2:
```bash
npm run watch
```

Terminal Tab 3:
```bash
php artisan make:controller DocumentsController --resource
php artisan make:model Document -m
php artisan make:factory DocumentFactory
php artisan make:seeder DocumentsTableSeeder
```

```bash
php artisan make:auth
```


