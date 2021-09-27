<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/image', $item_layout, $params ); ?>

<div class="qode-cli-text-holder">
	<div class="qode-cli-text-wrapper">
		<div class="qode-cli-text">
			<div class="qode-cli-top-info">
				<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/title', $item_layout, $params ); ?>
				
				<?php if ( $enable_price == 'yes' ) {
					echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/price', $item_layout, $params );
				} ?>
				
				<?php if ( $enable_instructor == 'yes' ) {
					echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/instructor-simple', $item_layout, $params );
				} ?>
			
			</div>
			<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/excerpt', $item_layout, $params ); ?>
			<div class="qode-cli-bottom-info">
				<?php if ( $enable_category == 'yes' ) {
					echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/category', $item_layout, $params );
				} ?>
				
				<?php if ( $enable_students == 'yes' ) {
					echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/students', $item_layout, $params );
				} ?>
			</div>
		</div>
	</div>
</div>