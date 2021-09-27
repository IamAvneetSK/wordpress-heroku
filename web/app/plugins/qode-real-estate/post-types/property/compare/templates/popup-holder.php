<div class="qodef-re-compare-popup">
    <div class="qodef-re-popup-outer">
        <a class="qodef-re-compare-popup-close" href="javascript:void(0)">
            <i class="icon_close"></i>
        </a>
        <div class="qodef-re-popup-inner">
            <div class="qodef-re-popup-items-holder">
                <?php if(isset($added_properties) && !empty($added_properties)) { ?>
                    <?php echo qodef_re_get_compare_list_items_structured($added_properties); ?>
                <?php } else {
                    echo qodef_re_cpt_single_module_template_part( 'compare/templates/parts/posts-not-found', 'property' );
                } ?>
            </div>
        </div>
    </div>
</div>