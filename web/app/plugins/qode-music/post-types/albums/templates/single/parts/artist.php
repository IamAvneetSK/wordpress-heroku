<?php
    $artists   = wp_get_post_terms(get_the_ID(), 'qode-album-artist');
    $art_names = array();

    if(is_array($artists) && count($artists)) :
        foreach($artists as $artist) {
            $art_names[] = $artist->name;
        }

?>
	    <div class="qode-album-details qode-album-artists">
            <p>
    	        <span><?php 
                    if (count($artists) > 1) { 
                        esc_html_e('Artists:', 'qode-music');
                    } else {
                        esc_html_e('Artist:', 'qode-music');
                    } ?>
                </span>
    	        <span>
                    <?php echo esc_html(implode(', ', $art_names)); ?>
                </span>
            </p>
	    </div>
    <?php endif; ?>