<?php if($query_result->max_num_pages > 1) { ?>
    <div class="qode-news-pag-loading">
        <div class="qode-news-pag-bounce1"></div>
        <div class="qode-news-pag-bounce2"></div>
        <div class="qode-news-pag-bounce3"></div>
    </div>
    <div class="qode-news-load-more-pagination">
        <?php
            echo bridge_core_get_button_v2_html(
                apply_filters(
                    'qode_news_shortcodes_load_more',
                    array(
                        'link' => 'javascript: void(0)',
                        'size' => 'large',
                        'text' => esc_html__('Load more', 'qode-news')
                    )
                )
            );
        ?>
    </div>
<?php }