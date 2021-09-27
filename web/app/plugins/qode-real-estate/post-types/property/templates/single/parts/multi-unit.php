<?php
$multi_units_meta = get_post_meta(get_the_ID(), 'qodef_multi_units_meta', true);

if(is_array($multi_units_meta) && count($multi_units_meta)) {
?>
<div class="qodef-property-multi-unit qodef-property-label-items-holder">
    <div class="qodef-property-multi-unit-label qodef-property-label-style">
        <h5>
            <?php esc_html_e('Multi Units', 'qode-real-estate'); ?>
        </h5>
    </div>
    <div class="qodef-property-multi-unit-items qodef-property-items-style clearfix">
        <table>
            <thead>
                <tr>
                    <td><?php esc_html_e('Title', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Type', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Price', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Bedrooms', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Bathrooms', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Size', 'qode-real-estate'); ?></td>
                    <td><?php esc_html_e('Available', 'qode-real-estate'); ?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($multi_units_meta as $multi_unit) { ?>
                    <tr>
                        <td>
                            <?php echo esc_html($multi_unit['title']);?>
                        </td>
                        <td>
                            <?php echo esc_html($multi_unit['type']);?>
                        </td>
                        <td>
                            <?php echo esc_html($multi_unit['price']);?>
                        </td>
                        <td>
                            <?php echo esc_html($multi_unit['bedrooms']);?>
                        </td>
                        <td>
	                        <?php echo esc_html($multi_unit['bathrooms']);?>
                        </td>
                        <td>
                            <?php echo esc_html($multi_unit['size']);?>
                        </td>
                        <td>
                            <?php echo esc_html($multi_unit['available']);?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
