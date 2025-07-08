<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chk = false;
$Insert = false;
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];



        // if  (
        //     (isset($_POST['callingCategory']) && !empty($_POST['callingCategory'])) && 
        //     (isset($_POST['srNo']) && !empty($_POST['srNo'])) && 
        //     (isset($_POST['callingType']) && !empty($_POST['callingType'])) && 
        //     (isset($_POST['callingTypeSrNo']) && !empty($_POST['callingTypeSrNo']))
        // )
        // {
    
            $Calling_Category_Cd = $_POST['calling_Category_Cd'];
            if(empty($Calling_Category_Cd)){
                $Calling_Category_Cd = 0;
            }
            $callingCategory = $_POST['callingCategory'];
            $callingType = $_POST['callingType'];
            $srNo = $_POST['srNo'];
            $callingTypeSrNo = $_POST['callingTypeSrNo'];
            $qcType = $_POST['qcType'];
            $remark = $_POST['remark'];
            $IsActive = $_POST['IsActive'];

            $query1 ="SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Category_Cd = $Calling_Category_Cd;";
            $chkCategory = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkCategory) > 0) 
            {
               
    
                $query2 ="UPDATE CallingCategoryMaster SET
                Calling_Category = '$callingCategory',
                Calling_Type = '$callingType',
                SrNo = $srNo,
                Type_SrNo = $callingTypeSrNo,
                QC_Type = '$qcType',
                Remark = N'$remark',
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE Calling_Category_Cd = $Calling_Category_Cd;";

                $UpdateCategory = $db->RunQueryData($query2, $electionName, $developmentMode);

                if($UpdateCategory){
                    $data["error"] = false;
                    $data["message"] = "Calling Category updated successfully!";
                }
                
            }else{

                $query1 ="SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Category = '$callingCategory';";
                $chkCategory = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chkCategory) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "Calling Category already present!";

                }
                else
                {

                    $query2 ="INSERT INTO CallingCategoryMaster (Calling_Category_Cd, Calling_Category, Calling_Type, SrNo, Type_SrNo, QC_Type, IsActive, Remark, UpdatedDate, UpdatedByUser)  VALUES ((SELECT ISNULL(MAX(Calling_Category_Cd),0)+1 from CallingCategoryMaster) ,'$callingCategory', '$callingType', $srNo, $callingTypeSrNo, '$qcType' $IsActive ,N'$remark',  GETDATE(), '$userName');";
                    $Insert = $db->RunQueryData($query2, $electionName, $developmentMode);

                    if($Insert){
                        $data["error"] = false;
                        $data["message"] = "Calling Category added succussfully!";         
                    }

                }

            }

        // }
        // else 
        // {
        //     $data["error"] = true;
        //     $data["message"] = "Required data is empty !";
        // }  


        echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
