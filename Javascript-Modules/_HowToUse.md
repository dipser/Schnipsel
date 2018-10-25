# Javascript modules


## Beispiele

### Im HTML einbinden

```Javascript
<script type="module" src="module.js"></script>
```

-----


*main.js*

```Javascript
import conlog from './mymodule.js';
conlog('Hello world.');
```

*mymodule.js*

```Javascript
export default (str) => {
  console.log(str);
}
```


-----

### Standard Export/Import


```Javascript
import myFunction from 'mymodule.js';
console.log(myFunction(3)); // 27
```

```Javascript
// Exports in mymodule.js
export default function cube(x) {
  return x * x * x;
}
```

### Benannter Export/Import

```Javascript
// Modul "mymodule.js"
function cube(x) {
  return x * x * x;
}
const foo = Math.PI + Math.SQRT2;
export { cube, foo };
```

```Javascript
import { cube, foo } from 'mymodule.js';
console.log(cube(3)); // 27
console.log(foo);    // 4.555806215962888
```

----

Sonstige Möglichkeiten:

```Javascript
export class MyClass {}
export const myclass = new MyClass();
export const myfn = () => {};
export function myfn() {}
export const strvar = '';
export * from './module.js';
```

