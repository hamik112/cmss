<?php
/**
 * simpleCE v.2.0 © 2014 by Pascal-Bajorat.com
 *
 * ************************************************************************
 * You can find more changeable or overwritable constants in:
 * application/config/constants.php
 *
 * But please do not change the values directly in the constants.php file,
 * copy the constants and change them here, in your config.php!!
 * ************************************************************************
 */

/**
 * Installation date, please do not change!
 * This date will lock the installer script after 10 minutes
 */
define('installation_date', '##Timestamp##');

/**
 * Timezone
 */
define('timezone', 'GMT');

/**
 * URL of your simpleCE Installation
 */
define('site_url', '##Site-URL##');

/**
 * Database Settings
 */
define('db_driver', '##DB-Driver##');
define('db_server', '##DB-Server##');
define('db_username', '##DB-Username##');
define('db_password', '##DB-Password##');
define('db_database', '##DB-Database##');
define('db_prefix', '##DB-Prefix##');

/**
 * Need an individual translation?
 *
 * Have a look at:
 * application/language/
 *
 * There you can find the available languages an also add your own translations.
 */
define('language', '##Lang##');

/**
 * Date Format
 * http://php.net/manual/en/function.date.php#refsect1-function.date-parameters
 */
define('date_format', '##Date-Format##');

/**
 * Logging
 *
 * Set logging to "true" if you have any problems with simpleCE
 * You can find your error logs at:
 * /application/logs/
 */
define('logging', false);

/**
 * Encryption Key for Sessions and Cookies
 */
define('encryption_key', '##Encryption-Key##');