# Laravel auf Windows


## Installation

Ausführung über "Windows PowerShell (Administrator)"

### Chocolatey
https://chocolatey.org/install 


### PHP & Composer
https://chocolatey.org/packages/composer

PHP wird nach C:\tools installiert.

Ggfs. muss die Umgebungsvariable auf die neue Version angepasst werden. Einstellungen > Systemumgebungsvariablen > Umgebungsvariablen > Systemvariablen > Path > Bearbeiten...

C:\tools\PHP?\php.ini anpassen bzgl. Libraries.


### NodeJS & NPM
https://chocolatey.org/packages/nodejs.install



## Ausführen
```
composer install
npm install
npm run watch
php artisan serve
```
