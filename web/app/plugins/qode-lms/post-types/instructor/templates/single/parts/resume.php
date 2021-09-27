<?php if ( ! empty( $resume ) ) { ?>
	<div class="qode-ts-info-row">
		<span aria-hidden="true" class="icon_document_alt qode-ts-bio-icon"></span>
		<a href="<?php echo esc_url( $resume ); ?>" download target="_blank">
            <span class="qode-ts-bio-info">
                <?php echo esc_html__( 'Download Resume', 'qode-lms' ); ?>
            </span>
		</a>
	</div>
<?php } ?>