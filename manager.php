<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Manager's View</title>
</head>
<body>
  <h3> What would you like to do? </h3>
  <form method="post">
    <select name="DeptName" required>
      <option selected disabled> Select a Department </option>
      <?php
      $conn=oci_connect('apalania','', '//dbserver.engr.scu.edu/db11g');
      if($conn) {
        $query = oci_parse($conn, "SELECT DeptName FROM Department");
        oci_execute($query);
        while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
          echo "<option value =".$row[0].">".$row[0]."</option>";
        }
      }
      ?>
      <input style = "margin-left: 0.4%;" type="submit" name="viewemployees" value="View Employees" />
      <input type="submit" name="addemployee" value="Add a New Employee" />
      <input type="submit" name="viewinventory" value="View Hotel Inventory" />
      <input type="submit" name="addpart" value="Add a New Part" />
    </select>
  </form>
  <br>
  <br>
  <div class="container">
    <?php
      //connect to your database. Type in your username, password and the DB path
      $conn=oci_connect('apalania','', '//dbserver.engr.scu.edu/db11g');
      if(!$conn) {
        print "<br> connection failed";
        exit;
      }
      if(isset($_POST['addemployee']) && isset($_POST['DeptName'])){
        $_SESSION['DeptName'] = $_POST['DeptName'];
        header("Location: addemployee.php");
        exit();
      }
      elseif (isset($_POST['addpart']) && isset($_POST['DeptName'])) {
        $_SESSION['DeptName'] = $_POST['DeptName'];
        header("Location: addpart.php");
        exit();
      }
      elseif (isset($_POST['viewemployees']) && isset($_POST['DeptName'])) {
        $dept = $_POST['DeptName'];
        $q = "SELECT EmpName, Salary FROM Employees, Department WHERE Employees.DeptID = Department.DeptID and DeptName = '".$dept."'";
        $query = oci_parse($conn, $q);
        oci_execute($query);
        echo "<h3> Employees from ".$dept." Department </h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th> Employee Name </th>";
        echo "<th> Salary </th>";
        while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
          echo "<tr>";
          echo "<td> $row[0] </td>";
          echo "<td> $row[1] </td>";
          echo "</tr>";
        }
        echo "</table>";
      } else if (isset($_POST['viewinventory']) && isset($_POST['DeptName'])) {
        $dept = $_POST['DeptName'];
        $q = "SELECT PartName, Qty FROM Inventory, Department WHERE Inventory.DeptID = Department.DeptID and DeptName = '".$dept."'";
        $query = oci_parse($conn, $q);
        oci_execute($query);
        echo "<h3> Inventory for ".$dept." Department </h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th> Part Name </th>";
        echo "<th> Quantity </th>";
        while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
          echo "<tr>";
          echo "<td> $row[0] </td>";
          echo "<td> $row[1] </td>";
          echo "</tr>";
        }
        echo "<table>";
      } else {
        echo "No request selected.";
      }
      OCILogoff($conn);
    ?>
  </div>
</body>
</html>
