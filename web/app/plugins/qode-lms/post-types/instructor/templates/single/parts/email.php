<?php if ( ! empty( $email ) ) { ?>
	<div class="qode-ts-info-row">
		<span aria-hidden="true" class="icon_mail_alt qode-ts-bio-icon"></span>
		<span itemprop="email" class="qode-ts-bio-info"><?php echo esc_html__( 'email: ', 'qode-lms' ) . sanitize_email( esc_html( $email ) ); ?></span>
	</div>
<?php } ?>