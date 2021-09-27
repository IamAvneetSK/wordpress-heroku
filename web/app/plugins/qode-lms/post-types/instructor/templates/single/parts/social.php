<?php if ( ! empty( $social_icons ) ) { ?>
	<p class="qode-social">
		<?php foreach ( $social_icons as $social_icon ) {
			echo wp_kses_post( $social_icon );
		} ?>
	</p>
<?php } ?>