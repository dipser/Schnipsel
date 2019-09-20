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


## NPM
npm install        #
npm run dev        # once
npm run watch      # always on changes


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
{{!!$html_allowed!!}}
```


## Controller


PagesController.php
```
return view('pages.index', compact('title'))
return view('pages.index')->with('title', $title)
return view('pages.index')->with(['title' => $title])
```

## CRUD

use DB;
$posts = DB:select('...');

use App\Post;
$posts = Post::all();
$posts = Post::sortBy('created_at', 'desc')->get();
$posts = Post::all()->paginate(); // {{$posts->links()}}
$posts = Post::all();



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



## Auth

```bash
php artisan make:auth
```


Erstellt neue DB migration file unter database/migrations/
```bash
php artisan make:migration add_user_id_to_posts
```

```php
public function up() {
  Schema::table('posts', function($table){
    $table->integer('user_id'); // add field
  });
}
public function down() {
  Schema::table('posts', function($table){
    $table->dropColumn('user_id'); // drop field
  });
}
```

```bash
php artisan migrate                 # calls up()
php artisan migrate rollback        # calls down()
```

```php
$user_id = auth()->user()->id; // currently loggedin user
```


## Model Relationship

/app/User.php
public function posts() {
  return $this->belongsTo('App\User');
}

/app/User.php
public function posts() {
  return $this->hasMany('App\Post');
}

/app/Http/Controllers/DashboardController.php
public function index() {
  $user_id = auth()->user()->id;
  $user = User::find($user_id);
  return view('dashboard')->with('posts', $user->posts); // see /app/User.php , we only see posts from this user
}


## Access control
PostsController
public function __construct() {
  $this->middleware('auth', ['except' => ['index', 'show']]);
}

@if(Auth::guest())
@endif

@if(Auth::user()->id == $post->user->id)
@endif

In methods:
if (auth()->user()->id !== $post->user_id) {
  return redirect('/posts')->with('error', 'Unauthorized Page');
} 


## File upload

php artisan make:migration add_cover_image_to_posts

```php
public function up() {
  Schema::table('posts', function($table){
    $table->string('cover_image'); // add field
  });
}
public function down() {
  Schema::table('posts', function($table){
    $table->dropColumn('cover_image'); // drop field
  });
}
```

$this->validate($request, [
  'title' => 'required',
  'cover_image' => 'image|nullable|max:1999'
]);

if($requust->hasFile('cover_image')){
  $filenameWithExt = $request->file('cover_image')->getClientOriginalImage();
  $filename = pathinfo($filenameWithExt, PATH_FILENAME);
  $extension = $request->file('cover_image')->getOriginalClientExtension()
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore); // => /storage/app/public/cover_images/
  
} else {
  $fileNameToStore = 'noimage.jpg'
} 

php artisan storage:ink

```bash
php artisan migrate                 # calls up()
php artisan migrate rollback        # calls down()
```


## Functions

```php
dd() // die and dump
```
