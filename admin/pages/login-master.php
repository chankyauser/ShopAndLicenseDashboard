<section id="login-master">

    <?php 

        $db=new DbOperation();
      
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $loginCd = 0;
        $userCd = 0;
        $executiveCd = 0;
        $designation = "";
        $mobile = "";
        $expDate = "";
        $deActivateFlag = "";
        $remark = "";
        $dataLoginMaster = array();
        if(isset($_GET['loginId']) && $_GET['loginId'] != 0 ){ 
                
            $loginCd = $_GET['loginId'];
            $query = "
                SELECT
                    ISNULL(lm.Login_Cd,0) as Login_Cd,
                    ISNULL(lm.User_Cd,0) as User_Cd,
                    ISNULL(lm.Executive_Cd,0) as Executive_Cd,
                    ISNULL(lm.User_Type,'') as User_Type,
                    ISNULL(lm.Mobile_No,'') as Mobile_No,
                    ISNULL(lm.Remark,'') as Remark,
                    ISNULL(um.UserName,'') as UserName,
                    ISNULL(um.UserType,'') as UM_UserType,
                    ISNULL(um.Executive_Cd,0) as UM_Executive_Cd,
                    COALESCE(
                            CASE WHEN um.UserType = 'A' THEN 'ORNET' END,
                            CASE WHEN um.UserType = 'C' THEN 'CLIENT' END,
                    '') as UM_UserCategory,
                    ISNULL(um.Remarks, '') as FullName, 
                    ISNULL(um.Mobile,'') as Mobile,
                    ISNULL(um.ExpDate,'') as ExpDate,
                    ISNULL(um.DeactiveFlag,'') as DeactiveFlag
                FROM LoginMaster lm
                LEFT JOIN Survey_Entry_Data..User_Master um on um.User_Id = lm.User_Cd
                LEFT JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                WHERE lm.Login_Cd = $loginCd";
            $dataLoginMaster = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
            if(sizeof($dataLoginMaster)>0){
                foreach ($dataLoginMaster as $key => $value) {
                    $loginCd = $value["Login_Cd"];
                    $userCd = $value["User_Cd"];
                    $executiveCd = $value["Executive_Cd"];
                    $designation = $value["User_Type"];
                    $mobile = $value["Mobile_No"];
                    $expDate = date('Y-m-d', strtotime($value["ExpDate"]));
                    $remark = $value["Remark"];
                    $deActivateFlag = $value["DeactiveFlag"];
                    // $expDateArray = explode('-',$value["ExpDate"]);
                    // $expDate = $expDateArray[2].'-'.$expDateArray[1].'-'.$expDateArray[0];
                }

                if(isset($_GET['action']) && $_GET['action'] == "edit"){
                    $action = "Update";
                }else if(isset($_GET['action']) && $_GET['action'] == "delete"){
                    $deActivateFlag = 'D';
                    $expDate = date('Y-m-d');
                    $action = "Remove";
                }
                
            }else{
                $action = "Insert";
            }
        }else{
            $expDate = date('Y-m-d', strtotime('+90 days'));
            $action = "Insert";
        }
        

    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login Master - <?php if(isset($_GET['loginId']) && $_GET['loginId'] != 0 && isset($_GET['action']) && $_GET['action'] == "edit" ){ ?> Edit <?php }else if(isset($_GET['loginId']) && $_GET['loginId'] != 0 && isset($_GET['action']) && $_GET['action'] == "delete" ){ ?> Delete <?php }else{ ?> New <?php } ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <?php include 'dropdown-user-login.php'; ?>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group">
                                        <label>Designation *</label>
                                        <div class="controls"> 
                                            <select class="select2 form-control" name="designation" required>
                                                <option value="">--Select--</option>   
                                                <option <?php echo $designation == 'Admin' ? 'selected' : '' ; ?> value="Admin">Admin</option>
                                                <option <?php echo $designation == 'Calling' ? 'selected' : '' ; ?> value="Calling">Calling</option>
                                                <option <?php echo $designation == 'Client' ? 'selected' : '' ; ?> value="Client">Client</option>
                                                <option <?php echo $designation == 'Collection' ? 'selected' : '' ; ?> value="Collection">Collection</option>
                                                <option <?php echo $designation == 'Executive' ? 'selected' : '' ; ?> value="Executive">Executive</option>
                                                <option <?php echo $designation == 'QC' ? 'selected' : '' ; ?> value="QC">QC</option>
                                                <option <?php echo $designation == 'Ward Officer' ? 'selected' : '' ; ?> value="Ward Officer">Ward Officer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group">
                                        <label for="expDate">License Expiry *</label>
                                        <input type='text' name="expDate" value="<?php echo $expDate;?>" class="form-control pickadate" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group">
                                        <label>License Deactivate</label>
                                        <div class="controls"> 
                                            <select class="select2 form-control" name="deActivateFlag">
                                                <option value="">--Select--</option>   
                                                <option <?php echo $deActivateFlag == 'D' ? 'selected' : '' ; ?> value="D">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type='text' name="remark" value="<?php echo $remark;?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xs-3 col-md-3 col-xl-3">
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <input type="hidden" name="loginCd" value="<?php echo $loginCd; ?>" class="form-control" >
                                     <input type="hidden" name="action" value="<?php echo $action; ?>" class="form-control" >
                                     <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                     <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>
                                <div class="col-xs-3 col-md-3 col-xl-3">
                                     <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <div class="controls text-right">
                                        <button id="submitLoginMasterBtnId" type="button" class="btn btn-primary" onclick="submitLoginMasterFormData()" >
                                            <?php if(isset($_GET['loginId']) && $_GET['loginId'] != 0 && isset($_GET['action']) && $_GET['action'] == "edit" ){ ?> Edit <?php }else if(isset($_GET['loginId']) && $_GET['loginId'] != 0 && isset($_GET['action']) && $_GET['action'] == "delete" ){ ?> Delete <?php }else{ ?> Add <?php } ?>
                                        </button>
                                    </div>
                                </div>

                                
                                
                                
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'datatbl/tblLoginMasterData.php';  ?>


</section>


        