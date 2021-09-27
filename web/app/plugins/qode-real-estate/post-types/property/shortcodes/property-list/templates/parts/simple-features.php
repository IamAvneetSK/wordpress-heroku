<?php

$beds = get_post_meta(get_the_ID(), 'qodef_property_bedrooms_meta', true);
$baths = get_post_meta(get_the_ID(), 'qodef_property_bathrooms_meta', true);
$size = get_post_meta(get_the_ID(), 'qodef_property_size_meta', true);

if( ! empty( $beds ) || ! empty( $baths ) || ! empty( $size ) ){ ?>
    <div class="qodef-property-list-simple-features">
        <?php if( ! empty( $beds ) ) { ?>
            <span class="qodef-simple-feature-item">
                <?php echo qode_re_singular_plural_words( $beds, esc_html__('beds', 'qode-real-estate'), esc_html__('bed', 'qode-real-estate'), esc_html__('beds', 'qode-real-estate') ); ?>
            </span>
        <?php } ?>

        <?php if( ! empty( $baths ) ) { ?>
            <span class="qodef-simple-feature-item">
                <?php echo qode_re_singular_plural_words( $baths, esc_html__('baths', 'qode-real-estate'), esc_html__('bath', 'qode-real-estate'), esc_html__('baths', 'qode-real-estate') ); ?>
            </span>
        <?php } ?>


        <?php if( ! empty( $size ) ) { ?>
            <span class="qodef-simple-feature-item">
                <?php echo esc_html( $size ); ?>
            </span>
        <?php } ?>
    </div>
<?php }