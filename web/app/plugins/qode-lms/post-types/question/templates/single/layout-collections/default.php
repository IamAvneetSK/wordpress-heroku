<?php
$question_slug = str_replace( '_', '-', $question_type );
?>
<div class="qode-question-single-wrapper">
	<div class="qode-question-title-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'question', '', $params ); ?>
	</div>
	<div class="qode-question-text-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/text', 'question', '', $params ); ?>
	</div>
	<div class="qode-question-answer-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/answers', 'question', $question_slug, $params ); ?>
		<?php if ( $question_params['show_hint'] == 'yes' ) { ?>
			<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/hint', 'question', '', $params ); ?>
		<?php } ?>
	</div>
	<div class="qode-question-actions-wrapper">
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/actions-prev-form', 'question', '', $params ); ?>
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/actions-hint-form', 'question', '', $params ); ?>
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/actions-check-form', 'question', '', $params ); ?>
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/actions-next-form', 'question', '', $params ); ?>
		<?php qode_lms_get_cpt_single_module_template_part( 'templates/single/parts/actions-finish', 'quiz', '', $params ); ?>
	</div>
</div>