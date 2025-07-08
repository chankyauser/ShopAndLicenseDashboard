<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkCategory = array();
$InsertCategory = false;
$UpdateBusiness = false;
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    if  (
        (isset($_POST['businessCategoryName']) && !empty($_POST['businessCategoryName'])) 
    )
    {

        $BusinessCat_Cd = $_POST['BusinessCat_Cd'];
        $businessCategoryName = $_POST['businessCategoryName'];
        $businessCategoryNameMar = $_POST['businessCategoryNameMar'];
        $taxPercentage = $_POST['taxPercentage'];
        $remark = $_POST['remark'];
        $IsActive = $_POST['IsActive'];

        $query1 ="SELECT BusinessCat_Cd FROM BusinessCategoryMaster WHERE  BusinessCat_Cd = $BusinessCat_Cd;";
        $chkCategory = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

        if (sizeof($chkCategory) > 0) 
        {
            
            $query1 ="UPDATE BusinessCategoryMaster SET
            BusinessCatName = '$businessCategoryName',
            BusinessCatNameMar = N'$businessCategoryNameMar',
            TaxPercentage = $taxPercentage,
            Remark = N'$remark',
            IsActive = $IsActive,
            UpdatedByUser = '$userName',
            UpdatedDate = GETDATE()
            WHERE BusinessCat_Cd = $BusinessCat_Cd;";

            $UpdateBusiness = $db->RunQueryData($query1, $electionName, $developmentMode);

            if($UpdateBusiness){
                $data["error"] = false;
                $data["message"] = "Business Category updated successfully!";    
            }

        }else{
            
            $query1 ="SELECT BusinessCat_Cd FROM BusinessCategoryMaster  WHERE BusinessCatName = '$businessCategoryName' AND IsActive = 1 ;";
            $chkCategory = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkCategory) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "Business Category already present!";
            } else {
            
                $query2 ="INSERT INTO BusinessCategoryMaster (BusinessCatName, BusinessCatNameMar, TaxPercentage, Remark, IsActive, UpdatedDate, UpdatedByUser)  VALUES('$businessCategoryName', N'$businessCategoryNameMar', $taxPercentage, N'$remark', $IsActive, GETDATE(), '$userName');";
                $InsertCategory = $db->RunQueryData($query2, $electionName, $developmentMode);

                if($InsertCategory){
                    $data["error"] = false;
                    $data["message"] = "Business category added succussfully!";
                }   
            }

        }
    }else{
        $data["error"] = true;
        $data["message"] = "Required data is empty !";
    }  

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
