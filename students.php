<?php
// Include configuration and database connection
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    // Build SQL statement to select student information
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);

    // Prepare page content
    $tableContent = "<table style='float: left; margin-left: 1%;' border='1'>";
    $tableContent .= "<tr><th>Student ID</th><th>Password</th><th>Date of Birth</th><th>First Name</th><th>Last Name</th><th>House</th><th>Town</th><th>County</th><th>Country</th><th>Postcode</th><th>Photo</th><th>Select</th></tr>";
    $tableContent .= "<form action='deletestudents.php' method='POST'>";
    
    // Display student information within the HTML table
    while ($row = mysqli_fetch_array($result)) {
        $tableContent .= "<tr>";
        $tableContent .= "<td>{$row['studentid']}</td>";
        $tableContent .= "<td>{$row['password']}</td>";
        $tableContent .= "<td>{$row['dob']}</td>";
        $tableContent .= "<td>{$row['firstname']}</td>";
        $tableContent .= "<td>{$row['lastname']}</td>";
        $tableContent .= "<td>{$row['house']}</td>";
        $tableContent .= "<td>{$row['town']}</td>";
        $tableContent .= "<td>{$row['county']}</td>";
        $tableContent .= "<td>{$row['country']}</td>"; 
        $tableContent .= "<td>{$row['postcode']}</td>";
        $tableContent .= "<td><img src='{$row['photoid']}' alt='Student Photo' width='100'></td>"; // Display the photo
        $tableContent .= "<td><input type='checkbox' name='students[]' value='{$row['studentid']}'></td>";

        $tableContent .= "</tr>";
    }

    $tableContent .= "</table>";

    // Add a delete button to delete selected rows
    $tableContent .= "<input type='submit' name='deletebtn' value='Delete' />";
    $tableContent .= "</form>";

    // Render the template 
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");
    echo "<style>
        body {
            margin-left: 10px;
            color: black;
            background: white;
        }
        th, td {
            text-align: center;
            padding: 5px;
        }
        tr:hover {
            background-color: #D6EEEE;
        }
    </style>";
    echo $tableContent;
    echo template("templates/partials/footer.php");
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
}
?>
