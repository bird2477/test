<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['companynameEN']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `companynameEN` FROM `customer` WHERE `companynameEN` like  '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["companynameEN"];
		}
		echo json_encode($countryResult);
	}
	
?>