<?php
/*
-----------------------------------------------------------------------------------------------
Name:		database_error.php
Author:		Tiffany Broz
Date:		2023-10-19
Language:	PHP
Purpose:	This file is the error page that will show up if there is any errors with connecting
            to the database.

-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-19		Original Version 
TJB         2023-10-26      Changed error message to fit more align with my current project
-----------------------------------------------------------------------------------------------
*/

include 'view/header.php'; ?>

    <!-- Displays error message if issues connecting to database on database.php -->
<main>
    <div class=error_container>
        <h1>Database Error</h1>

            <!-- 10/26/2023 changed paragraphs for more accurate database error message -->
        <p>There was an error connecting to the database.</p>
        <p>Please try again.</p>
        
        <p>Error message: <?php echo $error_message; ?></p>
    </div>
</main>

<?php include 'view/footer.php'; ?>