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


## Wordpress erweitern (add_action)

```php
function your_function() {
	echo '<p>INSERTED</p>';
}
add_action( 'wp_footer', 'your_function' );
//add_action('plugins_loaded', 'run_on_plugins_loaded');
//add_action('init', 'run_on_init', 10, 0);
```

## CSS und JS einbinden

```php
function add_my_css_and_my_js_files(){
	wp_enqueue_script('your-script-name', plugins_url('/assets/js/script.js', __FILE__), array('jquery'), '1.2.3', true);
	wp_enqueue_style('your-stylesheet-name', plugins_url('/assets/css/style.css', __FILE__), false, '1.0.0', 'all');
}
add_action( 'wp_enqueue_scripts', 'add_my_css_and_my_js_files' );
```

## Shortcodes

```php
function func_productimages( $atts, $content = "" ) {
	$sc = '...';
	return $sc;
}
add_shortcode( 'productimages', 'func_productimages' );

//echo do_shortcode("[shortcode]"); // via PHP an geeigneter Stelle ausführen
```


## Liste von nützlichen Funktionen

```php
get_bloginfo('url') // http://domain.com/public/
wp_normalize_path('path/path\path//file.svg') // => path/path/path/file.svg
wp_normalize_path(plugin_dir_url(__FILE__).'/assets/img/file.svg') // => /wp-content/plugins/assets/img/file.svg
wp_normalize_path(plugins_url('/assets/img/file.svg', __FILE__)) // => /wp-content/plugins/assets/img/file.svg
wp_get_current_user() // => WP_User
$user = new WP_User( 1 ); // => WP_User
do_shortcode("[shortcode]") // Führt einen shortcode aus
current_user_can('activate_plugins') // => Admin
get_query_var('pagename') // Request: /mein-konto/view-order/6070 => mein-konto
```
