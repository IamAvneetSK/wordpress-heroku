<div class = "qode-news-single-news-template qode-news-holder">
<?php
	qode_news_blog_get_single_post_format_html($blog_single_type);
	do_action('qode_news_after_article_content');
    echo qode_news_get_blog_part($blog_single_type.'/parts/single/single-navigation','single');
	echo qode_news_get_blog_part($blog_single_type.'/parts/single/author-info','single');
	echo qode_news_get_blog_part($blog_single_type.'/parts/single/comments','single');
?>
</div>
