<?php 

$number_of_pages = $query_result->max_num_pages;
$pagination_numbers_amount = !empty($pagination_numbers_amount)?$pagination_numbers_amount:3;

if($number_of_pages > 1) { ?>
	<div class="qode-news-pag-loading">
		<div class="qode-news-pag-bounce1"></div>
		<div class="qode-news-pag-bounce2"></div>
		<div class="qode-news-pag-bounce3"></div>
	</div>
	<?php
		$current_page = $query_result->query['paged'];
		
		if($number_of_pages > 1){ ?>
			<div class="qode-news-standard-pagination">
				<ul>
					<li class="qode-news-pag-first-page">
						<a href="#" data-paged="1"><span class="arrow_carrot-2left"></span></a>
					</li>
					<li class="qode-news-pag-prev">
						<a href="#" data-paged="1"><span class="icon-arrows-left"></span></a>
					</li>
					<?php for ($i=1; $i <= $number_of_pages; $i++) { ?>
						<?php
							$active_class = '';
							if($current_page == $i) {
								$active_class = 'qode-news-pag-active';
							}
						?>
						<?php if ($i <= $pagination_numbers_amount){ ?>
							<li class="qode-news-pag-number <?php echo esc_attr($active_class); ?>">
								<a href="#" data-paged="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></a>
							</li>
						<?php } 
						else {
							break;
						}?>
					<?php } ?>
					<li class="qode-news-pag-next">
						<a href="#" data-paged="2"><span class="icon-arrows-right"></span></a>
					</li>
					<li class="qode-news-pag-last-page">
						<a href="#" data-paged="<?php echo $number_of_pages; ?>"><span class="arrow_carrot-2right"></span></a>
					</li>
				</ul>
			</div>
		<?php }
	?>
<?php }