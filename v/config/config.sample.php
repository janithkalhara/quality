<?php 

/*
 * define mongo db password
*/
define('DB_MONGO_PASS', '');
/*
 * define mong db collection name
*/
define('DB_MONGO_COL_NAME', 'trackti');
/*
 * define mongo db user
*/
define('DB_MONGO_USER', 'root');
/*
 * define mongo database host
*/
define('DB_MONGO_HOST', 'localhost');
/*
 * defining development mod.When go to the production this constant should be set to false.
 */
define ('DEV_MOD',true);
/*
 * Tenant database configurations.
 * defining database host.
 */
define('DB_HOST', 'localhost');
/*
 * defining database name.
 */
define('DB_NAME', 'accounting_erp');
/*
 * defining database user.
 */
define('DB_USER', 'root');
/*
 * defining database password for relevant user.
 */

define('DB_PASSWORD', '123');
/*
 * defining application name.
 */

/*
 * defining authentication server URL.
 */
define('AUTH_SERVER',"http://server.accapp.dom/");

/*
 * redirecting server suffix of authentication server.
 */
define("SERVER_SUFFIX_API","api");
/*
 * defining database password for relevant user.
 */

define ("APP_NAME","base");
/*
 * Database table prefix.
 */
define("DB_TABLE_PREFIX", "ac");
/*
 * components.
 */
define("COMPONENTS","components");
/*
 * path ot base layouts.
 */
define("BASE_LAYOUT_PATH", dirname(dirname(dirname(__FILE__))).DS."layouts");

/*
 * paths to application base directory.
 */
define("APP_BASE_PATH","http://".$_SERVER['HTTP_HOST']."/apps/");


/* icons path*/
define("ICON_PATH","../layouts".DS."img".DS."icons".DS);


/*
 * cache directory 
 */
define("CACHE_DIR",dirname(dirname(__FILE__)).DS."tmp".DS."cache".DS);
/*
 * base cache file.
 */
define("MAIN_CACHE_FILE",dirname(dirname(__FILE__)).DS."tmp".DS."cache".DS."cache.cache");
/*
 * temperory configurations of the IXR library.
 */









