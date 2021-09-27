<?php
$query_args = array(
    'role' => 'agent',
    'meta_key' => 'qodef_belonging_agency',
    'meta_value' => $author->ID
);

$user_query = get_users($query_args);
if (is_array($user_query) && count($user_query)) {
?>
<div class="qodef-re-author-footer qodef-author-agents">
    <h5>
        <?php esc_html_e("Agent List:", 'qode-real-estate') ?>
    </h5>
    <?php foreach ($user_query as $user) { ?>
        <a href="<?php echo get_author_posts_url($user->ID); ?>" target="_self">
	        <?php echo qodef_re_get_author_image($user->ID, $user->roles, 'thumbnail', '37'); ?>
        </a>
    <?php } ?>
</div>
<?php } ?>