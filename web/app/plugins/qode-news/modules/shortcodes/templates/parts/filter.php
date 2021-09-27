<div class="qode-news-filter" data-filter-by="<?php echo esc_attr($filter_by);?>">
	<?php
		foreach ($filter_array as $filter) { ?>
			<a href="" itemprop="url" class="qode-news-filter-item" data-filter="<?php echo esc_attr($filter['slug']);?>"><?php echo esc_html($filter['name']);?></a>
		<?php }
	?>
</div>
<div class="qode-news-filter-loading">
	<div class="qode-news-filter-loading-table">
		<div class="qode-news-filter-loading-table-cell">
			<div class="qode-news-pag-bounce1"></div>
			<div class="qode-news-pag-bounce2"></div>
			<div class="qode-news-pag-bounce3"></div>
		</div>
	</div>
</div>