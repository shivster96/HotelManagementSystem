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
    <input type = "submit" name = "randparts" value = "Zero the Quantities of Random Parts">
    <br>
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
  <div id="buymore">
  <?php
    $buy = "SELECT PartName FROM Inventory WHERE qty < minqty";
    $mod = oci_parse($conn, $buy);
    oci_execute($mod);
    if (($row = oci_fetch_array($mod, OCI_BOTH)) != false) {
      ?>
      <form method="post">
        <p> There are some parts that are low in quantity. </h3>
        <input type="submit" name="buypart" value="Buy a New Part">
      </form>
      <?php
    }
    if (isset($_POST['buypart'])){
      header("Location: buypart.php");
      exit();
    }
    ?>
  </div>
  <br>

  <div id="container">
    <?php
      //connect to your database. Type in your username, password and the DB path
      $conn=oci_connect('apalania','', '//dbserver.engr.scu.edu/db11g');
      if(!$conn) {
        print "<br> connection failed";
        exit;
      }
      if (isset($_POST['randparts'])) {
        $q = "SELECT PartID FROM (SELECT PartID FROM Inventory ORDER BY DBMS_RANDOM.VALUE) WHERE ROWNUM <= 5";
        $query = oci_parse($conn, $q);
        oci_execute($query);
        $rand = array();
        while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
          array_push($rand, $row[0]);
        }
        $size = count($rand);
        for ($j = 0; $j < $size; $j++){
          $partid = $rand[$j];
          $update = oci_parse($conn, "UPDATE Inventory SET Qty = 0 WHERE PartID = :partid");
          oci_bind_by_name($update, ':partid', $partid);
          $res = oci_execute($update);
          if(!$res){
            $e = oci_error($update);
            echo $e['message'];
            break;
          }
        }
        echo '<br><br> <p style="color:green;font-size:20px"> Quantities of Random Parts are set to 0 </p>';
      }
      else if(isset($_POST['addemployee']) && isset($_POST['DeptName'])){
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
