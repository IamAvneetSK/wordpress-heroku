<div class="qodef-re-admin-most-viewed">
    <h1 class="wp-heading-inline"><?php esc_html_e('Users most viewed', 'qode-real-estate') ?></h1>
    <table class="qodef-re-most-viewed wp-list-table widefat fixed striped posts">
        <thead>
        <tr>
            <td>
                <?php esc_html_e('Property ID', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Title', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Image', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('City', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Status', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Type', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Price', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Views', 'qode-real-estate') ?>
            </td>
            <td>
                <?php esc_html_e('Actions', 'qode-real-estate') ?>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($posts)) { ?>
        <?php foreach($posts as $post) { ?>
            <tr class="iedit author-self level-0 most-viewed hentry">
                <td>
                    <?php echo esc_html($post['propertyID']) ?>
                </td>
                <td>
                    <?php echo esc_html($post['title']) ?>
                </td>
                <td>
                    <?php print bridge_qode_get_module_part($post['image']); ?>
                </td>
                <td>
                    <?php echo esc_html($post['city']) ?>
                </td>
                <td>
                    <?php echo esc_html($post['status']) ?>
                </td>
                <td>
                    <?php echo esc_html($post['type']) ?>
                </td>
                <td>
                    <?php echo esc_html($post['price']) ?>
                </td>
                <td>
                    <?php echo esc_html($post['views']) ?>
                </td>
                <td>
                    <a href="<?php echo esc_url($post['view_link']) ?>" target="_blank" title="<?php esc_attr_e('View', 'qode-real-estate'); ?>">
                        <i class="dashicons-before dashicons-admin-links"></i>
                    </a>
                    <a href="<?php echo esc_url($post['edit_link']) ?>" target="_blank" title="<?php esc_attr_e('Edit', 'qode-real-estate'); ?>">
                        <i class="dashicons-before dashicons-edit"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>