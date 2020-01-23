
App/Services/Twitter.php
```php
<?php

namespace App\Services;


/* 
Usage:
------

web.php:
    app()->singleton('App\Services\Twitter', function () {
        return new App\Services\Twitter('...apikey...');
    });

Controller:
    use App\Services\Twitter;
    function xyz(Twitter $twitter){ // autoresolution
        dd($twitter);
    }
*/

class Twitter {

    protected $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }


}
```


web.php
```
<?php
// Service container:
/* app()->bind('example', function() {
    return new \App\Example;
}); */
/* app()->singleton('example2', function() {
    return new \App\Example2;
}); */
/* app()->singleton('App\Example', function () {
    return new \App\Example;
}); */
// Test:
Route::get('/service-container', function(){
    //dd(app('example1'));
    //dd([app('example1'), app('example1')]);
    dd(app('App\Example')); // app() = resolve()
    return '';
});


/* app()->singleton('App\Services\Twitter', function () {
    return new App\Services\Twitter('...apikey...');
});
Route::get('/service-container-twitter', function(){
    dd(app('App\Services\Twitter')); // app() = resolve()
    return '';
}); */

?>
```
