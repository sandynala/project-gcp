<?php
define('WP_CACHE', true); // WP-Optimize Cache
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
define( 'DB_NAME', 'kwshh_dev' );
/** MySQL database username */
define( 'DB_USER', 'root' );
/** MySQL database password */
define( 'DB_PASSWORD', 'Some@Rand0mP@ssW0rd!' );
/** MySQL hostname */
define( 'DB_HOST', '10.16.3.16' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define( 'WP_POST_REVISIONS', false );
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
define( 'AUTH_KEY',         'iDUu5/Cw;$)$*;H?_> u2Ls}q|,!!v[cF#068xp$*NQS4^.f]hNn<Y3@#[^r^p$r' );
define( 'SECURE_AUTH_KEY',  'vX8^#eiwQ;H{<c58ft?IGc(m+Cb@cE+e{mdi)Cu$mJbr|6YQk[R>BP+&A]z)F$]`' );
define( 'LOGGED_IN_KEY',    ' ;xC(O%rLk&(8OG+7%y}m{9D=IqxR&S[6y<aUnKRgtmZX%bzw4I#!qo-#~Ww+@kk' );
define( 'NONCE_KEY',        't.)^qn3}>M64+Ok#KVd-_CBQucm4NJcz>P -q.4Q-:/@)%5S_;O=g@n6v[Fd!qZI' );
define( 'AUTH_SALT',        '2J=%;+J/:gD}?M`mxn:0@oV(^d>f%jnID_AnkHH{NZ).@/Sj)$)an~s5apWb4tRH' );
define( 'SECURE_AUTH_SALT', 'j{4mg-)j/M_L?+bR.Pz}9RymV~v|[:kp#bWO=Z*bFO {)EpY7Ix*,Y)7NN18[.iA' );
define( 'LOGGED_IN_SALT',   '>0Juh 9`:`&QBwKj_83xuZN Z:65r}72VhZ 0(J$*pPuhw_4L9hFb[([Scdi4N9U' );
define( 'NONCE_SALT',       'LZg&jVbEnN!mkz(A@H+k|mlR.+=uUe)]kA3<ar$5rA(.=Opr>8$Hl?F3uo{Q,~5+' );
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'kws_';
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
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

// This is for Test