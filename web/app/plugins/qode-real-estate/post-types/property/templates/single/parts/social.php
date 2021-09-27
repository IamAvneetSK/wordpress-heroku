<?php
$share_type = isset($share_type) ? $share_type : 'dropdown';
?>

<?php if(qodef_re_qodef_core_plugin_installed() && bridge_qode_options()->getOptionValue('enable_social_share') == 'yes' && bridge_qode_options()->getOptionValue('post_types_names_property') == 'property') : ?>
    <div class="qodef-property-social-share">
        <?php echo bridge_core_get_social_share_html(array('show_share_icon' => 'yes')) ?>
    </div>
<?php endif; ?>