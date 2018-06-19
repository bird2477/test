<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['searchpartcode']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `partcode` FROM `routing` WHERE  `partcode` like '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["partcode"];
		}
		echo json_encode($countryResult);
	}
	
?>