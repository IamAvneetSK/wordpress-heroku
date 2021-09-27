<?php
$size = get_post_meta(get_the_ID(), 'qodef_property_size_meta', true);
$structure = get_post_meta(get_the_ID(), 'qodef_property_bedrooms_meta', true);
$accommodation = get_post_meta(get_the_ID(), 'qodef_property_accommodation_meta', true);
?>
<div class="qodef-item-info">
    <?php if(!empty($size)) { ?>
        <span class="qodef-item-size"><?php echo qodef_re_get_real_estate_size($size); ?></span>
        <span class="qodef-item-dash">&ndash;</span>
    <?php } ?>
    <?php if(!empty($structure)) { ?>
        <span class="qodef-item-structure"><?php echo esc_html($structure); ?></span>
        <span class="qodef-item-dash">&ndash;</span>
    <?php } ?>
    <?php if(!empty($accommodation)) { ?>
        <span class="qodef-item-accomodation"><?php echo esc_html($accommodation); ?></span>
    <?php } ?>
</div>
