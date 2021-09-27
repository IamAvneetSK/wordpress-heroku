<select name="user_register_role" id="user_register_role">
    <?php if($owner_enabled) { ?>
        <option value="owner"><?php esc_html_e('Owner/Buyer', 'qode-real-estate'); ?></option>
    <?php } ?>
    <?php if($agent_enabled) { ?>
        <option value="agent"><?php esc_html_e('Agent', 'qode-real-estate'); ?></option>
    <?php } ?>
    <?php if($agency_enabled) { ?>
        <option value="agency"><?php esc_html_e('Agency', 'qode-real-estate'); ?></option>
    <?php } ?>
</select>