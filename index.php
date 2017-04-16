<?PHP
/* 
 * This is the Main Web Entry point for eOrg .
 * 
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * This program is free software; you can redistribute it and/or modify it.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * Thank you.
 * 
 */




require_once dirname( __FILE__ ).'/includes/PHPVersionCheck.php';

checkEntryPoint( 'index.php' );

require __DIR__.'/includes/WebStart.php';




?>
