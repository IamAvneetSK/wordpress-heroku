<?php
$package_custom_features = get_post_meta( get_the_ID(), 'qodef_package_custom_features_meta', true);
?>
<div class="qodef-package-title-holder">
    <h5 class="qodef-package-title"><?php the_title(); ?></h5>
    <?php if($params['featured'] === 'yes') {?>
        <span class="qodef-package-featured-icon-holder">
            <i class="qodef-icon-linea-icon icon-weather-lightning"></i>
        </span>
    <?php } ?>
</div>
<div class="qodef-package-content-holder">
	<div class="qodef-package-price">
		<?php
		echo esc_html( $package_values['currency'] );
		echo esc_html( $package_values['price'] );
		?>
	</div>
    <div class="qodef-package-pricing-period">
        <h6>
            <?php echo esc_html__('Monthly', 'qode-real-estate'); ?>
        </h6>
    </div>
	<div class="qodef-package-content">
		<div class="qodef-package-listings">
		    <span class="qodef-listings-label">
		        <?php esc_html_e( 'Listings Included:', 'qode-real-estate' ); ?>
		    </span>
			<span class="qodef-listings-value">
		        <?php echo esc_html( $package_values['listings_inluded'] ); ?>
		    </span>
		</div>
		<div class="qodef-package-featured">
		    <span class="qodef-featured-label">
		        <?php esc_html_e( 'Featured Included:', 'qode-real-estate' ); ?>
		    </span>
			<span class="qodef-featured-value">
		        <?php echo esc_html( $package_values['featured_inluded'] ); ?>
		    </span>
		</div>
		<div class="qodef-package-duration">
		    <span class="qodef-duration-label">
		        <?php esc_html_e( 'Duration (months):', 'qode-real-estate' ); ?>
		    </span>
			<span class="qodef-duration-value">
		        <?php echo esc_html( $package_values['duration'] ); ?>
		    </span>
		</div>
        <?php if( is_array( $package_custom_features ) && count( $package_custom_features ) > 0 ) {
            foreach ( $package_custom_features as $custom_feature ) {
                if( ! empty( $custom_feature['custom_feature_label'] ) ) { ?>
                    <div class="qodef-package-custom-feature">
                        <span class="qodef-custom-feature-label">
                            <?php echo esc_html( $custom_feature['custom_feature_label'] ) ?>
                        </span>
                    </div>
                <?php } ?>
            <?php }
        } ?>
	</div>
	<div class="qodef-package-action">
		<?php qodef_re_get_package_buy_form(); ?>
	</div>
</div>