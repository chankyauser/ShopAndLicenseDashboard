<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM BusinessCategoryMaster;";
    $BusinessList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $IsActive = 1; 

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['BusinessCat_Cd']) && !empty($_GET['BusinessCat_Cd']))
        {
        
            $style = "style='display:none;'";
            $style1 = "style=''";
            $BusinessCat_Cd = $_GET['BusinessCat_Cd'];

            $query1 = "SELECT * FROM BusinessCategoryMaster WHERE BusinessCat_Cd = $BusinessCat_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $BusinessCat_Cd = $EditList['BusinessCat_Cd'];
            $BusinessCatName = $EditList['BusinessCatName'];
            $BusinessCatNameMar = $EditList['BusinessCatNameMar'];
            $TaxPercentage = $EditList['TaxPercentage'];
            $Remark = $EditList['Remark'];
            $IsActive = $EditList['IsActive'];

        }else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['BusinessCat_Cd']) && !empty($_GET['BusinessCat_Cd']))
        { 
        
            $BusinessCat_Cd = $_GET['BusinessCat_Cd'];
       
            $query1 = "UPDATE BusinessCategoryMaster SET IsActive = 0 WHERE BusinessCat_Cd = $BusinessCat_Cd;";
            $deleteCategory = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=business-category-master");

        }

?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create Business Category</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Business Category</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                    <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Category Name * </label>
                                        <div class="controls"> 
                                        <input type="hidden" name="BusinessCat_Cd" value="<?php if(isset($_GET['BusinessCat_Cd'])) {echo $BusinessCat_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Business Category Cd" required>
                                        <input type="text" name="businessCategoryName" value="<?php if(isset($_GET['BusinessCat_Cd'])) {echo $BusinessCatName;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Business Category Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Business Category Name (Marathi)</label>
                                        <div class="controls"> 
                                            <input type="text" name="businessCategoryNameMar" value="<?php if(isset($_GET['BusinessCat_Cd'])) {echo $BusinessCatNameMar;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Business Category Name (Marathi)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Tax Percentage</label>
                                        <div class="controls"> 
                                            <input type="number" name="taxPercentage" value="<?php if(isset($_GET['BusinessCat_Cd'])) {echo $TaxPercentage;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Tax Percentage" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="remark" value="<?php if(isset($_GET['BusinessCat_Cd'])) {echo $Remark;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Remark" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4 col-md-4 col-lg-2">
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

                                <div class="col-sm-4 col-md-4 col-lg-4" style="margin-top: 30px;">
                                        <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                        <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>

                                <div class="col-sm-4 col-md-2 col-lg-2 text-right" style="margin-top: 30px;">
                                    <button type="button" id= "submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="BusinessCategoryMaster()">SAVE</button>
                                        
                               </div>
                                
                            </div>
                        </form>
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
                    <h4 class="card-title">Business Category Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <!--   <p class="mt-1">Add <code>novalidate</code> attribute to form tag and <code>required</code> attribute to input tag.</p> -->
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                            <!-- <table  id="tblLoginDetailData" class="table"> -->
                                <thead>
                                     <tr>
                                        <th>Business Category Name</th>
                                        <th>Business Category Name (Marathi)</th>
                                        <th>Tax Percentage</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($BusinessList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["BusinessCatName"]; ?></td>
                                            <td><?php echo $value["BusinessCatNameMar"]; ?></td>
                                            <td><?php echo $value["TaxPercentage"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                            <td>
                                                <a href="home.php?p=business-category-master&action=edit&BusinessCat_Cd=<?php echo $value["BusinessCat_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=business-category-master&action=delete&BusinessCat_Cd=<?php echo $value["BusinessCat_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Business Category Name</th>
                                        <th>Business Category Name (Marathi)</th>
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


        