<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM ShopAreaMaster;";
    $ShopAreaList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $IsActive = 1;

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['ShopArea_Cd']) && !empty($_GET['ShopArea_Cd']))
        {

        $style = "style='display:none;'";
        $style1 = "style=''";
        $ShopArea_Cd = $_GET['ShopArea_Cd'];

        $query1 = "SELECT * FROM ShopAreaMaster WHERE ShopArea_Cd = $ShopArea_Cd;";
        $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
        $ShopArea_Cd = $EditList['ShopArea_Cd'];
        $ShopAreaName = $EditList['ShopAreaName'];
        $ShopAreaNameMar = $EditList['ShopAreaNameMar'];
        $TaxPercentage = $EditList['TaxPercentage'];
        $Remark = $EditList['Remark'];
        $IsActive = $EditList['IsActive'];

        }else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['ShopArea_Cd']) && !empty($_GET['ShopArea_Cd']))
        { 
            $ShopArea_Cd = $_GET['ShopArea_Cd'];
       
            $query1 = "UPDATE ShopAreaMaster SET IsActive = 0 WHERE ShopArea_Cd = $ShopArea_Cd;";
            $deleteShopArea = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=shop-area-master");
            
        }

?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create Shop Area</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Shop Area</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                    
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Shop Area Name * </label>
                                    <div class="controls"> 
                                        <input type="hidden" name="ShopArea_Cd" value="<?php if(isset($_GET['ShopArea_Cd'])) {echo $ShopArea_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="ShopArea Cd" required>
                                        <input type="text" name="shopAreaName" value="<?php if(isset($_GET['ShopArea_Cd'])) {echo $ShopAreaName;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Shop Area Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Shop Area Name (Marathi)</label>
                                    <div class="controls"> 
                                        <input type="text" name="shopAreaNameMar" value="<?php if(isset($_GET['ShopArea_Cd'])) {echo $ShopAreaNameMar;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Shop Area Name (Marathi)" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tax Percentage</label>
                                    <div class="controls"> 
                                        <input type="number" name="taxPercentage" value="<?php if(isset($_GET['ShopArea_Cd'])) {echo $TaxPercentage;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Tax Percentage" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <div class="controls"> 
                                        <input type="text" name="remark" value="<?php if(isset($_GET['ShopArea_Cd'])) {echo $Remark;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Remark" >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>IsActive * </label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="IsActive" >
                                        <option value="" selected disabled>--Select--</option>  
                                        <option <?php echo $IsActive == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                                        <option <?php echo $IsActive == '0' ? 'selected' : '' ; ?> value="0">No</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-3" style="margin-top: 30px;">
                                <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                            </div>

                            <div class="col-sm-6 col-md-2 col-lg-2 text-right" style="margin-top: 30px;">
                                <button type="button" id= "submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="ShopAreaMaster()">SAVE</button> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shop Area Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>Shop Area Name</th>
                                        <th>Shop Area Name (Marathi)</th>
                                        <th>Tax Percentage</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($ShopAreaList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["ShopAreaName"]; ?></td>
                                            <td><?php echo $value["ShopAreaNameMar"]; ?></td>
                                            <td><?php echo $value["TaxPercentage"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                           <td>
                                                <a href="home.php?p=shop-area-master&action=edit&ShopArea_Cd=<?php echo $value["ShopArea_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=shop-area-master&action=delete&ShopArea_Cd=<?php echo $value["ShopArea_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Shop Area Name</th>
                                        <th>Shop Area Name (Marathi)</th>
                                        <th>Tax Percentage</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


        