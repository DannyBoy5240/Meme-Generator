<?php /* BEGIN KINSTA DEVELOPMENT ENVIRONMENT - DO NOT MODIFY THIS CODE BLOCK */ ?>
<?php if ( !defined('KINSTA_DEV_ENV') ) { define('KINSTA_DEV_ENV', true); /* Kinsta development - don't remove this line */ } ?>
<?php if ( !defined('JETPACK_STAGING_MODE') ) { define('JETPACK_STAGING_MODE', true); /* Kinsta development - don't remove this line */ } ?>
<?php /* END KINSTA DEVELOPMENT ENVIRONMENT - DO NOT MODIFY THIS CODE BLOCK */ ?>
<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lovelettertidesadvocacy' );

/** Database username */
define( 'DB_USER', 'lovelettertidesadvocacy' );

/** Database password */
define( 'DB_PASSWORD', 'db6TzIcItwjgGOd' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'tS~9{zOi[@5eL(D[hwPi#9Zq7dx5Efkg0Ge@C3CDM[.]A(a7dT +90T=nh}#.vAj' );
define( 'SECURE_AUTH_KEY',   '<BQ_F 5qy>b?LFWa>+pRHKv;T-n7i)@@d]L;KkXV>5q#Vw9p4yN)wztQ+g%!%s#D' );
define( 'LOGGED_IN_KEY',     'Ml$oarT!nZh^?_P3{j!V_<Xs,TzOq;3O#0Owgp!{E2+9oGr6jJrsL_)gjWgz-7>J' );
define( 'NONCE_KEY',         '}>[+%*_OH/BF+{yZPD(Dbm(:A`6ZJ3DwK8.nYM-1L}i70C $`  J^/v:hUlpim<%' );
define( 'AUTH_SALT',         'Q~*{3o,lz,rtgOow|Qy+i~qsX:T&=.b]/|fm$?s~KQL~9U{dm>PD`Tc:(WgCh6OR' );
define( 'SECURE_AUTH_SALT',  'rM|.(^(jwKt;$@>djfk>ofz?)k!YwijiIxcY>h;}>s>wQe:GE1hKoX D@>{pHi}i' );
define( 'LOGGED_IN_SALT',    '&)1WLN4w&Fr*wH5lf6={,Zr`3#UjL=l%qc7svd3fA12-hgv5K0</Pjx/rH:A[9Pa' );
define( 'NONCE_SALT',        '|#D7,{s-rZ=]z=RRfHzoZ37%xG2y//BP.uk6^ qzl{HnbSk^U O1tshp1vPu8y##' );
define( 'WP_CACHE_KEY_SALT', 'XDhd)yS=nDG,8cAN=Ico43v&1BAFAHN?L_e!iA<Na)G]1Gc`]hiYIkop[&;15Vs&' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
