<?php
/*
-----------------------------------------------------------------------------------------------
Name:		db_functions.php
Author:		Tiffany Broz
Date:		2023-10-19
Language:	PHP
Purpose:	This file is used create the functions to be used on my web page.

-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-19		Added functions to get all cats, get all cat names, get all of the
                            cat ages/genders/breeds/colors separately. added function to allow
                            users to add a cat to the database

TJB         2023-10-26      Added function to display chosen cat data. Added function to grab
                            the last inserted catID to be able to reference the assigned personality 
                            and physical traits. added function to display pre-popualted 
                            personality/physical traits on add_cat.php and another function to 
                            assign catID to chosen personality/physical traits.
                            
TJB         2023-10-27      Added functions to grab the assigned data for personality/physical
                            traits to be displayed on cat_details.php

TJB         2023-11-02      Added functions to delete catID from assigned_personality_traits table
                            and assigned_physical_traits along with a function for deleting catID 
                            in cat_info table

TJB         2023-11-09      Added numerous functions to help update the cat. update_cat_info and
                            update_assigned_traits are used inside another function called 
                            update_cat_with_traits.

TJB         2023-11-10      Added function that grabs the ID keys from cat_info table and uses
                            it to prepopulate the select fields.

TJB         2023-11-15      Added function to allow user to filter view of cats

TJB         2023-11-16      Worked on troubleshooting function

TJB         2023-11-17      Was able to get filter function working if you select all parameters
                            but am still trying to get it to work for only selecting one ability

TJB         2023-11-24      Worked on filter_cats function to accommodate my one-to-many table
                            structures and added sub-queries. Fixed syntax and changed all nulls
                            to empty strings
-----------------------------------------------------------------------------------------------
*/


    // this function grabs all the cats from the cat_info table
function get_all_cats() {
    global $db;
    $query = 'SELECT * FROM cat_info';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_cats = $statement->fetchAll(PDO::FETCH_ASSOC); // Use FETCH_ASSOC to get an associative array
    $statement->closeCursor();
    return $all_cats;
}



    // this function grabs all the cat names which will display on the cat_info_list.php
function get_all_cat_names() {
    global $db;
    $query = 'SELECT cat_name FROM cat_info';
    $statement = $db->prepare($query);
    $statement->execute();
    $cat_names = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
    $statement->closeCursor();
    return $cat_names;
}



    // This function grabs all the ages from the cat_age table
function get_all_cat_ages() {
    global $db;
    $query = 'SELECT ageID, age FROM cat_age';
    $statement = $db->prepare($query);
    $statement->execute();
    $cat_ages = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $cat_ages;
}



    // This function grabs all the genders from the cat_gender table
function get_all_cat_genders() {
    global $db;
    $query = 'SELECT genderID, gender FROM cat_gender';
    $statement = $db->prepare($query);
    $statement->execute();
    $cat_genders = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    // Add var_dump to inspect the data
    //var_dump($cat_genders);

    return $cat_genders;
}
    


    // This function grabs all the breeds from the cat_breed table
function get_all_cat_breeds() {
    global $db;
    $query = 'SELECT breedID, breed FROM cat_breed';
    $statement = $db->prepare($query);
    $statement->execute();
    $cat_breeds = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $cat_breeds;
}



    // This function grabs all the colors from the cat_color table
function get_all_cat_colors() {
    global $db;
    $query = 'SELECT colorID, color FROM cat_color';
    $statement = $db->prepare($query);
    $statement->execute();
    $cat_colors = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $cat_colors;
}



    // this function adds the cat to the database
function add_cat($cat_name, $ageID, $genderID, $breedID, $colorID) {
    global $db;
    $query = 'INSERT INTO cat_info (cat_name, ageID, genderID, breedID, colorID)
              VALUES (:cat_name, :ageID, :genderID, :breedID, :colorID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':cat_name', $cat_name);
    $statement->bindValue(':ageID', $ageID);
    $statement->bindValue(':genderID', $genderID);
    $statement->bindValue(':breedID', $breedID);
    $statement->bindValue(':colorID', $colorID);
    $statement->execute();
    $statement->closeCursor();
}



    // 10/26/2023 added function for showing cat details after clicking div
function get_cat_details_by_id($catID) {
    global $db;
    $query = 'SELECT catID, cat_name, age AS age, gender AS gender, breed AS breed, color AS color
                FROM cat_info
                INNER JOIN cat_age ON cat_info.ageID = cat_age.ageID
                INNER JOIN cat_gender ON cat_info.genderID = cat_gender.genderID
                INNER JOIN cat_breed ON cat_info.breedID = cat_breed.breedID
                INNER JOIN cat_color ON cat_info.colorID = cat_color.colorID
                WHERE cat_info.catID = :catID';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
    $cat_details = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $cat_details;
}



    // 10/26/2023 added function to grab the newest catID to be able to add cat to personality and physical traits table
