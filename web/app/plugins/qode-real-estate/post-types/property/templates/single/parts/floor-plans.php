<?php

$home_plan_meta = get_post_meta(get_the_ID(), 'qodef_home_plans_meta', true);

if(is_array($home_plan_meta) && count($home_plan_meta)) {
?>
<div class="qodef-property-floor-plans qodef-property-label-items-holder">
    <div class="qodef-property-floor-plans-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Floor Plans', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-floor-plans-accordion-holder">
        <div class="qode-accordion-holder clearfix qode-accordion qodef-property-accordion">
            <?php foreach($home_plan_meta as $home_plan) { ?>
                <h4 class="clearfix qode-title-holder">
                <span class="qode-accordion-mark">
                    <span class="qode-accordion-mark-icon">
                        <span class="icon_plus"></span>
                        <span class="icon_minus-06"></span>
                    </span>
                </span>
                    <span class="qodef-accordion-title-content">
                    <span class="qodef-accordion-title-value">
                        <?php echo esc_html($home_plan['title']); ?>
                    </span>
                    <span class="qodef-accordion-title-info">
                        <span class="qodef-accordion-title-item qodef-accordion-title-size">
                            <span class="qodef-accordion-size-label">
                                <?php esc_html_e('size:', 'qode-real-estate'); ?>
                            </span>
                            <span class="qodef-accordion-size-value">
                                <?php echo esc_html($home_plan['size']); ?>
                            </span>
                        </span>
                        <span class="qodef-accordion-title-item qodef-accordion-title-rooms">
                            <span class="qodef-accordion-room-label">
                                <?php esc_html_e('rooms:', 'qode-real-estate'); ?>
                            </span>
                            <span class="qodef-accordion-room-value">
                                <?php echo esc_html($home_plan['bedrooms']); ?>
                            </span>
                        </span>
                        <span class="qodef-accordion-title-item qodef-accordion-title-baths">
                            <span class="qodef-accordion-bath-label">
                                <?php esc_html_e('baths:', 'qode-real-estate'); ?>
                            </span>
                            <span class="qodef-accordion-bath-value">
                                <?php echo esc_html($home_plan['bathrooms']); ?>
                            </span>
                        </span>
                    </span>
                </span>
                </h4>
                <div class="qode-accordion-content">
                    <div class="qodef-accordion-content-inner">
                        <div class="qodef-accordion-description">
                            <?php echo esc_html($home_plan['description']); ?>
                        </div>
                        <div class="qodef-accordion-image">
                            <img src="<?php echo esc_url($home_plan['image']); ?>" alt="<?php esc_attr_e('Floor plan image', 'qode-real-estate') ?>"/>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>