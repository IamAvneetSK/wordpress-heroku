<article class="qodef-pl-item <?php echo esc_attr( $this_object->getArticleClasses( $params ) ); ?>" id="<?php echo esc_attr(get_the_ID()); ?>">
    <div class="qodef-pl-item-inner">
        <?php echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-list', 'layout-collections/' . $item_layout, '', $params ); ?>
        <a itemprop="url" class="qodef-pli-link qodef-block-drag-link" href="<?php echo get_permalink(); ?>" target="_self"></a>
    </div>
</article>