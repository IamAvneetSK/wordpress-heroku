<?php
	$tracks = get_post_meta(get_the_ID(), 'qode_album_tracks', true);
	$i = 0;
	if( ! empty( $tracks ) ) { ?>
    <div class="qode-album-tracks-holder ">
        <h3 class="qode-tracks-holder-title"><?php esc_html_e('Tracklist', 'qode-music'); ?></h3>
        <div class="qode-tracks-holder">
        <?php
            foreach ($tracks as $track) : ?>
                <div class="qode-track-holder qode-unique-track-<?php echo esc_attr(get_the_ID()); ?>-<?php echo esc_attr(qode_music_get_attachment_id_from_url($track['qode_album_track_file'])); ?>">
                    <?php if ($track['qode_album_track_title'] != ''): ?>
                        <h4 class="qode-track-title" data-track-index="<?php echo esc_attr($i); ?>">
                        <span class="qode-track-number">
                            <?php echo esc_attr($i + 1) . '. ' ?>
                        </span>
                        <i class="fa fa-play" aria-hidden="true"></i>
                            <?php echo esc_attr($track['qode_album_track_title']) ?></h4>
                    <?php endif; ?>
                    <?php if (($track['qode_album_track_buy_link'] != '') && ($track['qode_album_track_free_download'] != 'yes')) : ?>
                        <h6 class="qode-track-buy">
                            <a href="<?php echo esc_url($track['qode_album_track_buy_link']) ?>">
                                <?php esc_html_e('buy track', 'qode-music'); ?>
                            </a>
                        </h6>
                    <?php elseif ($track['qode_album_track_free_download'] == 'yes') : ?>
                        <h6 class="qode-track-buy">
                            <a href="<?php echo esc_url($track['qode_album_track_file']) ?>" download="<?php echo strtolower(str_replace(' ', '-', $track['qode_album_track_title'])) . '.mp3'; ?>">
                                <?php esc_html_e('download', 'qode-music'); ?>
                            </a>
                        </h6>
                    <?php endif; ?>
                </div>
            <?php $i++; endforeach;
        } ?>
        </div>
    </div>