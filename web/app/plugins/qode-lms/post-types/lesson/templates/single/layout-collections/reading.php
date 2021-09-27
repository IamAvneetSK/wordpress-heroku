<div class="qode-lms-lesson-content-wrapper">
	<div class="qode-lms-lesson-title">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'lesson', '', $params ); ?>
	</div>
	<div class="qode-lms-lesson-content">
		<?php the_content(); ?>
	</div>
	<div class="qode-lms-lesson-complete">
		<?php echo qode_lms_complete_button( $params ); ?>
	</div>
</div>