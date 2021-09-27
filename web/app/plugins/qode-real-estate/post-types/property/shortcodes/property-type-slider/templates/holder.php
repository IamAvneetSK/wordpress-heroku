<div class="qodef-property-type-slider-holder">
    <div class="qodef-pts-inner qode-owl-slider" <?php echo bridge_qode_get_inline_attrs($data_attr); ?>>
        <?php
        if ( isset($property_types) && !empty($property_types) ) {
            foreach($property_types as $type) {
                $additional_params['id'] = $type->term_id;
                $additional_params['name'] = $type->name;
                $additional_params['slug'] = $type->slug;
                $additional_params['count'] = $type->count;
                $additional_params['link'] = get_term_link($type->term_id);
                $additional_params['object'] = $type;

                echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-type-slider', 'item', '', $params, $additional_params );
            }
        } else {
            echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-type-slider', 'parts/posts-not-found', '', $params, $additional_params );
        }
        ?>
    </div>
</div>