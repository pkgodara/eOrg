<?php
/* 
 * Log out user.
 */
session_start();

unset( $_SESSION['PostName'] );

header("Location:../");

?>
