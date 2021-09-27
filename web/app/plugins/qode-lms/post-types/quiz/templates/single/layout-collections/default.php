<div class="qode-quiz-single-wrapper">
	<div class="qode-quiz-title-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'quiz' ); ?>
	</div>
	<div class="qode-quiz-info-top-wrapper">
		<?php qode_lms_template_quiz_info_top( $params ); ?>
		<?php qode_lms_template_start_quiz_button( $params ); ?>
	</div>
	<div class="qode-quiz-result-wrapper">
		<?php qode_lms_template_quiz_status( $params ); ?>
	</div>
	<div class="qode-quiz-old-results-wrapper">
		<?php qode_lms_template_quiz_results( $params ); ?>
	</div>
</div>