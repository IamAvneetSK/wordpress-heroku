<?php
$has_audio_link = get_post_meta(get_the_ID(), "audio_link", true) !== '';
?>
<?php if($has_audio_link) { ?>
    <div class="qode-news-audio-holder">
        <audio class="qode-news-audio" src="<?php echo esc_url(get_post_meta(get_the_ID(), "audio_link", true)) ?>" controls="controls">
            <?php esc_html_e("Your browser don't support audio player", "qode-news"); ?>
        </audio>
    </div>
<?php } ?>