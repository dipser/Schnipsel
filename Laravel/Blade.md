# Blade-Templates

## Zeilenumbrüche in HTML aber sonst kein HTML

```
<?php $address = "<b>Zeile1</b>\nZeile2"; ?>
{!! nl2br(e($address)) !!}
```

Results in: 
```
&lt;b&gt;Zeile1&lt;/b&gt;<br>Zeile2
```
