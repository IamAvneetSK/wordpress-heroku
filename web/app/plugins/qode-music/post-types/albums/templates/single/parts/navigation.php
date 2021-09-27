<?php  if ( bridge_qode_options()->getOptionValue( 'album_pagination' ) == 'yes' ) : ?>
<div class="qode-album-nav qode-grid-section container_inner">
	<div class="qode-album-nav-inner qode-section-inner">
		<?php if ( get_previous_post() !== '' ) : ?>
			<div class="qode-album-prev">
				<?php previous_post_link( '%link', esc_html__( '', 'qode-music' ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $back_to_link !== '' ) : ?>
			<div class="qode-album-back-btn">
				<a href="<?php echo esc_url($back_to_link); ?>">
					<?php esc_html_e( '', 'qode-music' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if ( get_next_post() !== '' ) : ?>
			<div class="qode-album-next">
				<?php next_post_link( '%link', esc_html__( '', 'qode-music' )); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>