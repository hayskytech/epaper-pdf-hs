<?php
/*
Template Name: Books
Template Post Type: book
*/
get_header();
$pdf_id = get_post_meta($post->ID,'pdf',true);
$file_url = wp_get_attachment_url( $pdf_id );

?>
<h1 class="epaper-title">E-paper: <?php echo the_title(); ?></h1>
<style type="text/css">
    iframe{
/*        margin: 50px;*/
        height: 800px;
        width: 100%;
        border: none;
    }
</style>

<iframe src="<?php echo $file_url; ?>"></iframe>

<?php

get_footer();
?>

