# Submodules
Mit git Submodule Normalerweise möchten Sie ein großes Repository in kleinere aufteilen. Die Art der Referenzierung eines Submoduls ist Maven-Stil - Sie verweisen auf einen einzelnen Commit aus dem anderen (Submodul-) Repository. Wenn Sie eine Änderung innerhalb des Submoduls benötigen, müssen Sie innerhalb des Submoduls einen Commit / Push durchführen, dann auf den neuen Commit im Haupt-Repository verweisen und dann den geänderten Verweis des Haupt-Repositorys bestätigen / übertragen. Auf diese Weise müssen Sie Zugriff auf beide Repositories für den vollständigen Build haben.


## Hinzufügen von Submodules/Verlinkungen

```
$ git submodule add https://dipser@bitbucket.org/bitfertig/php_thumbnails.git vevi/lib/php_thumbnails
Cloning into '/.../vevi/lib/php_thumbnails'...
remote: Counting objects: 9, done.
remote: Compressing objects: 100% (8/8), done.
remote: Total 9 (delta 0), reused 0 (delta 0)
Unpacking objects: 100% (9/9), done.
```



# Subtrees
Mit Git Unterbaum Sie integrieren ein anderes Repository in Ihr, einschließlich seiner Geschichte. Nach der Integration ist die Größe Ihres Repositorys wahrscheinlich größer (dies ist keine Strategie, um Repositories kleiner zu halten). Nach der Integration gibt es keine Verbindung zum anderen Repository, und Sie benötigen keinen Zugriff darauf, es sei denn, Sie möchten ein Update erhalten. Diese Strategie ist also eher für die Wiederverwendung von Code und Historie gedacht - ich benutze sie nicht selbst.

