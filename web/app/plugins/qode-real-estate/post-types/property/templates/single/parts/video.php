<?php
$has_video_link = get_post_meta(get_the_ID(), "qodef_property_video_custom_meta", true) !== '' || get_post_meta(get_the_ID(), "qodef_property_video_link_meta", true) !== '';

if ($has_video_link) {

    $video_type = get_post_meta( get_the_ID(), "qodef_property_video_type_meta", true );
    if ( $video_type == 'social_networks' ) {
        $video_link = get_post_meta( get_the_ID(), "qodef_property_video_link_meta", true );
    } else if ( $video_type == 'self' ) {
        $video_link = get_post_meta( get_the_ID(), "qodef_property_video_custom_meta", true );
    }
    $video_image = get_post_meta( get_the_ID(), "qodef_property_video_image_meta", true );
    $video_image_id = bridge_qode_get_attachment_id_from_url($video_image);
    $video_button_params = array(
        'video_image' => $video_image_id,
        'video_link' => $video_link,
    );

?>
    <div class="qodef-property-video qodef-property-label-items-holder">
        <div class="qodef-property-video-label qodef-property-label-style">
            <h5>
                <?php esc_html_e('Property Video', 'qode-real-estate'); ?>
            </h5>
        </div>
        <div class="qodef-property-video-items qodef-property-items-style clearfix">
            <?php echo bridge_qode_execute_shortcode('qode_video_box', $video_button_params); ?>
        </div>
    </div>
<?php } ?>