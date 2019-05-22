# Plugins

## Beispiel Plugin-Starter-Datei:

Lege einen Ordner unter /wp-content/plugins/ mit dem Namen des Plugins an. Erstelle darin eine PHP-Datei z.B. main.php.

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
//add_action('plugins_loaded', 'runOnPluginsLoaded');
//add_action('init', 'runOnInit', 10, 0);
```

## Liste von nützlichen Funktionen

```php
get_bloginfo('url') // http://domain.com/public/
wp_normalize_path('path/path\path//file.svg') // => path/path/path/file.svg
wp_normalize_path(plugin_dir_url(__FILE__).'/assets/img/file.svg') // => /wp-content/plugins/assets/img/file.svg
wp_normalize_path(plugins_url('/assets/img/file.svg', __FILE__)) // => /wp-content/plugins/assets/img/file.svg
wp_get_current_user() // => WP_User
$user = new WP_User( 1 ); // => WP_User
```
