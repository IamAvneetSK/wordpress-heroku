<?php if ( $query_results->max_num_pages > 1 ) { ?>
    <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'pagination/loading-element' ); ?>
	<?php
	$pages = $query_results->max_num_pages;
	$paged = $query_results->query['paged'];
	
	if ( $pages > 1 ) { ?>
		<div class="qodef-pl-standard-pagination">
			<ul>
				<li class="qodef-pl-pag-prev">
					<a href="#" data-paged="1"><span class="icon-arrows-left"></span></a>
				</li>
				<?php for ( $i = 1; $i <= $pages; $i ++ ) { ?>
					<?php
					$active_class = '';
					if ( $paged == $i ) {
						$active_class = 'qodef-pl-pag-active';
					}
					?>
					<li class="qodef-pl-pag-number <?php echo esc_attr( $active_class ); ?>">
						<a href="#" data-paged="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
					</li>
				<?php } ?>
				<li class="qodef-pl-pag-next">
					<a href="#" data-paged="2"><span class="icon-arrows-right"></span></a>
				</li>
			</ul>
		</div>
	<?php }
	?>
<?php }