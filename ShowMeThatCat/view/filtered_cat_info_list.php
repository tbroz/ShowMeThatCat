<?php
/*
-----------------------------------------------------------------------------------------------
Name:		filtered_cat_info_list.php
Author:		Tiffany Broz
Date:		2023-10-19
Language:	PHP
Purpose:	This file displays a table of all the cats that are stored in the cat_info table. 
            

            
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-19		As of right now, the goal is that this page will display card divs
                            of the submitted cats. It will show the cat's photo file and the 
                            cat's name in a div that can be clicked which will lead to seeing 
                            the full display of the submitted information. 

TJB         2023-10-20      Added the ability to see the cat's name in a clickable div that, when
                            clicked, will lead to a page called cat_details.php. Added two sections
                            to html, a main and an aside. The main is pretty well set up, I just
                            need to learn how to allow users to send photos to database. Currently  
                            I just have a default photo being used any time a cat is added just     
                            to give a reference of what it could look like.    
                            
TJB         2023-10-27      changed query parameters from cat name to catID when clicking on div
                            to select a cat to display selected information

TJB         2023-11-09      Added a javascript script that hides the success/error message after
                            3 seconds

TJB         2023-11-18      Duplicated cat_info_list.php to repurpose into filtered_cat_info_list.php
                            to show filtered selection of cats. Changed add cat button to return
                            to cat_info_list.php with all cats shown. 

TJB         2023-11-24      Added the ability to show a success or error message depending on
                            if filtering was successful or not. Changed the way the 
                            success and error message is shown under the aside compared to
                            cat_info_list.php

TJB         2023-12-07      Added a "$selected" variable to each field in the form to make sure
                            the options chosen from the filter form in cat_info_list.php is 
                            shown in the form when you view the filtered cats. Added variables
                            to grab values from the URL parameters 
-----------------------------------------------------------------------------------------------
*/

include '../view/header.php';


?>

    <!-- container that holds both main and aside section -->
