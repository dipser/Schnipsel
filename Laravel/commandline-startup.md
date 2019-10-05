# Commandline startup

Terminal Tab 1: (Setup und Server start)
```bash
brew update                           # Mac
brew upgrade node                     # Mac
composer selfupdate
npm install -g npm                    # Mac
npm install -g npm-windows-upgrade    # Windows
brew install php@7.3                  # Mac
brew install mysql                    # Mac
```

```bash
cd ~
mkdir Laravel
cd Laravel
composer create-project laravel/laravel <appname>
cd <appname>
composer require laravel/ui --dev
php artisan ui vue --auth
composer require intervention/image
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
npm install
```

```bash
php artisan serve
```

Terminal Tab 2: (SASS, ...)
```bash
npm run watch
```

Terminal Tab 3:
```bash
php artisan make:controller DocumentsController --resource
php artisan make:model Document -m
php artisan make:factory DocumentFactory
php artisan make:seeder DocumentsTableSeeder

php artisan make:mail ExampleMail --markdown="mail.examplemail"
```

```bash
php artisan migrate:fresh --seed
```

```bash
php artisan db:seed
#php artisan db:seed --class=ProductsTableSeeder
```

```bash
php artisan config:cache       # create combination of config files into one file
php artisan config:clear       # dump combination of config files
```


