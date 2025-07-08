<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM DropDownMaster;";
    $DropDownList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $IsActive = 1;
        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['DropDown_Cd']) && !empty($_GET['DropDown_Cd']))
        {

            $style = "style='display:none;'";
            $style1 = "style=''";
            $DropDown_Cd = $_GET['DropDown_Cd'];

            $query1 = "SELECT * FROM DropDownMaster WHERE DropDown_Cd = $DropDown_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $DropDown_Cd = $EditList['DropDown_Cd'];
            $DTitle = $EditList['DTitle'];
            $DValue = $EditList['DValue'];
            $SerialNo = $EditList['SerialNo'];
            $Remark = $EditList['Remark'];
            $IsActive = $EditList['IsActive'];

        }else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['DropDown_Cd']) && !empty($_GET['DropDown_Cd']))
        { 
        
            $DropDown_Cd = $_GET['DropDown_Cd'];
       
            $query1 = "UPDATE DropDownMaster SET IsActive = 0 WHERE DropDown_Cd = $DropDown_Cd;";
            $deleteDropDown = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=drop-down-master");

        }

?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create DropDown</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit DropDown</h4>
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
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>DTitle *</label>
                                        <div class="controls"> 
                                          <input type="hidden" name="DropDown_Cd" value="<?php if(isset($_GET['DropDown_Cd'])) {echo $DropDown_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="DropDown Cd" required>
                                          <input type="text" name="DTitle" value="<?php if(isset($_GET['DropDown_Cd'])) {echo $DTitle;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="DTitle">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>DValue *</label>
                                        <div class="controls"> 
                                            <input type="text" name="DValue" value="<?php if(isset($_GET['DropDown_Cd'])) {echo $DValue;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="DValue" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>SerialNo *</label>
                                        <div class="controls"> 
                                            <input type="number" name="SerialNo" value="<?php if(isset($_GET['DropDown_Cd'])) {echo $SerialNo;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="SerialNo" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="remark" value="<?php if(isset($_GET['DropDown_Cd'])) {echo $Remark;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Remark" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4 col-md-3 col-lg-3">
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

                                <div class="col-sm-4 col-md-3 col-lg-3 text-right"  style="margin-top: 30px;">
                                    <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>

                                <div class="col-sm-4 col-md-3 col-lg-3 text-right"  style="margin-top: 30px;">
                                    <button type="button" id= "submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="DropDownMaster()">SAVE</button>
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
                    <h4 class="card-title">DropDown Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <!--   <p class="mt-1">Add <code>novalidate</code> attribute to form tag and <code>required</code> attribute to input tag.</p> -->
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                            <!-- <table  id="tblLoginDetailData" class="table"> -->
                                <thead>
                                     <tr>
                                        <th>DTitle</th>
                                        <th>DValue</th>
                                        <th>Serial No</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($DropDownList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["DTitle"]; ?></td>
                                            <td><?php echo $value["DValue"]; ?></td>
                                            <td><?php echo $value["SerialNo"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                            <td>
                                                <a href="home.php?p=drop-down-master&action=edit&DropDown_Cd=<?php echo $value["DropDown_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=drop-down-master&action=delete&DropDown_Cd=<?php echo $value["DropDown_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>DTitle</th>
                                        <th>DValue</th>
                                        <th>Serial No</th>
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


        