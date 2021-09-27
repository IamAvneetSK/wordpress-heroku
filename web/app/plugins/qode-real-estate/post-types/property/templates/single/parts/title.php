<?php
$date_published = get_post_meta(get_the_ID(), 'qodef_property_publication_date_meta', true);
$number_of_views = get_post_meta(get_the_ID(), 'qodef_count_property_views_meta', true);
$property_id = get_post_meta(get_the_ID(), 'qodef_property_id_meta', true);
$date_formatted = date('d.m.Y', strtotime($date_published));
?>
<div class="container_inner">
    <div class="qodef-property-title-section">
        <div class="qodef-property-title-outer">
            <div class="qodef-property-title-inner">
                <div class="qodef-property-title-left">
                    <div class="qodef-property-title-left-inner">
                        <h3 class="qodef-title-title">
                            <?php echo get_the_title(); ?>
                        </h3>

                        <?php qodef_re_get_cpt_single_module_template_part( 'templates/single/parts/taxonomy', 'property', 'status', $params ); ?>

                        <div class="qodef-title-id">
                            <span class="qodef-property-id-label">
                                <?php esc_html_e('Property ID:', 'qode-real-estate'); ?>
                            </span>
                            <span class="qodef-property-id-value">
                                <?php echo esc_html($property_id); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="qodef-property-title-right">
                    <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/price-info', 'property', '', $params); ?>
                </div>
            </div>
        </div>
        <div class="qodef-property-info-holder">
            <div class="qodef-property-title-info">
                <?php if(!empty($date_published)) { ?>
                    <div class="qodef-title-inline-part">
                        <?php echo esc_html($date_formatted); ?>
                    </div>
                <?php } ?>
                <!--			        --><?php //if(qodef_re_qodef_core_plugin_installed() && qodef_core_post_number_of_ratings() > 0) { ?>
                <!--				        <div class="qodef-title-inline-part">-->
                <!--					        --><?php //echo qodef_re_get_cpt_single_module_template_part( 'templates/single/parts/rating', 'property', 'simple', $params ); ?>
                <!--				        </div>-->
                <!--			        --><?php //} ?>
                <!--			        --><?php //if( is_user_logged_in() ) { ?>
                <!--				        <div class="qodef-title-inline-part">-->
                <!--					        --><?php //qode_membership_get_favorite_template(get_the_ID(), 'icon-with-text'); ?>
                <!--				        </div>-->
                <!--			        --><?php //} ?>
                <?php if(!empty($number_of_views)) { ?>
                    <div class="qodef-title-inline-part">
                        <i class="qodef-views-icon lnr lnr-eye" aria-hidden="true"></i>
                        <span class="qodef-views-value"><?php echo esc_html($number_of_views); ?></span>
                    </div>
                <?php } ?>
                <?php if(qodef_re_qodef_core_plugin_installed() && bridge_qode_options()->getOptionValue('enable_social_share') == 'yes' && bridge_qode_options()->getOptionValue('post_types_names_property') == 'property') { ?>
                    <div class="qodef-title-inline-part">
                        <?php qodef_re_get_cpt_single_module_template_part( 'templates/single/parts/social', 'property', '', $params ); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php qodef_re_get_cpt_single_module_template_part('templates/single/parts/basic-info', 'property', '', $params); ?>
    </div>
</div>
