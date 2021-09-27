<div class="container">
	<div class="container_inner clearfix">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="qode-course-single-holder">
				<?php if ( post_password_required() ) {
					echo get_the_password_form();
				} else { ?>
				<div class="qode-grid-row">
					<div <?php echo bridge_qode_get_content_sidebar_class(); ?>>
						<div class="qode-course-single-outer">
							<?php
							do_action( 'qode_course_page_before_content' );
							
							qode_lms_get_cpt_single_module_template_part( 'templates/single/layout-collections/default', 'course', '', $params );
							
							do_action( 'qode_course_page_after_content' );
							?>
						</div>
					</div>
					<?php if ( $sidebar_layout !== '' ) { ?>
						<div <?php echo bridge_qode_get_sidebar_holder_class(); ?>>
							<?php get_sidebar(); ?>
						</div>
					<?php } ?>
				</div>
                <?php } ?>
			</div>
		<?php endwhile; endif; ?>
	</div>
</div>
<?php do_action( 'qode_lms_course_popup' ); ?>