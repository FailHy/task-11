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
define( 'DB_NAME', 'ukm_toko' );

/** Database username */
define( 'DB_USER', 'ukm_dbuser' );

/** Database password */
define( 'DB_PASSWORD', 'GTk1bGc6bD5jBUlzJ1zUBMdH' );

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
define( 'AUTH_KEY',          '6]NWVSuLG.,Jm=v:kAI$-;e3S&,nW?yR{2A}I0FNwH)_C[Bt_#~,`NO&D/D{M!&S' );
define( 'SECURE_AUTH_KEY',   'QGmbweq-TSz;JVvSQ5YA,sDhr3rNfb;T1Zk1Mk7e!9IMDJOXSSEH)d]_z#e~rCyy' );
define( 'LOGGED_IN_KEY',     'B!}-^nk#GFIs/yEd@r)}.@0.~OdhMQu_!33>Z oD<9p:Q,VaW1<}F g9lT?tp3^%' );
define( 'NONCE_KEY',         'j?.s3ssO+<gj517h$beO6;0jfmt< ~aI8Scx#4-0C0D![Z=zi};DbA<@j8;GK<g_' );
define( 'AUTH_SALT',         '#)2|!~YX[i#z?frW(SvHF/G@Lds_eMbg`:[se|)&LN+6&,G0sO`/J(#g8pcDR8Jv' );
define( 'SECURE_AUTH_SALT',  '?|AI|Z!c%mzE*bL]Yb+iG9e2PB ,dklVFQ,1~[mpwAkG^}B5m_Q9vpGnb;^4T|A6' );
define( 'LOGGED_IN_SALT',    'l%ODr7hn74K7+t>(&BDmbQ[u1B-(fF=axI#x-xw,>0F =mB}c66o*IX@xLbaD;$y' );
define( 'NONCE_SALT',        'Lx]WCS!M_W];]0w.&;1T@v]-XOh/H0f=urNr`:M}^=3biHjA5k5tf%n[/T|k|*$p' );
define( 'WP_CACHE_KEY_SALT', 'i,_P7djl^/rRVD|B8~d?5os[wJHm7p|kS6|:kt;ZcIC.kJI?-DEto]mcIJ@mXh$:' );


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
