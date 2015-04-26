# dirtreewalk: Rekursive Ausgabe eines Verzeichnisses mit md5-Hash und Exceptions


__author__ = 'Aurelian Hermand'


#import os
from os import listdir
from os.path import isfile, isdir, join
import hashlib

def dirtreewalk(path):
    try:
        for f in listdir(path):
            fullpath = join(path,f)
            if isfile(fullpath):
                hash = '-'
                try:
                    hash = hashlib.md5(open(fullpath, 'rb').read()).hexdigest()
                except PermissionError:
                    print('\033[91m'+'iPermission denied:'+'\033[0m', fullpath)
                except Exception:
                    print('\033[91m'+'iException:', fullpath)
                print("{f} {p} {h}".format(f=f, p=fullpath, h=hash))
            elif isdir(fullpath):
                dirtreewalk(fullpath)
    except FileNotFoundError:
        print('\033[91m'+'File not found:'+'\033[0m', path)
    except NotADirectoryError:
        print('\033[91m'+'Not a directory:'+'\033[0m', path)
    except PermissionError:
        print('\033[91m'+'oPermission denied:'+'\033[0m', path)
    except Exception:
        print('\033[91m'+'oException:'+'\033[0m', path)




# Direktaufruf
if __name__ == '__main__':
    # Zum testen einen Ordner mit Inhalt anlegen
    # Danach eine Datei und einen Ordner ohne Rechte erstellen:
    # touch norights.txt && chmod 0000 norights.txt && mkdir -m 0000 norightsdir
    path = '/Users/dipser/Desktop/GIS'
    dirtreewalk(path)

