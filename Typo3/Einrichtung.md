# Einrichtung

## System

### Install

#### Install > All configuration
* $TYPO3_CONF_VARS['FE']
  * [FE][pageNotFound_handling] = READFILE:fileadmin/notfound.html
  * [FE][pageUnavailable_handling] = READFILE:fileadmin/unavailable.html
* $TYPO3_CONF_VARS['SYS']
  * [SYS][sitename] = Seitenname!

#### Install > Upgrade Wizard
Nach einem Update muss man hier aktiv werden.


## Web

### Web > Page
Anlegen der Seitenstruktur mit 3 versch. Seitentypen: Standard, Link, Ordner


### Web > Template
1. Typoscript auf der höchsten Ebene der Rootline erstellen und die setup.ts einfügen.
2. fileadmin/-Verzeichnis reinkopieren.
3. Im Reiter "Includes" die "CSS Styled Content" aktivieren.

## Extention Manager

### Extention Manager > Get Extention
Installiere: "RealURL: speaking paths for TYPO3"


