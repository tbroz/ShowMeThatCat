/*
-----------------------------------------------------------------------------------------------
Name:		show_me_that_cat.sql
Author:		Tiffany Broz
Date:		2023-10-14
Language:	SQL
Purpose:	This file will be used to create the database for my website, "Show Me That Cat!"

-----------------------------------------------------------------------------------------------
ChangeLog:
Who			When			What
----------- --------------- -------------------------------------------------------------------
TJB			2023-10-14		I decided to make two tables, cat_age and cat_gender. They were    
                            pretty simple tables with information already pre-defined inside, 
                            so I figured those were some easy ones to chip away at. 

                            ** I tried importing this file to DBeaver, and it kept getting hung
                            up over the drop database and it says it can't do it because there 
                            is no database. 

                            I was able to upload it fine into phpmyadmin and the tables showed
                            the data so I wasn't sure if it was something with DBeaver or if I 
                            did this wrong. 

TJB         2023-10-19      Fixed cat_age and cat_gender to auto increment primary keys. 
                            added new tables like cat_info, cat_breed, cat_colors with pre-defined
                            options

TJB         2023-10-26      Added 4 tables. personality_traits, physical_traits, 
                            assigned_personality_traits, and assigned_physical_traits. Gave 
                            the personality_traits/physical_traits tables 20 pre-determined 
                            answers each.
-----------------------------------------------------------------------------------------------
*/

    -- Drops the database if it exists
DROP DATABASE IF EXISTS show_me_that_cat;

    -- Create a new blank database
CREATE DATABASE show_me_that_cat;

    -- Uses the database to creat tables
USE show_me_that_cat;



    -- Creates cat_age table to store pre-defined age values with an auto-increment primary key
CREATE TABLE cat_age (
    ageID INT AUTO_INCREMENT PRIMARY KEY,
    age VARCHAR(255)
);
    -- Inserts "ageID" and "age" values into cat_age table
INSERT INTO cat_age (age) VALUES
("Kitten"),
("Adult"),
("Senior");



    -- Creates cat_gender table to store pre-defined gender values with an auto-increment primary key
CREATE TABLE cat_gender (
    genderID INT AUTO_INCREMENT PRIMARY KEY,
    gender VARCHAR(255)
);
    -- Inserts "genderID" and "gender" values into cat_gender table
INSERT INTO cat_gender (gender) VALUES
("Male"),
("Female"),
("Unknown");



    -- Creates cat_breed table to store pre-defined breed values with an auto-increment primary key
CREATE TABLE cat_breed (
    breedID INT AUTO_INCREMENT PRIMARY KEY,
    breed VARCHAR(255)
);
    -- Inserts "breedID" and "breed" values into cat_breed table
INSERT INTO cat_breed (breed) VALUES
("Mixed"),
("Unknown"),
("Abyssinian"),
("American Shorthair"),
("Bengal"),
("Birman"),
("British Shorthair"),
("Devon Rex"),
("Exotic Shorthair"),
("Maine Coon"),
("Manx"),
("Norwegian Forest Cat"),
("Oriental Shorthair"),
("Persian"),
("Ragdoll"),
("Russian Blue"),
("Scottish Fold"),
("Siamese"),
("Siberian"),
("Sphynx"),
("Turkish Van"),
("Balinese"),
("Burmese"),
("Cornish Rex"),
("Himalayan"),
("Tonkinese"),
("Ragamuffin");



    -- Creates cat_color table to store pre-defined color values with an auto-increment primary key
CREATE TABLE cat_color (
    colorID INT AUTO_INCREMENT PRIMARY KEY,
    color VARCHAR(255)
);
   -- Inserts "colorID" and "color" values into cat_color table
