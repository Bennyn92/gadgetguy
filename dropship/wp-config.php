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
define('DB_NAME', 'jixilh1q_dropship');

/** MySQL database username */
define('DB_USER', 'jixilh1q_compute');

/** MySQL database password */
define('DB_PASSWORD', 'computer2016');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '1LO6zhX~>))BD^pe@)c=gid!,Sd5q9Z^w3h5R<-_Bc.K6,/8Yk&Sy@y3GtkZI[x?');
define('SECURE_AUTH_KEY',  'CH @]::Q-nzJxlwcD_9EnV2Coz8T9n^6.+S-{nb;.HCO7*Vdydk@!#IAc81~oB`3');
define('LOGGED_IN_KEY',    'R#3p141H6x>^#~_i:=}$BVG25KYLU|o#/?9,~7 -/rFe}l-@f?D4^&|NXeg*sR1<');
define('NONCE_KEY',        '>`NG}G-^KjyjU/D@^%.!8V,`fLlP6vHt&j|7=u^ok}~}).Hn(2JYYRQsH00%mB/o');
define('AUTH_SALT',        'z#,.#/V]2K^F3P?e;!t0hNh:>=?G4Tl_G^9(d&JUBH^x`8o_454#7hxE:N>1j=#|');
define('SECURE_AUTH_SALT', 'a&p$,+>4FB?KEm3jg:m0HgFy~ u_9-FR.oiF9H,vvcF|tA+uaJo. vbH-BTg)2!I');
define('LOGGED_IN_SALT',   'l-K(9GP{+0(IFP,.+0=|QM-:R}F&;x,NF)Gh7/$`l/LfBPTQ{p?N;#+p{=x#}]9z');
define('NONCE_SALT',       'tte/O[1nvF:naG}hkI3XI:?=8IUQrjj~]W*:M@xVd]K=Qjkb=f0:vtBT<oi0`%{l');

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