function get_last_inserted_cat_id() {
    global $db;
    $query = 'SELECT LAST_INSERT_ID() as catID';
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $result['catID'];
}



    // 10/26/2023 added function to grab all personality traits from personality_traits table
function get_all_personality_traits() {
    global $db;
    $query = 'SELECT personalityID, personality FROM personality_traits';
    $statement = $db->prepare($query);
    $statement->execute();
    $personality_traits = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $personality_traits;
}



    // 10/26/2023 added function to assign catID to personality traits
function assign_personality_traits($catID, $personality_traits) {
    global $db;
    $query = 'INSERT INTO assigned_personality_traits (catID, personalityID) VALUES (:catID, :personalityID)';
    $statement = $db->prepare($query);

    foreach ($personality_traits as $personalityID) {
        $statement->bindValue(':catID', $catID);
        $statement->bindValue(':personalityID', $personalityID);
        $statement->execute();
    }
}



    // 10/26/2023 added function to grab all physical traits from physical_traits table
function get_all_physical_traits() {
    global $db;
    $query = 'SELECT physicalID, physical FROM physical_traits';
    $statement = $db->prepare($query);
    $statement->execute();
    $physical_traits = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $physical_traits;
}



    // 10/26/2023 added function to assign catID to physical traits
function assign_physical_traits($catID, $physical_traits) {
    global $db;
    $query = 'INSERT INTO assigned_physical_traits (catID, physicalID) VALUES (:catID, :physicalID)';
    $statement = $db->prepare($query);

    foreach ($physical_traits as $physicalID) {
        $statement->bindValue(':catID', $catID);
        $statement->bindValue(':physicalID', $physicalID);
        $statement->execute();
    }
}



    // 10/27/2023 added function to grab chosen personality traits
function get_personality_traits_for_cat($catID) {
    global $db;
    $query = 'SELECT personality.personalityID, personality.personality FROM assigned_personality_traits
                JOIN personality_traits AS personality ON assigned_personality_traits.personalityID = personality.personalityID
                WHERE assigned_personality_traits.catID = :catID';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
    $personality_traits = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $personality_traits;
}



    // 10/27/2023 added function to grab chosen physical traits
function get_physical_traits_for_cat($catID) {
    global $db;
    $query = 'SELECT physical.physicalID, physical.physical FROM assigned_physical_traits
                JOIN physical_traits AS physical ON assigned_physical_traits.physicalID = physical.physicalID
                WHERE assigned_physical_traits.catID = :catID';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
    $physical_traits = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $physical_traits;
}

    // 11/02/2023 deletes catID from assigned_personality_traits/assigned_physical_traits tables
function delete_assigned_traits($catID) {
    global $db;
    $query = 'DELETE FROM assigned_personality_traits WHERE catID = :catID;
              DELETE FROM assigned_physical_traits WHERE catID = :catID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
}

    // 11/02/2023 deletes catID from cat_info table
function delete_cat_info($catID) {
    global $db;
    $query = 'DELETE FROM cat_info WHERE catID = :catID';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
}

// 11/09/2023 Function to update cat information in the cat_info table
function update_cat_info($catID, $cat_name, $ageID, $genderID, $breedID, $colorID) {
    global $db;

    $query = 'UPDATE cat_info
              SET cat_name = :cat_name,
                  ageID = :ageID,
                  genderID = :genderID,
                  breedID = :breedID,
                  colorID = :colorID
              WHERE catID = :catID';

    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->bindValue(':cat_name', $cat_name);
    $statement->bindValue(':ageID', $ageID);
    $statement->bindValue(':genderID', $genderID);
    $statement->bindValue(':breedID', $breedID);
    $statement->bindValue(':colorID', $colorID);
    $statement->execute();
    $statement->closeCursor();
}

// 11/09/2023 Function to update assigned personality and physical traits
function update_assigned_traits($catID, $personality_traits, $physical_traits) {
    // delete existing assigned traits
    delete_assigned_traits($catID);

    // assign new personality and physical traits
    assign_personality_traits($catID, $personality_traits);
    assign_physical_traits($catID, $physical_traits);
}

