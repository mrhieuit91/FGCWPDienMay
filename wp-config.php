<?php
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
if($_SERVER["SERVER_NAME"]==="localhost") {
	define('WP_SITEURL', 'http://localhost:8080/FGCWPDienMay');
	define('WP_HOME', WP_SITEURL);
	define('DB_NAME', 'wordpress_fgcwpdienmay');

	/** MySQL database username */
	define('DB_USER', 'root');

	/** MySQL database password */
	define('DB_PASSWORD', '');

	/** MySQL hostname */
	define('DB_HOST', 'localhost');
}elseif($_SERVER["SERVER_NAME"]==="http://vanhieu.wdev.fgct.net/FGCWPDienMay/"){
    define('WP_SITEURL', 'http://vanhieu.wdev.fgct.net/FGCWPDienMay/');
    define('WP_HOME', WP_SITEURL);
    define('DB_NAME', 'wordpress_fgcwpdienmay');



    /** MySQL database username */
    define('DB_USER', 'vanhieu');

    /** MySQL database password */
    define('DB_PASSWORD', 'hieu.123456');

    /** MySQL hostname */
    define('DB_HOST', 'localhost');

}elseif(strpos($_SERVER["SERVER_NAME"], 'vanhieu.wdev.fgct.net') !== false) {
	define('WP_SITEURL', 'http://vanhieu.wdev.fgct.net/FGCWPDienMay/');
	define('WP_HOME', WP_SITEURL);
	define('DB_NAME', 'wordpress_fgcwpdienmay');

	/** MySQL database username */
	define('DB_USER', 'vanhieu');

	/** MySQL database password */
	define('DB_PASSWORD', 'hieu.123456');

	/** MySQL hostname */
	define('DB_HOST', 'localhost');
}


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_& &Q%-NaQN]2p8W}Ry]OHdkaw0|`-K: #,Z*)SeoL=kH!a4@?T%wh@ku*6kiEa;');
define('SECURE_AUTH_KEY',  '#C~4n561gX%TaltC-?H#6u4unvHavswBs0&D2<+Ixh`CgAQWr]%C(!$%k2g-x&V.');
define('LOGGED_IN_KEY',    'i:!On&Bc{*%q?3^/AD}pfG`Hg9RRA&bpdp],(;}>cR+.^6,Xf2vU;~<kU?TyfyuZ');
define('NONCE_KEY',        'jR~5`B%U/f#h@Z$N`0ZjX*l0wGEL[j/lh.N:)_jLnJr.8pZsI(*$B4PWp_?{!#L ');
define('AUTH_SALT',        '2VYJp&bfm%OV{c#W#v`7alo-1}K$nKXe_YS:V9b%N-t1CR]xH@b7B(YZWmr|[*nT');
define('SECURE_AUTH_SALT', '9]9KmX}I-Fg3Q0)]H1<XZ2q>g!: -l2fm.39cm32czy{;Dz+mSqbl*{)NE$ vE),');
define('LOGGED_IN_SALT',   'n,>m]NKRfIrHry8$f88|<*}}tf+Twv!7}P }W$1 VM[ <}`E(1NF_lvq%kzHDk-g');
define('NONCE_SALT',       '2=50[jc5{4~c3K|U!(t(w#;3+mvZ?:6z-{EXI~vhrX^CtwAB ps<kf0} u*{M/%I');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
