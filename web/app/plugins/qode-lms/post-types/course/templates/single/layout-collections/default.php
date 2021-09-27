<div class="qode-course-single-wrapper">
	<div class="qode-course-title-wrapper">
		<div class="qode-course-left-section">
			<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'course', '', $params ); ?>
			<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/course-type', 'course', '', $params ); ?>
		</div>
		<div class="qode-course-right-section">
			<?php qode_lms_get_wishlist_button(); ?>
		</div>
	</div>
	<div class="qode-course-basic-info-wrapper">
		<div class="qode-grid-row">
			<div class="qode-grid-col-9">
				<div class="qode-grid-row">
					<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/instructor', 'course', '', $params ); ?>
					<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/categories', 'course', '', $params ); ?>
					<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/reviews', 'course', '', $params ); ?>
				</div>
			</div>
			<div class="qode-grid-col-3">
				<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/action', 'course', '', $params ); ?>
			</div>
		</div>
	</div>
	<div class="qode-course-image-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/image', 'course', '', $params ); ?>
	</div>
	<div class="qode-course-tabs-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/tabs', 'course', '', $params ); ?>
	</div>
</div>