<?php

include '../../../../config/database.php';
$step = $_POST['step'];
$id = $_POST['id'];
$partname = $_POST['partname'];
$partcode = $_POST['partcode'];
$productioncode = $_POST['productioncode'];
$listsubproductionline_id = $_POST['listsubproductionline_id'];
$productionline = $_POST['productionline'];
$subproductionline = $_POST['subproductionline'];
$query = "SELECT * FROM `listsubproductionline` WHERE `id` ='$listsubproductionline_id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
$json = $row['json'];
$data = array();
if ($json == "") {
    $array = array();
    $array['productionline'] = $productionline;
    $array['subproductionline'] = $subproductionline;
    $data[0] = $array;
    $json = json_encode($data);
   
} else {
    $data = json_decode($json, TRUE);
    $array = array();
    $array['productionline'] = $productionline;
    $array['subproductionline'] = $subproductionline;
   
    $data[sizeof($data)] = $array;
  
    $json = json_encode($data);
    
}
 $query = "UPDATE `listsubproductionline` SET `json`='$json' WHERE `id`='$listsubproductionline_id'";
mysqli_query($connection, $query);
?>
<script >
    window.location.replace("../views/subrouting.php?id=<?php echo $id; ?>&lotno=<?php echo $_POST['lotno']; ?>&target=<?php echo  $_POST['target'] ?>");
</script>