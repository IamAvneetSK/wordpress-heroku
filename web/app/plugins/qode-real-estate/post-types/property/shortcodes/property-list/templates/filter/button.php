<span class="qodef-property-filter-button-section qodef-property-filter-button-holder">
<?php echo bridge_core_get_button_html(
    array(
        'custom_class' => 'qodef-property-filter-button',
        'html_type'    => 'button',
        'text'         => esc_html__('Filter Results', 'qode-real-estate')
    )
);
?>
</span>
<span class="qodef-property-query-section qodef-property-filter-button-holder">
    <?php
    echo bridge_core_get_button_html(
        array(
            'custom_class' => 'qodef-property-save-search-button',
            'html_type'    => 'button',
            'text'         => esc_html__('Save Search', 'qode-real-estate'),
            'background_color' => '#6a6a6a',
            'hover_background_color' => '#919191'
        )
    );
    ?>
    <span class="qodef-query-result">

    </span>
</span>
<span class="qodef-reset-filter-section qodef-property-filter-button-holder">
    <?php
    echo bridge_core_get_button_html(
        array(
            'custom_class'     => 'qodef-property-filter-reset-button',
            'html_type'        => 'button',
            'text'             => esc_html__('Reset', 'qode-real-estate'),
            'color'            => '#000',
            'background_color' => '#f4f4f4',
            'hover_background_color' => '#e1e9ee'
        )
    );
    ?>
</span>