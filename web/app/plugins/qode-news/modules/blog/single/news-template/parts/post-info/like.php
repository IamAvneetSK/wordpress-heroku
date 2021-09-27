<?php
$qode_like = bridge_qode_options()->getOptionValue('qode_like');
?>
<?php if($qode_like == 'on'){ ?>
    <div class="qode-blog-like">
        <?php if( function_exists('qode_news_get_like') ) qode_news_get_like(); ?>
    </div>
<?php } ?>