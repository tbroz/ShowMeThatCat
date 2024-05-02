<?php
/*
-----------------------------------------------------------------------------------------------
Name:		cat_info_list.php
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

TJB         2023-11-15      Added filter form to allow users to show a view of filtered cats 
                            of their choosing

TJB         2023-11-17      Added but removed the ability to try to change between get_all_cats()
                            and filtered_cat() functions and instead moved filtered view to new page
                            called filtered_cat_info_list.php

TJB         2023-11-24      Removed a code block for an error message under the <aside> tag 
                            as I realize it is not being used (instead it is being used on
                            errors.php)
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

                    // 10/27/2023 gets submitted cats to display for user with card divs
                    $cats = get_all_cats();

                    foreach ($cats as $cat) {
                        if (is_array($cat)) {
                            $catID = $cat['catID'] ?? ''; // Use null coalescing operator to provide a default value
                            echo '<a href="../view/cat_details.php?cat_id=' . $catID . '">';
                            echo '<div class="card">';
                            echo '<img src="../assets/default_cat_image.jpg" alt="Default Cat Image">';
                            $catName = $cat['cat_name'] ?? ''; // Use null coalescing operator to provide a default value
                            echo '<h3 class="cat_name">' . $catName . '</h3>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }
                    ?>
            </main>
        </div>
    </div>

    <!-- aside section that will hold data to be able to sort and filter the submitted cats. Also where success/fail message will be along with ability to add cat. 10/20/2023 -->
    <aside class="filter_section">
        <button class="add_cat_button" onclick="location.href='index.php?action=show_add_cat_form'">Add New Cat</button>

        <!-- Container for success/error message -->
        <div class="message_container">
            <!-- Displays success message after successful action -->
            <?php if (isset($_GET['success_message'])): ?>
                <div class="success_style">
                    <?php echo htmlspecialchars($_GET['success_message']); ?>
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
                    <input type="text" name="cat_name" id="cat_name" placeholder="Enter Cat Name">
                </div>

                <!-- cat age drop-down select -->
                <div class="filter_form_group">
                    <label class="filter_label" for="cat_age">Cat Age:</label>
                    <select name="ageID" id="cat_age" class="filter_select">
                        <option value="">Any</option> <!-- Add a default option for "Any" -->
                        <?php
                        $cat_ages = get_all_cat_ages();
                        foreach ($cat_ages as $cat_age) {
                            echo "<option value='{$cat_age['ageID']}'>{$cat_age['age']}</option>";
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
                            echo "<option value='{$cat_gender['genderID']}'>{$cat_gender['gender']}</option>";
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
                            echo "<option value='{$cat_breed['breedID']}'>{$cat_breed['breed']}</option>";
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
                            echo "<option value='{$cat_color['colorID']}'>{$cat_color['color']}</option>";
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
                            echo "<option value='{$trait['personalityID']}'>{$trait['personality']}</option>";
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
                            echo "<option value='{$trait['physicalID']}'>{$trait['physical']}</option>";
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


