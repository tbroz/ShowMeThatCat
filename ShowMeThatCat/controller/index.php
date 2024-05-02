<?php
/*
-----------------------------------------------------------------------------------------------
Name:		index.php
Author:		Tiffany Broz
Date:		2023-10-20
Language:	PHP
Purpose:	This file handles all the control functions for the web page and processes actions 
            such as listing cats, deleting existing cats, updating a cat, and adding
            a new cat. 
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-20		I added the ability to list the cats names on the cat_info_list.php         
                            and have added the ability to add a cat to the cat_info table. 
                            
TJB         2026-10-26      Changed the validation code to allow numbers to be used for cat name
                            and changed error message to reflect that. Added functions to 
                            retreive last inserted catID immediately after a cat is added and use
                            that catID to insert into the tables for assigning personality/physical
                            traits along with whatever traits that were checkmarked in add_cat.php

TJB         2023-11-17      Tried adding ability to change between list_cats view and new
                            list_filtered_cats view for changing between seeing all cats or 
                            filtered cats
                            
TJB         2023-11-18      Rewrote code that way instead of switching between different cat 
                            views on cat_info_list.php, I created a new page (copied from 
                            cat_info_list.php) to show filtered view for seeing filtered cats
                            called filtered_cat_info_list.php. 
-----------------------------------------------------------------------------------------------
*/

    // 10/26/2023 switched the positions of the php files
    // 10/26/2023 switched the positions of the php files
require('../model/db_connect.php');
require('../model/db_functions.php');
     
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_cats';
    }
}
    
    
    
    // Populates the table with data from the show_me_that_cat database 
if ($action == 'list_cats') {
    $cats = get_all_cats();
        
    include('../view/cat_info_list.php');
    
    
// 11/18/2023 Populates the page with filtered cats after submitting the filtered cat form.
} elseif ($action == 'list_filtered_cats') {
    // Handle the form submission and display filtered cats

    // 12/01/2023 added cat name 
    $catName = filter_input(INPUT_GET, 'cat_name', FILTER_SANITIZE_STRING);
    $ageID = filter_input(INPUT_GET, 'ageID', FILTER_VALIDATE_INT);
    $genderID = filter_input(INPUT_GET, 'genderID', FILTER_VALIDATE_INT);
    $breedID = filter_input(INPUT_GET, 'breedID', FILTER_VALIDATE_INT);
    $colorID = filter_input(INPUT_GET, 'colorID', FILTER_VALIDATE_INT);
    $personalityTrait = filter_input(INPUT_GET, 'personality_trait', FILTER_VALIDATE_INT);
    $physicalTrait = filter_input(INPUT_GET, 'physical_trait', FILTER_VALIDATE_INT);
    
    // Call the filter_cats function to get the filtered cats
    // 12/01/2023 added cat name
    $filtered_cats = filter_cats($catName, $ageID, $genderID, $breedID, $colorID, $personalityTrait, $physicalTrait);

    // Include the file without parameters
    include('../view/filtered_cat_info_list.php');

    // Goes to the add_cat.php when clicked on 
} else if ($action == 'show_add_cat_form') {
    include('../view/add_cat.php');
        
    // Allows the ability to add a new cat 
} else if ($action == 'add_cat') {
    $cat_name = filter_input(INPUT_POST, 'cat_name');
    $ageID = filter_input(INPUT_POST, 'ageID', FILTER_VALIDATE_INT);
    $genderID = filter_input(INPUT_POST, 'genderID', FILTER_VALIDATE_INT);
    $breedID = filter_input(INPUT_POST, 'breedID', FILTER_VALIDATE_INT);
    $colorID = filter_input(INPUT_POST, 'colorID', FILTER_VALIDATE_INT);
        
        // Trim the input and check if they are empty after trimming
    $cat_name = trim($cat_name);
        
        // Check for empty fields
    if (empty($cat_name)) {
        $error = "Invalid cat information. Please check all fields and try again.";
        include('../errors/error.php');
    } else {
            // Define a regular expression pattern for valid names
            // 10/26/2023 allowed numbers to be used in pattern
        $name_pattern = "/^[0-9a-zA-Z-' ]+$/";
        
            // Check if the input matches the pattern
        if (!preg_match($name_pattern, $cat_name)) {
        
                // 10/26/2023 changed error message to accommodate allowing numbers
            $error = "Invalid cat data. Names should only contain alphabetic characters, numbers, hyphens, or apostrophes.";
            include('../errors/error.php');
        } else {
            add_cat($cat_name, $ageID, $genderID, $breedID, $colorID);
                    
            // 10/26/2023 Retrieve the newly added cat's ID
            $catID = get_last_inserted_cat_id();
        
            // 10/26/2023 personality traits in array for checkboxes inside add_cat.php to be assigned to catID if selected
            if (isset($_POST['personality_traits']) && is_array($_POST['personality_traits'])) {
                $personality_traits = $_POST['personality_traits'];
                assign_personality_traits($catID, $personality_traits);
            }
        
            // 10/26/2023 physical traits in array for checkboxes inside add_cat.php to be assigned to catID if selected
            if (isset($_POST['physical_traits']) && is_array($_POST['physical_traits'])) {
                $physical_traits = $_POST['physical_traits'];
                assign_physical_traits($catID, $physical_traits);
            }
        
                // Set the success message
            $success_message = "Cat added successfully!";
            header("Location: .?action=list_cats&success_message=" . urlencode($success_message));
        }
    }
}
    

?>