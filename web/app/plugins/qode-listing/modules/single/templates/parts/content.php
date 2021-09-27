<?php
if(get_the_content() !== '' || ( qode_listing_is_elementor_installed() && \Elementor\Plugin::$instance->preview->is_preview_mode() )){?>
	<div class="qode-ls-content-part-holder clearfix">

		<div class="qode-ls-content-part left">
			<h6 class="qode-ls-content-part-title">
				<?php esc_html_e('The property','qode-listing'); ?>
			</h6>
		</div>

		<div class="qode-ls-content-part right">
			<?php the_content(); ?>
		</div>

	</div>
<?php }