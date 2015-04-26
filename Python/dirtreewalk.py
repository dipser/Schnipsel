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
    # Zum Testen einen Ordner mit Inhalt anlegen, danach z.B. eine Datei und einen Ordner ohne Rechte erstellen, oder:
    # mkdir example && cd example && touch file.txt && touch file2.txt && echo 2 > file2.txt && touch file3.txt && echo 3 > file3.txt && mkdir subdir && mkdir subdir/subsubdir && touch subdir/subsubdir/file.txt && echo 4 > subdir/subsubdir/file.txt && touch norights.txt && chmod 0000 norights.txt && mkdir -m 0000 norightsdir && cd ..
    path = '/Users/dipser/Desktop/example'
    dirtreewalk(path)

