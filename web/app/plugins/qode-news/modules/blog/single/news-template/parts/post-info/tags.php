<?php
$tags = get_the_tags();
?>
<?php if($tags) { ?>
<div class="qode-tags-holder">
    <div class="qode-tags">
        <?php the_tags('<h5 class="qode-tags-title">'.esc_html__('Tags:','qode-news').'</h5>', '', ''); ?>
    </div>
</div>
<?php } ?>