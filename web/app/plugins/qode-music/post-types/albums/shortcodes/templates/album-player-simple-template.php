<div class="qode-audio-player-wrapper <?php echo esc_attr($player_classes) ?>" >
    <div id= "qode-player-<?php echo esc_attr($player_id); ?>" class="jp-jplayer"></div>
    <?php if ($full_width_bg == 'yes'): ?>
        <div class="container_inner">
    <?php endif; ?>
    <div id= "qode-player-container-<?php echo esc_attr($player_id); ?>" class="qode-audio-player-holder qode-audio-player-simple " data-album-id="<?php echo esc_attr($album); ?>" <?php qode_music_inline_style($player_styles); ?>>
        <div class = "qode-audio-player-main-holder">
            <div class="qode-audio-player-controls-holder">
                <div class="jp-audio player-box">
                    <div class="jp-gui jp-interface">
                        <ul class="jp-controls">
                            <li <?php qode_music_inline_style($nav_buttons_styles); ?>><a class="jp-previous" href="#"><i class="fa fa-fast-backward"></i></a></li><!--
							--><li <?php qode_music_inline_style($play_button_styles); ?>><a class="jp-play" href="#"><i class="fa fa-play qode-play-button"></i><i class="fa fa-pause qode-pause-button"></i></a></li><!--
							--><li <?php qode_music_inline_style($nav_buttons_styles); ?>><a class="jp-next" href="#"><i class="fa fa-fast-forward"></i></a></li>
                        </ul>
                    </div>
                    <div class="jp-type-playlist">
                        <div class="jp-playlist">
                            <ul class="tracks-list">
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="qode-audio-player-details-holder">
                <div class= "qode-audio-player-details">
                    <h4 class="qode-audio-player-title"></h4>
                    <div class="qode-audio-player-time">
                        <div class="jp-audio player-box">
                            <div class="jp-gui jp-interface">
                                <p class="time-box">
                                    <span class="jp-current-time"></span>/<span class="jp-duration"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>