<?php
$subproductionlineID=$_GET['subproductionlineID'];
$checksheetId=$_GET['checksheetId'];
$query="SELECT  `checksheet`.`date`,`subchecksheet`.`target`,`subchecksheet`.`actual_total`,`subchecksheet`.`free_total`,`subchecksheet`.`reject_total`
FROM  `checksheet` 
INNER JOIN `subchecksheet` ON  `subchecksheet`.`checksheet`=`checksheet`.`id` WHERE  `subchecksheet`.`checksheet` ='$checksheetId' and `subchecksheet`.`subproductionlineID` ='$subproductionlineID'";
?>
<style type="text/css">
    <!--

    body,td,th {
        font-family: Tahoma;
        font-size: 11px;

    }

    table { border-collapse:collapse;}
    .frame{ border: 1px solid black;	text-align: center; }
    .rec{ color:#0066ff; }

    -->
</style> 
<table border="0" align="center"  style="width: 650px; text-align: center;" class="frame"  >
    <thead>
        <tr class="frame">
            <th class="frame">Firstname</th>
            <th class="frame">Lastname</th>
            <th class="frame">Email</th>
        </tr>
    </thead>
    <tbody>
        <tr class="frame">
            <td class="frame">John</td>
            <td class="frame">Doe</td>
            <td class="frame">john@example.com</td>
        </tr>
       
    </tbody>
</table>