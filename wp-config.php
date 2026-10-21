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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          'lL-vSoJa}}Wb&6iM}qAn<CVgSu-Dpa;u +~bF~!w(TOF&PQsRrE@#[bfs*:cJ10>' );
define( 'SECURE_AUTH_KEY',   '/f=O1_O7TM)+u)c^>{7YZzIO{IbA<d0{&i~hQ=%qe*w0i()niLv|`kuf6MVz=za]' );
define( 'LOGGED_IN_KEY',     '/0*1xu`(&@~JZ5+j2XPLef%l-Hv@%S^BHHynzGd>.gF5:i&{C1Bs1keTNejt8)2Q' );
define( 'NONCE_KEY',         '=3i*rj[lNT/ykkuv]tRq=IB;leVh8>E|ss/2.MAi/xX>m?k7J?D@4Nts<Bsps5~q' );
define( 'AUTH_SALT',         'qr+K5&t5)iz(rbr,K#z,{V+vh95UlU!CLZU_mvNCrm ,4Yn)Y_C.a#2@<Q^,zRZG' );
define( 'SECURE_AUTH_SALT',  '}QapwAYP_&]3R^4]o^WfAv<}%&t@hHa+>i.Yv<N;.hJW>BYE:J-}4Cc}kA.%mkBc' );
define( 'LOGGED_IN_SALT',    '!qrd>&,|o#`|#o5<v-^a)(:m2s;TptwlPAK:{[tg6hwOly27]NA;<uSSCxz]sG(<' );
define( 'NONCE_SALT',        'jP()gB:XbzR/3FI:a]VG`7qp7#0UUVNGtJ?mTf_03MdCiS&|Kf52fN/#{kh6T{|u' );
define( 'WP_CACHE_KEY_SALT', '8Dh~M!!4k[L;#mK!Tm Gje{@T}bA6%9YQ>~I_z}GOt68_)Y#q|w<Iri<NRwW&{A;' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
