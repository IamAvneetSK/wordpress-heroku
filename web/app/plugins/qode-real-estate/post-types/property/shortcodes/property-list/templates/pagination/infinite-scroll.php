<?php if ( $query_results->max_num_pages > 1 ) { ?>
    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'pagination/loading-element' ); ?>
<?php }