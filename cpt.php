<?php
add_action( "init",function(){
    // Set labels for pdf
    $labels = array(
        "name" => "E-Papers",
        "singular_name" => "E-Paper",
        "add_new"    => "Add E-Paper",
        "add_new_item" => "Add New E-Paper",
        "all_items" => "All E-Papers",
        "edit_item" => "Edit E-Paper",
        "new_item" => "New E-Paper",
        "view_item" => "View E-Paper",
        "search_items" => "Search E-Papers",
    );
    // Set Options for pdf
    $args = array(    
        "public" => true,
        "label"       => "E-Papers",
        "labels"      => $labels,
        "has_archive"        => true,
        "description" => "E-Papers custom post type.",
        "menu_icon"   => "dashicons-pdf",
        // 'rewrite'     => array( 'slug' => 'epaper/%year%/%monthnum%/%day%/%post_id%', 'with_front' => true ),    
        "supports"   => array( "title", "thumbnail"),
        "capability_type" => "post",
        "publicly_queryable"  => true,
        "exclude_from_search" => false
    );
    register_post_type("epaper", $args);
    
});

function custom_post_type_permalink( $post_link, $post ) {
    if ( 'epaper' === $post->post_type ) {
        $post_link = str_replace( '%year%', get_the_date( 'Y', $post->ID ), $post_link );
        $post_link = str_replace( '%monthnum%', get_the_date( 'm', $post->ID ), $post_link );
        $post_link = str_replace( '%day%', get_the_date( 'd', $post->ID ), $post_link );
        $post_link = str_replace( '%post_id%', $post->ID, $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'custom_post_type_permalink', 10, 2 );