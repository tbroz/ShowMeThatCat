<!--
-----------------------------------------------------------------------------------------------
Name:		header.php
Author:		Tiffany Broz
Date:		2023-10-2019
Language:	PHP
Purpose:	This file is used to populate the header of my web page with the title of the page
            and to add a bottom border, which will be stylized with styles.css

-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-19		Original Version 

TJB         2023-12-07      Added href to h1 to send users back to the home page when selecting
                            h1 in the header
-----------------------------------------------------------------------------------------------
-->

<!DOCTYPE html>
<html>
    <!-- the head section -->
<head>
    <title>Show Me That Cat!</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

    <!-- the body section -->
<body>
<header>
    <!-- 12/07/23 added link to head to main page -->
    <h1 class="header_h1"><a href="/modules/final/TJB_CPT-250-F82-FINAL/controller/index.php">Show Me That Cat!</a></h1>
</header>
