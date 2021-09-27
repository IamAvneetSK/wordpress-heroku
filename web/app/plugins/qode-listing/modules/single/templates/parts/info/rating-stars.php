<?php
$html = $article_obj->getListingAverageRating();
$number = $article_obj->getListingAverageRatingNumber();
if($html !== ''){ ?>
	<div itemprop="ratingStars" class="qode-ls-header-info rating-stars  entry-rating-stars published updated">
		<?php
			comments_number( __('No Review','qode-listing'), '1'.__('Review','qode-listing'), '% '.__('Reviews','qode-listing'));
			echo wp_kses_post($html);
		?>
	</div>
<?php }