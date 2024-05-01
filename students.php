<?php

   include("_includes/config.inc");
   include("_includes/dbconnect.inc");
   include("_includes/functions.inc");


   // check logged in
   if (isset($_SESSION['id'])) {

      echo template("templates/partials/header.php");
      echo template("templates/partials/nav.php");

      // Build SQL statment that selects a student's modules
      //Rewrite query to student SELECT
      //$sql = "select * from studentmodules sm, module m where m.modulecode = sm.modulecode and sm.studentid = '" . $_SESSION['id'] ."';";
        $sql = "SELECT * FROM student";
      $result = mysqli_query($conn,$sql);

      // prepare page content
      $data['content'] .= "<table border='1'>";
      $data['content'] .= "<tr><th colspan='5' align='center'>Modules</th></tr>";
      $data['content'] .= "<tr><th>Student ID</th> <th>Password</th> <th>Date of Birth</th> <th>First Name</th> <th>Second Name</th> <th>House</th> <th>Town</th> <th>County</th> <th>Country</th> <th>Postcode</th> </tr>";
      // Display the modules within the html table
      while($row = mysqli_fetch_array($result)) {
        //Start of table
        $data['content'] .= "<tr>";
        //Student ID
        $data['content'] .= "<td> {$row["studentid"]} </td>";
        //Password
        $data['content'] .= "<td> {$row["passwords"]} </td>";
        //Date Of Birth
        $data['content'] .= "<td> {$row["dob"]} </td>";
        //First Name
        $data['content'] .= "<td> {$row["firstname"]} </td>";
        //Second Name
        $data['content'] .= "<td> {$row["secondname"]} </td>";
        //House
        $data['content'] .= "<td> {$row["house"]} </td>";
        //Town
        $data['content'] .= "<td> {$row["town"]} </td>";
        //County
        $data['content'] .= "<td> {$row["county"]} </td>";
        //Country
        $data['content'] .= "<td> {$row["contry"]} </td>";
        //Postcode
        $data['content'] .= "<td> {$row["postcode"]} </td>";
        //end of table
        $data['content'] .= "</tr>";
      }
      $data['content'] .= "</table>";

      // render the template
      echo template("templates/default.php", $data);

   } else {
      header("Location: index.php");
   }

   echo template("templates/partials/footer.php");

?>
