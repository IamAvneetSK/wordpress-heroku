<?php if ( ! empty( $address ) ) { ?>
	<div class="qode-ts-info-row">
		<span aria-hidden="true" class="icon_building_alt qode-ts-bio-icon"></span>
		<span class="qode-ts-bio-info"><?php echo esc_html__( 'lives in: ', 'qode-lms' ) . esc_html( $address ); ?></span>
	</div>
<?php } ?>