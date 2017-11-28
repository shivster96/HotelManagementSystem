/** Login **/
//Existing
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // collect input data

	// Get the custid
     $id = $_POST['Customer ID'];
  // Request password
     $password = $_POST['Password'];

     if (!empty($id)){
    $id= prepareInput($id);
     }
     if (!empty($password)){
   $password = prepareInput($password);
     }

	// into Customer table

	checktier($id,$password);


}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}
  //Access rewards
function checktier($id,$password){
	//connect to your database. Type in your username, password and the DB path
$conn=oci_connect( /* insert login details */ );
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	$query = oci_parse($conn, "Select tier from rewards natural join customer where custid = :id AND password = :password");
// Need to add if statements on the value of tier
  if($query = 1){
    echo file_get_contents("useRewards1.html");
  }
  if($query = 2){
    echo file_get_contents("useRewards2.html");
  }
  if($query = 3){
    echo file_get_contents("useRewards3.html");
  }
//Provide Radio Buttons to change variables inserted
	// Execute the query
	$res = oci_execute($query);
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
	else{
		$e = oci_error($query);
        	echo $e['Id and password do not match or we fucked up'];
	}
	OCILogoff($conn);
}


?>
