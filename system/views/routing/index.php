<?php
$component = isset($_GET['component']) ? $_GET['component'] : "lineproduction";
$query = "SELECT * FROM `component` WHERE `projectfragment` like '$fragment' and `fragment` like '$component'";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

include $row['path'];
?>