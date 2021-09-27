<div class="qode-quiz-info-top">
	<div class="qode-quiz-questions-number">
		<i class="icon_folder-alt" aria-hidden="true"></i>
		<span class="qode-question-number-completed"><?php echo esc_html( $question_position ); ?></span> /
		<span class="qode-question-number-total"><?php echo esc_html( $questions_number ); ?></span>
	</div>
	<?php if ( $time_remaining != "" ) { ?>
		<div class="qode-quiz-duration">
			<i class=" icon_clock_alt" aria-hidden="true"></i>
			<span class="qode-duration-value" id="qode-quiz-timer" data-duration="<?php echo esc_attr( $time_remaining ) ?>"><?php echo esc_html( $time_remaining_formatted ); ?></span>
			<span class="qode-duration-parameter"><?php esc_html_e( '(mm:ss)', 'qode-lms' ); ?></span>
		</div>
		<input type='hidden' name='qode_lms_time_remaining' value=''/>
	<?php } ?>
</div>