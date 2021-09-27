<div class="qode-atrist-single">
    <div class="qode-atrist-image-holder">
        <a href="<?php echo esc_url(get_term_meta ($artist->term_id, 'artist_link', true )); ?>">
            <img class="qode-atrist-image" src="<?php echo wp_get_attachment_url(get_term_meta($artist->term_id, 'artist_image', true )); ?>" alt="<?php esc_attr($artist->name);?>" />
        </a>
    </div>
    <span class="qode-number"><?php echo esc_html($counter); ?><span class="qode-number-total"><?php echo esc_html($number_of_artists); ?></span></span>
    <h3 class="qode-stage"><a href="<?php echo esc_url(get_term_meta ($artist->term_id, 'artist_link', true )); ?>">
            <?php echo esc_attr(get_term_meta ($artist->term_id, 'artist_stage', true )); ?>
    </a></h3>
    <h2 class="qode-name"><a href="<?php echo esc_url(get_term_meta ($artist->term_id, 'artist_link', true )); ?>">
        <?php echo esc_attr($artist->name); ?>
    </a></h2>
</div>