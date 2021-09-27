<article class="qode-cl-item <?php echo esc_attr( $this_object->getArticleClasses( $params ) ); ?>" <?php echo esc_attr( $this_object->getArticleData( $params ) ); ?>>
	<div class="qode-cl-item-inner">
		<?php echo qode_lms_get_cpt_shortcode_module_template_part( 'course', 'layout-collections/' . $item_layout, '', $params ); ?>
		<a itemprop="url" class="qode-cli-link qode-block-drag-link" href="<?php echo get_permalink(); ?>" target="_self"></a>
	</div>
</article>