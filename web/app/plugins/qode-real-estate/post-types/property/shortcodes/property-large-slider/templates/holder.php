<div class="qodef-pls-holder qode-owl-slider" data-slider-animate-out="fadeOut">

    <?php
    if ( $query_results->have_posts() ):
        while ( $query_results->have_posts() ) : $query_results->the_post();
            echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-large-slider', 'item', '', $params, $additional_params );
        endwhile;
    else:
        echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-large-slider', 'posts-not-found' );
    endif;

    wp_reset_postdata();
    ?>

</div>