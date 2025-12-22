<section id="application-approval-stages-master">

    <?php 

        $db=new DbOperation();
      
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

      
        if(isset($_GET['approvalStageId']) && $_GET['approvalStageId'] != 0 ){ 
                
            $approvalStageId = $_GET['approvalStageId'];
            $query = "SELECT
                        ISNULL(aas.Approval_Stage_Id,0) as Approval_Stage_Id,
                        ISNULL(aas.Stage_Number,0) as Stage_Number,
                        ISNULL(aas.Role_Id,0) as Role_Id,
                        ISNULL(aas.Is_Mandatory,'') as Is_Mandatory,
                        ISNULL(aas.IsActive,0) as IsActive,
                        ISNULL(dm.DValue,'') as Role_Name
                    FROM Application_Approval_Stages aas
                    LEFT JOIN DropDownMaster dm on dm.DropDown_Cd = aas.Role_Id AND dm.DTitle='ApprovalRoles'
                    WHERE aas.Approval_Stage_Id = $approvalStageId";

            $dataStageMaster = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

            if(sizeof($dataStageMaster)>0){
                foreach ($dataStageMaster as $key => $value) {
                    $Approval_Stage_Id = $value["Approval_Stage_Id"];
                    $Stage_Number = $value["Stage_Number"];
                    $Role_Id = $value["Role_Id"];
                    $Is_Mandatory = $value["Is_Mandatory"];
                }

                if(isset($_GET['action']) && $_GET['action'] == "edit"){
                    $action = "Update";
                }else if(isset($_GET['action']) && $_GET['action'] == "delete"){
                    $action = "Remove";
                }
                
            }else{
                $action = "Insert";
            }
        }else{
            $action = "Insert";
        }
        

    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Application Approval Stages Master- <?php if(isset($_GET['approvalStageId']) && $_GET['approvalStageId'] != 0 && isset($_GET['action']) && $_GET['action'] == "edit" ){ ?> Edit <?php }else if(isset($_GET['approvalStageId']) && $_GET['approvalStageId'] != 0 && isset($_GET['action']) && $_GET['action'] == "delete" ){ ?> Delete <?php }else{ ?> New <?php } ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group">
                                        <label>Role Name</label>
                                        <div class="controls"> 
                                            <select class="select2 form-control" name="rolename">
                                                <option value="">--Select--</option>   
                                                <?php
                                                    $electionName = $_SESSION['SAL_ElectionName'];
                                                    $developmentMode = $_SESSION['SAL_DevelopmentMode'];

                                                    $roleQuery = "SELECT 
                                                            aas.Approval_Stage_Id,
                                                            aas.Role_Id,
                                                            dm.DValue AS Role_Name
                                                        FROM Application_Approval_Stages as aas
                                                        LEFT JOIN DropDownMaster AS dm ON aas.Role_Id = dm.DropDown_Cd 
														";

                                                    $db = new DbOperation();
                                                    $roleData = $db->ExecutveQueryMultipleRowSALData($roleQuery, $electionName, $developmentMode);
                                                    if (!empty($roleData)) {
                                                        foreach($roleData as $role){
                                                            $selected=($Role_Id == $role['Role_Id']) ? 'selected' :'';
                                                            ?>
                                                              <option value="<?php echo htmlspecialchars($role['Role_Id']); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($role['Role_Name']); ?> </option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group">
                                        <label>Stage Number</label>
                                        <div class="controls"> 
                                          <select class="select2 form-control" name="stageNumber" required>
                                             <option value="">--Select--</option> 
                                            <?php for($i=1; $i<=10; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php if(isset($Stage_Number) && $Stage_Number == $i){ echo 'selected'; } ?> >
                                                    <?php echo $i; ?>
                                                </option>
                                            <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3 col-md-6 col-xl-3">
                                    <div class="form-group">
                                        <label for="isMandatory">Is Mandatory</label>
                                        <select class="select2 form-control" name="isMandatory" required>
                                            <option value="">--Select--</option> 
                                            <option value="1" <?php if(isset($Is_Mandatory) && $Is_Mandatory == "1"){ echo 'selected'; } ?> >Yes</option>
                                            <option value="0" <?php if(isset($Is_Mandatory) && $Is_Mandatory == "0"){ echo 'selected'; } ?> >No</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-xs-3 col-md-3 col-xl-3">
                                     <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <div class="controls d-flex justify-content-end">
                                        <button id="submitstageMasterBtnId" type="button" class="btn btn-primary" onclick="submitApprovalStageMasterFormData()" >
                                            <?php if(isset($_GET['approvalStageId']) && $_GET['approvalStageId'] != 0 && isset($_GET['action']) && $_GET['action'] == "edit" ){ ?> Edit <?php }else if(isset($_GET['approvalStageId']) && $_GET['approvalStageId'] != 0 && isset($_GET['action']) && $_GET['action'] == "delete" ){ ?> Delete <?php }else{ ?> Add <?php } ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 col-xl-6">
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <input type="hidden" name="Approval_Stage_Id" value="<?php echo $Approval_Stage_Id; ?>" class="form-control" >
                                     <input type="hidden" name="action" value="<?php echo $action; ?>" class="form-control" >
                                     <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                     <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>
                               
                               
                                
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php

        $db=new DbOperation();
      
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        
        $query = "SELECT
                ISNULL(aas.Approval_Stage_Id,0) as Approval_Stage_Id,
                ISNULL(aas.Stage_Number,0) as Stage_Number,
                ISNULL(aas.Role_Id,0) as Role_Id,
                ISNULL(aas.Is_Mandatory,'') as Is_Mandatory,
                ISNULL(aas.IsActive,0) as IsActive,
                ISNULL(dm.DValue,'') as Role_Name
            FROM Application_Approval_Stages aas
            LEFT JOIN DropDownMaster dm on dm.DropDown_Cd = aas.Role_Id AND dm.DTitle='ApprovalRoles'
            where aas.IsActive = 1";

      $dataapprovalstageMaster = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    //   print_r($dataapprovalstageMaster);
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Application Approval Stage Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                     
                        <div class="table-responsive">
                            <table id="tblApprovalStagesMasterData" class="table table-striped table-bordered complex-headers">
                            <!-- <table class="table row-grouping"> -->
                                <thead>
                                     <tr>
                                        <th>Sr No</th>
                                        <th>Role Name</th>
                                        <th>Stage Number</th>
                                        <th>Is Mandatory</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $srNo=0;
                                        foreach ($dataapprovalstageMaster as $key => $value) {
                                            $srNo = $srNo + 1;
                                   ?> 
                                        <tr>
                                            <td><?php echo $srNo; ?></td>
                                            <td><?php echo $value["Role_Name"]; ?></td>
                                            <td><?php echo $value["Stage_Number"]; ?></td>
                                             <td><?php echo $value["Is_Mandatory"]; ?></td>
                                            <td>
                                                <!-- <a href="home.php?p=login-detail&loginId=<?php //echo $value["Login_Cd"]; ?>"><i class="feather icon-list mr-50 font-medium-3"></i></a> -->
                                                <a href="home.php?p=application-approval-stages-master&action=edit&approvalStageId=<?php echo $value["Approval_Stage_Id"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i></a>
                                                <a href="home.php?p=application-approval-stages-master&action=delete&approvalStageId=<?php echo $value["Approval_Stage_Id"]; ?>"><i class="feather icon-trash-2 mr-50 font-medium-3"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

</section>


        