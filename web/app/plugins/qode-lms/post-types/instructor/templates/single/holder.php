<div class="container">
	<div class="container_inner clearfix">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if ( post_password_required() ) {
				echo get_the_password_form();
			} else { ?>
				<div class="qode-instructor-single-holder">
					<div class="qode-grid-row">
						<div <?php echo bridge_qode_get_content_sidebar_class(); ?>>
							<div class="qode-instructor-single-outer">
								<?php
								//load instructor info
								qode_lms_get_cpt_single_module_template_part( 'templates/single/layout-collections/standard', 'instructor', '', $params );
								?>
							</div>
						</div>
						<?php

						if ( $sidebar_layout != '') { ?>
							<div <?php echo bridge_qode_get_sidebar_holder_class(); ?>>
								<?php get_sidebar(); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php endwhile; endif; ?>
	</div>
</div>