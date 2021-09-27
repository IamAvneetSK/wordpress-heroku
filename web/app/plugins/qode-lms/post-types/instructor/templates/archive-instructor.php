<?php
get_header();
bridge_qode_get_title();
do_action( 'qode_before_main_content' ); ?>
<div class="container qode-default-page-template">
	<?php do_action( 'qode_after_container_open' ); ?>
	<div class="container_inner clearfix">
		<?php
		$qode_taxonomy_id   = get_queried_object_id();
		$qode_taxonomy      = ! empty( $qode_taxonomy_id ) ? get_category( $qode_taxonomy_id ) : '';
		$qode_taxonomy_slug = ! empty( $qode_taxonomy ) ? $qode_taxonomy->slug : '';
		
		qode_lms_get_instructor_category_list( $qode_taxonomy_slug );
		?>
	</div>
	<?php do_action( 'qode_before_container_close' ); ?>
</div>
<?php get_footer(); ?>
