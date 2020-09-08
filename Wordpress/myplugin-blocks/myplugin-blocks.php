<?php
/*
Plugin Name: Myplugin Blocks
*/

add_filter('block_categories', function( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'myplugin',
                'title' => 'Myplugin',
            ),
        )
    );
}, 10, 2);


function myplugin_register_gutenberg_block() {

    $blocks = [
        (object)['category'=>'myplugin', 'name'=>'download', 'file'=>'download.js', 'style'=>'download.css', 'editor_style'=>'download_editor.css', 'script_deps'=>['wp-blocks', 'wp-element', 'wp-editor']],
        
        
    ];

    foreach ($blocks as $block) {

        // Register our block script with WordPress
        wp_register_script(
            'gutenberg-block-'.$block->category.'-'.$block->name,
            plugins_url('/blocks/'.$block->name.'/'.$block->file, __FILE__),
            $block->script_deps
        );
        
        if( $block->editor_style && is_admin() ) {
            // Register our block's editor-specific CSS
            wp_register_style(
                'gutenberg-block-editor-style-'.$block->category.'-'.$block->name,
                plugins_url('/blocks/'.$block->name.'/'.$block->editor_style, __FILE__),
                ['wp-edit-blocks']
            );
        }
    
        if ( $block->style ) {
            // Register our block's base CSS
            wp_register_style(
                'gutenberg-block-style-'.$block->category.'-'.$block->name,
                plugins_url('/blocks/'.$block->name.'/'.$block->style, __FILE__ ),
                [/* 'wp-blocks' */]
            );
        }

        // Enqueue the script in the editor
        $args = [];
        $args['editor_script'] = 'gutenberg-block-'.$block->category.'-'.$block->name;
        if ( $block->editor_style ) $args['editor_style'] = 'gutenberg-block-editor-style-'.$block->category.'-'.$block->name;
        if ( $block->style ) $args['style'] = 'gutenberg-block-style-'.$block->category.'-'.$block->name;
        #var_export($args);exit;
        register_block_type($block->category.'/'.$block->name, $args);

    }

}
add_action('init', 'myplugin_register_gutenberg_block');



 
function myplugin_block_enqueue(){

    // General editor style
    $editor_style = plugins_url('/blocks/editor.css', __FILE__);
	wp_enqueue_style('gutenberg-block-style-editor', $editor_style, ['wp-edit-blocks'], time());
 
}
add_action('enqueue_block_editor_assets', 'myplugin_block_enqueue');
















function rest_api_myplugin() {
	register_rest_route(
		'myplugin',
		'/contacts',/* /(?P<option>([A-Za-z0-9\_])+)/', */
		array(
			'callback'            => function ( $request ) {
#return 123;

                $posts = get_posts([
                    'post_type' => 'contacts',
                    'post_status' => 'publish',
                    /* 'posts_per_page' => 1000,
                    'nopaging' => true,
                    'order' => 'DESC',
                    'orderby' => 'date', */
                ]);
                // $posts fields auswählen
                $contacts = [];
                foreach ($posts as $post) {
                    $contacts[] = (object)[
                        'id' => $post->ID,
                        'title' => $post->post_title,
                        //'menu_order' => $post->menu_order,
                        //'url' => get_permalink($post->ID),
                        'date' => $post->post_date,
                        'excerpt' => $post->post_excerpt,
                        'image_id' => get_post_meta($post->ID, '_thumbnail_id', true),
                        'image_url' => get_the_post_thumbnail_url($post->ID),
                        // Terms/Taxonomies:
                        //'term_locations' => wp_get_post_terms($post->ID, 'contacts_locations', ['fields' => 'names']), // Examples
                        //'term_sectors' => wp_get_post_terms($post->ID, 'contacts_sectors', ['fields' => 'names']),
                        // Meta-fields:
                        'meta_lastname' => get_post_meta($post->ID, 'lastname', true),
                        'meta_firstname' => get_post_meta($post->ID, 'firstname', true),
                        'meta_function' => get_post_meta($post->ID, 'function', true),
                        'meta_email' => get_post_meta($post->ID, 'email', true),
                        'meta_phone' => get_post_meta($post->ID, 'phone', true),
                        'meta_description' => get_post_meta($post->ID, 'description', true),
                    ];
                }
                $response = /* ['contacts' =>  */$contacts/*  ] */;



				/* $option = isset( $request['option'] ) ? esc_attr( $request['option'] ) : null;
				$value  = get_option( $option, '' );
                return $value; */
                return json_encode($response);
			},
			'methods'             => 'GET',
			'permission_callback' => function () {
                return true;
                //return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'rest_api_init', 'rest_api_myplugin' );
