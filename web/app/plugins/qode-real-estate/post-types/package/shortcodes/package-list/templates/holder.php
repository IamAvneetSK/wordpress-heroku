<div class="qodef-package-list-holder <?php echo esc_attr( $holder_classes ); ?>">
    <div class="qodef-pckgl-inner <?php echo esc_attr( $holder_inner_classes ); ?> clearfix">
        <?php
        if ( $query_results->have_posts() ):
            while ( $query_results->have_posts() ) : $query_results->the_post();
                $params['package_values'] = qodef_re_package_list_shortcode_item_values(get_the_ID());
                $params['featured'] = get_post_meta(get_the_ID(), 'qodef_package_featured_meta', true);
                echo qodef_re_get_cpt_shortcode_module_template_part( 'package', 'package-list', 'item', '', $params, $additional_params );
            endwhile;
        else:
            echo qodef_re_get_cpt_shortcode_module_template_part( 'package', 'package-list', 'parts/posts-not-found' );
        endif;

        wp_reset_postdata();
        ?>
    </div>
</div>