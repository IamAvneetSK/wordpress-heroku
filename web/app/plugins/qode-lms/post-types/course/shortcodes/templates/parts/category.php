<?php if ( $enable_category === 'yes' ) {
	$categories = wp_get_post_terms( get_the_ID(), 'course-category' );
	
	if ( ! empty( $categories ) ) { ?>
		<div class="qode-cli-category-holder">
			<span aria-hidden="true" class="qode-category-icon"></span>
			<?php foreach ( $categories as $cat ) {
                $additional_class = '';
                $style = '';
                $cat_meta_color = get_term_meta($cat->term_id,'course_category_color',true);
                if( !empty($cat_meta_color) ){
                    $additional_class = 'qode-cli-category-with-color';
                    $style = 'style="background-color: ' . $cat_meta_color . '"';
                }
            ?>
				<a itemprop="url" class="qode-cli-category <?php echo esc_attr($additional_class);?>" href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>" <?php echo wp_kses_post($style); ?>><?php echo esc_html( $cat->name ); ?></a>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>