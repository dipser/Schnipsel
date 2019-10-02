# Laravel (mit Windows und Visual Studio Code)


## Benötigte Software
* Composer https://getcomposer.org/download/
* Node.js
* NPM
* PHP (Neueste Version) https://www.betterhostreview.com/turn-on-iis-windows-10.html und https://www.iis.net/downloads/microsoft/web-platform-installer

## Optionale Software
* Chrome JSON-Formatter Extension https://chrome.google.com/webstore/detail/json-formatter/bcjindcccaagfpapjjmafapmmgkkhgoa



## Visual Studio Code: Terminal nutzen

**Tastaturkombination: Strg + ö**

### Besseres Terminal installieren:

**In Visual Studio Code gehe:**

Datei > Einstellungen > Einstellungen >Features > Terminal> Windows Exec
    
**Füge nun folgenden Pfad ein:**

C:\Program Files\Git\bin\bash.exe



## Neues Projekt mit composer anlegen

### Installation im Verzeichnis C:\Webentwicklung\<appname>

```bash
cd C:\Webentwicklung                               # Windows
composer create-project laravel/laravel <appname>
```

### Serving

```bash
php artisan serve
php artisan serve --port=8080
```

### Editor öffnen und Server starten

```bash
cd C:\Webentwicklung && cd <appname> && code . && php artisan serve
```

### DB einrichten
 
Zunächst die Datei /.env bearbeiten:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

Und dann **frisch** migrieren:

```bash
php artisan migrate:fresh
```
*Bei Fehlern ggfs. die DB Einstellungen ändern: charset auf utf8 und collation to utf8_unicode_ci in config/database.php*



## NPM starten

Mit dem Node Package Manager (NPM) werden Komponenten nachgeladen und z.B. die SCSS Kompilierung gestartet:

```bash
npm install        #
npm run dev        # einmaliger Aufruf
npm run watch      # überwacht Datei-Änderungen permanent
```



## Blade

Template Engine.

/resources/views/layouts/master.blade.php
```
...
@include('inc.navbar')
...
@yield('content')
...
```

/resources/views/pages/<pagename>.blade.php
```
@extends('layouts.master')
...
@section('content')
...
@endsection
```

Sonstiges:
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



## Controller, Model, Migration (mit Artisan)

### Dateien anlegen für Crontroller, Model und Migration

```bash
php artisan make:constroller PostsController --resource      # Mit Standard-Methoden
php artisan make:model Post -m                               # Mit Migration in database/migrations/...
```

### Route in /routes/web.php:
```php
Route::resource('posts', 'PostsController'); // !!!
```

Controller in /app/Http/Controllers/ProductsController.php:
```php
...
```

Model:
```php

```

```bash
php artisan migrate
```

php artisan tinker
App\Post::count()
$post = new App\Post();
$post->title = 'Post One';
$post->body = 'Post Body';
$post->save();

-- 
php artisan make:crontroller PostsController --resource


php artisan route:list




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
  $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATH_FILENAME);
  $extension = $request->file('cover_image')->getClientOriginalExtension()
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore); // => /storage/app/public/cover_images/
  
} else {
  $fileNameToStore = 'noimage.jpg'
} 

php artisan storage:link                # Erstellt symlink im öffentlichen Ordner

<img src="/storage/cover_images/{{$post->cover_image}}">

use Illuminate\Support\Facades\Storage;
Storage::delete('public/cover_images/'.$post->cover_image);


```bash
php artisan migrate                 # calls up()
php artisan migrate rollback        # calls down()
```

## Eloquent

- hasOne wenn das referenzierte model den foreign key hat
- belongsTo wenn das aktuelle model den foreign key hat


php artisan make:model Post

php artisan tinker

```
DB::enableQueryLog(); // Enable Query Log
...
DB::getQueryLog(); // => Array of all queries
```

php artisan migrate:fresh               # db-tabellen neu anlegen


return $this->hasOne(Post::class); // z.B. user has one Post

public function posts() {
  return $this->hasMany(Post::class); // z.B. user has many Posts
}
//return $this->hasMany(Post::class, 'different_id');
//return $this->belongsTo(User::class); // z.B. comment belongs to post
//return $this->belongsToMany(Post::class); // z.B. Tags belongs to many posts


```bash
# erstelle eine assozierte/relationship/pivot tabelle der beiden tabellen post und tag
php artisan make:migration create_post_tag_table --create=post_tag
```

//return $this->belongsToMany(Post::class, 'different_table_name_than_standard'); // z.B. Tags belongs to many posts

->attach($id)
->detach($id)
->attach([...])
->attach($obj_instance)

//return $this->belongsToMany(Post::class)->withTimestamps();

migration file:
Schema::create('post_tag', function(Blueprint $table){
  $table->primary(['post_id', 'tag_id']); // => together it is the primary key
  ...
  $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
  $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
  $table->timestamps();
}):


### hasManyThrough(): innerjoin where ...
return $this->hasManyThrough(Post::class, User:: class)


### Polymorphic relations

Unbekannter typ

"morph", "watchable"


## Laravel-Debugbar

Alle SQL Befehle und Co einsehen



##
php artisan make:seeder UsersTableSeeder     # Neuen Seeder anlegen unter (database/seeds/)
php artisan db:seed                                # Alles seeden
php artisan db:seed --class=ProductsTableSeeder    # Nur eins seeden



## Functions

```php
dd() // die and dump
```


## Font-Awesome

```bash
npm i --save @fortawesome/fontawesome-free
```

```scss
@import '~@fortawesome/fontawesome-free/scss/brands';
@import '~@fortawesome/fontawesome-free/scss/regular';
@import '~@fortawesome/fontawesome-free/scss/solid';
@import '~@fortawesome/fontawesome-free/scss/fontawesome';
```

```html
<i class="fa fa-edit"></i>
```


## Material Design Icons

https://material.io/resources/icons/

```bash
npm install material-design-icons
```

```scss
@import '~material-design-icons/iconfont/material-icons.css';
```

```html
<i class="material-icons">face</i>
<i class="material-icons">edit</i>
```


## Dialog

https://github.com/GoogleChrome/dialog-polyfill

```bash
npm i dialog-polyfill
```

```html
<dialog id="deleteConfirmDialog">
    Wirklich löschen?
    <form method="dialog">
        <input type="submit" value="Löschen" />
    </form>
</dialog>
```

```js=app.js
window.dialogPolyfill = require('dialog-polyfill').default;

var deleteConfirmDialog = document.querySelector('dialog#deleteConfirmDialog');
window.dialogPolyfill.registerDialog( deleteConfirmDialog );

deleteConfirmDialog.showModal();
deleteConfirmDialog.addEventListener('close', function (event) {
    if (deleteConfirmDialog.returnValue == 'true') {
        alert('TODO: Löschen!');
    } else {
        //
    }
});
```
