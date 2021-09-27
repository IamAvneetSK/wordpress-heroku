<?php
$user_address = get_user_meta($author->ID, 'qodef_' . $role . '_address', true);
$maps_url = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($user_address);
?>
<?php if( !empty($user_address) ) { ?>
<div class="qodef-re-author-contact-section">
    <div class="qodef-re-contact-item">
        <span class="qodef-contact-label">
            <?php esc_html_e('Location:', 'qode-real-estate') ?>
        </span>
        <a class="qodef-contact-value" href="<?php echo esc_url($maps_url); ?>" target="_blank">
            <?php echo esc_html($user_address); ?>
        </a>
    </div>
</div>
<?php } ?>