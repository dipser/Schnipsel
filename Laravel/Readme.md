# Laravel


## Visual Studio Code: Terminal

Set Windows internal Terminal to:
Go to Datei > Einstellungen > Einstellungen >Features > Terminal> Windows Exec
C:\Program Files\Git\bin\bash.exe

Anzeigen > Terminal (Strg + ö)

## Projekt mit composer anlegen

```
composer create-project laravel/laravel <appname>
```
  

## Blade

/resources/views/layouts/app.blade.php
```
...
@include('inc.navbar')
...
@yield('content')
...
```

/resources/views/pages/<pagename>.blade.php
```
@extends('layouts.app')

@section('content')
  ...
@endsection

```

/resources/views/inc/navbar.blade.php


```
@if(true)
@foreach($collection as $item)
{{config('app.name', 'default')}}
{{asset('css/app.css')}}
```


PagesController.php
```
return view('pages.index', compact('title'))
return view('pages.index')->with('title', $title)
return view('pages.index')->with(['title' => $title])
```

## NPM
npm install        #
npm run dev        # once
npm run watch      # always on changes


## Artisan

php artisan make:constroller PostsController
php artisan make:model Post -m            #Mit Migration in database/migrations/...




php artisan migrate

php artisan tinker
App\Post::count()
$post = new App\Post();
$post->title = 'Post One';
$post->body = 'Post Body';
$post->save();

-- Mit standard methods
php artisan make:crontroller PostsController --resource


php artisan route:list


Route::resource('posts', 'PostsController'); // !!!

https://www.youtube.com/watch?v=emyIlJPxZr4
