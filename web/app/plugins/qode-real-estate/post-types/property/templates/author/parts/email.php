<?php
$user_email = get_the_author_meta('email', $author->ID);
?>
<?php if( !empty($user_email) ) { ?>
<div class="qodef-re-author-contact-section">
    <div class="qodef-re-contact-item">
        <span class="qodef-contact-label">
            <?php esc_html_e('Email:', 'qode-real-estate') ?>
        </span>
        <a class="qodef-contact-value" href="mailto:<?php echo esc_attr($user_email) ?>" target="_self">
            <?php echo esc_html($user_email) ?>
        </a>
    </div>
</div>
<?php } ?>