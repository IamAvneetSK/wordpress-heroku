<li class="qodef-ptl-item <?php echo esc_attr($id) == $params['active_element'] ? 'active' : ''; ?>" data-id="<?php echo esc_attr($id); ?>">
    <div class="qodef-ptl-item-inner">
        <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-type-list', 'layout-collections/' . $item_layout, '', $params, $additional_params ); ?>
        <a itemprop="url" class="qodef-ptl-item-link" href="<?php echo esc_url($link); ?>" target="_self"></a>
    </div>
</li>