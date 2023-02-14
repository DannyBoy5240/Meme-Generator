=== Wordfence Assistant ===
Contributors: mmaunder, wfryan, wfmattr
Tags: wordfence, wordfence assistant, wordfence helper, wordfence security assistant, wordfence security helper 
Requires at least: 3.9
Tested up to: 5.7
Stable tag: 1.0.9

Wordfence Assistant provides data management utilities for Wordfence users.  

== Description ==

Wordfence Assistant provides data management utilities for Wordfence users. 
You can use Wordfence Assistant to:

* Disable the Wordfence firewall without having the Wordfence plugin active.
* Delete all Wordfence data in your database.
* Purge the Wordfence Live Traffic Table.
* Delete all locked out users, IP addresses and advanced locks.

If you have been locked out of your WordPress installation, we provide a user-friendly way to unlock your site by sending an unlock email to the site administrator's email address. Occasionally this does not work which is why we created this plugin. In this case, you will need to delete the Wordfence files from the /wp-content/plugins/wordfence/ directory. Once you've done that, install this plugin and use it to disable the Wordfence firewall. You can then safely reenable Wordfence and adjust the configuration to avoid getting locked out again. Make sure you update your administrator email address so that you can use the user-friendly email unlock feature if you lock yourself out of your site in future.

== Installation ==

To install Wordfence assistant, simply install it as you would any other WordPress plugin. Once installed you'll see a "WF Assistant" menu on the left side of your administrative interface. If you click the menu option the data management options are self explanatory.

== Changelog ==

= 1.0.9 =
* Incremented version number to work around build issues

= 1.0.8 =
* Improvement: Added option to keep 2FA secrets when deleting data
* Improvement: Replaced "blacklist" with "blocklist"
* Fix: Included "wfwafconfig" in tables to delete
* Fix: Added "wordfence_installed" to list of options to delete
* Fix: Corrected messaging around removing all data
* Fix: Prevented errors when disabling manually optimized WAF

= 1.0.7 =
* Improvement: Added controls to disable the IP blacklist and clear its block cache.
* Improvement: Added support for clearing the new Wordfence Login Security tables and settings.
* Change: Updated the Wordfence logo.

= 1.0.6 =
* Improvement: Updated data removal to include lowercase tables when applicable.
* Improvement: Block clearing now covers the WAF when it's deactivated.
* Improvement: Added additional options to clear on data removal.

= 1.0.5 =
* Improvement: Updated block removal for Wordfence 7.0.1
* Improvement: Added support for new Wordfence tables.

= 1.0.4 =
* Improvement: Included new Wordfence tables added since the last update in the table removal function.
* Improvement: Added a function to disable automatic update of Wordfence.
* Improvement: Disabling the WAF provides better status updates for sites using .user.ini and the associated cache time.
* Fix: When clearing all blocks, the WAF's are now also cleared.
* Fix: Fixed a PHP notice when Wordfence is not active.

= 1.0.3 =
* Added Firewall uninstall tools.

= 1.0.2 =
* Changed logo.
* Changed Tested up to information.

= 1.0.1 =
* Initial release.

