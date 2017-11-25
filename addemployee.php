<?php
session_start();
$dept = $_SESSION['DeptName'];
$min = 1;
$max = 2147483647;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Manager's View - Add an Employee</title>
</head>
<body>
  <h3> Adding an Employee into the <?php echo $dept ?> Department </h3>
  <form method="post">
    <label for="empid">Employee ID:</label>
    <input type="text" name="empid" id="empid" required><br>
    <label for="empname">Employee Name:</label>
    <input type="text" name="empname" id="empname" required><br>
    <label for="salary">Salary:</label>
    <input type="text" name="salary" id="salary" required><br>
    <input type="submit" value="Add Employee" name="submit">
  </form>
  <?php
  if (isset($_POST['submit'])) {
    $empid = $_POST['empid'];
    $empname = prepareInput($_POST['empname']);
    $salary = $_POST['salary'];
    $deptid = 0;
    if ($empname == ""){
      echo "Employee name is not valid.";
    }
    if(!filter_var($empid, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))){
      echo "Employee ID is not an integer greater than 0.";
    }
    if(!filter_var($salary, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))){
      echo "Employee ID is not an integer greater than 0.";
    }
    if(filter_var($empid, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) &&
    filter_var($salary, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))){
      $conn=oci_connect('apalania','B29red1322','//dbserver.engr.scu.edu/db11g');
      if(!$conn) {
        print "<br> connection failed:";
        exit;
      }
      $eid = "SELECT EmpId FROM Employees WHERE EmpId = '".$empid."'";
      $e = oci_parse($conn, $eid);
      oci_execute($e);
      if (($row = oci_fetch_array($e, OCI_BOTH)) != false) {
        echo "Employee ID ".$empid." has already been taken.";
        exit;
      }
      $q = "SELECT DeptID FROM Department WHERE DeptName = '".$dept."'";
      $query = oci_parse($conn, $q);
      oci_execute($query);
      if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
        $deptid = $row[0];
    	}
      $q2 = "Insert Into Employees(EmpID,EmpName,DeptId,Salary) values(:empid,:empname,:deptid,:salary)";
      $query2 = oci_parse($conn, $q2);
      oci_bind_by_name($query2, ':empid', $empid);
    	oci_bind_by_name($query2, ':empname', $empname);
    	oci_bind_by_name($query2, ':salary', $salary);
      oci_bind_by_name($query2, ':deptid', $deptid);
      $res = oci_execute($query2);
      if ($res)
        echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
      else{
        $e = oci_error($query);
        echo $e['message'];
      }
    }
  }
  ?>
</body>
</html>
<?php
function prepareInput($inputData){
  $inputData = trim($inputData);
  $inputData  = htmlspecialchars($inputData);
    return $inputData;
}
?>
