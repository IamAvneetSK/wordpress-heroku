<div class="qodef-full-width">
    <div class="qodef-full-width-inner clearfix">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="qodef-property-single-holder">
                <?php if ( post_password_required() ) {
                    echo get_the_password_form();
                } else { ?>
                    <?php

                    do_action( 'bridge_qode_property_page_before_content' );

                    qodef_re_get_cpt_single_module_template_part( 'templates/single/layout-collections/default', 'property', '', $params );

                    do_action( 'bridge_qode_property_page_after_content' );

                    ?>
                <?php } ?>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>