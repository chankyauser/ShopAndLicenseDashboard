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

 
        if  (
            (isset($_POST['BtmType']) && !empty($_POST['BtmType'])) && 
            (isset($_POST['boardHeight']) && !empty($_POST['boardHeight'])) && 
            (isset($_POST['boardWidth']) && !empty($_POST['boardWidth'])) &&
            (isset($_POST['boardAreaWiseTax']) && !empty($_POST['boardAreaWiseTax']))
        )
        {
    
            $BTM_Cd = $_POST['BTM_Cd'];
            $BtmType = $_POST['BtmType'];
            $boardHeight = $_POST['boardHeight'];
            $boardWidth = $_POST['boardWidth'];
            $boardAreaWiseTax = $_POST['boardAreaWiseTax'];
            $IsActive = $_POST['IsActive'];
    
            $query1 ="SELECT BTM_Cd FROM BoardTaxMaster WHERE BTM_Cd = $BTM_Cd ;";
            $chkBoard = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkBoard) > 0) 
            {

                $query1 ="UPDATE BoardTaxMaster SET
                BTM_Type = '$BtmType',
                Height = $boardHeight,
                Width = $boardWidth,
                BAreaWiseTax = $boardAreaWiseTax,
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE BTM_Cd = $BTM_Cd;";

                $UpdateShopDoc = $db->RunQueryData($query1, $electionName, $developmentMode);

                if($UpdateShopDoc){
                    $data["error"] = false;
                    $data["message"] = "Board Type updated successfully!";    
                }
                
            }else{

                $query1 ="SELECT BTM_Cd FROM BoardTaxMaster WHERE BTM_Type = '$BtmType' AND IsActive = 1 ;";
                $chk = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chk) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "Board Type already present!";

                }
                else
                {

                    $query2 ="INSERT INTO BoardTaxMaster (BTM_Type, Height, Width, BAreaWiseTax, IsActive, UpdatedDate, UpdatedByUser) VALUES ('$BtmType', $boardHeight, $boardWidth, $boardAreaWiseTax, $IsActive , GETDATE(), '$userName');";
                    $Insert = $db->RunQueryData($query2, $electionName, $developmentMode);
                    
                    if($UpdateShopDoc){
                         $data["error"] = false;
                        $data["message"] = "Board Tax added succussfully!";
                    }  

                }     
            }

        }
        else 
        {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  

  
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
