<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['search_param']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `name`  FROM `customer` WHERE `name` like  '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["name"];
		
		}
		echo json_encode($countryResult);
	}
	
?>