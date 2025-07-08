<?php
    session_start();

    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    $data = array();
    $empty = array();

    $chkDropDown = array();
    $InsertDropDown = false;
    $UpdateDropDown = false;
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];



        if  (
            (isset($_POST['DTitle']) && !empty($_POST['DTitle'])) && 
            (isset($_POST['DValue']) && !empty($_POST['DValue'])) && 
            (isset($_POST['SerialNo']) && !empty($_POST['SerialNo'])) 
          
        )
        {
    
            $DropDown_Cd = $_POST['DropDown_Cd'];
            $DTitle = $_POST['DTitle'];
            $DValue = $_POST['DValue'];
            $SerialNo = $_POST['SerialNo'];
            $remark = $_POST['remark'];
            $IsActive = $_POST['IsActive'];
    
            $query1 ="SELECT DropDown_Cd FROM DropDownMaster WHERE DropDown_Cd = $DropDown_Cd ;";
            $chkDropDown = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkDropDown) > 0) 
            {
              
                $query1 ="UPDATE DropDownMaster SET
                DTitle = '$DTitle',
                DValue = '$DValue',
                SerialNo = $SerialNo,
                Remark = N'$remark',
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE DropDown_Cd = $DropDown_Cd;";

                $UpdateDropDown = $db->RunQueryData($query1, $electionName, $developmentMode);

                if($UpdateDropDown){
                    $data["error"] = false;
                    $data["message"] = "DropDown updated successfully!";    
                }

            } else {
                
                $query1 ="SELECT DropDown_Cd FROM DropDownMaster WHERE DTitle = '$DTitle' AND DValue = '$DValue' AND IsActive = 1 ;";
                $chkDropDown = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chkDropDown) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "DropDown already present!";
                }else{
                        
                    $query1 ="INSERT INTO DropDownMaster (DTitle, DValue, SerialNo, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ( '$DTitle', '$DValue', $SerialNo, N'$remark', $IsActive, GETDATE(), '$userName');";
                    $InsertDropDown = $db->RunQueryData($query1, $electionName, $developmentMode);

                    if($InsertDropDown){
                        $data["error"] = false;
                        $data["message"] = "DropDown added succussfully!";
                    }
                }

            }
              
        } else {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
