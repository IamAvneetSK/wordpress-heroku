<?php
$user_address = get_user_meta($author->ID, 'qodef_' . $role . '_address', true);
$user_phone = get_user_meta($author->ID, 'qodef_' . $role . '_mobile_phone', true);
$user_email = get_the_author_meta('email', $author->ID);
$user_website = get_the_author_meta('url', $author->ID);
?>
<div class="qodef-re-author-contact">
    <?php if( !empty($user_address) ) { ?>
        <div class="qodef-re-contact-item">
            <span class="qodef-contact-icon icon-location-pin"></span>
            <span class="qodef-contact-label">
                <?php echo esc_html($user_address) ?>
            </span>
        </div>
    <?php } ?>
    <?php if( !empty($user_phone) ) { ?>
        <div class="qodef-re-contact-item">
            <span class="qodef-contact-icon icon-call-end"></span>
            <span class="qodef-contact-label">
                <a href="tel:<?php echo esc_attr($user_phone) ?>" target="_self">
                    <?php echo esc_html($user_phone) ?>
                </a>
            </span>
        </div>
    <?php } ?>
    <?php if( !empty($user_email) ) { ?>
        <div class="qodef-re-contact-item">
            <span class="qodef-contact-icon icon-envelope"></span>
            <span class="qodef-contact-label">
                <a href="mailto:<?php echo esc_attr($user_email) ?>" target="_self">
                    <?php echo esc_html($user_email) ?>
                </a>
            </span>
        </div>
    <?php } ?>
    <?php if( !empty($user_website) ) { ?>
        <div class="qodef-re-contact-item">
            <span class="qodef-contact-icon icon-link"></span>
            <span class="qodef-contact-label">
                <a href="<?php echo esc_url($user_website) ?>" target="_blank">
                    <?php echo esc_html($user_website) ?>
                </a>
            </span>
        </div>
    <?php } ?>
</div>