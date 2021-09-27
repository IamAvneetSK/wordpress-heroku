<?php
$share_type = isset($share_type) ? $share_type : 'dropdown';

$display_share = isset($display_share) && $display_share !== '' ? $display_share : 'yes';

?>
<?php if($display_share == 'yes' && bridge_qode_options()->getOptionValue('enable_social_share') === 'yes' && bridge_qode_options()->getOptionValue('post_types_names_post') === 'post') { ?>
    <div class="qode-blog-share">
        <?php echo bridge_qode_execute_shortcode('social_share', array('show_share_icon' => 'yes', 'social_share_icon_pack' => 'font_elegant', 'show_share_text' => 'no')); ?>
    </div>
<?php } ?>