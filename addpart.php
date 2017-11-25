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
    <title>Manager's View - Add a Part</title>
</head>
<body>
  <h3> Adding a Part into the <?php echo $dept ?> Department </h3>
  <form method="post">
    <label for="partid">PartID:</label>
    <input type="text" name="partid" id="partid" required><br>
    <label for="partname">Part Name:</label>
    <input type="text" name="partname" id="partname" required><br>
    <label for="qty">Quantity:</label>
    <input type="text" name="qty" id="qty" required><br>
    <label for="minqty">Minimum Quantity:</label>
    <input type="text" name="minqty" id="minqty" required><br>
    <label for="price">Price (enter a number):</label>
    <input type="text" name="price" id="price" required><br>
    <input type="submit" value="Add Part" name="submit">
  </form>
  <?php
  if (isset($_POST['submit'])) {
    $partid = $_POST['partid'];
    $partname = prepareInput($_POST['partname']);
    $qty = $_POST['qty'];
    $minqty = $_POST['minqty'];
    $price = $_POST['price'];
    $date = Date('Y-m-d');
    $deptid = 0;
    if ($partname == ""){
      echo "Part Name is not valid.";
    }
    if(!filter_var($partid, FILTER_VALIDATE_INT,$min, $max)){
      echo "PartID is not an integer greater than 0.";
    }
    if (!preg_match('/^\d+$/', $qty)) {
      echo "Quantity is not an integer";
    }
    if (!preg_match('/^\d+$/', $minqty)) {
      echo "Minimum quantity is not an integer";
    }
    if(!filter_var($price, FILTER_VALIDATE_INT,$min, $max)){
      echo "Price is not an integer greater than 0.";
    }
    if(filter_var($price, FILTER_VALIDATE_INT,$min,$max) && preg_match('/^\d+$/', $minqty) && preg_match('/^\d+$/', $qty) && filter_var($partid, FILTER_VALIDATE_INT,$min,$max)){
      $conn=oci_connect('apalania','B29red1322','//dbserver.engr.scu.edu/db11g');
      if(!$conn) {
        print "<br> connection failed:";
        exit;
      }
      $pid = "SELECT PartID FROM Inventory WHERE PartID = '".$partid."'";
      $p = oci_parse($conn, $pid);
      oci_execute($p);
      if (($row = oci_fetch_array($p, OCI_BOTH)) != false) {
        echo "PartID ".$partid." has already been taken.";
        exit;
      }
      $q = "SELECT DeptID FROM Department WHERE DeptName = '".$dept."'";
      $query = oci_parse($conn, $q);
      oci_execute($query);
      if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
        $deptid = $row[0];
    	}
      $q2 = "Insert Into Inventory(PartID,PartName,Qty,MinQty,Price,DeptID,Date_Checked) values(:partid,:partname,:qty,:minqty,:price,:deptid,trunc(sysdate))";
      $query2 = oci_parse($conn, $q2);
      oci_bind_by_name($query2, ':partid', $partid);
    	oci_bind_by_name($query2, ':partname', $partname);
    	oci_bind_by_name($query2, ':qty', $qty);
    	oci_bind_by_name($query2, ':minqty', $minqty);
      oci_bind_by_name($query2, ':price', $price);
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
