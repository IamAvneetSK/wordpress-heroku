<?php
$qodef_re_archive_holder_params = qodef_re_get_holder_params_archive();
get_header();
?>
<?php do_action('bridge_qode_before_main_content'); ?>
<div class="<?php echo esc_attr( $qodef_re_archive_holder_params['holder'] ); ?>">
	<?php do_action('bridge_qode_after_container_open'); ?>
    <div class="<?php echo esc_attr( $qodef_re_archive_holder_params['inner'] ); ?>">
        <?php
        $qodef_taxonomy_name = '';
        $qodef_taxonomy_id = get_queried_object_id();
        if(is_tax('property-type')) {
            $qodef_taxonomy_name = 'property-type';
        } else if(is_tax('property-status')) {
            $qodef_taxonomy_name = 'property-status';
        } else if(is_tax('property-city')) {
            $qodef_taxonomy_name = 'property-city';
        } else if(is_tax('property-feature')) {
            $qodef_taxonomy_name = 'property-feature';
        } else if(is_tax('property-county')) {
            $qodef_taxonomy_name = 'property-county';
        } else if(is_tax('property-neighborhood')) {
            $qodef_taxonomy_name = 'property-neighborhood';
        } else if(is_tax('property-tag')) {
            $qodef_taxonomy_name = 'property-tag';
        }

        qodef_re_get_archive_property_list($qodef_taxonomy_id, $qodef_taxonomy_name);
        ?>
	</div>
	<?php do_action('bridge_qode_before_container_close'); ?>
</div>
<?php get_footer(); ?>
