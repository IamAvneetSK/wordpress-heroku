<?php
$blog_hide_comments = esc_attr(bridge_qode_options()->getOptionValue('blog_hide_comments'));

if($blog_hide_comments !== 'yes'){
    comments_template('', true);
}