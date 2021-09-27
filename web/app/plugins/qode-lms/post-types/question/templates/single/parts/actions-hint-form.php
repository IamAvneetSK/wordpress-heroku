<?php if ( $question_params['show_hint'] != 'yes' ) { ?>
	<form action='' method='post' class="qode-lms-question-actions-hint-form">
		<input type='hidden' name='qode_lms_questions' value='<?php echo esc_attr( $questions ); ?>'/>
		<input type='hidden' name='qode_lms_question_id' value='<?php echo esc_attr( $question_id ); ?>'/>
		<input type='hidden' name='qode_lms_course_id' value='<?php echo esc_attr( $course_id ); ?>'/>
		<input type='hidden' name='qode_lms_quiz_id' value='<?php echo esc_attr( $quiz_id ); ?>'/>
		<div class="qode-question-actions">
			<?php
			echo bridge_core_get_button_html(
				array(
					'custom_class' => 'qode-hint-question qode-lms-actions-buttons',
					'html_type'    => 'button',
					'input_name'   => 'submit',
					'size'         => 'medium',
					'type'         => 'outline',
					'text'         => esc_html__( 'Hint', 'qode-lms' ),
					'link'         => '#',
				)
			);
			?>
		</div>
	</form>
<?php } ?>