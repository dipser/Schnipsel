# Laravel


## Visual Studio Code: Terminal

Set Windows internal Terminal to:
C:\Program Files\Git\bin\bash.exe


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

