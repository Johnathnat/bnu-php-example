<?php

    include("_includes/config.inc");
    include("_includes/dbconnect.inc");
    include("_includes/functions.inc");

    //Checks if logged in
    if (isset($_SESSION['id'])) {
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
            'postcodes' => array('RG40-7FG', 'MK18-1LP', 'OX26-0EU', 'GL53-7IQ', 'NN18 3ET')
        );

        // Loop to insert 5 student records
        for ($i = 1; $i <= 5; $i++) {
            $studentids = $studentData['studentids'][array_rand($studentData['studentids'])];
            $passwords = $studentData['passwords'][array_rand($studentData['passwords'])];
            $dobs = $studentData['dobs'][array_rand($studentData['dobs'])];
            $first_name = $studentData['first_names'][array_rand($studentData['first_names'])];
            $last_name = $studentData['last_names'][array_rand($studentData['last_names'])];
            $house = $studentData['houses'][array_rand($studentData['houses'])];
            $town = $studentData['towns'][array_rand($studentData['towns'])];
            $county = $studentData['counties'][array_rand($studentData['counties'])];
            $postcode = $studentData['postcodes'][array_rand($studentData['postcodes'])];

            // Build the SQL statement for inserting a new student
            $sql = "INSERT INTO student (studentid, password, dob, firstname, lastname, house, town, county, country, postcode)
                    VALUES ('$studentids', '$passwords', '$dobs', '$first_name', '$last_name', '$house', '$town', '$county', 'United Kingdom', '$postcode')";

            // Execute the query and handle errors
            $result = mysqli_query($conn, $sql);
        }
    }
?>