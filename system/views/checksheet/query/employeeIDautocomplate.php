<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['employeeID']);
	$name = strval($_POST['name']);
	$search_param = "%{$keyword}%";
	$query ="SELECT * FROM `users` WHERE `employeeID` like '$search_param' and `name`like '$name'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["employeeID"];
		}
		echo json_encode($countryResult);
	}
	
?>