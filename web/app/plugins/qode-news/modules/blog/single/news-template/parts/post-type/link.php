<?php
$title_tag = isset($link_tag) ? $link_tag : 'h2';
$post_link_meta = get_post_meta(get_the_ID(), "title_link", true );

if(!empty($post_link_meta)) {
    $post_link = esc_html($post_link_meta);
}

?>

<div class="qode-post-link-holder">
    <div class="qode-post-link-holder-inner">
        <<?php echo esc_attr($title_tag);?> itemprop="name" class="qode-link-title qode-post-title">
        <?php if(isset($post_link) && $post_link != '') { ?>
        <a itemprop="url" href="<?php echo esc_url($post_link); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
            <?php } ?>
            <?php echo get_the_title(); ?>
            <?php if(isset($post_link) && $post_link != '') { ?>
        </a>
        <?php } ?>
        </<?php echo esc_attr($title_tag);?>>
    </div>
</div>