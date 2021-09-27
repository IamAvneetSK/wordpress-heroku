<div class="qodef-property-reviews">
    <div class="qodef-property-reviews-list-top">
        <?php
        if(qodef_re_qodef_core_plugin_installed()) {
            //echo qodef_core_list_review_details('stars');
        }
        ?>
    </div>
    <div class="qodef-property-reviews-list">
        <?php comments_template('', true); ?>
    </div>
</div>