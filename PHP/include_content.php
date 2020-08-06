<?php

// Include content
// Usage: $var1 = '1'; $var2 = '2'; $content = include_content('template.php', compact('var1', 'var2'));
if ( !function_exists('include_content') ) {  
    function include_content($file, $args = []) {
        extract($args);
        $template = $file;
        $contents = '';//'<i>Missing '.$template.'</i>';
        if ( file_exists($template) ) {
            ob_start();
            include $template;
            $contents = ob_get_contents(); // data is now in here
            ob_end_clean();
        }
        return $contents;
    }
}
