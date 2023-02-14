=== Wordfence Login Security ===
Contributors: wfryan, wfmattr, mmaunder, wfmatt
Tags: security, login security, 2fa, two factor authentication, captcha, xml-rpc, mfa, 2 factor
Requires at least: 4.5
Requires PHP: 5.3
Tested up to: 6.1
Stable tag: 1.0.12

Secure your website with Wordfence Login Security, providing two-factor authentication, login and registration CAPTCHA, and XML-RPC protection.

== Description ==

### WORDFENCE LOGIN SECURITY

Wordfence Login Security contains a subset of the functionality found in the full Wordfence plugin: Two-factor Authentication, XML-RPC Protection and Login Page CAPTCHA.
     
Are you looking for comprehensive WordPress Security? [Check out the full Wordfence plugin](https://wordpress.org/plugins/wordfence/).

#### TWO-FACTOR AUTHENTICATION

* Two-factor authentication (2FA), one of the most secure forms of remote system authentication available.
* Use any TOTP-based authenticator app or service like Google Authenticator, Authy, 1Password or FreeOTP.
* Enable 2FA for any WordPress user role.
* Completely free to use, no limits or restrictions of any kind.

#### LOGIN PAGE CAPTCHA

* Easily enable Google ReCAPTCHA v3 on your login and registration pages.
* Stops bots from logging in without inconveniencing your site visitors.
* Robust protection against password guessing and credential stuffing attacks distributed across large IP pools

#### XML-RPC PROTECTION

* XML-RPC is the biggest target for WordPress attacks, but is often overlooked.
* Protect XML-RPC with 2FA or disable it altogether if it’s not needed.

== Installation ==

Secure your website using the following steps to install Wordfence:

1. Install Wordfence Login Security automatically or by uploading the ZIP file. 
2. Activate the Wordfence Login Security through the 'Plugins' menu in WordPress. Wordfence Login Security is now activated.
3. Go to the 'Login Security' menu and activate two-factor authentication and configure other settings.

To install Wordfence Login Security on WordPress Multisite installations:

1. Install Wordfence Login Security via the plugin directory or by uploading the ZIP file.
2. Network Activate Wordfence Login Security. This step is important because until you network activate it, your sites will see the plugin option on their 'Plugins' menu. Once activated, that option disappears. 
3. Now that Wordfence Login Security is network activated, it will appear on your Network Admin menu for super administrators and individual sites for users who have permission to activate 2FA. 

== Screenshots ==

Secure your website with Wordfence Login Security. 

1. Take login security to the next level with two-factor authentication.
2. Logging in is easy with Wordfence 2FA.
3. Configuration options include XML-RPC protection and login page CAPTCHA.

== Changelog ==

= 1.0.12 - November 28, 2022 =
* Improvement: Added feedback when login form is submitted with 2FA
* Fix: Restored click support on login button when using 2FA with WooCommerce
* Fix: Corrected display issue with reCAPTCHA score history graph
* Fix: Prevented errors on PHP caused by corrupted login timestamps

= 1.0.11 - September 19, 2022 =
* Improvement: Hardened 2FA login flow to reduce exposure in cases where an attacker is able to obtain privileged information from the database

= 1.0.10 - June 2, 2022 =
* Improvement: Added option to toggle display of last login column on WP Users page
* Improvement: Improved autocomplete support for 2FA code on Apple devices
* Fix: Corrected issue that prevented reCAPTCHA scores from being recorded
* Fix: Prevented invalid JSON setting values from triggering fatal errors
* Fix: Made text domains consistent for translation support
* Fix: Clarified that allowlisted IP addresses also bypass reCAPTCHA

= 1.0.9 - October 12, 2021 =
* Fix: Prevented login errors with WooCommerce integration when manual username entry is enabled on the WooCommerce registration form
* Fix: Corrected theme incompatibilities with WooCommerce integration

= 1.0.8 - July 19, 2021 =
* Fix: WooCommerce integration notice can now be dismissed on any admin page
* Change: Updated messaging around 2FA for WooCommerce roles

= 1.0.7 - July 8, 2021 =
* Improvement: Added 2FA and reCAPTCHA support for WooCommerce login and registration forms
* Improvement: Added option to require 2FA for any role
* Improvement: Added logic to automatically disable NTP after repeated failures and option to manually disable NTP
* Change: Updated reCAPTCHA setup note
* Change: Updated plugin headers for compatibility with WordPress 5.8

= 1.0.6 - January 14, 2021 =
* Improvement: Made a number of WordPress 5.6 and jQuery 3.x compatibility improvements.
* Improvement: Replaced the terms whitelist and blacklist with allowlist and blocklist.
* Fix: Sync roles to new sites in multisite configurations
* Fix: Corrected 2FA config links in notices for multisite
* Fix: Corrected inactive user count when users with 2FA have been deleted
* Fix: reCAPTCHA will no longer block requests with missing tokens in test mode

= 1.0.5 - January 13, 2020 =
* Changed: AJAX endpoints now send the application/json Content-Type header.
* Changed: Added compatibility messaging for reCAPTCHA when WooCommerce is active.
* Fixed: The "Require 2FA for all administrators" notice is now automatically dismissed if an administrator sets up 2FA.

= 1.0.4 - November 6, 2019 =
* Fix: Added styling fix to the 2FA code prompt for WordPress 5.3.
* Fix: Added compatibility tags for WP Tide.

= 1.0.3 - July 16, 2019 =
* Improvement: Added additional information about reCAPTCHA to its setting control.
* Improvement: Added a constant that may be overridden to customize the expiration time of login verification email links.
* Improvement: reCAPTCHA keys are now tested on saving to prevent accidentally inputting a v2 key.
* Improvement: Added a setting to control the reCAPTCHA human/bot threshold.
* Improvement: Added an option to trigger removal of Login Security tables and data on deactivation.
* Improvement: Reworked the reCAPTCHA implementation to trigger the token check on login/registration form submission to avoid the token expiring.
* Fix: Widened the reCAPTCHA key fields to allow the full keys to be visible.
* Fix: Addressed an issue when outbound UDP connections are blocked where the NTP check could log an error.
* Fix: Added handling for reCAPTCHA's JavaScript failing to load, which previously blocked logging in.
* Fix: Fixed the functionality of the button to send 2FA grace period notifications.
* Fix: Fixed a missing icon for some help links when running in standalone mode.

= 1.0.2 - May 30, 2019 =
* Initial release
