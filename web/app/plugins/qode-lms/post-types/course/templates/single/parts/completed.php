<?php if ( qode_lms_theme_installed() ) { ?>
	<?php echo bridge_core_get_button_html( array(
		'text' => esc_html__( 'Completed', 'qode-lms' ),
		'link' => 'javascript:void(0)'
	) ); ?>
<?php } else { ?>
	<a href="javascript:void(0)" class="qode-btn qode-btn-medium qode-btn-solid"><?php echo esc_html__( 'Completed', 'qode-lms' ); ?></a>
<?php } ?>