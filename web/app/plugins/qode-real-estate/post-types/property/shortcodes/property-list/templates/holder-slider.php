<div class="qodef-property-list-holder <?php echo esc_attr( $holder_classes ); ?>" <?php echo wp_kses( $holder_data, array( 'data' ) ); ?>>
    <div class="qodef-pl-inner <?php echo esc_attr( $holder_inner_classes ); ?> clearfix">
        <?php
        if ( $query_results->have_posts() ):
            while ( $query_results->have_posts() ) : $query_results->the_post();
                echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'item', '', $params, $additional_params );
            endwhile;
        else:
            echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'parts/posts-not-found' );
        endif;

        wp_reset_postdata();
        ?>
    </div>
</div>
