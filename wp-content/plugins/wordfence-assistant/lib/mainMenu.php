<div class="wrap wordfence">
	<h2><?php esc_html_e('Wordfence Assistant', 'wordfence-assistant') ?></h2>
	<div class="wfAstBlock">
	<h3><?php esc_html_e('Why does this additional plugin exist?', 'wordfence-assistant') ?></h3>
	<p>
		<?php
		esc_html_e('In rare cases, Wordfence users can accidentally lock themselves out of their system. Wordfence provides a built-in user-friendly system to regain access to your website which allows site administrators to send themselves an unlock email which contains a link that unlocks their website.', 'wordfence-assistant');
		?>
		<br /><br />
		<?php
		esc_html_e('Because Wordfence has become so popular, we see edge cases where systems administrators no longer have access to their old email address or the email unlock does not work for another reason. To help unlock sites with that problem, we\'ve provided this plugin which you can install after you\'ve removed Wordfence from your system. You can use this plugin to modify the Wordfence data in your database and disable the Wordfence firewall so that if you reinstall Wordfence the firewall won\'t lock you out again. You can also use this plugin to delete all Wordfence data.', 'wordfence-assistant');
		?>
	</p>
	<h3><?php esc_html_e('Disable Wordfence Automatic Updates', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('If you have disabled Wordfence due to problems with an update, it can end up automatically updating on reinstall and causing the same problem. You can use the button below to disable automatic updates so that when you reinstall, it stays on the version installed.', 'wordfence-assistant') ?>
		<br /><br />
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Disable Wordfence Automatic Updates', 'wordfence-assistant') ?>" onclick="WFAST.disableAutoUpdate(); return ;" />
	</p>
	<h3><?php esc_html_e('Disable Wordfence Firewall', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('If you have locked yourself out of your website and the "recovery email" option does not work, you can regain access by deleting the Wordfence files from your system. These files are stored in', 'wordfence-assistant') ?><br /><br />
		<b>/wp-content/plugins/wordfence/</b>
		<br /><br />
		<?php esc_html_e('Once you\'ve done that you might want to reenable Wordfence but if you do you could get locked out again without having the opportunity to modify your Wordfence configuration and fix the thing that locked you out in the first place.', 'wordfence-assistant') ?>
		<br /><br />
		<?php esc_html_e('You can use the button below to disable the Wordfence firewall. Then when you reinstall the Wordfence files and activate Wordfence you won\'t be locked out any longer. You can then access the Wordfence Firewall page and modify the configuration to make sure you don\'t get locked out again.', 'wordfence-assistant') ?>
		<br /><br />
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Disable Wordfence Firewall', 'wordfence-assistant') ?>" onclick="WFAST.disableFirewall(); return ;" />
		<span id="disableFirewall"></span>
	</p>
	<h3><?php esc_html_e('Disable Wordfence IP Blocklist', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('You can use the button below to disable the Wordfence IP blocklist. Then when you reactivate Wordfence, all IP blocklist entries will be cleared. You can then access the Wordfence Firewall page and re-enable the blocklist when wanted.', 'wordfence-assistant') ?>
		<br /><br />
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Disable Wordfence IP Blocklist', 'wordfence-assistant') ?>" onclick="WFAST.disableBlacklist(); return ;" />
		<span id="disableBlacklist"></span>
	</p>
	<h3><?php esc_html_e('Remove all Wordfence Data in the Database and elsewhere', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('Use this option if you\'ve uninstalled Wordfence and don\'t plan to reinstall it. It will remove all Wordfence tables from your database, safely remove the files used to optimize the Wordfence WAF, and clear any other data we may store in the system including scheduled jobs.', 'wordfence-assistant') ?>
		<br /><br />
		<span class="wf-assistant-checkbox">
			<input type="checkbox" id="delete_2fa_secrets"/>
			<label><?php esc_html_e('Delete 2FA secrets', 'wordfence-assistant') ?></label>
		</span>
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Delete all Wordfence Data and Tables', 'wordfence-assistant') ?>" onclick="WFAST.delAll(); return false;" />
	</p>
	<h3><?php esc_html_e('Clear all locked out Wordfence IPs, locked out users and advanced blocks', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('If for some reason you can\'t disable the Firewall in Wordfence, you can use this option to clear all tables that contain locked out IP addresses, locked out users and rules that may cause you to be locked out.', 'wordfence-assistant') ?>
		<br /><br />
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Clear all Wordfence locked out IPs, locked out Users and advanced blocks', 'wordfence-assistant') ?>" onclick="WFAST.clearLocks();" />
	</p>
	<h3><?php esc_html_e('Clear the Wordfence Live Traffic Table', 'wordfence-assistant') ?></h3>
	<p>
		<?php esc_html_e('Some users have requested the ability to manually purge the Wordfence Live Traffic table. The table is pruned automatically by Wordfence from time to time, but clicking this button will do that for you.', 'wordfence-assistant') ?>
		<br /><br />
		<input class="button-primary" type="button" name="but1" value="<?php esc_attr_e('Delete all Live Traffic Data', 'wordfence-assistant') ?>" onclick="WFAST.clearLiveTraffic(); return;" />
	</p>
	</div>

</div>

