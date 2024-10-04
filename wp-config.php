<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'techbook' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'rootpassword' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         'g4_8H#!9$TJ4):Eu)`$O1U1?5r6>Z~[E3b7{ScNY!{>?y0lnP<!7Jf0XkDtzp%`^' );
define( 'SECURE_AUTH_KEY',  'J^=;:x|<|>XHIL8+U:<;H.~bV!ytD^O!VLqaM](PL4U j-0h@dfV$mB*sby9 !wh' );
define( 'LOGGED_IN_KEY',    'X88J#sdti#};qh=$Q^Yt~KP[_Y]3sm.h*C-Ur9$VK$DdIQ3YD9xLlHXZb_:MXS@A' );
define( 'NONCE_KEY',        ',`o2h=N4~34fhP>EnUF=}&i.eQ}VINX$i@g;z$M/^LfSJ6d+bg,L?)MtY^&Mqc%K' );
define( 'AUTH_SALT',        '.Y}jXg-y>CTdgJdC&VACt4rq@rJS[z-8 WjuswkaQkk7n}XfIgjXNz]w@;|UnCvq' );
define( 'SECURE_AUTH_SALT', '7O&*A92JqVTxiB1c_Bygj5A2F_>kp]Y|qWIJ_#G_sy1=6T_[BIB)EVLpt3:;[&7)' );
define( 'LOGGED_IN_SALT',   'K&nE4oE;Qx6*m3<nS9^ ;0Z72_w|ni=P-|jacGrQKMPo:%N)^%7YHh,o]61C+iTg' );
define( 'NONCE_SALT',       'p`Pi>vb?VeigWr.jXS3:Rhp+J@#ZY^dl:AMX%O4!Y>Gq HdC-k(b^Pvdb>9_/Dkx' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