// 11/09/2023 Function to update cat information along with traits
function update_cat_with_traits($catID, $cat_name, $ageID, $genderID, $breedID, $colorID, $personality_traits, $physical_traits) {
    global $db;

    try {
        // Begin a transaction
        $db->beginTransaction();

        // Update cat information in cat_info table
        update_cat_info($catID, $cat_name, $ageID, $genderID, $breedID, $colorID);

        // Update assigned personality and physical traits
        update_assigned_traits($catID, $personality_traits, $physical_traits);

        // Commit the transaction
        $db->commit();
    } catch (PDOException $e) {
        // An error occurred, rollback the transaction
        $db->rollBack();
        
    }
}

// 11/10/2023 function to grab the IDs of each section to be able to pre-populate update_cat.php 
function get_IDs_from_cat_info($catID) {
    global $db;
    $query = 'SELECT catID, cat_name, ageID, genderID, breedID, colorID
              FROM cat_info
              WHERE catID = :catID';
    $statement = $db->prepare($query);
    $statement->bindValue(':catID', $catID);
    $statement->execute();
    $cat_attributes = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $cat_attributes;
}


// 11/15/2023 function to allow cats to be filtered
// 11/24/2023 changed NULL to empty strings
// 12/01/2023 added cat name to function
function filter_cats($catName = "", $ageID = "", $genderID = "", $breedID = "", $colorID = "", $personalityTrait = "", $physicalTrait = "") {
    global $db;

    // base query
    $query = 'SELECT cat_info.catID, cat_name, age, gender, breed, color FROM cat_info
              INNER JOIN cat_age ON cat_info.ageID = cat_age.ageID
              INNER JOIN cat_gender ON cat_info.genderID = cat_gender.genderID
              INNER JOIN cat_breed ON cat_info.breedID = cat_breed.breedID
              INNER JOIN cat_color ON cat_info.colorID = cat_color.colorID';

    // 11/24/2023 Subquery for personality traits
    if ($personalityTrait != "") {
        $query .= ' LEFT JOIN (
                        SELECT catID, GROUP_CONCAT(personalityID) as personalityIDs
                        FROM assigned_personality_traits
                        GROUP BY catID
                    ) AS personality_subquery ON cat_info.catID = personality_subquery.catID';
    }

    // 11/24/2023 Subquery for physical traits
    if ($physicalTrait != "") {
        $query .= ' LEFT JOIN (
                        SELECT catID, GROUP_CONCAT(physicalID) as physicalIDs
                        FROM assigned_physical_traits
                        GROUP BY catID
                    ) AS physical_subquery ON cat_info.catID = physical_subquery.catID';
    }

    // Create an array to store conditions
    $conditions = [];

    // Add conditions for each input box, only if it's selected
    // 11/24/2023 changed syntax from !== to !=

    // 12/1/2023 added condition for cat name
    if ($catName != "") {
        $conditions[] = 'cat_info.cat_name LIKE :catName';
    }

    if ($ageID != "") {
        $conditions[] = 'cat_info.ageID = :ageID';
    }

    if ($genderID != "") {
        $conditions[] = 'cat_info.genderID = :genderID';
    }

    if ($breedID != "") {
        $conditions[] = 'cat_info.breedID = :breedID';
    }

    if ($colorID != "") {
        $conditions[] = 'cat_info.colorID = :colorID';
    }

    // Add conditions for personality trait
    if ($personalityTrait != "") {
        $conditions[] = 'FIND_IN_SET(:personalityID, personality_subquery.personalityIDs)';
    }

    // Add conditions for physical trait
    if ($physicalTrait != "") {

        // 11/24/2023 
        $conditions[] = 'FIND_IN_SET(:physicalID, physical_subquery.physicalIDs)';
    }

    // If there are conditions, append them to the query
    $query .= !empty($conditions) ? ' WHERE ' . implode(' AND ', $conditions) : '';

    // 12/01/2023 added debug to help fix filter by name issue
    // echo "Debug: SQL Query: $query<br>";
    
    $statement = $db->prepare($query);

    // Bind parameters if they exist
    // 12/01/2023 added cat name bind
    if ($catName != "") {
        $statement->bindValue(':catName', '%' . $catName . '%');
    }

    if ($ageID != "") {
        $statement->bindValue(':ageID', $ageID);
    }

    if ($genderID != "") {
        $statement->bindValue(':genderID', $genderID);
    }

    if ($breedID != "") {
        $statement->bindValue(':breedID', $breedID);
    }

    if ($colorID != "") {
        $statement->bindValue(':colorID', $colorID);
    }

    // Bind parameters for personality trait
    if ($personalityTrait != "") {
        $statement->bindValue(':personalityID', $personalityTrait);
    }

    // Bind parameters for physical trait
    if ($physicalTrait != "") {
        $statement->bindValue(':physicalID', $physicalTrait);
    }

    // Execute the query and check for errors
    $statement->execute();

    $filtered_cats = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $filtered_cats;
}

?>