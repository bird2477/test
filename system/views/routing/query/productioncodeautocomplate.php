<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['product']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `productioncode` FROM `mold` WHERE  `productioncode` like  '$search_param'";
       
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["productioncode"];
		}
		echo json_encode($countryResult);
	}
	
?>