<?php
    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM FAQMaster;";
    $FAQList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $UserType = "";
    $IsActive = 1;

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['FAQ_Cd']) && !empty($_GET['FAQ_Cd']))
        { 
        
            $style = "style='display:none;'";
            $style1 = "style=''";
            $FAQ_Cd = $_GET['FAQ_Cd'];

            $query1 = "SELECT * FROM FAQMaster WHERE FAQ_Cd = $FAQ_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $FAQ_Cd = $EditList['FAQ_Cd'];
            $Question = $EditList['Question'];
            $Answer = $EditList['Answer'];
            $UserType = $EditList['UserType'];
            $Remark = $EditList['Remark'];
            $IsActive = $EditList['IsActive'];

        }else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['FAQ_Cd']) && !empty($_GET['FAQ_Cd']))
        { 
            $FAQ_Cd = $_GET['FAQ_Cd'];
       
            $query1 = "UPDATE FAQMaster SET IsActive = 0 WHERE FAQ_Cd = $FAQ_Cd;";
            $deleteRecord = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=faq-master");
        }
?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                    <h4 class="card-title" <?php echo $style;?>>Create FAQ</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit FAQ</h4>
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
                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <div class="form-group">
                                    <label>Question *</label>
                                    <div class="controls"> 
                                        <input type="hidden" name="FAQ_Cd" value="<?php if(isset($_GET['FAQ_Cd'])) {echo $FAQ_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="FAQ Cd" required>
                                        <input type="text" name="question" value="<?php if(isset($_GET['FAQ_Cd'])) {echo $Question;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Question" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>User Type *</label>
                                    <div class="controls"> 
                                        <select class="select2 form-control" name="usertype" required>
                                            <option value="">--Select--</option>   
                                            <option <?php echo $UserType == 'Admin' ? 'selected' : '' ; ?> value="Admin">Admin</option>
                                            <option <?php echo $UserType == 'Calling' ? 'selected' : '' ; ?> value="Calling">Calling</option>
                                            <option <?php echo $UserType == 'Client' ? 'selected' : '' ; ?> value="Client">Client</option>
                                            <option <?php echo $UserType == 'Collection' ? 'selected' : '' ; ?> value="Collection">Collection</option>
                                            <option <?php echo $UserType == 'Executive' ? 'selected' : '' ; ?> value="Executive">Executive</option>
                                            <option <?php echo $UserType == 'QC' ? 'selected' : '' ; ?> value="QC">QC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Answer *</label>
                                    <div class="controls"> 
                                        <input type="text" name="answer" value="<?php if(isset($_GET['FAQ_Cd'])) {echo $Answer;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Answer" required>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <div class="controls"> 
                                        <input type="text" name="remark" value="<?php if(isset($_GET['FAQ_Cd'])) {echo $Remark;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Remark" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>IsActive *</label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="IsActive" required>
                                        <option value="">--Select--</option>   
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

                            <div class="col-sm-6 col-md-3 col-lg-3 text-right" style="margin-top: 30px;">
                                <button type="button" id="submitBtnId" class="btn btn-primary mr-1 mb-1" onclick ="FAQMaster()" >SAVE</button>
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
                    <h4 class="card-title">FAQ Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       <div class="table-responsive">
                       <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>User Type</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($FAQList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["Question"]; ?></td>
                                            <td><?php echo $value["Answer"]; ?></td>
                                            <td><?php echo $value["UserType"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                            <td>
                                                <a href="home.php?p=faq-master&action=edit&FAQ_Cd=<?php echo $value["FAQ_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=faq-master&action=delete&FAQ_Cd=<?php echo $value["FAQ_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>User Type</th>
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
        