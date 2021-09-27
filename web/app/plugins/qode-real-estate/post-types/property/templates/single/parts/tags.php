<?php
$tags = qodef_re_get_property_taxonomy('property-tag');
?>
<div class="qodef-property-tags qodef-property-label-items-holder">
    <div class="qodef-property-tags-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Property Tags', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-tags-items qodef-property-items-style clearfix">
        <?php foreach($tags as $tag) { ?>
              <div class="qodef-tag-item">
                  <a href="<?php echo get_term_link($tag->term_id); ?>" target="_self">
                    <?php echo esc_html($tag->name); ?>
                  </a>
              </div>
        <?php } ?>
    </div>
</div>