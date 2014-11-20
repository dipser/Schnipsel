# Vorbereitung, Installation und Update



## SSH Zugriff
```
ssh [Benutzername]@[domain.tld] -p[Portnummer]
```
Oder man legt eine Abkürzung an:
```
# Nachschauen ("~" schreibt man mit alt+n)
sudo nano ~/.ssh/config

# Anlegen
cd ~/ && mkdir .ssh && cd .ssh && sudo nano config
# ...diese Zeilen hinzufügen:
Host [AbkName]
User [Benutzername]
Port [Portnummer]
HostName [domain.tld]

# Aufrufen
ssh [AbkName]
```



## Server-Benutzerpasswort ändern
```
# Passwort generieren
openssl rand -base64 42

# Passwort ändern
passwd [Benutzername]
```



## Server vorbereiten (Apache, PHP, MySQL)
```
# Zugriffsrechte beschaffen
sudo su

# Mache Updates (Fehlerbehebungen) und Upgrades (Neue Version)
apt-get update
apt-get upgrade 
# Alternativer Einzeiler => sudo apt-get update && sudo apt-get upgrade 

# Installationen über den Paketmanager APT (Advanced Packaging Tool)
apt-get install apache2 php5 mysql-server
apt-get install phpmyadmin imagemagick php5-imagick 
apt-get install php5-mysql libapache2-mod-php5 
apt-get install php5-curl php5-xmlrpc mcrypt php5-mcrypt
apt-get install libimage-exiftool-perl ufraw-batch
apt-get install libav-tools ghostscript php-apc imagemagick htop
apt-get install sendmail aptitude
apt-get install unzip
# Alternativer Einzeiler => apt-get install apache2 php5 mysql-server phpmyadmin imagemagick php5-imagick php5-mysql libapache2-mod-php5 php5-curl php5-xmlrpc mcrypt php5-mcrypt libimage-exiftool-perl ufraw-batch libav-tools ghostscript php-apc imagemagick htop sendmail aptitude

# Server testen
nano /var/www/info.php
# ...Inhalt eintragen: <?php phpinfo(); ?>

# Paket-Einstellungen ändern (dpkg = Debian Package)
#dpkg-reconfigure [paket]
#bsp.: dpkg-reconfigure phpmyadmin

# Mysql-Benutzer erstellen
mysql -u root -p 
# ...folgendes eingeben und dabei 'username' und 'password' anpassen:
CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'username'@'localhost';
```



## Typo3 Installation

```
# Zugriffsrechte beschaffen
sudo su

# In das Verzeichnis wechseln
cd /var/www/

# Ein Projekt-Verzeichnis anlegen
mkdir tld_domain

# Ein Daten-Verzeichnis anlegen
mkdir _ && cd _/

# Den Link zur Typo3-Datei besorgen und per wget laden
wget http://.../typo3_src-6.2.5.tar.gz

# Entpacken ins Projekt-Verzeichnis (xzf-Merkhilfe: eXtract Ze Files)
tar -xzf typo3_src-6.2.5.tar.gz -C ../tld_domain/

# Ins Projekt-Verzeichnis wechseln
cd ../tld_domain/

# Symlinks anlegen
ln -s typo3_src-6.2.5 typo3_src 
ln -s typo3_src/typo3 typo3 
ln -s typo3_src/index.php index.php
# Alternativer Einzeiler => ln -s typo3_src-6.2.5 typo3_src && ln -s typo3_src/typo3 typo3 && ln -s typo3/index.php index.php 

# Benutzerrechte setzen
chown -R www-data:www-data /var/www/ && sudo chmod -R 755 /var/www/

# PHP Einstellungen vornehmen
nano /etc/php5/apache2/php.ini
# ...folgendes ändern:
max_execution_time = 240
upload_max_filesize = 12M
post_max_size = 13M

# Virtuellen Host einrichten für das Projekt-Verzeichnis
nano /etc/apache2/sites-enabled/000-default
# ...folgendes ändern:
<VirtualHost *:80>
        DocumentRoot /var/www/tld_domain/
        DirectoryIndex index.php
        <Directory /var/www/tld_domain/>
                Options +FollowSymLinks -indexes
                AllowOverride all
                Require all granted
        </Directory>
        <ifModule mod_deflate.c>
                <filesMatch "\.(js|css)$">
                SetOutputFilter DEFLATE
                </filesMatch>
        </ifModule>
        <IfModule mod_expires.c>
            ExpiresActive On
            ExpiresDefault "access plus 10 days"
            ExpiresByType text/css "access plus 1 week"
            ExpiresByType text/plain "access plus 1 month"
            ExpiresByType image/gif "access plus 1 month"
            ExpiresByType image/png "access plus 1 month"
            ExpiresByType image/jpeg "access plus 1 month"
            ExpiresByType application/x-javascript "access plus 1 month"
            ExpiresByType application/javascript "access plus 1 week"
            ExpiresByType application/x-icon "access plus 1 year"
        </IfModule>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

# Apache neustarten
/etc/init.d/apache2 restart


# Alternativ eigene VirtualHost-Datei anlegen
nano /etc/apache2/sites-available/projektname.conf
# ...füllen. (Siehe oben...)
# Deaktivieren:
sudo a2dissite 000-default.conf
# Aktivieren:
sudo a2ensite projektname.conf
# Apache neustarten
/etc/init.d/apache2 restart



# Typo3-Installation aktivieren
sudo touch FIRST_INSTALL
```



