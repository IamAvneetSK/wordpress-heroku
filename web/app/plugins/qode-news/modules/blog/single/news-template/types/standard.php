<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="qode-post-content">
        <div class="qode-post-heading">
            <?php echo qode_news_get_blog_part($blog_single_type.'/parts/image','single', '', $params); ?>
        </div>
        <div class="qode-post-text">
            <div class="qode-post-text-inner">
                <div class="qode-post-info-top">
					<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/category','single', '', $params); ?>
                </div>
                <div class="qode-post-text-main">
					<?php echo qode_news_get_blog_part($blog_single_type.'/parts/title','single', '', $params); ?>
                    <div class="qode-post-info-after-title">
						<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/date','single', '', $params); ?>
						<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/author','single', '', $params); ?>
						<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/comments','single', '', $params); ?>
                        <?php do_action('qode_action_blog_single_after_title_info'); ?>
                    </div>
                    <?php the_content(); ?>
                    <?php do_action('qode_single_link_pages'); ?>
                </div>
                <div class="qode-post-info-bottom clearfix">
                    <div class="qode-post-info-bottom-left">
						<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/share','single', '', $params); ?>
                    </div>
                    <div class="qode-post-info-bottom-right">
						<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/like','single', '', $params); ?>
                    </div>
                </div>
                <div class="qode-post-info-below">
					<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/tags','single', '', $params); ?>
                </div>
            </div>
        </div>
    </div>
</article>