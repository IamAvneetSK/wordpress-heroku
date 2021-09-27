<?php $value = isset( $question_params['answers'] ) && $question_params['answers'] != '' ? $question_params['answers'] : ''; ?>
<?php if ( $question_params['answer_checked'] != 'yes' ) { ?>
	<form action='' method='post' class="qode-lms-question-actions-check-form">
		<input type='hidden' name='qode_lms_questions' value='<?php echo esc_attr( $questions ); ?>'/>
		<input type='hidden' name='qode_lms_question_id' value='<?php echo esc_attr( $question_id ); ?>'/>
		<input type='hidden' name='qode_lms_course_id' value='<?php echo esc_attr( $course_id ); ?>'/>
		<input type='hidden' name='qode_lms_quiz_id' value='<?php echo esc_attr( $quiz_id ); ?>'/>
		<input type='hidden' name='qode_lms_question_answer' value='<?php echo esc_attr( $value ); ?>'/>
		<div class="qode-question-actions">
			<?php
			echo bridge_core_get_button_html(
				array(
					'custom_class' => 'qode-check-question qode-lms-actions-buttons',
					'html_type'    => 'button',
					'input_name'   => 'submit',
					'size'         => 'medium',
					'type'         => 'outline',
					'text'         => esc_html__( 'Check Answer', 'qode-lms' )
				)
			);
			?>
		</div>
	</form>
<?php } ?>