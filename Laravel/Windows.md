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

* Projekt via Git runterladen.
* Projektordner in Visual Studio Code öffnen
* Visual Studio Code: "Terminal" > "Neues Terminal" öffnen
* Beim ersten mal folgende Befehle ausführen:

```
composer install
npm install
```

* Jedes mal ausführen:

```
npm run watch
php artisan serve
```


### Freigabe im Netzwerk

```
php artisan serve --host 10.1.1.108 --port 8000
```

Host lässt sich mit "ipconfig" ermitteln.

