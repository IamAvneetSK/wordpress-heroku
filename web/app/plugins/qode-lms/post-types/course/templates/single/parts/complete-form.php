<form action="" method="post" class="qode-lms-complete-item-form">
	<input type="hidden" name="qode_lms_course_id" value="<?php echo esc_attr( $course_id ) ?>"/>
	<input type="hidden" name="qode_lms_item_id" value="<?php echo esc_attr( $item_id ) ?>"/>
	<?php if ( qode_lms_theme_installed() ) { ?>
		<?php echo bridge_core_get_button_v2_html( array(
			'html_type'  => 'input',
			'text'       => esc_html__( 'Complete', 'qode-lms' ),
			'input_name' => 'submit'
		) ); ?>
	<?php } else { ?>
		<input name="submit" type="submit" value="<?php echo esc_html__( 'Complete', 'qode-lms' ); ?>"/>
	<?php } ?>
</form>
