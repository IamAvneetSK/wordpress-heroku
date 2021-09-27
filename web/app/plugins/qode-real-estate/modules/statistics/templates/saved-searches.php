<div class="qodef-re-admin-saved-searches">
    <h1 class="wp-heading-inline"><?php esc_html_e('Users saved searches', 'qode-real-estate') ?></h1>
    <table class="qodef-re-saved-searches wp-list-table widefat fixed striped posts">
        <thead>
        <tr>
            <td><?php esc_html_e('Status', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Type', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('City', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Price', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Size', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Bedrooms', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Bathrooms', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Features', 'qode-real-estate') ?></td>
            <td><?php esc_html_e('Actions', 'qode-real-estate') ?></td>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($searches)) { ?>
            <?php foreach($searches as $search) { ?>
                <tr>
                    <td>
                        <?php
                        if(!empty($search['status'])) {
                            echo esc_html(qodef_re_get_taxonomy_name_from_id($search['status']));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(!empty($search['type'])) {
                            echo esc_html(qodef_re_get_taxonomy_name_from_id($search['type']));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(!empty($search['city'])) {
                            echo esc_html(qodef_re_get_taxonomy_name_from_id($search['city']));
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo esc_html($search['minPrice']) . ' - ' .esc_html($search['maxPrice']); ?>
                    </td>
                    <td>
                        <?php echo esc_html($search['minSize']) . ' - ' .esc_html($search['maxSize']); ?>
                    </td>
                    <td>
                        <?php echo esc_html($search['bedrooms']); ?>
                    </td>
                    <td>
                        <?php echo esc_html($search['bathrooms']); ?>
                    </td>
                    <td>
                        <?php
                        if(!empty($search['features'])) {
                            $features = explode(',', $search['features']);
                            $feature_names = array();
                            foreach ($features as $feature) {
                                $feature_names[] = qodef_re_get_taxonomy_name_from_id($feature);
                            }
                            $feature_names = implode(', ', $feature_names);
                            echo esc_html($feature_names);
                        }
                        ?>
                    </td>
                    <td>
                        <form role="search" method="get" target="_blank" class="searchform qodef-property-search" action="<?php echo esc_url( home_url( "/" ) ) ?>">
                            <input type="hidden" name="s" value="" />
                            <input type="hidden" name="qodef-property-search" value="yes" />
                            <input type="hidden" name="qodef-search-city" id="qodef-search-city" value="<?php echo esc_attr($search['city']); ?>"/>
                            <input type="hidden" name="qodef-search-status" id="qodef-search-status" value="<?php echo esc_attr($search['status']); ?>"/>
                            <input type="hidden" name="qodef-search-type" id="qodef-search-type" value="<?php echo esc_attr($search['type']); ?>"/>
                            <input type="hidden" name="qodef-search-minPrice" id="qodef-search-minPrice" value="<?php echo esc_attr($search['minPrice']); ?>"/>
                            <input type="hidden" name="qodef-search-maxPrice" id="qodef-search-maxPrice" value="<?php echo esc_attr($search['maxPrice']); ?>"/>
                            <input type="hidden" name="qodef-search-minSize" id="qodef-search-minSize" value="<?php echo esc_attr($search['minSize']); ?>"/>
                            <input type="hidden" name="qodef-search-maxSize" id="qodef-search-maxSize" value="<?php echo esc_attr($search['maxSize']); ?>"/>
                            <input type="hidden" name="qodef-search-bedrooms" id="qodef-search-bedrooms" value="<?php echo esc_attr($search['bedrooms']); ?>"/>
                            <input type="hidden" name="qodef-search-bathrooms" id="qodef-search-bathrooms" value="<?php echo esc_attr($search['bathrooms']); ?>"/>
                            <input type="hidden" name="qodef-search-features" id="qodef-search-features" value="<?php echo esc_attr($search['features']); ?>"/>
                            <button class="qodef-query-search-page" title="<?php esc_attr_e('View', 'qode-real-estate'); ?>">
                                <i class="dashicons-before dashicons-admin-links"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>