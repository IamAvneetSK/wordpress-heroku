<div class="qode-course-popup">
	<div class="qode-course-popup-inner">
		<div class="qode-grid-row">
			<div class="qode-grid-col-8">
				<div class="qode-course-item-preloader qode-hide">
					<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
				</div>
				<div class="qode-popup-heading">
					<h5 class="qode-course-popup-title"><?php the_title(); ?></h5>
					<span class="qode-course-popup-close"><i class="icon_close"></i></span>
				</div>
				<div class="qode-popup-content">
				
				</div>
			</div>
			<div class="qode-grid-col-4">
				<div class="qode-popup-info-wrapper">
					<div class="qode-lms-search-holder">
						<div class="qode-lms-search-field-wrapper">
							<input class="qode-lms-search-field" value="" placeholder="<?php esc_html_e( 'Search Courses', 'qode-lms' ) ?>">
							<i class="qode-search-icon fa fa-search" aria-hidden="true"></i>
							<i class="qode-search-loading fa fa-spinner fa-spin qode-hidden" aria-hidden="true"></i>
						</div>
						<div class="qode-lms-search-results"></div>
					</div>
					<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/popup-items-list', 'course' ) ?>
				</div>
			</div>
		</div>
	</div>
</div>
