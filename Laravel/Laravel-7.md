
Fluent Strings Syntax / Chaining für bessere Lesbarkeit

https://laravel.com/docs/7.x/helpers#fluent-strings

str_replace('gif', 'svg', trim($str))

Str::of($str)
    ->trim(' ')
    ->afterLast(',')
    ->before('.')
    ->camel() // "xyz xyz xyz" => xyzXyzXyz
    ->containsAll(['x']) // Enthalten?
    ->replaceLast('gif', 'svg') // Replace only last


--------

New Blade Components / x-Tag-Syntax: https://laravel.com/docs/7.x/blade#components

php artisan component <name>

app/View/Components/<name>.php

usage in blade as: <x-name />

wie eine include aber mit eigenem controller

Passing data:
<x-name attr="value" :attrib="$value" />

Vorstellbar z.B. wäre sowas: 
<x-thumbnail src="image.png" width="30" height="30" position="cover" />

---------

HTTP Client: https://laravel.com/docs/7.x/http-client

Http::post('http://example.com', $postargs)
Http::attach('image-upload', file_get_contents($file), $filename)->post(...)
Http::withHeaders([...])->post(...)
Http::withBasicAuth($name, $pass)->post(...)
Http::withToken($token)->post(...)
Http::retries(2, 1000)->post(...)

---------

Route Model Binding:
Man kann nun in den Routes definieren welches Feld genommen werden soll - statt der ID

Route::get('/posts/{post:slug}', 'PostController@show')

---------

Query Casts / Custom classes: https://laravel.com/docs/master/eloquent-mutators#custom-casts

app/Casts/<name>.php enthält setter und getter Methoden

protected $casts = [ 'myfield' => <name>::class ];
    

---------------

Laravel 7 ist da: https://laravel.com/docs/7.x/releases
    Highlights sind

	"Fluent Strings Syntax" für noch einfachere Lesbarkeit: Str::->trim(',')->replaceLast('gif', 'jpg')->...->...
	Blade Components / x-Tags: Ist im Grunde ein @include() aber mit eigenen Controller.
	Http Client: Verständliche "curl" alternative, ebenfalls mit Chaining. Beispiel: Http::attach('image-upload', file_get_contents($file), $filename)->withHeaders([...])->post($url)
	Route Model Binding: Es ist möglich statt der id nun auch andere DB-Zellen zu verwenden. Beispiel mit "slug": Route::get('/posts/{post:slug}', 'PostController@show')
	Query Casts / Custom Classes für Casting von DB-Werten



