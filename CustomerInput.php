
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // collect input data

	// Get the custname
     $name = $_POST['Name'];

	// Get the custid
     //$id = $_POST['Customer ID'];
  // Request password
     $password = $_POST['Password'];

     if (!empty($name)){
		$name = prepareInput($name);
     }
		$id = rand; //Need to run trigger to make sure that id does not already exist in the table
   $password = prepareInput($password);

	// into Customer table

	insertCustomerIntoDB($id,$name,$password);


}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}
function insertCustomerIntoDB($id,$name,$password){
	//connect to your database. Type in your username, password and the DB path
$conn=oci_connect( /* insert login details */ );
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	$query = oci_parse($conn, "Insert Into Customer values(:id,upper(:name),password");

	oci_bind_by_name($query, ':custid', $id);
	oci_bind_by_name($query, ':custname', $name);
  oci_bind_by_name($query, ':password', $password);

	// Execute the query
	$res = oci_execute($query);
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query);
        	echo $e['message'];
	}
	OCILogoff($conn);
}


?>
