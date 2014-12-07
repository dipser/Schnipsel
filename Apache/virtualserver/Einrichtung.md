# Einrichtung virtueller Hosts (z.B. MAMP)

Ziel ist es hierbei über einen selbst definierten Host (localhost, domain.tld,...) je einen festgelegten Document-Root zu erhalten.

Zuerst muss in die hosts Datei die Umleitung auf die IP (127.0.0.1) erfolgen:

```
sudo su
nano /etc/hosts
```

Füge folgendes hinzu:
```
127.0.0.1 MYHOSTNAME.local
127.0.0.1 MYOTHERHOSTNAME.local
```

Öffne nun die Konfiguration des Apache und füge hinzu:

```
Include /.../httpd-vhosts.conf
```

Als letztes muss noch die vhosts.conf mit den eigenen virtuellen Hosts gefüllt werden:

```
NameVirtualHost *:80

# Standard localhost
<VirtualHost *:80>
    ServerAdmin webmaster@domain.tld
    DocumentRoot "/Applications/MAMP/htdocs"
    ServerName localhost
</VirtualHost>

# Weitere virtuelle Hosts
<VirtualHost *:80>
    ServerAdmin webmaster@domain.tld
    DocumentRoot "/.../htdocs/local.MYHOST"
    ServerName MYHOST.local
    ServerAlias www.MYHOST.local
    ErrorLog "logs/MYHOST.local-error_log"
    CustomLog "logs/MYHOST.local-access_log" common
</VirtualHost>

...
```
