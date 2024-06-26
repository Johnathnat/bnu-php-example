<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

function handleImageUpload($fileInputName, $targetDirectory, $maxSize = 2097152) {
    // Check if the file was uploaded successfully
    if (!isset($_FILES[$fileInputName])) {
        return "No file uploaded.";
    }

    $imageFile = $_FILES[$fileInputName];

    // Set acceptable file types (MIME types)
    $acceptableTypes = ['image/jpeg', 'image/png', 'image/gif'];

    // Check file size
    if ($imageFile['size'] > $maxSize) {
        return "File too large. Please upload an image smaller than 2MB.";
    }

    // Check file type
    if (!in_array($imageFile['type'], $acceptableTypes)) {
        return "Invalid file type. Only JPG, PNG, and GIF types are accepted.";
    }

    // Generate a unique filename (you can customize this part)
    $targetFile = $targetDirectory . uniqid() . '_' . basename($imageFile['name']);

    // Move the uploaded file to the desired location
    if (move_uploaded_file($imageFile['tmp_name'], $targetFile)) {
        // File uploaded successfully
        return $targetFile; // Return the saved file path
    } else {
        return "Error moving uploaded image.";
    }
}

// Display the form initially
function displayForm() {
    echo <<<EOD
    <h2>Add New Student</h2>
    <form enctype="multipart/form-data" name="frmdetails" action="" method="post">
        Student ID:
        <input name="txtstudentid" type="text" value="" /><br/>
        First Name:
        <input name="txtfirstname" type="text" value="" /><br/>
        Last Name:
        <input name="txtlastname" type="text" value="" /><br/>
        Date of Birth:
        <input name="dob" type="date" /><br/>
        ID Image:
        <input type="file" name="student_image" accept="image/*" /><br/> <!-- Add this line for image upload -->
        Number and Street:
        <input name="txthouse" type="text" value="" /><br/>
        Town:
        <input name="txttown" type="text" value="" /><br/>
        County:
        <input name="txtcounty" type="text" value="" /><br/>
        Country:
        <input name="txtcountry" type="text" value="" /><br/>
        Postcode:
        <input name="txtpostcode" type="text" value="" /><br/>
        Password:
        <input name="txtpassword" type="password" value="" /><br/>
        <input type="submit" value="Save" name="submit"/>
    </form>
    EOD;
}

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // If the form has been submitted
    if (isset($_POST['submit'])) {
        // Validate and sanitize input data
        $studentId = mysqli_real_escape_string($conn, $_POST['txtstudentid']);
        $firstName = mysqli_real_escape_string($conn, $_POST['txtfirstname']);
        $lastName = mysqli_real_escape_string($conn, $_POST['txtlastname']);
        $house = mysqli_real_escape_string($conn, $_POST['txthouse']);
        $town = mysqli_real_escape_string($conn, $_POST['txttown']);
        $county = mysqli_real_escape_string($conn, $_POST['txtcounty']);
        $country = mysqli_real_escape_string($conn, $_POST['txtcountry']);
        $postcode = mysqli_real_escape_string($conn, $_POST['txtpostcode']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);

        // Handle the uploaded image
        if (isset($_FILES['student_image'])) {
            $target_file = handleImageUpload('student_image', '_includes/uploads');
            if (is_string($target_file)) {
                // Handle error (display message or log it)
                echo $target_file;
            } else {
                // Image uploaded successfully
                // Save $target_file path in your database
            }
        }

        // Hash the password securely (using bcrypt)
        $password = password_hash($_POST['txtpassword'], PASSWORD_BCRYPT);

        // Check if the student ID already exists
        $existingStudentQuery = "SELECT studentid FROM student WHERE studentid = '$studentId'";
        $existingStudentResult = mysqli_query($conn, $existingStudentQuery);
        if (mysqli_num_rows($existingStudentResult) > 0) {
            // Duplicate student ID found, prompt user to try again
            echo "<p>Duplicate student ID. Please try again.</p>";
            displayForm();
        } else {
            // Insert the student record into the database
            $sql = "INSERT INTO student (studentid, password, firstname, lastname, house, town, county, country, postcode, dob, photoid) 
                    VALUES ('$studentId', '$password', '$firstName', '$lastName', '$house', '$town', '$county', '$country', '$postcode', '$dob', '$target_file')";
            $result = mysqli_query($conn, $sql);
            echo "<p>Your student record has been added</p>";
        }
    } else {
        displayForm();
    }

    // Render the template
    echo template("templates/default.php", $data);
} else {
    // Redirect to the login page
    header("Location: index.php");
    exit; // Ensure that no further code execution occurs
}
echo template("templates/partials/footer.php");
?>
