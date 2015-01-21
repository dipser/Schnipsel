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
1. Installiere: "RealURL: speaking paths for TYPO3"
2. RealUrl-Typoscript einfügen (siehe config.ts)


## Extention Manager > Manage Extentions
1. "Frontend editing" aktivieren
2. Frontend editing für einen Benutzer aktivieren durch hinzufügen eines Typoscripts unter "Backend users > Options":
```
admPanel {
  enable.edit=1
  module.edit.forceDisplayFieldIcons=1
  hide=0
}
```

