# NPM

## Package erstellen

Zuerst einen Account anlegen auf [npmjs.com](https://www.npmjs.com/) und übers Terminal/Bash einloggen.

### Login

```bash
 npm login
```

### Package erstellen und hochladen

Die Information wie Name und Version werden aus der package.json übernommen.

```bash
npm publish --access public
```

## Package deprecation

```bash
npm deprecate <package-name> "<message>"
```

## Package löschen
```bash
npm unpublish <package-name> -f
```
