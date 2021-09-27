<?php
$genres   = wp_get_post_terms(get_the_ID(), 'album-genre');
$genre_names = array();

if(is_array($genres) && count($genres)) :
	foreach($genres as $genre) {
		$genre_names[] = $genre->name;
	}

	?>
	<div class="qode-album-details qode-album-genres">
		<span><?php 
            if (count($genres) > 1) { 
                esc_html_e('Genres:', 'qode-music');
            } else {
                esc_html_e('Genre:', 'qode-music');
            } ?>
        </span>
		<span>
			<?php echo esc_html(implode(', ', $genre_names)); ?>
		</span>
	</div>
<?php endif; ?>