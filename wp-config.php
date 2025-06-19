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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'mysql-8.4' );

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
define( 'AUTH_KEY',         'VAs:}SQJM^?IzS9/r8CAI1+#lWDArHgK7P}RQdFHkmbI+9-#u@y4P~qmr}z|HnqI' );
define( 'SECURE_AUTH_KEY',  'Dipk9Q{-rT e:ZraZjf)Z5^7o,&Q7Z%GkLoE`jb(WZHkLA~0E@{xZ%IR!Fm_hQ6m' );
define( 'LOGGED_IN_KEY',    '3AbvffG;;;Ije2dBvfngxCGY/=(b7k/[o$B(OH8qv:hp6M;`<f`|cb^X{!&IhUZ`' );
define( 'NONCE_KEY',        ',obC+G&Q<&*XpdNb-`bV5tO~B}5$X^08IK}:I2{~+.T@j(.H>p%[[Cf1`M={G#bf' );
define( 'AUTH_SALT',        'HcmNgBJ&^U6j6-q+c@ 4:,hkz_u>_I:DF,h$kAB/dUF}!3i3S;[Pv4&,3Vj/k#hw' );
define( 'SECURE_AUTH_SALT', '[?0{zq7R<(4V_5_cMbyiSvaQZTAk5* Q<RBju!PqYbOuTar[q$9Gj/uw02jK^o>!' );
define( 'LOGGED_IN_SALT',   '^jC%%e{0-MU~}^mv@KG*Z3TKE>SoFGE96}HsOf7Ct!-K!Oxkd/}{2SD(}d}UX3(T' );
define( 'NONCE_SALT',       'j/,D5x2MNu||/?v)zP *QM.y?uX>I]`W/aS0Ii2(I_$UW  )a(Q}^|1Yl< (UE%~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
