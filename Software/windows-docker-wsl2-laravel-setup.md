# Docker mit WSL2 unter Windows für [Laravel Sail](https://laravel.com/docs/8.x/sail)

## Setup

* Im BIOS die Virtualisierung aktivieren (OC -> Features -> SVM Mode -> Activate!)
* Unter "Windows-Features" > "Hyper-V" aktivieren
* WSL2 installieren
  * Unter "Windows-Insider-Programm" > "Release Preview-Kanal" (Vorschauversion)
  * Ausführen in Powershell als Admin: ```wsl --install```
  * Ausführen in Powershell als Admin: ```wsl --set-default-version 2```
* Download und installiere [Linux from Microsoft Store](https://www.microsoft.com/de-de/p/ubuntu-2004-lts/9n6svws3rx71?cid=msft_web_chart&activetab=pivot:overviewtab)
* Ausführen in Powershell als Admin: ```wsl -d ubuntu-20.04```
* Installiere Docker
  * [Download Docker](https://www.docker.com/products/docker-desktop)
  * Activate WSL2 under "Settings" > "General" > "Use the WSL 2 based engine"
  * Activate downloaded Linux under "Settings" > "Resources" > "WSL Integration"
* Laravel/Docker .env Datei erweitern um "COMPOSE_PROJECT_NAME=myprojectname". Dies legt den projektnamen fest, ansonsten, wird der Ordnername verwendet.
* Service "laravel.test" umbenennen in "myprojectname.test". Dies ermöglicht lokale Domains. Sollte dann auch in /etc/hosts angelegt werden.
  * Laravel: http://myprojectname.test/
  * Mailhog: http://myprojectname.test:8025/
  
## 1. Start
* ```wsl``` in Powershell eingeben um nach Linux zu wechseln.
* Befehl ausführen: ```echo "alias sail='bash vendor/bin/sail'" >> ~/.bash_aliases && source ~/.bash_aliases```
* In den Laravel Ordner wechseln und Befehl ```./vendor/bin/sail up``` oder ```sail up``` ausführen zum starten
  
## Ab dem 2. Start

Die nächsten Starts sind über "Docker Desktop" möglich.
