<div class="qode-quiz-info-top">
	<div class="qode-quiz-questions-number">
		<i class="icon_folder-alt" aria-hidden="true"></i>
		<span class="qode-question-number"><?php echo esc_html( $questions_number ); ?></span>
		<span class="qode-question-label"><?php echo esc_html( $questions_label ); ?></span>
	</div>
	<?php if ( $quiz_duration_value != "" ) { ?>
		<div class="qode-quiz-duration">
			<i class=" icon_clock_alt" aria-hidden="true"></i>
			<span class="qode-duration-value"><?php echo esc_html( $quiz_duration_value ); ?></span>
			<span class="qode-duration-parameter"><?php echo esc_html( $quiz_duration_parameter ); ?></span>
		</div>
	<?php } ?>
</div>