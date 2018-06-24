<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['moldcode']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `moldcode`  FROM `mold` WHERE `moldcode` like  '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["moldcode"];
		}
		echo json_encode($countryResult);
	}
	
?>