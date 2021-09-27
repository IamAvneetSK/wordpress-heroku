<div class="qodef-property-city-list-holder <?php echo esc_attr( $holder_classes ); ?>">
    <div class="qodef-pcl-inner <?php echo esc_attr( $holder_inner_classes ); ?> clearfix" <?php echo bridge_qode_get_inline_attrs($slider_data); ?>>
        <?php
        if ( isset($property_cities) && !empty($property_cities) ) {
            foreach($property_cities as $city) {
                $additional_params['id'] = $city->term_id;
                $additional_params['name'] = $city->name;
                $additional_params['slug'] = $city->slug;
                $additional_params['count'] = $city->count;
                $additional_params['link'] = get_term_link($city->term_id);
                $additional_params['county'] = get_term_meta($city->term_id, 'property_city_county', true);
                $additional_params['object'] = $city;
                echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-city-list', 'item', '', $params, $additional_params );
            }
        } else {
            echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-city-list', 'parts/posts-not-found', '', $params, $additional_params );
        }
        ?>
    </div>
</div>