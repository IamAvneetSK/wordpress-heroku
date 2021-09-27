<div class="qodef-pts-item" data-id="<?php echo esc_attr($id); ?>">
    <div class="qodef-pts-item-inner">
        <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-type-slider', 'layout-collections/' . $item_layout, '', $params, $additional_params ); ?>
        <a itemprop="url" class="qodef-ptl-item-link qodef-block-drag-link" href="<?php echo esc_url($link); ?>" target="_self"></a>
    </div>
</div>