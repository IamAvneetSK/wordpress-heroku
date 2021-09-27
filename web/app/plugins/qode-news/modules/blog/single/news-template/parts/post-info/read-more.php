<?php if ( ! bridge_qode_post_has_read_more() ) { ?>
	<div class="qode-post-read-more-button">
		<?php
		if ( qode_core_plugin_installed() ) {
			echo bridge_core_get_button_html(
				apply_filters(
					'qode_blog_template_read_more_button',
					array(
						'type'         => 'simple',
						'size'         => 'medium',
						'link'         => get_the_permalink(),
						'text'         => esc_html__( 'READ MORE', 'qode-news' ),
						'custom_class' => 'qode-blog-list-button'
					)
				)
			);
		} else { ?>
			<a itemprop="url" href="<?php echo esc_attr( get_the_permalink() ); ?>" target="_self" class="qode-btn qode-btn-medium qode-btn-simple qode-blog-list-button">
                <span class="qode-btn-text"><?php echo esc_html__( 'READ MORE', 'qode-news' ); ?></span>
			</a>
		<?php } ?>
	</div>
<?php } ?>