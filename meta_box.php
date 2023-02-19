<?php
add_action( "add_meta_boxes",function(){
	add_meta_box(
	    "post-meta-fields-hvb",
	    "Epaper Fields ", 
// Creates Metabox Callback Function
function(){
    global $post;
    wp_enqueue_script("jquery");
    $meta = get_post_meta($post->ID);
    $data["pdf"] = $meta["pdf"][0];
    ?>
    <h3>Select PDF</h3>

    <div class="image-preview-wrapper">
        <img src="" height="100"><a id="link_pdf">View</a>
    </div><br>
    <input type="button" class="ui blue mini button" value="Select PDF" onclick="choose_media(this)" />
    <input type="hidden" name="pdf">
        <?php
        wp_enqueue_media();
        add_action( 'admin_footer', 'media_selector_print_scripts' );
        add_action( 'wp_footer', 'media_selector_print_scripts' );
        function media_selector_print_scripts() {
            ?>
            <script type='text/javascript'>
            function choose_media(x) {
                var file_frame;
                var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                var set_to_post_id = jQuery(x).parent().find('input[type=hidden]').val(); // Set this
                if ( file_frame ) {
                    file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                    file_frame.open();
                    return;
                } else {
                    wp.media.model.settings.post.id = set_to_post_id;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a PDF to upload',
                    button: {
                        text: 'Use this file',
                    },
                    multiple: false
                });
                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();
                    // Do something with attachment.id and/or attachment.url here
                    jQuery(x).parent().find('#link_pdf').attr( 'href', attachment.url );
                    jQuery(x).parent().find('#link_pdf').text( attachment.url );
                    jQuery(x).parent().find('input[type=hidden]').val( attachment.id );
                    // Restore the main post ID
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
                    // Finally, open the modal
                    file_frame.open();
                // Restore the main ID when the add media button is pressed
                jQuery( 'a.add_media' ).on( 'click', function() {
                    wp.media.model.settings.post.id = wp_media_post_id;
                    // jQuery('#link_pdf').text()
                });
            }
            </script>
            <?php
        }
        ?>
        
    <script type="text/javascript">
        <?php 
        $img_id = $data["pdf"];
        $file_url = wp_get_attachment_url( $img_id );
        $img_url = wp_get_attachment_image_src($img_id, 'medium');
        ?>
        jQuery("input[name=pdf").val("<?php echo $img_id; ?>");
        jQuery('#img_pdf').attr('src','<?php echo $img_url[0]; ?>');
        jQuery("#link_pdf").attr("href","<?php echo $file_url; ?>");
        jQuery("#link_pdf").text("<?php echo $file_url; ?>");
        jQuery("#link_pdf").attr("target","_blank");
    </script>
	<?php
},
	    "epaper",            // change "post" to "some other post_type"
	    "side",
	    "high"
	);
});

add_action( "save_post",function(){
    if("epaper" == $_POST["post_type"]){          // change "post" to "some other post_type"
        global $post;
        update_post_meta($post->ID, "pdf", $_POST["pdf"]);
    }
});
?>