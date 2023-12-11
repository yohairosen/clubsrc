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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'clubsrc' );

/** MySQL database username */
define( 'DB_USER', 'clubsrc' );

/** MySQL database password */
define( 'DB_PASSWORD', 'J0p1wY8Ai2RH1iFA' );

/** MySQL hostname */
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
define('AUTH_KEY',         '@n4vgiVDL-OWNT)U}XJvJrf?SEaAJd|eMRwNSQ&=crU+NZU}fIrtALpHLOW26r|%');
define('SECURE_AUTH_KEY',  'r$HxbV+#AlH|# uOE^WsbH.Wj8J?:Dn1KvaV|}2`GUjAa&pY&@A>H6XQ0$lgD$1f');
define('LOGGED_IN_KEY',    'K-3IcfKkkm(jZ`ok:-K!lH_TkTn=|{C /]fxo&!IBqUs#gHIt 0$`fC[9|y<L96K');
define('NONCE_KEY',        'TS,jP0PN%8]CH:#&a1nehk]8vs-fcXe+ %X&XEWe-rDod0qToQ.HNv2x.sre&RQ8');
define('AUTH_SALT',        'I{:r YiD|@v%JL-Pv8)As7!t#fED:D7@N?%*gR]Eb-)[SeCj(TF/sAh]P;lEO_L3');
define('SECURE_AUTH_SALT', 'Qg3m>_dD!sz%n{bu!qq8G,X/Ni8u0BE@5g1?jYV+m~0X/HSOHc0+lH(@MW~48g-Y');
define('LOGGED_IN_SALT',   'KNu)|SgG^(+2X[-0ZK2^WZ-lZh`e(J_G4ZTb0ocJNtE4d>xfi*U*b0y(se78SZ#3');
define('NONCE_SALT',       ':-U``];Q+*Dw/d?.e#GELT~tk dBtcK:@uH.LQ!sk&?~Y-T8os{@a_=pUB,6L/I3');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );
# define('FORCE_SSL_ADMIN', false);
/* Add any custom values between this line and the "stop editing" line. */

if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
	$_SERVER['HTTPS']='on';

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