## Typo3 Update

Ein Update ist möglich, indem man einfach das zu Grunde liegende Verzeichnis austauscht.

```
# Zugriffsrechte beschaffen
sudo su

# Entferne Verknüpfung/Symlink "typo3_src"
rm typo3_src

# Erstelle neue Verknüfung auf "typo3_src" mit dem Update-Verzeichnis
ln -s typo3_src-6.2.6 typo3_src

# Ändere Besitzer der Verzeichnisse auf "www-data:www-data"
chown -R www-data:www-data typo3_src-6.2.6
chown -R www-data:www-data typo3_src

# Anzeige der Symlinks zur Überprüfung (ls = list; al = "a"lles anzeigen und "l"angform)
ls -al
```



## Typo3-Backend .htaccess Schutz
```
# Zugriffsrechte beschaffen
sudo su

# Wechsle in das Prjekt-Verzeichnis
cd /var/www/tld_domain/

# Aktuelle Benutzer ansehen
nano /var/htpasswd/.htusers

# Weiteren Benutzer anlegen
htpasswd .htusers [Benutzername]

# .htaccess schreiben / öffnen
nano .htaccess
# ...Inhalt hinzufügen:
AuthType Basic
AuthName "Backend"
AuthUserFile /var/htpasswd/.htusers
Require user [Benutzername] [WeitererBenutzername] [...]
```



## SSL Zertifikat (https)
```
# Zugriffsrechte beschaffen
sudo su

# Falls noch nicht installiert
apt-get install openssl

# Verzeichnis wechseln
cd /etc/apache2/ssl/projektname/

# Neuen Schlüssel erstellen (4096 Bit Länge)
openssl genrsa -out typo3.key 4096

# CSR (Certificate signing request) erstellen (Zertifikat-Informationen angeben)
openssl req -new -key typo3.key -out typo3.csr

# Selbstsignierung
openssl x509 -req -days 365 -in typo3.csr -signkey typo3.key -out typo3.crt

# Modul SSL aktivieren
a2enmod ssl

# In das Apache-Konfigurations Verzeichnis wechseln
cd etc/apache2/sites-available/

# Apache Porjekt-Konfiguration öffnen
nano projektname.conf
# ...hinzufügen:
<VirtualHost *:443>
        DocumentRoot /var/www/tld_domain/
        DirectoryIndex index.php
        SSLEngine on
        SSLCertificateFil /etc/apache2/ssl/projektname/typo3.crt
        SSLCertificateKeyFile /etc/apache2/ssl/projektname/typo3.key
        <Directory /var/www/tld_domain/>
                Options +FollowSymLinks -indexes
                AllowOverride all
                Require all granted
        </Directory>
        <ifModule mod_deflate.c>
                <filesMatch "\.(js|css)$">
                SetOutputFilter DEFLATE
                </filesMatch>
        </ifModule>
        <IfModule mod_expires.c>
            ExpiresActive On
            ExpiresDefault "access plus 10 days"
            ExpiresByType text/css "access plus 1 week"
            ExpiresByType text/plain "access plus 1 month"
            ExpiresByType image/gif "access plus 1 month"
            ExpiresByType image/png "access plus 1 month"
            ExpiresByType image/jpeg "access plus 1 month"
            ExpiresByType application/x-javascript "access plus 1 month"
            ExpiresByType application/javascript "access plus 1 week"
            ExpiresByType application/x-icon "access plus 1 year"
        </IfModule>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

# Apache neustarten
/etc/init.d/apache2 restart
```

