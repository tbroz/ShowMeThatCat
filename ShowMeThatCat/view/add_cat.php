<?php
/*
-----------------------------------------------------------------------------------------------
Name:		add_cat.php
Author:		Tiffany Broz
Date:		2023-10-19
Language:	PHP
Purpose:	This file is the form that will allow you to add a new cat record to the database.
            It will submit data to the "cat_info" table and the "traits_assigned" table. 

            
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-19		Original Version 

TJB         2023-10-20      added drop down select options for the cat age, gender, breed and color

TJB         2023-10-27      added checkboxes that display the different personality and physical   
                            traitsand added the personality traits and physical traits in their 
                            own divs to help layout each section easily

TJB         2023-10-28      Added image button that allows you to return to cat_info_list.php 

TJB         2023-11-24      Added 2nd image button that allows you to return to cat_info_list.php 
                            to the top of the page
-----------------------------------------------------------------------------------------------
*/

include '../view/header.php'; ?>

<!-- div for main section to help with CSS in relation to cat_info_list.php -->
<main class="main_container">

    <!-- 10/28/2023 added back button to return to index.php -->
    <div class="back_button">
        <a href="../controller/index.php">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image"/>
        </a>
    </div>

    <!-- div around the entire form to help with CSS -->
    <div class="form_container">
        <h1 class="form_h1">Add a New Cat</h1>
        <form action="." method="post" id="add_cat_form">
            <input type="hidden" name="action" value="add_cat">

            <!-- cat name user input -->
            <div class="form_group">
                <label for="cat_name">Cat Name:</label>
                <input type="text" name="cat_name" id="cat_name" placeholder="Add cat name here!" />
            </div>

            <!-- cat age drop-down select -->
            <div class="form_group">
                <label for="cat_age">Cat Age:</label>
                <select name="ageID" id="cat_age" required>
                    <?php
                    $cat_ages = get_all_cat_ages();
                    foreach ($cat_ages as $cat_age) {
                        echo "<option value='{$cat_age['ageID']}'>{$cat_age['age']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- cat gender drop-down select -->
            <div class="form_group">
                <label for="cat_gender">Cat Gender:</label>
                <select name="genderID" id="cat_gender" required>
                    <?php
                    $cat_genders = get_all_cat_genders();
                    foreach ($cat_genders as $cat_gender) {
                        echo "<option value='{$cat_gender['genderID']}'>{$cat_gender['gender']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- cat breed drop-down select -->
            <div class="form_group">
                <label for="cat_breed">Cat Breed:</label>
                <select name="breedID" id="cat_breed" required>
                    <?php
                    $cat_breeds = get_all_cat_breeds();
                    foreach ($cat_breeds as $cat_breed) {
                        echo "<option value='{$cat_breed['breedID']}'>{$cat_breed['breed']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- cat color drop-down select -->
            <div class="form_group">
                <label for="cat_color">Cat Color/Pattern:</label>
                <select name="colorID" id="cat_color" required>
                    <?php
                    $cat_colors = get_all_cat_colors();
                    foreach ($cat_colors as $cat_color) {
                        echo "<option value='{$cat_color['colorID']}'>{$cat_color['color']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- 10/26/2023 added checkboxes for traits -->
            <div class="form_group">
                <div class="form_traits_section">
                    
                    <!-- 10/26/2023 Personality Traits section -->
                    <div class="form_traits_column">
                        <h2 class="form_form_h2">Personality:</h2>
                        <div class="form_traits_container">
                            <?php
                            $personality_traits = get_all_personality_traits();
                            foreach ($personality_traits as $trait) {
                                echo "<div class='form_trait_value'><label><input type='checkbox' name='personality_traits[]' value='{$trait['personalityID']}'><span>{$trait['personality']}</span></label></div>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- 10/26/2023 Physical Traits section -->
                    <div class="form_traits_column">
                        <h2 class="form_form_h2">Physical:</h2>
                        <div class="form_traits_container">
                            <?php
                            $physical_traits = get_all_physical_traits();
                            foreach ($physical_traits as $trait) {
                                echo "<div class='form_trait_value'><label><input type='checkbox' name='physical_traits[]' value='{$trait['physicalID']}'><span>{$trait['physical']}</span></label></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Submit button -->
            <div class="form_group">
                <input type="submit" value="Add Cat" />
            </div>
        </form>
    </div>

     <!-- 10/28/2023 added back button to return to cat_info_list.php -->
    <div class="back_button">
        <a href="../controller/index.php">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image"/>
        </a>
    </div>
</main>


<?php include '../view/footer.php'; ?>