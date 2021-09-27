<?php if($query_results->max_num_pages>1){ ?>
	<div class="qode-events-list-paging">
		<span class="qode-events-list-load-more">
			<?php 
				echo bridge_core_get_button_html(array(
					'link' => 'javascript: void(0)',
					'text' => $load_more_label != '' ? $load_more_label : esc_html__('Load More','qode-music') ,
                    'type' => 'solid'
				));
			?>
		</span>
		<div class="qode-stripes">
			<div class="qode-rect1"></div>
			<div class="qode-rect2"></div>
			<div class="qode-rect3"></div>
			<div class="qode-rect4"></div>
			<div class="qode-rect5"></div>
		</div>
	</div>
<?php }