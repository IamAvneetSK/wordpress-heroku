<?php if($query_results->max_num_pages>1){ ?>
	<div class="qode-albums-list-paging">
		<span class="qode-albums-list-load-more">
			<?php 
				echo bridge_core_get_button_html(array(
					'link' => 'javascript: void(0)',
					'text' => $load_more_label != '' ? $load_more_label : esc_html__('Show more', 'qode-music')
				));
			?>
		</span>
	</div>
<?php }