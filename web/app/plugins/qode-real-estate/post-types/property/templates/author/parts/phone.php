<?php
$user_phone = get_user_meta($author->ID, 'qodef_' . $role . '_mobile_phone', true);
?>
<?php if( !empty($user_phone) ) { ?>
<div class="qodef-re-author-contact-section">
    <div class="qodef-re-contact-item">
        <span class="qodef-contact-label">
            <?php esc_html_e('Phone number:', 'qode-real-estate') ?>
        </span>
        <a class="qodef-contact-value" href="tel:<?php echo esc_attr($user_phone);?>" target="_self">
            <?php echo esc_html($user_phone) ?>
        </a>
    </div>
</div>
<?php } ?>