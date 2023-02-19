<?php
/**
 * Plugin Name: Epaper PDFs by Haysky
 * Plugin URI: https://haysky.com/
 * Description: Creates a custom post type Epaper.
 * Version: 1.0.0
 * Author: Haysky
 * Author URI: https://haysky.com/
 * License: GPLv2 or later
  */
// $wpdb->show_errors(); $wpdb->print_error();
error_reporting(E_ERROR | E_PARSE);


include 'cpt.php';
include 'meta_box.php';

add_filter( 'template_include', 'my_plugin_custom_template', 99 );

function my_plugin_custom_template( $template ) {
    if ( is_singular( 'epaper' ) ) {
        $new_template = plugin_dir_path( __FILE__ ) . 'single-epaper.php';
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }
    return $template;
}


