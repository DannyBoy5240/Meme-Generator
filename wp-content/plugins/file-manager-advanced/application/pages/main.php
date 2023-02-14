<?php if ( ! defined( 'ABSPATH' ) ) exit;
$settings = get_option('fmaoptions');
$path = str_replace('\\','/', ABSPATH);
?>
<div class="wrap fma" style="background:#fff; padding: 0 0 20px 0;">
<div id="file_manager_advanced"><center><img src="<?php echo plugins_url( 'images/wait.gif', __FILE__ );?>"></center></div>
<div style="width:100%; text-align:center;" class="description">
<span>
<a href="https://advancedfilemanager.com/documentation/" target="_blank"><?php _e('Documentation','file-manager-advanced')?></a> | <a href="https://advancedfilemanager.com/contact/" target="_blank"><?php _e('Support','file-manager-advanced')?></a> | <a href="https://advancedfilemanager.com/shortcodes/"  target="_blank"><?php _e('Shortcodes','file-manager-advanced')?></a>
</span>
<span id="thankyou"><?php _e('Thank you for using <a href="https://wordpress.org/plugins/file-manager-advanced/">Advanced File Manager</a>. If you are happy then please ','file-manager-advanced')?>
<a href="https://wordpress.org/support/plugin/file-manager-advanced/reviews/?filter=5"><?php _e('Rate Us','file-manager-advanced')?> <img src="<?php echo plugins_url( 'images/5stars.png', __FILE__ );?>" style="width:100px; top: 11px; position: relative;"></a></span>
</div>
 
</div>