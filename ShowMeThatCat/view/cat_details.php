<?php
/*
-----------------------------------------------------------------------------------------------
Name:		actor_cat.php
Author:		Tiffany Broz
Date:		2023-10-19
Language:	PHP
Purpose:	This file is will be the full details from the cat_info table that is submitted by
            the users

            
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-20		Original Version 

TJB         2023-10-26      Added required files. Added php script to input data from add_cat.php 
                            into a table that will show the specific cat data when chosen. 

TJB         2023-10-27      Added display for assigned traits. Laid out assigned traits in  
                            unordered list (ul) separated by the two trait categories. Also changed  
                            the GET request to get cat details by catID and not cat name like
                            originally written.

TJB         2023-10-28      Added image button that allows you to return to cat_info_list.php  

TJB         2023-11-02      Added two image buttons to the top right of page for updating cat and   
                            deleting cat

TJB         2023-11-24      Added 2nd image button that allows you to return to cat_info_list.php 
                            to the top of the page
-----------------------------------------------------------------------------------------------
*/

include '../view/header.php'; 
require('../model/db_connect.php');
require('../model/db_functions.php');
?>

<main class="details_main">

    <?php
        if (isset($_GET['cat_id'])) {
        $catID = $_GET['cat_id'];
     } ?>
    
    <!-- 11/02/2023 image buttons for updating cat and deleting cat -->
    <div class="cat_buttons">
        <!-- 11/24/2023 added back button to return to cat_info_list.php -->
        <a href="../controller/index.php" class="back_button_nav">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image"/>
        </a>
        <a href="update_cat.php?cat_id=<?php echo $catID; ?>">
            <img src="../assets/update.png" alt="Update" class="update_button_image" />
        </a>
        <a href="delete_cat.php?cat_id=<?php echo $catID; ?>">
        <img src="../assets/delete.png" alt="Delete" class="delete_button_image" />
    </a>
    </div>

     

    
    <div class="cat_details">
        <?php

            // 10/27/2023 changed GET request by catID and not cat name in case we have cats with the same name 
        if (isset($_GET['cat_id'])) {
            $catID = $_GET['cat_id'];
            $cat_details = get_cat_details_by_id($catID);

            if ($cat_details) {
                // 10/26/2023 displays data from cat_info table
                echo '<h1 class="details_h1">' . $cat_details['cat_name'] . '</h1>';
                echo '<hr>';
                echo '<table class="details_table">';
                echo '<tr><td class="details_label">Age:</td><td class="details_cat">' . $cat_details['age'] . '</td></tr>';
                echo '<tr><td class="details_label">Gender:</td><td class="details_cat">' . $cat_details['gender'] . '</td></tr>';
                echo '<tr><td class="details_label">Breed:</td><td class="details_cat">' . $cat_details['breed'] . '</td></tr>';
                echo '<tr><td class="details_label">Color:</td><td class="details_cat">' . $cat_details['color'] . '</td></tr>';
                echo '</table>';

                // 10/27/2023 added a horizontal rule and an h2 below the table
                echo '<hr>';
                echo '<h2 class="details_traits_header"> Traits</h2>';
                echo '<div class="details_traits_container">';

                // 10/27/2023 displays data from assigned_personality_traits table
                $personality_traits = get_personality_traits_for_cat($catID);
                if ($personality_traits) {
                    echo '<div class="details_personality">';
                    echo '<h2 class="details_h2">Personality</h2>';
                    echo '<hr class="traits_hr">';
                    echo '<ul class="traits_list">';
                    foreach ($personality_traits as $trait) {
                        echo '<li>' . $trait['personality'] . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';

                    // 10/27/2023 added else statement to show "no traits chosen" in case no checkboxes were selected
                } else {
                    echo '<div class="details_personality">';
                    echo '<h2 class="details_h2">Personality</h2>';
                    echo '<hr class="traits_hr">';
                    echo '<ul class="traits_list">';
                    echo '<li>No trait chosen</li>';
                    echo '</ul>';
                    echo '</div>';
                }

                // 10/27/2023 displays data from assigned_physical_traits table
                $physical_traits = get_physical_traits_for_cat($catID);
                if ($physical_traits) {
                    echo '<div class="details_physical">';
                    echo '<h2 class="details_h2">Physical</h2>';
                    echo '<hr class="traits_hr">';
                    echo '<ul class="traits_list">';
                    foreach ($physical_traits as $trait) {
                        echo '<li>' . $trait['physical'] . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';

                    // 10/27/2023 added else statement to show "no traits chosen" in case no checkboxes were selected
                } else {
                    echo '<div class="details_physical">';
                    echo '<h2 class="details_h2">Physical</h2>';
                    echo '<hr class="traits_hr">';
                    echo '<ul class="traits_list">';
                    echo '<li>No trait chosen</li>';
                    echo '</ul>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Cat not found.</p>';
            }
        } else {
            echo 'Incorrect URL Redirection.';
        }
        ?>
    </div>


    <!-- 10/28/2023 added back button to return to cat_info_list.php -->
    <div class="back_button">
        <a href="../controller/index.php">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image"/>
        </a>
    </div>

</main>

<?php include '../view/footer.php'; ?>