<?php
/*
-----------------------------------------------------------------------------------------------
Name:		update_cat.php
Author:		Tiffany Broz
Date:		2023-11-02
Language:	PHP
Purpose:	This file is the form that will allow you to update an existing cat on the database.

            
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-11-02      original version

TJB         2023-11-08      removed the "under construction" reference and added the form to update
                            cat with all the fields being pre-populated with the selected cat's name
                            and personality traits

TJB         2023-11-09      tried troubleshooting why my code was not adding the proper "selected"
                            value for the drop down menus. Not successful

TJB         2023-11-10      Fixed problem why code was not properly selecting the value based off
                            of selected cat. Instead to "selecting" the value equated to the 
                            primary key of each section (age, breed, gender, and color tables), it
                            was just grabbing the actual name. ageID vs age. I added a new function
                            to grab the ageID, breedID, colorID and genderID.
-----------------------------------------------------------------------------------------------
*/

include '../view/header.php'; 
require('../model/db_connect.php');
require('../model/db_functions.php');

$catID = filter_input(INPUT_GET, 'cat_id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action');
$confirmation_container_visible = true; // Flag to control visibility
$success_message = '';
$error_message = '';

// Retrieve cat details for pre-populating the form
if ($catID) {
    $ID_keys = get_IDs_from_cat_info($catID);

    if ($ID_keys) {
        $existingCatName = $ID_keys['cat_name'];
        $existingAgeID = $ID_keys['ageID'];
        $existingGenderID = $ID_keys['genderID'];
        $existingBreedID = $ID_keys['breedID'];
        $existingColorID = $ID_keys['colorID'];
        $selectedPersonalityTraits = get_personality_traits_for_cat($catID);
        $selectedPhysicalTraits = get_physical_traits_for_cat($catID);
    } else {
        
        $error_message = "Invalid Cat ID.";
    }
} else {
    
    $error_message = "Cat ID not provided.";
}

// Check if the form is submitted for cat update
if ($action == 'update_cat') {
    // Process form data and update the cat
    $catID = $_POST['cat_id'];
    $cat_name = $_POST['cat_name'];
    $ageID = $_POST['ageID'];
    $genderID = $_POST['genderID'];
    $breedID = $_POST['breedID'];
    $colorID = $_POST['colorID'];
    $personality_traits = isset($_POST['personality_traits']) ? $_POST['personality_traits'] : [];
    $physical_traits = isset($_POST['physical_traits']) ? $_POST['physical_traits'] : [];

    try {
        // Call the update function
        update_cat_with_traits($catID, $cat_name, $ageID, $genderID, $breedID, $colorID, $personality_traits, $physical_traits);

        // Set success message
        $success_message = "Cat Updated Successfully!";
        // Hide the confirmation container
        $confirmation_container_visible = false;
    } catch (PDOException $e) {
        // Handle the exception, show an error message, log the error, etc.
        $error_message = "Error updating cat: " . $e->getMessage();
    }
}

?>

 <!-- same form structure as add_cat.php -->
<main class="main_container">
    <?php if ($confirmation_container_visible): ?>

        <!-- div around the entire form to help with CSS -->
        <div class="form_container">
            <h1 class="form_h1">Update Cat</h1>
            <form action="../view/update_cat.php" method="post" id="update_cat_form">
                <input type="hidden" name="action" value="update_cat">
                <input type="hidden" name="cat_id" value="<?php echo $catID; ?>">


                <!-- cat name user input -->
                <div class="form_group">
                    <label for="cat_name">Cat Name:</label>
                    <input type="text" name="cat_name" id="cat_name" value="<?php echo $existingCatName; ?>" />
                </div>


                <!-- cat age drop-down select -->
                <div class="form_group">
                    <label for="cat_age">Cat Age:</label>
                    <select name="ageID" id="cat_age" required>
                        <?php
                        $cat_ages = get_all_cat_ages();
                        foreach ($cat_ages as $cat_age) {
                            $selected = ($cat_age['ageID'] == $existingAgeID) ? 'selected' : '';
                            echo "<option value='{$cat_age['ageID']}' $selected>{$cat_age['age']}</option>";
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
                            $selected = ($cat_gender['genderID'] == $existingGenderID) ? 'selected' : '';
                            echo "<option value='{$cat_gender['genderID']}' $selected>{$cat_gender['gender']}</option>";
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
                            $selected = ($cat_breed['breedID'] == $existingBreedID) ? 'selected' : '';
                            echo "<option value='{$cat_breed['breedID']}' $selected>{$cat_breed['breed']}</option>";
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
                            $selected = ($cat_color['colorID'] == $existingColorID) ? 'selected' : '';
                            echo "<option value='{$cat_color['colorID']}' $selected>{$cat_color['color']}</option>";
                        }
                        ?>
                    </select>
                </div>


                <!-- 10/26/2023 added checkboxes for traits -->
                <div class="form_group">
                    <div class="form_traits_section">
                        <div class="form_traits_column">
                            <h2 class="form_form_h2">Personality Traits:</h2>
                            <div class="form_traits_container">
                                <?php
                                $personality_traits = get_all_personality_traits();
                                $selectedPersonalityTraits = get_personality_traits_for_cat($catID); // Get the selected traits for the current cat
                                foreach ($personality_traits as $trait) {
                                    $checked = in_array($trait['personalityID'], array_column($selectedPersonalityTraits, 'personalityID')) ? 'checked' : ''; // Check if the trait is in the selected traits array
                                    echo "<div class='form_trait_value'><label><input type='checkbox' name='personality_traits[]' value='{$trait['personalityID']}' $checked><span>{$trait['personality']}</span></label></div>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Physical Traits section -->
                        <div class="form_traits_column">
                            <h2 class="form_form_h2">Physical Traits:</h2>
                            <div class="form_traits_container">
                                <?php
                                $physical_traits = get_all_physical_traits();
                                $selectedPhysicalTraits = get_physical_traits_for_cat($catID); // Get the selected traits for the current cat
                                foreach ($physical_traits as $trait) {
                                    $checked = in_array($trait['physicalID'], array_column($selectedPhysicalTraits, 'physicalID')) ? 'checked' : ''; // Check if the trait is in the selected traits array
                                    echo "<div class='form_trait_value'><label><input type='checkbox' name='physical_traits[]' value='{$trait['physicalID']}' $checked><span>{$trait['physical']}</span></label></div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="form_group">
                    <input type="submit" value="Update Cat" />
                </div>
            </form>
        </div>
    <?php endif; ?>


    <!-- 11/10/2023 Display the success or error message after form submission -->
    <?php if (!empty($success_message) || !empty($error_message)): ?>
        <div class="update_message_container">
            <?php if (!empty($success_message)): ?>
                <h2 class="update_success"><?php echo $success_message; ?></h2>
                <div class="back_button">
                    <a href="../controller/index.php">
                        <img src="../assets/back.png" alt="Go Back" id="update_back_button_image"/>
                    </a>
                </div>
            <?php elseif (!empty($error_message)): ?>
                <h2 class="update_error"><?php echo $error_message; ?></h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

     <!-- added back button to return to index.php -->
    <div class="back_button">
        <a href="../controller/index.php">
            <img src="../assets/back.png" alt="Go Back" class="back_button_image" />
        </a>
    </div>
</main>

<?php include '../view/footer.php'; ?>