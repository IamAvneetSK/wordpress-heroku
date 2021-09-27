<?php
$thumb_size = $this_object->getImageSize($params);
$list_image = get_post_meta(get_the_ID(), 'qodef_property_featured_image_meta', true);
if(!isset($list_image) || empty($list_image)) {
    if(has_post_thumbnail(get_the_ID())) {
        $list_image = get_the_post_thumbnail_url(get_the_ID(), $thumb_size);
    } else {
        $list_image = QODE_RE_CPT_URL_PATH . '/property/assets/img/property_featured_image.jpg';
    }
}
?>
<div class="qodef-pli-image">
    <img itemprop="image" src="<?php echo esc_url($list_image); ?>" alt="<?php esc_attr_e('Property Featured Image', 'qode-real-estate'); ?>" />
</div>