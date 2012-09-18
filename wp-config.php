<?php
// define('WP_DEBUG', true);
define('SAVEQUERIES', true);
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_old_css');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ']1sI`&=~)7a-e5~NN[p3n;WbgG+<0%rZ Sl]+<+XL_JRegB2) mbSA(ki[W[kX#|');
define('SECURE_AUTH_KEY',  ',2x>Wiuh|?c{jOXQ_}z{,?/9`EOC9j|[6X^uAT3#}MS%Mh{8XiF-`7P|WsH~5+8*');
define('LOGGED_IN_KEY',    '?{dstt;()dmMjj%g5D,gmg1pET#/Z{gGbEX7b-D/&TpLG3[5FyslFXuYloUt!sFn');
define('NONCE_KEY',        'pe{&Q[GVM7jkQ@TX55U{t+cON<EsB*Hn|5`vPY!/SPFJn4TazJaowut+[s*n(#x@');
define('AUTH_SALT',        'Rs*|j42VK.8;#/K z~o~QM6Xnz2S)c1^aZ%!6zo3XY dx]IahofWy=!@vXh%!J,v');
define('SECURE_AUTH_SALT', 'kxkDAA-/9kT6SK}_~NX=kL2ewt1eX[*5kJ?&gGVa]7Z>>)`g=dJ=|2i}uzAex)Vy');
define('LOGGED_IN_SALT',   'rc$Pk[Fnso#o/UooU2[b3uii[oW/y3f7z 1&bxAkjM#P4#j3!]w=SF_;ax}g3us5');
define('NONCE_SALT',       'Va%J8W*S&_;jwerS3,=>8Q3(iiTXJ{Y#n{_jN1d4J(OD(z6cq*~CLk[Wn:lo$x[G');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
