<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['searchpartname']);
	$search_param = "%{$keyword}%";
	$query ="SELECT  `partname` FROM `routing` WHERE `partname` like '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["partname"];
		}
		echo json_encode($countryResult);
	}
	
?>