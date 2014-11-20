
## JPEGs optimieren
```
# Zugriffsrechte beschaffen
sudo su

# Paket-Installation
apt-get install jpegoptim

cd /var/www/projekt/bilder/

# EXIF Daten ansehen
exiftool bild.jpg

# Bilder optimieren
jpegoptim -o --strip-all *.jpg
```

## PNGs optimieren
```
# Zugriffsrechte beschaffen
sudo su

# Paket-Installation
apt-get install optipng

# Grafiken optimieren
optipng -o7 -preserve *png
```

## Gifs optimieren
...gifsicle...