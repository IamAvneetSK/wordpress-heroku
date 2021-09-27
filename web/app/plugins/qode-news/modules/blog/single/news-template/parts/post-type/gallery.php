<?php
$post_content = get_the_content();
preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
$array_id = explode(",", $ids[1]);

$gallery_post_layout = bridge_qode_check_gallery_post_layout(get_the_ID());
?>

<div class="qode-post-image">
    <?php switch ($gallery_post_layout) {
        case 'slider':
            ?>
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    foreach ($array_id as $img_id) { ?>
                        <li><a itemprop="url"
                               href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image($img_id, 'full'); ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php break;
        case 'masonry':
            echo bridge_qode_get_blog_gallery_layout($array_id);
            break;
    } ?>
</div>

