<h2 class="qodef-membership-page-title"><?php esc_html_e('My Packages', 'qode-real-estate'); ?></h2>
<p><?php esc_html_e('My packages', 'qode-real-estate'); ?></p>

<div class="qodef-re-profile-packages-holder">
    <table>
        <thead>
            <tr>
                <td><?php esc_html_e('Package Name', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Expiration Date', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Items Included', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Items Remaining', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Featured Included', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Featured Remaining', 'qode-real-estate') ?></td>
                <td><?php esc_html_e('Status', 'qode-real-estate') ?></td>
            </tr>
        </thead>
        <tbody>
            <?php if ( ! empty( $user_packages ) ) { ?>
                <?php foreach($user_packages as $key => $package) { ?>
                    <?php $package_info = qodef_re_get_package_info($package);?>
                    <tr>
                        <td>
                            <?php echo esc_html($package_info['package_name']); ?>
                        </td>
                        <td>
                            <?php echo esc_html(gmdate( 'd/m/Y', $package_info['expiration_date'])); ?>
                        </td>
                        <td>
                            <?php echo esc_html($package_info['items_included']); ?>
                        </td>
                        <td>
                            <?php echo esc_html($package_info['items_remaining']); ?>
                        </td>
                        <td>
                            <?php echo esc_html($package_info['featured_items_included']); ?>
                        </td>
                        <td>
                            <?php echo esc_html($package_info['featured_items_remaining']); ?>
                        </td>
                        <td>
                            <?php echo qodef_re_get_package_status($package); ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <?php
        if ( qode_membership_theme_installed() ) {
            echo bridge_core_get_button_v2_html( array(
                'text'      => esc_html__( 'Buy Package', 'qode-real-estate' ),
                'custom_class' => 'qodef-membership-buy-package',
                'link' => $package_url
            ) );
        } else {
            echo '<a itemprop="url" href="' . $package_url . '" target="_self" class="qodef-btn qodef-btn-medium qodef-btn-solid qodef-membership-buy-package"><span class="qodef-btn-text">' . esc_html__( 'Buy Package', 'qode-real-estate' ) . '</span></a>';
        }
    ?>
</div>
