<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];  
    
    $updatedByUser = $userName;
    
    $updateLoginMaster = array();

    if  (
            (isset($_POST['electionName']) && !empty($_POST['electionName'])) &&
            (isset($_POST['userCd']) && !empty($_POST['userCd'])) && 
            (isset($_POST['designation']) && !empty($_POST['designation'])) && 
            (isset($_POST['expDate']) && !empty($_POST['expDate'])) && 
            (isset($_POST['action']) && !empty($_POST['action'])) 
        ) {

        $electionName = $_POST['electionName'];
        $action = $_POST['action'];
        
        $loginCd = $_POST['loginCd'];
        $userCd = $_POST['userCd'];
        $designation = $_POST['designation'];
        $expDate = $_POST['expDate'];
        $deActivateFlag = $_POST['deActivateFlag'];
        $remark = $_POST['remark'];

        $query = "SELECT top (1) Executive_Cd, Mobile FROM Survey_Entry_Data..User_Master WHERE User_Id = $userCd ;";
        
        $isUserMasterExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isUserMasterExists) > 0 )
        {
            $executiveCd = $isUserMasterExists["Executive_Cd"];
            $mobile = $isUserMasterExists["Mobile"];
        }else{
            $executiveCd = 0;
            $mobile = '';
        }

        if($action == 'Update'){
                
            $sql1 = "SELECT top (1) Login_Cd FROM LoginMaster WHERE Login_Cd = $loginCd ;";
            
            $isLoginExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            if( sizeof($isLoginExists) > 0 )
            {
                $dbSEUser=new DbOperation();
                $expDate = date('d-m-Y',strtotime($expDate));
                $sqlSEUser = "UPDATE Survey_Entry_Data..User_Master
                     SET 
                        ElectionName = '$electionName',
                        ExpDate = '$expDate',
                        DeactiveFlag = '$deActivateFlag'
                     WHERE User_Id = $userCd;";
                $updateSEUser = $dbSEUser->RunQueryData($sqlSEUser, $electionName, $developmentMode);


                $sql2 = "UPDATE LoginMaster
                     SET 
                        IsActive = 1,
                        User_Type = '$designation',
                        Remark = N'$remark',
                        UpdatedByUser = '$updatedByUser',
                        UpdatedDate = GETDATE()
                     WHERE Login_Cd = $loginCd;";
                $updateLogin = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updateLogin){
                    $updateLoginMaster['Flag'] = 'U';
                }
            }

                
        } else if($action == 'Insert'){
            $sql1 = "SELECT top (1) Login_Cd FROM LoginMaster WHERE User_Cd = $userCd AND Executive_Cd = $executiveCd ;";
            $isLoginExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            
            if( sizeof($isLoginExists) > 0 )
            {
                $dbSEUser=new DbOperation();
                $expDate = date('d-m-Y',strtotime($expDate));
                $sqlSEUser = "UPDATE Survey_Entry_Data..User_Master
                     SET 
                        ElectionName = '$electionName',
                        ExpDate = '$expDate',
                        DeactiveFlag = '$deActivateFlag'
                     WHERE User_Id = $userCd;";
                $updateSEUser = $dbSEUser->RunQueryData($sqlSEUser, $electionName, $developmentMode);


                $sql2 = "UPDATE LoginMaster
                     SET 
                        IsActive = 1,
                        User_Type = '$designation',
                        Remark = N'$remark',
                        UpdatedByUser = '$updatedByUser',
                        UpdatedDate = GETDATE()
                     WHERE User_Cd = $userCd AND Executive_Cd = $executiveCd;";
                $updateLogin = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updateLogin){
                    $updateLoginMaster['Flag'] = 'U';
                }
            }else{

                $dbSEUser=new DbOperation();
                $expDate = date('d-m-Y',strtotime($expDate));
                $sqlSEUser = "UPDATE Survey_Entry_Data..User_Master
                     SET 
                        ElectionName = '$electionName',
                        ExpDate = '$expDate',
                        DeactiveFlag = '$deActivateFlag'
                     WHERE User_Id = $userCd;";
                $updateSEUser = $dbSEUser->RunQueryData($sqlSEUser, $electionName, $developmentMode);

                $sql2 = "INSERT INTO LoginMaster(User_Cd,Executive_Cd,User_Type,Mobile_No,Remark,UpdatedDate,UpdatedByUser,AddedByUser,AddedDate)
                VALUES($userCd,$executiveCd,'$designation','$mobile',N'$remark',GETDATE(),'$updatedByUser','$updatedByUser',GETDATE());";
                $insertLogin = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($insertLogin){
                    $updateLoginMaster['Flag'] = 'I';
                }
            }
        } else if($action == 'Remove'){

            $sql1 = "SELECT top (1) Login_Cd FROM LoginMaster WHERE Login_Cd = $loginCd ;";
            $isLoginExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            
            if( sizeof($isLoginExists) > 0 )
            {

                $dbSEUser=new DbOperation();
                $expDate = date('d-m-Y',strtotime($expDate));
                $sqlSEUser = "UPDATE Survey_Entry_Data..User_Master
                     SET 
                        ElectionName = '$electionName',
                        ExpDate = '$expDate',
                        DeactiveFlag = '$deActivateFlag'
                     WHERE User_Id = $userCd;";
                $updateSEUser = $dbSEUser->RunQueryData($sqlSEUser, $electionName, $developmentMode);


                $sql2 = "UPDATE LoginMaster
                         SET 
                             IsActive = 0,
                             Remark = N'$remark',
                             UpdatedByUser = '$updatedByUser',
                             UpdatedDate = GETDATE()
                         WHERE Login_Cd = $loginCd ";
                $deleteLogin = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($deleteLogin){
                    $updateLoginMaster['Flag'] = 'D';
                }
            }

        }

            
      
    }else{
        
    }


    if (sizeof($updateLoginMaster) > 0) {

        $flag = $updateLoginMaster['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
        } elseif($flag == 'E'){
            echo json_encode(array('statusCode' => 206, 'msg' => 'Already Have An Entry!'));
        } elseif($flag == 'D'){
            echo json_encode(array('statusCode' => 203, 'msg' => 'Login Deactivated!'));
        }
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
    }

    
}
?>
