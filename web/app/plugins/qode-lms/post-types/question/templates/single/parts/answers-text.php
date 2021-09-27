<?php
$value = isset( $question_params['answers'] ) && $question_params['answers'] != '' ? $question_params['answers'] : '';
?>
<div class="qode-question-answers">
	<div class="qode-answer-wrapper qode-answer-text">
		<input type="text" title="question_answer" name="question_answer" value="<?php echo esc_attr( $value ); ?>"/>
	</div>
</div>
