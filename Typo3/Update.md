#Typo3-Update:

```
# Entferne Verknüpfung/Symlink "typo3_src"
rm typo3_src

# Erstelle neue Verknüfung auf "typo3_src" mit dem Update-Verzeichnis
ln -s typo3_src-6.2.6 typo3_src

# Ändere Besitzer der Verzeichnisse auf "www-data:www-data"
chown -R www-data:www-data typo3_src-6.2.6
chown -R www-data:www-data typo3_src

# Anzeige der Symlinks zur überprüfung
ls -al
```
