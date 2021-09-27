<?php if ( $query_results->max_num_pages > 1 ) {
	$holder_styles = $this_object->getLoadMoreStyles( $params );
	?>
	<div class="qode-cl-loading">
		<div class="qode-cl-loading-bounce1"></div>
		<div class="qode-cl-loading-bounce2"></div>
		<div class="qode-cl-loading-bounce3"></div>
	</div>
	<div class="qode-cl-load-more-holder">
		<div class="qode-cl-load-more" <?php bridge_qode_inline_style( $holder_styles ); ?>>
			<?php
			echo bridge_core_get_button_html( array(
				'link' => 'javascript: void(0)',
				'size' => 'large',
				'text' => esc_html__( 'Load more', 'qode-lms' )
			) );
			?>
		</div>
	</div>
<?php }