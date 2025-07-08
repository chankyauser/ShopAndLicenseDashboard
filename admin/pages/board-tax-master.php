<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM BoardTaxMaster;";
    $BoardList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $IsActive = 1;

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['BTM_Cd']) && !empty($_GET['BTM_Cd']))
        {
        
            $style = "style='display:none;'";
            $style1 = "style=''";
            $BTM_Cd = $_GET['BTM_Cd'];

            $query1 = "SELECT * FROM BoardTaxMaster WHERE BTM_Cd = $BTM_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $BTM_Cd = $EditList['BTM_Cd'];
            $BTM_Type = $EditList['BTM_Type'];
            $Height = $EditList['Height'];
            $Width = $EditList['Width'];
            $BAreaWiseTax = $EditList['BAreaWiseTax'];
            $IsActive = $EditList['IsActive'];

        }else  if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['BTM_Cd']) && !empty($_GET['BTM_Cd']))
        { 
        
            $BTM_Cd = $_GET['BTM_Cd'];
       
            $query1 = "UPDATE BoardTaxMaster SET IsActive = 0 WHERE BTM_Cd = $BTM_Cd;";
            $deleteBoard = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=board-tax-master");
        }

?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create Board Tax</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Board Tax</h4>
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
                                    <label>BTM Type *</label>
                                    <div class="controls"> 
                                    <input type="hidden" name="BTM_Cd" value="<?php if(isset($_GET['BTM_Cd'])) {echo $BTM_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="BTM Cd" required>
                        
                                    <input type="text" name="Btm_Type" value="<?php if(isset($_GET['BTM_Cd'])) {echo $BTM_Type;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="BTM Type" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Board Height *</label>
                                    <div class="controls"> 
                                        <input type="number" name="boardHeight" value="<?php if(isset($_GET['BTM_Cd'])) {echo $Height;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Board Height" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Board Width *</label>
                                    <div class="controls"> 
                                        <input type="number" name="boardWidth" value="<?php if(isset($_GET['BTM_Cd'])) {echo $Width;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Board Width" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Board Area wise Tax *</label>
                                    <div class="controls"> 
                                        <input type="number" name="boardAreaWiseTax" value="<?php if(isset($_GET['BTM_Cd'])) {echo $BAreaWiseTax;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Board Area wise Tax" >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>IsActive *</label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="IsActive" >
                                        <option value="" >--Select--</option>    
                                        <option <?php echo $IsActive == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                                        <option <?php echo $IsActive == '0' ? 'selected' : '' ; ?> value="0">No</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 30px;">
                                <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-3 text-right" style="margin-top: 30px;">
                                <button type="button" id="submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="BoardTaxMaster()">SAVE</button>
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
                    <h4 class="card-title">Board Tax Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>BTM Type</th>
                                        <th>Board Height</th>
                                        <th>Board Width</th>
                                        <th>Board Area wise Tax</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($BoardList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["BTM_Type"]; ?></td>
                                            <td><?php echo $value["Height"]; ?></td>
                                            <td><?php echo $value["Width"]; ?></td>
                                            <td><?php echo $value["BAreaWiseTax"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                            <td>
                                                <a href="home.php?p=board-tax-master&action=edit&BTM_Cd=<?php echo $value["BTM_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=board-tax-master&action=delete&BTM_Cd=<?php echo $value["BTM_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>BTM Type</th>
                                        <th>Board Height</th>
                                        <th>Board Width</th>
                                        <th>Board Area wise Tax</th>
                                        <th>Is Active</th>
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
        