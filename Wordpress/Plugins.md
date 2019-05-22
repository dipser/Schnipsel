# Plugins


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


# add_action

function your_function() {
    echo '<p>INSERTED</p>';
}
add_action( 'wp_footer', 'your_function' );
//add_action('plugins_loaded', 'runOnPluginsLoaded');
//add_action('init', 'runOnInit', 10, 0);


# Liste von nützlichen Funktionen

```php
get_bloginfo('url')
.wp_normalize_path(plugin_dir_url(__FILE__).'/assets/img/file.svg')
wp_normalize_path(plugins_url('/assets/img/file.svg', __FILE__))
wp_get_current_user()
$user = new WP_User( 1 );
```
