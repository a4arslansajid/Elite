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

 * * ABSPATH

 *

 * @link https://wordpress.org/documentation/article/editing-wp-config-php/

 *

 * @package WordPress

 */



// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/towelpro/EliteSportsN/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'towelpro_wp9' );



/** Database username */

define( 'DB_USER', 'developer' );



/** Database password */

define( 'DB_PASSWORD', 'Elit@2019#[.i.]' );



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

define('AUTH_KEY',         'p6N79aSiVGrS71GMWZKW6v7Nq2gBvZ36Z8f5TdsWmjbQsl1rvzUgoUCKrIaFvL8B');

define('SECURE_AUTH_KEY',  '4Ph3vKlB5HhZpUpoY6HDkyfCB9hbg0pqCs6O0XJMlzSKOOKhwYXJZu1KXcOIJNDk');

define('LOGGED_IN_KEY',    'UfKA7BIJVGQw6lY4JeeMWEPigJjpEtmlphLzpfuYZAXemmap3n6TWO9XY2kFwXFr');

define('NONCE_KEY',        '7gB806kAenxizmVMfQZjpWmmzzEkIJd6cPfOwJ01CgLGSn2Ea0UqVWKd1mLT6kWl');

define('AUTH_SALT',        'QaQAWjHrXtNBMNytfibmO9kuaiSCnYHBxYxmUT4tC765N48dBjR3OAh8ZABZQPRp');

define('SECURE_AUTH_SALT', 'fPg9cwZDsBg2PavAeSdJPUzC3UjE9ht5M6wXmO4BOq3A2agML4gS5uow9KNj97bP');

define('LOGGED_IN_SALT',   'XAMDGbMbaMcbLgYSWWUnXKr12HJyLQnn9UTPfpDc8R8ZIKw2mA8L1inKJdcd315Q');

define('NONCE_SALT',       'zYjVxFuksQ00NBY4J5pAlet9w3tj3riXzO48IEuKeI0FCsgPShiTyUqNlrCnQ4tY');



/**

 * Other customizations.

 */

define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');





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

define( 'WP_DEBUG', false );



/* Add any custom values between this line and the "stop editing" line. */







/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

