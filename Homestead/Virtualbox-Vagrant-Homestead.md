## VirtualBox / Vagrant / Homestead
 
[Laravel Homestead - Laravel 11.x - The PHP Framework For Web Artisans](https://laravel.com/docs/11.x/homestead)
 
### Anlegen
 
mkdir C:\code
 
cd ~
 
git clone https://github.com/laravel/homestead.git Homestead
 
cd Homestead
 
git checkout release
 
./init.bat
 
 
### Homestead.yaml bearbeiten
 
"ssh-keygen" ausführen
 
 
```
authorize: C:\Users\WORKSTATION\.ssh\id_ed25519
 
keys:
  - ~/.ssh/id_ed25519
 
folders:
  - map: C:\code
    to: /home/vagrant/code
 
sites:
  - map: bpb.test
    to: /home/vagrant/code/bpb
```
 
 
### hosts bearbeiten mit Adminrechten
 
C:\Windows\System32\drivers\etc\
 
127.0.0.1   bpb.test
 
 
### Vagrant NGINX Host
 
cd ~
cd .\Homestead\
 
vagrant ssh
 
/etc/nginx/sites-available/domain.name
 
```
server {
    listen 80;
    server_name homestead.test;  # Change to your desired hostname
 
    # Set root to Laravel's public directory
    root /home/vagrant/code/public;  # Adjust path as needed
 
    # Set default index file
    index index.php index.html index.htm;
 
    # Access logs for debugging purposes
    access_log /var/log/nginx/homestead.access.log;
    error_log /var/log/nginx/homestead.error.log;
 
    # Handling Laravel's routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
 
    # PHP script handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Adjust for your PHP version
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
 
    # Disable access to hidden files like .env
    location ~ /\.(?!well-known).* {
        deny all;
    }
 
    # Compression settings for optimized loading
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    gzip_vary on;
 
    # Cache static files for performance
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1w;
        add_header Cache-Control "public";
    }
 
    # Security headers (optional)
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
}
```
 
sudo ln -s /etc/nginx/sites-available/domain.name /etc/nginx/sites-enabled/
 
sudo systemctl restart nginx
 
 
### Neu starten
 
vagrant reload --provision
 
vagrant up --provision
 
 
#### Hinweis
npm von außen (extra installation auf windows)
composer von innen