<div class="container">


    <!-- main section for submitted user cats -->
    <div class="main_container">
        <div class="card_container">
            <main class="cat_cards">

                <?php

                // 12/07/23 Retrieve values from variables
                $catName = isset($_GET['cat_name']) ? $_GET['cat_name'] : '';
                $ageID = isset($_GET['ageID']) ? $_GET['ageID'] : '';
                $genderID = isset($_GET['genderID']) ? $_GET['genderID'] : '';
                $breedID = isset($_GET['breedID']) ? $_GET['breedID'] : '';
                $colorID = isset($_GET['colorID']) ? $_GET['colorID'] : '';
                $personalityTrait = isset($_GET['personality_trait']) ? $_GET['personality_trait'] : '';
                $physicalTrait = isset($_GET['physical_trait']) ? $_GET['physical_trait'] : '';

                // 11/24/2023 Initialize message variables
                $success_message = "";
                $error_message = "";

                // 11/24/2023 Check if the filtering was successful
                if (isset($filtered_cats) && !empty($filtered_cats)) {
                    $success_message = "Filtering successful!";
                } else {
                    $error_message = "No cats found matching the criteria.";
                }
                // trying to troubleshoot function not working for single selection
                // echo "Age ID: $ageID<br>";
                // echo "Gender ID: $genderID<br>";
                // echo "Breed ID: $breedID<br>";
                // echo "Color ID: $colorID<br>";
                // echo "Personality Trait ID: $personalityTrait<br>";
                // echo "Physical Trait ID: $physicalTrait<br>";

                // Display the filtered cats
                foreach ($filtered_cats as $cat) {
                    // Display cat details as needed
                    // Note: You might want to create a separate function or include a partial file for displaying cat details
                    echo '<a href="../view/cat_details.php?cat_id=' . $cat['catID'] . '">';
                    echo '<div class="card">';
                    echo '<img src="../assets/default_cat_image.jpg" alt="Default Cat Image">';
                    echo '<h3 class="cat_name">' . $cat['cat_name'] . '</h3>';
                    // Display other cat details
                    echo '</div>';
                    echo '</a>';
                }
                ?>

            </main>
        </div>
    </div>

    <!-- aside section that will hold data to be able to sort and filter the submitted cats. Also where success/fail message will be along with ability to add cat. 10/20/2023 -->
    <aside class="filter_section">
        <button class="add_cat_button" onclick="location.href='index.php?action=list_cats'">Show All Cats</button>

        <div class="message_container">
            <!-- 11/24/2023 Displays success message after successful action -->
            <?php if (!empty($success_message)): ?>
                <div class="success_style">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <!-- 11/24/2023 Displays error message after an error -->
            <?php if (!empty($error_message)): ?>
                <div class="error_style">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="filter_form_container">
            <h1 class="filter_form_h1">Filter Cats</h1>
            <form action="." method="get" id="filter_cat_form">
                <input type="hidden" name="action" value="list_filtered_cats">

                <!-- 12/01/2023 cat name field -->
                <div class="filter_form_group">
                <label class="filter_label" for="cat_name">Cat Name:</label>
                <input type="text" name="cat_name" id="cat_name" placeholder="Enter Cat Name" value="<?php echo htmlspecialchars($catName); ?>">
            </div>

                <!-- cat age drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="cat_age">Cat Age:</label>
                    <select name="ageID" id="cat_age" class="filter_select">
                        <option value="">Any</option> <!-- Add a default option for "Any" -->
                        <?php
                        $cat_ages = get_all_cat_ages();
                        foreach ($cat_ages as $cat_age) {
                            $selected = ($cat_age['ageID'] == $ageID) ? 'selected' : '';
                            echo "<option value='{$cat_age['ageID']}' $selected>{$cat_age['age']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- cat gender drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="cat_gender">Cat Gender:</label>
                    <select name="genderID" id="cat_gender" class="filter_select">
                        <option value="">Any</option> <!-- Add a default option for "Any" -->
                        <?php
                        $cat_genders = get_all_cat_genders();
                        foreach ($cat_genders as $cat_gender) {
                            $selected = ($cat_gender['genderID'] == $genderID) ? 'selected' : '';
                            echo "<option value='{$cat_gender['genderID']}' $selected>{$cat_gender['gender']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- cat breed drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="cat_breed">Cat Breed:</label>
                    <select name="breedID" id="cat_breed" class="filter_select">
                        <option value="">Any</option> <!-- Add a default option for "Any" -->
                        <?php
                        $cat_breeds = get_all_cat_breeds();
                        foreach ($cat_breeds as $cat_breed) {
                            $selected = ($cat_breed['breedID'] == $breedID) ? 'selected' : '';
                            echo "<option value='{$cat_breed['breedID']}' $selected>{$cat_breed['breed']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- cat color drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="cat_color">Cat Color/Pattern:</label>
                    <select name="colorID" id="cat_color" class="filter_select">
                        <option value="">Any</option> <!-- Add a default option for "Any" -->
                        <?php
                        $cat_colors = get_all_cat_colors();
                        foreach ($cat_colors as $cat_color) {
                            $selected = ($cat_color['colorID'] == $colorID) ? 'selected' : '';
                            echo "<option value='{$cat_color['colorID']}' $selected>{$cat_color['color']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Personality Traits drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="personality_traits">Personality Trait:</label>
                    <select name="personality_trait" id="personality_traits" class="filter_select">
                        <option value="">Any</option> <!-- Default option -->
                        <?php
                        $personality_traits = get_all_personality_traits();
                        foreach ($personality_traits as $trait) {
                            $selected = ($trait['personalityID'] == $personalityTrait) ? 'selected' : '';
                            echo "<option value='{$trait['personalityID']}' $selected>{$trait['personality']}</option>";
                        }
                        ?>
                    </select>
                </div>


                <!-- Physical Traits drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="physical_traits">Physical Trait:</label>
                    <select name="physical_trait" id="physical_traits" class="filter_select">
                        <option value="">Any</option> <!-- Default option -->
                        <?php
                        $physical_traits = get_all_physical_traits();
                        foreach ($physical_traits as $trait) {
                            $selected = ($trait['physicalID'] == $physicalTrait) ? 'selected' : '';
                            echo "<option value='{$trait['physicalID']}' $selected>{$trait['physical']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Submit button -->
                <div class="filter_form_group">
                    <input type="submit" value="Filter Cats" />
                </div>
            </form>
        </div>
        
        <!-- 11/09/2023 hides the succes/error message after 3 seconds -->
        <script>
            // Wait for the DOM to be ready
            document.addEventListener("DOMContentLoaded", function () {
                // Get the message container element
                var messageContainer = document.querySelector('.message_container');

                // Check if the message container exists
                if (messageContainer) {
                    // Set a timeout to hide the message container after 5000 milliseconds (5 seconds)
                    setTimeout(function () {
                        messageContainer.style.display = 'none';
                    }, 5000);
                }
            });

        </script>


    </aside>
</div>

<?php
include '../view/footer.php';
?>


