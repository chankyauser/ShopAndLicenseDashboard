<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM CallingCategoryMaster ORDER By SrNo;";
    $CallingCategoryList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $Calling_Type = ""; 
    $QC_Type = ""; 
    $IsActive = 1; 

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['Calling_Category_Cd']) && !empty($_GET['Calling_Category_Cd']))
        {
        
            $style = "style='display:none;'";
            $style1 = "style=''";
            $Calling_Category_Cd = $_GET['Calling_Category_Cd'];

            $query1 = "SELECT * FROM CallingCategoryMaster WHERE Calling_Category_Cd = $Calling_Category_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $Calling_Category_Cd = $EditList['Calling_Category_Cd'];
            $Calling_Category = $EditList['Calling_Category'];
            $Calling_Type = $EditList['Calling_Type'];
            $SrNo = $EditList['SrNo'];
            $Type_SrNo = $EditList['Type_SrNo'];
            $QC_Type = $EditList['QC_Type'];
            $Remark = $EditList['Remark'];
            $IsActive = $EditList['IsActive'];

        } else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['Calling_Category_Cd']) && !empty($_GET['Calling_Category_Cd']))
        { 
            $Calling_Category_Cd = $_GET['Calling_Category_Cd'];
       
            $query1 = "UPDATE CallingCategoryMaster SET IsActive = 0 WHERE Calling_Category_Cd = $Calling_Category_Cd;";
            $deleteCategory = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=calling-category-master");
        }

?>
<section id="calling-category-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" <?php echo $style;?>>Create Calling Category</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Calling Category</h4>
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
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Calling Category Name *</label>
                                        <div class="controls"> 
                                            <input type="hidden" name="Calling_Category_Cd" value="<?php if(isset($_GET['Calling_Category_Cd'])) {echo $Calling_Category_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Calling Category Cd">
                                            <input type="text" name="callingCategory" value="<?php if(isset($_GET['Calling_Category_Cd'])) {echo $Calling_Category;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Calling Category Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Category Sr.No. *</label>
                                        <div class="controls"> 
                                            <input type="number" name="srNo" value="<?php if(isset($_GET['Calling_Category_Cd'])) {echo $SrNo;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Sr.No." >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Calling Type *</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="callingType" >
                                            <option value="" selected disabled>--Select--</option>    
                                            <option <?php echo $Calling_Type == 'Survey' ? 'selected' : '' ; ?> value="Survey">Survey</option>
                                            <option <?php echo $Calling_Type == 'Calling' ? 'selected' : '' ; ?> value="Calling">Calling</option>
                                            <option <?php echo $Calling_Type == 'Collection' ? 'selected' : '' ; ?> value="Collection">Collection</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                              
                                
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Calling Type Sr.No. *</label>
                                        <div class="controls"> 
                                            <input type="number" name="callingTypeSrNo" value="<?php if(isset($_GET['Calling_Category_Cd'])) {echo $Type_SrNo;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Calling Type Sr.No." >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>QC Type *</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="qcType" >
                                            <option value="" selected disabled>--Select--</option>    
                                            <option <?php echo $QC_Type == 'ShopSurvey' ? 'selected' : '' ; ?> value="ShopSurvey">Shop Survey</option>
                                            <option <?php echo $QC_Type == 'ShopDocument' ? 'selected' : '' ; ?> value="Shop Document">ShopDocument</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="remark" value="<?php if(isset($_GET['Calling_Category_Cd'])) {echo $Remark;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Remark" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>IsActive *</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="IsActive" >
                                            <option value="" selected disabled>--Select--</option>    
                                            <option <?php echo $IsActive == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                                            <option <?php echo $IsActive == '0' ? 'selected' : '' ; ?> value="0">No</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2 col-lg-2" style="margin-top: 30px;">
                                    <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>
                                <div class="col-sm-6 col-md-2 col-lg-2 text-right" style="margin-top: 30px;">
                                    <button type="submit" id= "submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="CallingCategoryMaster()">SAVE</button>
                                    
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
                    <h4 class="card-title">Calling Category Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>Calling Category Sr No</th>
                                        <th>Calling Category</th>
                                        <th>Calling Type Sr No</th>
                                        <th>Calling Type</th>
                                        <th>QC Type</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($CallingCategoryList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["SrNo"]; ?></td>
                                            <td><?php echo $value["Calling_Category"]; ?></td>
                                            <td><?php echo $value["Type_SrNo"]; ?></td>
                                            <td><?php echo $value["Calling_Type"]; ?></td>
                                            <td><?php echo $value["QC_Type"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                           <td>
                                                <a href="home.php?p=calling-category-master&action=edit&Calling_Category_Cd=<?php echo $value["Calling_Category_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=calling-category-master&action=delete&Calling_Category_Cd=<?php echo $value["Calling_Category_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Calling Category</th>
                                        <th>Calling Category Sr No</th>
                                        <th>Calling Type</th>
                                        <th>Calling Type Sr No</th>
                                        <th>QC Type</th>
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



        