INSERT INTO cat_color (color) VALUES
("Black"),
("Black and White"),
("Black with White Bib and Paws"),
("Black with White Chest"),
("Black with White Face"),
("Black with White Feet"),
("Black with White Paws"),
("Black, White, and Grey Mix"),
("Black, White, and Orange Mix"),
("Brown"),
("Brown Tabby"),
("Brown with Black Spots"),
("Brown with Grey Stripes"),
("Brown with White Paws"),
("Calico"),
("Cream with Dark Ears, Face, Paws, and Tail"),
("Dilute Grey (Light Grey)"),
("Dilute Orange (Light Orange)"),
("Grey"),
("Grey and White"),
("Grey Stripes"),
("Grey with Black Stripes"),
("Grey with White Chest"),
("Grey with White Paws"),
("Mix of Black, Orange, and Brown"),
("Mix of Grey, Orange, and White"),
("Orange"),
("Orange and White"),
("Orange Tabby"),
("Orange with Black Stripes"),
("Orange with White Face"),
("Orange with White Paws"),
("Siamese"),
("Solid Black"),
("Solid Brown"),
("Solid Grey"),
("Solid Orange"),
("Solid White"),
("Spotted Tabby"),
("Striped (Ticked Tabby)"),
("Tortoiseshell (Tortie)"),
("White"),
("White with Black Spots"),
("White with Grey Spots"),
("White with Orange Spots");



    -- Creates cat_info table to store data from users with auto-increment primary key and foreign key references
CREATE TABLE cat_info (
    catID INT AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255),
    ageID INT,
    genderID INT,
    breedID INT,
    colorID INT,
    -- photo_file,
    -- passcodeID INT,
    FOREIGN KEY (ageID) REFERENCES cat_age(ageID),
    FOREIGN KEY (genderID) REFERENCES cat_gender(genderID),
    FOREIGN KEY (breedID) REFERENCES cat_breed(breedID),
    FOREIGN KEY (colorID) REFERENCES cat_color(colorID)
);



    -- 10/26/2023 Creates personality_traits table to store pre-defined personality traits with an auto-increment primary key
CREATE TABLE personality_traits (
    personalityID INT AUTO_INCREMENT PRIMARY KEY,
    personality VARCHAR(255)
);
   -- 10/26/2023 Inserts "personalityID" and "personality" values into personality_traits table
INSERT INTO personality_traits (personality) VALUES
("Loving"),
("Cuddly"),
("Aloof"),
("Independent"),
("Clingy"),
("Playful"),
("Grouchy"),
("Curious"),
("Shy"),
("Confident"),
("Timid"),
("Adventurous"),
("Energetic"),
("Lazy"),
("Talkative"),
("Reserved"),
("Social"),
("Proud"),
("Nurturing"),
("Mischievous");


    -- 10/26/2023 Creates physical_traits table to store pre-defined physical traits with an auto-increment primary key
CREATE TABLE physical_traits (
    physicalID INT AUTO_INCREMENT PRIMARY KEY,
    physical VARCHAR(255)
);
   -- 10/26/2023 Inserts "physicalID" and "physical" values into physical_traits table
INSERT INTO physical_traits (physical) VALUES
("Fluffy fur"),
("Short fur"),
("Long fur"),
("coarse fur"),
("soft fur"),
("curly fur"),
("No tail"),
("Bobtail (short tail)"),
("Hairless"),
("Tufted ears"),
("Folded ears"),
("Polydactyl (extra toes)"),
("Big paws"),
("Long whiskers"),
("Short whiskers"),
("Snub nose"),
("Muscular build"),
("Slender build"),
("Stocky build"),
("Heterochromia eyes");



    -- 10/26/2023 Creates assigned_personality table to store traits data from users with auto-increment primary key and foreign key references
CREATE TABLE assigned_personality_traits (
    assigned_personalityID INT AUTO_INCREMENT PRIMARY KEY,
    catID INT,
    personalityID INT,
    FOREIGN KEY (catID) REFERENCES cat_info(catID),
    FOREIGN KEY (personalityID) REFERENCES personality_traits(personalityID)
);


    -- 10/26/2023 Creates assigned_personality table to store traits data from users with auto-increment primary key and foreign key references
CREATE TABLE assigned_physical_traits (
    assigned_physicalID INT AUTO_INCREMENT PRIMARY KEY,
    catID INT,
    physicalID INT,
    FOREIGN KEY (catID) REFERENCES cat_info(catID),
    FOREIGN KEY (physicalID) REFERENCES physical_traits(physicalID)
);
