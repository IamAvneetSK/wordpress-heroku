<?php if ( qode_lms_theme_installed() ) {
	echo bridge_core_get_button_html( array(
		'text' => esc_html__( 'View Cart', 'qode-lms' ),
		'link' => wc_get_cart_url()
	) );
} else { ?>
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="qode-btn qode-btn-medium qode-btn-solid"><?php echo esc_html__( 'View Cart', 'qode-lms' ); ?></a>
<?php } ?>