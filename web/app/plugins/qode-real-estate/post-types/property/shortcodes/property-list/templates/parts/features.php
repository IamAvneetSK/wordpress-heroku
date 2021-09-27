<?php

$features_meta = get_post_meta(get_the_ID(), 'qodef_property_list_features_meta', true);

if(is_array($features_meta) && count($features_meta)) { ?>
    <div class="qodef-pl-features-holder">
        <?php foreach ( $features_meta as $feature ) { ?>
            <div class="qodef-pl-feature-item">
                <div class="qodef-pl-feature-image">
                    <img src="<?php echo esc_html( $feature['image'] ); ?>" alt="<?php echo esc_html__('feature image', 'qode-real-estate')?>"/>
                </div>
                <div class="qodef-pl-feature-value">
                    <?php echo wp_kses( $feature['value'], array( 'sup' => array() ) ); ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
