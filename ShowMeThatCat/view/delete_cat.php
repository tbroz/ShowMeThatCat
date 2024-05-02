<?php
/*
-----------------------------------------------------------------------------------------------
Name:		delete_cat.php
Author:		Tiffany Broz
Date:		2023-11-02
Language:	PHP
Purpose:	This file allows you to delete the selected cat
            

            
-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-11-02		original version

TJB         2023-11-03      added success/error message for when you submit the button to delete   
                            cat. Adds a flag to allow enabling and disabling of containers. First, 
                            the container delete_container is shown which prompts you to delete cat.
                            If button is clicked, the delete_container is hidden and the 
                            delete_message_container is shown which gives you either a success/error 
                            message and them prompts you to return to the main page.
-----------------------------------------------------------------------------------------------
*/

// Include required files and functions
include '../view/header.php';
require('../model/db_connect.php');
require('../model/db_functions.php');

// Initialize the $catID and $action variables
$catID = filter_input(INPUT_GET, 'cat_id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action');
$confirmation_container_visible = true; // 11/03/2023 Flag to control visibility
$success_message = '';
$error_message = '';

if ($action == 'confirm_delete_cat') {
    // Check if catID is valid
    if ($catID) {
        // functions to delete assigned traits and cat info
        delete_assigned_traits($catID);
        delete_cat_info($catID);
        
        // 11/03/2023 adds Success message
        $success_message = "Cat Deleted Successfully!";
        // 11/03/2023 Hide the confirmation container
        $confirmation_container_visible = false;
    } else {
        // 11/03/2023 addsError message
        $error_message = "Invalid Cat ID for Deletion.";
    }
}
?>

<!-- Display the confirmation container initially -->
<?php if ($confirmation_container_visible): ?>
<div class="delete_container">
    <h2>Are you sure you want to delete this cat?</h2>
    <form method="post" action="delete_cat.php?cat_id=<?php echo $catID; ?>">
        <input type="hidden" name="action" value="confirm_delete_cat">
        <input type="hidden" name="cat_id" value="<?php echo $catID; ?>">
        <button type="submit" name="confirm_delete" class="delete_submit_button">Yes, Delete</button><br>
        <a href="../controller/index.php">Cancel</a>
    </form>
</div>
<?php endif; ?>

<!-- 11/03/2023 Display the success or error message after form submission -->
<?php if (!empty($success_message) || !empty($error_message)): ?>
    <div class="delete_message_container">
        <?php if (!empty($success_message)): ?>
            <h2 class="delete_success"><?php echo $success_message; ?></h2>
            <div class="back_button">
                <a href="../controller/index.php">
                    <!-- 11/09/2023 changed class to id -->
                    <img src="../assets/back.png" alt="Go Back" id="delete_back_button_image"/>
                </a>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <h2 class="delete_error"><?php echo $error_message; ?></h2>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include '../view/footer.php'; ?>