<div class="qode-post-read-more-button">
<?php
    echo bridge_core_get_button_v2_html(
        apply_filters(
            'qode_themename_filter_blog_template_read_more_button',
            array(
                'type' => 'simple',
                'size' => 'medium',
                'link' => get_the_permalink(),
                'text' => esc_html__('Read more', 'qode-news'),
                'custom_class' => 'qode-blog-list-button'
            )
        )
    );
    ?>
</div>
