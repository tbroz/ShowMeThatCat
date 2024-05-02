<?php
/*
-----------------------------------------------------------------------------------------------
Name:		error.php
Author:		Tiffany Broz
Date:		2023-10-20
Language:	PHP
Purpose:	This file is the error page that will show up if there are any mishaps with any
            of the functions pertaining to adding, deleting, selecting, and updating the cats
            from the show_me_that_cat database
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-20		Original Version     

TJB         2023-10-28      Added image button that allows you to return to index.php  
-----------------------------------------------------------------------------------------------
*/
include '../view/header.php'; ?>

    <!-- Displays error message if invalid input for forms on cat_add.php -->
<main>
    <div class=error_container>
        <h1>ERROR!</h1>
        <p><?php echo $error; ?></p>
    </div>

        <!-- 10/28/2023 added back button to return to index.php -->
    <div class="back_button">
        <a href="../controller/index.php">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image"/>
        </a>
    </div>
</main>

<?php include '../view/footer.php'; ?>
 