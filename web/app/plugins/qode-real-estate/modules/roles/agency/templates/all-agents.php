<?php

if (isset($agents) && is_array($agents) && count($agents)){ ?>
	<div class="qodef-membership-dashboard-page qodef-real-estate-dashboard-page">
		<div class="qodef-re-all-agents">
			<h2 class="qodef-real-estate-page-title"><?php esc_html_e('Agents List', 'qode-real-estate'); ?></h2>
			<p><?php esc_html_e('List of your agents', 'qode-real-estate'); ?></p>
			<div class="qodef-re-all-agents-table-row qodef-re-all-agents-heading">
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Name','qode-real-estate');?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Position','qode-real-estate');?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Telephone','qode-real-estate');?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Mobile Phone','qode-real-estate');?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Email','qode-real-estate');?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php esc_html_e('Address','qode-real-estate');?>
				</span>
			</div>
			<?php foreach ($agents as $agent) { ?>
			<div class="qodef-re-all-agents-table-row">
				<span class="qodef-re-all-agents-table-cell">
					<?php echo esc_html($agent['name']);?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php if (isset($agent['position'])) {
						echo esc_html($agent['position']);
					} ?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php if (isset($agent['telephone'])) {
						echo esc_html($agent['telephone']);
					} ?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php if (isset($agent['mobile'])) {
						echo esc_html($agent['mobile']);
					} ?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php if (isset($agent['email'])) {
						echo esc_html($agent['email']);
					} ?>
				</span>
				<span class="qodef-re-all-agents-table-cell">
					<?php if (isset($agent['address'])) {
						echo esc_html($agent['address']);
					} ?>
				</span>
			</div>
			<?php } ?>
		</div>
	</div>
<?php }