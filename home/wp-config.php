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
define( 'DB_NAME', 'homedb' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'ed/W-[eJEE,<C@Q/b5T~%P5Q6cMva -+Kr>dp/7S?xio7C(5VFR(LjnZtYJ&~<pm' );
define( 'SECURE_AUTH_KEY',  'X=7[V%!^lrIEP(sS!P=fAD2>Tm`fKBl!YzE[D)D6mo=&IadV6;e/O=UmbK^Cv~33' );
define( 'LOGGED_IN_KEY',    '~@#8i}#]ECVYQp=`t3!`MX9H[8cPC<{7$w?<8hz|IvqK2KB-D*1g2nlDH*<*k,[^' );
define( 'NONCE_KEY',        '-kfi+cns=:!ugGh~@cYf}Qd7A~mU3iR0KWf~0!v<IbP3gewFWH2&d|>uMfd^dS0b' );
define( 'AUTH_SALT',        '0xYQO5|A]LkDAb:D`w!!H_FIkY]{T5[]+U9(aEq#]pDmWDZd_s4pX`x`TLz~/se8' );
define( 'SECURE_AUTH_SALT', 'vRb9uPk`d}rz/u,HQUE:)*T`W20*w|HfnO2#Y~5U])peGkOJK]pN!#JCQ>fUp?1w' );
define( 'LOGGED_IN_SALT',   'I6wU5<~=!-K[&vJ(!`]O[?Tf#Ga?=mYN_:psA-{QUyiSch/[6~l2gg3<Ac/0KkYg' );
define( 'NONCE_SALT',       '2)9XsTp_}Cd,{T6T3&OZsL63FN A#NC4sa3D*%2Cj2-3^icN!2z)})7DgZ?ez5yk' );

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
