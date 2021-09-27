<div class="qodef-ptl-item-image">
    <?php if( ! $used_for_search ) { ?>
        <?php if($params['skin'] === 'qodef-light-skin') {?>
            <?php echo qodef_re_get_taxonomy_icon($id, 'property_type_custom_icon_light', 'property_type_icon'); ?>
        <?php } else { ?>
            <?php echo qodef_re_get_taxonomy_icon($id, 'property_type_custom_icon', 'property_type_icon'); ?>
        <?php } ?>
    <?php } else { ?>
        <div class="qodef-ptl-light-img-holder">
            <?php echo qodef_re_get_taxonomy_icon($id, 'property_type_custom_icon_light', 'property_type_icon'); ?>
        </div>
        <div class="qodef-ptl-dark-img-holder">
            <?php echo qodef_re_get_taxonomy_icon($id, 'property_type_custom_icon', 'property_type_icon'); ?>
        </div>
    <?php } ?>
</div>
<div class="qodef-ptl-item-title">
    <?php echo esc_html($name); ?>
</div>