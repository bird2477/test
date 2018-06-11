<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['code']);
	$search_param = "%{$keyword}%";
	$query ="SELECT  `code` FROM `routing` WHERE `code` like '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["code"];
		}
		echo json_encode($countryResult);
	}
	
?>