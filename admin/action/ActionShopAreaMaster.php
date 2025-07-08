<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkShopArea = array();
$Insert = false;
$UpdateDropDown = false;
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

 

        if  (
            (isset($_POST['shopAreaName']) && !empty($_POST['shopAreaName'])) 
        )
        {
    
            $ShopArea_Cd = $_POST['ShopArea_Cd'];
            $shopAreaName = $_POST['shopAreaName'];
            $shopAreaNameMar = $_POST['shopAreaNameMar'];
            $taxPercentage = $_POST['taxPercentage'];
            $remark = $_POST['remark'];
            $IsActive = $_POST['IsActive'];
            
            $query1 ="SELECT ShopArea_Cd FROM ShopAreaMaster WHERE ShopArea_Cd = $ShopArea_Cd; ";
            
            $chkShopArea = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkShopArea) > 0) 
            {
                
                $query1 ="UPDATE ShopAreaMaster SET
                ShopAreaName = '$shopAreaName',
                ShopAreaNameMar = N'$shopAreaNameMar',
                TaxPercentage = $taxPercentage,
                Remark = N'$remark',
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE ShopArea_Cd = $ShopArea_Cd;";

                $UpdateDropDown = $db->RunQueryData($query1, $electionName, $developmentMode);
                
                if($UpdateDropDown){
                    $data["error"] = false;
                    $data["message"] = "Shop Area updated successfully!";    
                }
                
            }else{

                $query1 ="SELECT ShopArea_Cd FROM ShopAreaMaster WHERE ShopAreaName = '$shopAreaName' AND IsActive = 1 ;";
                $chk = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chk) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "Shop Area Name already present!";

                } else {

                    $query2 ="INSERT INTO ShopAreaMaster (ShopAreaName, ShopAreaNameMar, TaxPercentage, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES('$shopAreaName', N'$shopAreaNameMar', $taxPercentage, N'$remark', $IsActive , GETDATE(), '$userName');";
                    $Insert = $db->RunQueryData($query2, $electionName, $developmentMode);

                    if($Insert){
                        $data["error"] = false;
                        $data["message"] = "Shop Area added succussfully!";   
                    }
                    
                }
            }
   
        } else  {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
