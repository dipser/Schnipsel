# Plugins

## Beispiel Plugin-Starter-Datei:

Lege einen Ordner unter /wp-content/plugins/ mit dem Namen deines Plugins an. Erstelle darin eine PHP-Datei z.B. main.php.

```php
<?php
/**
 * Plugin Name: [Insert Name]
 * Plugin URI: [Insert Plugin URL]
 * Description: [Insert Short Description]
 * Author: [Insert Your Name]
 * Author URI: [Insert Your URL]
 * Version: 1.0
 * Text Domain: plugin-name
 * Domain Path: /languages/
 *
 * Copyright: (c) 2019 [Insert Your Name] (your@email.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @author    [Insert Your Name]
 * @copyright Copyright (c) 2019, [Insert Your Name]
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Add your custom code below this line
```

## Wordpress erweitern in OOP

```php
class MySideSpecificPlugin {
    public function __construct()
    {
        add_action('init', [$this, 'theme_setup']);
    }
    public function theme_setup()
    {
        #add_image_size('my1-thumb', 300); // 300 pixels wide (and unlimited height)
        #add_image_size('my2-thumb', 220, 180, true); // (cropped)
    }
}
$my_ssp = new MySideSpecificPlugin();
```

## Wordpress erweitern (add_action)

```php
function your_function() {
	echo '<p>INSERTED</p>';
}
add_action( 'wp_footer', 'your_function' );
//add_action('plugins_loaded', 'run_on_plugins_loaded');
//add_action('init', 'run_on_init', 10, 0);
```


## Hook: Plugin Aktivierung

```php
function MYPLUGIN_activate() {
    // ...
}
register_activation_hook( __FILE__, 'MYPLUGIN_activate' );
```

## Sprache

```php
function MYPLUGIN_load_plugin_textdomain() {
    load_plugin_textdomain( 'plugin-name', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'MYPLUGIN_load_plugin_textdomain' );
```

## CSS und JS einbinden

```php
function MYPLUGIN_frontend_enqueue_scripts(){
	wp_enqueue_script('your-script-name', plugins_url('/assets/js/script.js', __FILE__), array('jquery'), '1.2.3', true);
	wp_enqueue_style('your-stylesheet-name', plugins_url('/assets/css/style.css', __FILE__), false, '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'MYPLUGIN_frontend_enqueue_scripts');
```

oder im Adminbereich:

```php
function MYPLUGIN_admin_enqueue_scripts($hook) {
    wp_enqueue_style('wcpp_admin_css_styles', wp_normalize_path(plugin_dir_url(__FILE__).'/assets/css/styles-admin.css'));
    wp_enqueue_script('wcpp_admin_js_scripts', wp_normalize_path(plugin_dir_url(__FILE__).'/assets/js/scripts-admin.js'));
}
add_action('admin_enqueue_scripts', 'MYPLUGIN_admin_enqueue_scripts');
```

## Shortcodes

```php
function MYPLUGIN_myshortcode( $atts, $content = "" ) {
	$sc = '...';
	return $sc;
}
add_shortcode('myshortcode', 'MYPLUGIN_myshortcode');

//echo do_shortcode("[shortcode]"); // via PHP an geeigneter Stelle ausführen
```

## Ajax calls

```php
function MYPLUGIN_MYACTION() {
	global $wpdb; // this is how you get access to the database

	echo 'Hello Internet.';

	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action('wp_ajax_MYPLUGIN_MYACTION', 'MYPLUGIN_MYACTION');
```

```js
jQuery(document).ready(function($) {
	jQuery.post(ajaxurl, {
		'action': 'MYPLUGIN_MYACTION',
		'key': 'val'
	}, function(response) { // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		console.log('Got this from the server: ' + response);
	});
});
```


## Datenbankstruktur

https://codex.wordpress.org/Database_Description

## Liste nützlicher Funktionen

```php
site_url() // http://domain/public
get_bloginfo('url') // http://domain.com/public/
wp_normalize_path('path/path\path//file.svg') // => path/path/path/file.svg
wp_normalize_path(plugin_dir_url(__FILE__).'/assets/img/file.svg') // => /wp-content/plugins/assets/img/file.svg
wp_normalize_path(plugins_url('/assets/img/file.svg', __FILE__)) // => /wp-content/plugins/assets/img/file.svg
wp_get_current_user() // => WP_User
$user = new WP_User( 1 ); // => WP_User
do_shortcode("[shortcode]") // Führt einen shortcode aus
current_user_can('activate_plugins') // => Admin
get_query_var('pagename') // Request: /mein-konto/view-order/6070 = Querystring: pagename=mein-konto&view-order=6070 => mein-konto
$upload_info = wp_upload_dir(); // => Array ( [path] => /.../wp-content/uploads/2019/05 [url] => http://.../wp-content/uploads/2019/05 [subdir] => /2019/05 [basedir] => /.../wp-content/uploads [baseurl] => http://.../wp-content/uploads [error] => )
update_option( 'key', 'val' ); get_option( 'key' ); // => val
__('MYTEXT', 'my-plugins-textdoamin') // returns translation
_e('MYTEXT', 'my-plugins-textdoamin') // echos translation
printf( esc_html__( 'We deleted %d spam messages.', 'my-plugins-textdomain' ), $count ) // Übersetzung mit Vars
printf( esc_html( _n( 'We deleted %d spam message.', 'We deleted %d spam messages.', $count, 'my-plugins-textdomain'  ) ), $count ); // Plurals
```
