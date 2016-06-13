<?php
// ** SpaceWeb technical domain BEGIN **
if (strpos($_SERVER['HTTP_HOST'], '.swtest.ru') !== false) {
    if (!defined('WP_HOME')) define('WP_HOME','http://' . $_SERVER['HTTP_HOST'] . '');
    if (!defined('WP_SITEURL')) define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '');
}
// ** SpaceWeb technical domain END **
    
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sergeydons_worp1');

/** MySQL database username */
define('DB_USER', 'sergeydons_worp1');

/** MySQL database password */
define('DB_PASSWORD', 'evegiticif');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '^E(2ACATP&LOwS5^t6HUdaTTewCiydogxT%f(1^^O(kq6ZFbmQmqT6eS^Y7VMNQo');
define('SECURE_AUTH_KEY',  'UiAb5cMk6Kb5IX2wCo@84rZn)CzyUQu4t#Zp)UOIifD9ky!uU2P3dg7eZCAlm5SX');
define('LOGGED_IN_KEY',    'ChuQY4@GN&iQG1*JpmVuTDq9lOPbcy&@M5%COHQpxjud8aJ7E^uHasupjpz8nj#P');
define('NONCE_KEY',        'cW9(F4@2j(x(E7ewO9X6@JIw2#pqOmMyiKj&WpGDIg#!RioZPfG8Qel07%bnE*rv');
define('AUTH_SALT',        'SBpXYLnlG22MunqI668pXQbIm^wHUG%qU@ZAIJH!g&9HtBNCLH*9fg4!SjtFH4kN');
define('SECURE_AUTH_SALT', '4nP&l&BR9AXA(kx@hgi7NRBBXy&)BGFKYU4jUKUW!C8%A@gkA7xoxGzZqjvaQQxK');
define('LOGGED_IN_SALT',   '1w(m(Nz@QU4WYib&lNQqaiD@frj&1RprjO1vlmmczwomW)H9OIHbCS1cMzdi(&ML');
define('NONCE_SALT',       'u6vyY5)vBPrbMEi0Fc8HS^1BaM2B2WXCyYZ1kjYXc35z%8C8P8070M)(Zp!N)Eu&');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );
?>
