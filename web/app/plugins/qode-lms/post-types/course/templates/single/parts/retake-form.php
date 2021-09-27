<form action="" method="post" class="qode-lms-retake-course-form">
	<input type="hidden" name="qode_lms_course_id" value="<?php echo get_the_ID(); ?>"/>
	<?php if ( qode_lms_theme_installed() ) { ?>
		<?php echo bridge_core_get_button_html( array(
			'html_type'  => 'input',
			'text'       => esc_html__( 'Retake', 'qode-lms' ),
			'input_name' => 'submit'
		) ); ?>
	<?php } else { ?>
		<input name="submit" type="submit" value="<?php echo esc_html__( 'Retake', 'qode-lms' ); ?>"/>
	<?php } ?>
</form>
