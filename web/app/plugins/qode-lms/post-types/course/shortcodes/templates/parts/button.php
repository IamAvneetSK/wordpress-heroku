<?php
if ( qode_lms_user_has_course() ) {
	$user_current_course_status = qode_lms_user_current_course_status();
	if ( $user_current_course_status == 'completed' ) {
		$button_text = esc_html__( 'Retake', 'qode-lms' );
	} else if ( $user_current_course_status == 'in-progress' ) {
		$button_text = esc_html__( 'Resume', 'qode-lms' );
	} else {
		$button_text = esc_html__( 'Start ', 'qode-lms' );
	}
} else {
	$button_text = esc_html__( 'Enroll', 'qode-lms' );
}
?>
<?php if ( qode_lms_theme_installed() ) {
	?>
	<?php echo bridge_core_get_button_html( array(
		'text' => $button_text,
		'link' => get_the_permalink()
	) ); ?>
<?php } else { ?>
	<a href="<?php echo get_the_permalink(); ?>" class="qode-btn qode-btn-medium qode-btn-solid"><?php echo esc_html( $button_text ); ?></a>
<?php } ?>