<div class="qode-quiz-active-wrapper">
	<div class="qode-quiz-title-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'quiz', '', $params ); ?>
	</div>
	<div class="qode-quiz-info-top-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/info-top', 'quiz', 'active', $params ); ?>
	</div>
	<div class="qode-quiz-question-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/layout-collections/default', 'question', '', $params ); ?>
	</div>
</div>