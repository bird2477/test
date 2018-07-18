<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
?>
<script >
    $(document).ready(function () {
        $(".remove").click(function () {
            
          
            var id = "id=" + $(this).attr("id");
            $.ajax({data: id, url: "views/managementmachine/query/ajaxRemore.php",type: 'POST' ,cache: false, success: function (data, textStatus, jqXHR) {
                
            if(data== 1){
                         window. location.replace("?fragment=managementmachine&component=lineproduction"); 
                       }
                }});

        });

        $("#productionlineadd").click(function () {
            var name = "name=" + $("#nameline").val();
            if(name=="name="){
               alert("กรุณาใส่ค่าให้ครับ");
            }else{
                
           
            
            $.ajax({data: name, url: "views/managementmachine/query/ajaxAddProductionLine.php", type: 'POST', cache: false, success: function (data, textStatus, jqXHR) {
                    if (data != "") {
                        window.location.replace("./views/managementmachine/views/subproductionline.php?id="+data);
                    }
                }});
             }
            
        });

        $("#searchname").change(function () {

            var id = $("#searchname").val();
            window.location.replace("?fragment=managementmachine&component=lineproduction&id=" + id);
        });
    });
</script>

<div class="row" >
    <table style="width: 100%;" >
        <tr>
            <td ></td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#linemachine">
                    Production Line +
                </button>   
            </td>
        </tr>
    </table>
</div>



<div class="row" style="background: buttonhighlight;" >
    <div class="col-md-5 mb-3">
        <label for="searchname">Production Line</label>          
        <select name="searchname" class="custom-select d-block w-100 " id="searchname" required="">
            <option value="">Choose...</option>
            <?php
            $query = "SELECT * FROM `productionline` WHERE 1";
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
            <option  <?php if($id==$row['id']) {     echo 'selected'; }  ?> value="<?php echo $row['id']; ?>"><?php echo $row['machine']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>


</div>
<div class="row">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($id != "") {

                $query = "SELECT * FROM `productionline` WHERE `id` like '$id'";
                $result = mysqli_query($connection, $query);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row1['id']; ?></td>
                        <td><?php echo $row1['machine']; ?></td>
                        <td>
                            <a href="./views/managementmachine/views/subproductionline.php?id=<?php echo $row1['id']; ?>"  class="btn btn-success " >Sub station</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row1['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                }
            } else {
                 $query = "SELECT * FROM `productionline` WHERE 1 order by  `machine` ";
                $result = mysqli_query($connection, $query);
                if(mysqli_num_rows($result)>0){
                    while ($row2 = mysqli_fetch_array($result)) {
                
                    ?>
                       <tr>
                        <td><?php echo $row2['id']; ?></td>
                        <td><?php echo $row2['machine']; ?></td>
                        <td>
                            <a href="./views/managementmachine/views/subproductionline.php?id=<?php echo $row2['id']; ?>"  class="btn btn-success " >Sub station</a>
                            <button type="button" class="btn btn-danger remove" id="<?php echo $row2['id']; ?>">
                                Remove
                            </button>   
                        </td>
                    </tr>
                    <?php
                    }
                }else{
                    
                ?>
                <tr style="text-align: center;">
                    <td colspan="3"> No data</td>

                </tr>
            <?php
            
                }
            
                } ?>
        </tbody>
    </table>
</div>




<div id="linemachine" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Production Line 
            </div>
            <div class="modal-body">
                <label for="name">Production Line</label>

                <div class="input-group ">
                    <input type="text" class="form-control " id="nameline" name="nameline" placeholder="Name Line" required="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="productionlineadd" class="btn btn-default" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>