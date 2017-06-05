<?php
/***********************************************************************************************************************
 * This file contains all the definitions for global constants that are used throughout the web application.   This file
 * is called in as ain include in routes/web.php in the Route::group(['prefix' => ''], function() { }.  Think of this
 * like a more-static .env file (we commit this).
 * */

//Authentication
define('AUTH_LDAP_ENABLED',true);


#Todo: get rid of these variables do everything in database.

//Application IDs in Groups DB These need to match.
/*define('APP_SUPERUSER','1');
define('APP_FUNDINGOPPORTUNITIES','2');
define('APP_MATHPHDS','3');
*/