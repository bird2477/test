<?php	
       include '../../../../config/database.php';

	$keyword = strval($_POST['lotno']);
	$search_param = "%{$keyword}%";
	$query ="SELECT `lotno` FROM `routing` WHERE  `lotno` like '$search_param'";
        $result= mysqli_query($connection, $query);
	
	if (mysqli_num_rows($result)>0) {
		while($row =  mysqli_fetch_assoc($result)) {
		$countryResult[] = $row["lotno"];
		}
		echo json_encode($countryResult);
	}
	
?>