<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");



//Checks if logged in
//if (isset($_SESSION['id'])) {
    // Generate random data for student records
    $studentData = array(
        'studentids' => array('20123456', '20298765', '20345678', '20432109', '20567890'),
        'passwords' =>array('123456', 'password', 'qwerty', '111111', '1q2w3e'),
        'dobs' => array('1983-05-17', '2002-08-15', '1998-11-22', '1976-04-5', '2005-12-10'),
        'first_names' => array('Alice', 'Bob', 'Charlie', 'David', 'Eva'),
        'last_names' => array('Smith', 'Johnson', 'Brown', 'Lee', 'Garcia'),
        'houses' => array('Red House', 'Blue House', 'Green House', 'Yellow House', 'Purple House'),
        'towns' => array('Springfield', 'Riverside', 'Maplewood', 'Hillside', 'Oakville'),
        'counties' => array('Bershire', 'Buckinghamshire', 'Oxfordshire', 'Gloucestershire', 'Northamptonshire'),
        'postcodes' => array('RG40 7FG', 'MK18 1LP', 'OX26 0EU', 'GL53 7IQ', 'NN18 3ET'));

    // Loop to insert 5 student records
    for ($i = 0; $i < 5; $i++) 
    {
        $studentids = $studentData['studentids'][$i];
        $password = $studentData['passwords'][$i];
        $dobs = $studentData['dobs'][$i];
        $first_name = $studentData['first_names'][$i];
        $last_name = $studentData['last_names'][$i];
        $house = $studentData['houses'][$i];
        $town = $studentData['towns'][$i];
        $county = $studentData['counties'][$i];
        $postcode = $studentData['postcodes'][$i];

        // Build the SQL statement for inserting a new student
        $sql = "INSERT INTO student (studentid, passwords, dob, firstname, lastname, house, town, county, country, postcode) VALUES ('$studentids', '$password', '$dobs', '$first_name', '$last_name', '$house', '$town', '$county', 'United Kingdom', '$postcode')";
        

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Student record $i added successfully.<br>";
        } else {
            echo "Error adding student record $i: " . mysqli_error($conn) . "<br>";
        }
    }

//}
?>
