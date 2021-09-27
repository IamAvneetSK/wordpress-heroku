<?php
$tags = get_the_tags();
?>
<?php if($tags) { ?>
<div class="qode-tags-holder">
    <div class="qode-tags">
        <?php the_tags('', ', ', ''); ?>
    </div>
</div>
<?php } ?>