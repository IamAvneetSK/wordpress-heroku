<?php
$shortcode_params = qodef_re_get_search_page_sc_params($params);

echo bridge_qode_execute_shortcode('qodef_property_list', $shortcode_params);