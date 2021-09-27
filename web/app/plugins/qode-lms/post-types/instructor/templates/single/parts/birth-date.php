<?php if ( ! empty( $birth_date ) ) { ?>
	<div class="qode-ts-info-row">
		<span aria-hidden="true" class="icon_calendar qode-ts-bio-icon"></span>
		<span class="qode-ts-bio-info"><?php echo esc_html__( 'born on: ', 'qode-lms' ) . esc_html( $birth_date ); ?></span>
	</div>
<?php } ?>