<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['companynameTH']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `companynameTH` FROM `customer` WHERE `companynameTH` like  '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["companynameTH"];
		}
		echo json_encode($countryResult);
	}
	
?>