<?php
// Include configuration and database connection
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    if (isset($_POST['students']) && is_array($_POST['students'])) {
        // Loop over the selected student IDs
        foreach ($_POST['students'] as $studentID) {
            // Build SQL query to delete the student
            $sql = "DELETE FROM student WHERE studentid = '$studentID'";
            if (mysqli_query($conn, $sql)) {
                // Student deleted successfully
                echo "Student with ID $studentID deleted successfully.<br>";
            } else {
                // Error deleting student
                echo "Error deleting student with ID $studentID: " . mysqli_error($conn) . "<br>";
            }
        }
    } else {
        echo "No students selected for deletion.<br>";
    }

    // Redirect back to the students page
    header("Location: students.php");
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
}
?>
