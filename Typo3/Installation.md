# Installation

´´´
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
# Einzeiler: ln -s typo3_src-6.2.5 typo3_src && ln -s typo3_src/typo3 typo3 && ln -s typo3/index.php index.php 

# Benutzerrechte setzen
chown -R www-data:www-data /var/www/ && sudo chmod -R 755 /var/www/

# PHP Einstellungen vornehmen
nano /etc/php5/apache2/php.ini
folgende Zeilen ändern:
max_execution_time = 240
upload_max_filesize = 12M
post_max_size = 13M

# Virtuellen Host einrichten für das Projekt-Verzeichnis
nano /etc/apache2/sites-enabled/000-default

# ...folgende Zeilen ändern:

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
sudo /etc/init.d/apache2 restart
