<?php
/*
-----------------------------------------------------------------------------------------------
Name:		   dc_connect.php
Author:	   Tiffany Broz
Date:		   2023-10-19
Language:	PHP
Purpose:	   This file is used connect to the show_me_that_cat database
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-20		Original Version    
-----------------------------------------------------------------------------------------------
*/

   // Define database connection details for show_me_that_cat
   $dsn = 'mysql:host=localhost;dbname=show_me_that_cat';
   $username = 'SCC';
   $password = 'SCC';

   try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
   }
 
?>