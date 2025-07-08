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
            (isset($_POST['documentName']) && !empty($_POST['documentName'])) && 
            (isset($_POST['documentType']) && !empty($_POST['documentType']))
        )
        {
    
            $Document_Cd = $_POST['Document_Cd'];
            if(empty($Document_Cd)){
                $Document_Cd = 0;
            }
            $documentName = $_POST['documentName'];
            $documentNameMar = $_POST['documentNameMar'];
            $documentType = $_POST['documentType'];
            $isCompulsory = $_POST['isCompulsory'];
            $IsActive = $_POST['IsActive'];
    
            $query1 ="SELECT Document_Cd FROM ShopDocumentMaster WHERE Document_Cd = $Document_Cd;";
            $chkShopDoc = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkShopDoc) > 0) 
            {
                              
                $query1 ="UPDATE ShopDocumentMaster SET
                DocumentName = '$documentName',
                DocumentNameMar = N'$documentNameMar',
                DocumentType = '$documentType',
                IsCompulsory = $isCompulsory,
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE Document_Cd = $Document_Cd;";

                $UpdateShopDoc = $db->RunQueryData($query1, $electionName, $developmentMode);

                if($UpdateShopDoc){
                    $data["error"] = false;
                    $data["message"] = "Shop Document updated successfully!";
                }
                
            }else{

                $query1 ="SELECT Document_Cd FROM ShopDocumentMaster WHERE DocumentName = '$documentName' AND IsActive = 1 ;";
                $chk = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chk) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "Shop Document Name already present!";
                }
                else
                {

                    $query2 ="INSERT INTO ShopDocumentMaster (DocumentName, DocumentNameMar, DocumentType, IsCompulsory, IsActive, UpdatedDate, UpdatedByUser) VALUES ('$documentName', N'$documentNameMar', '$documentType', $isCompulsory, $IsActive , GETDATE(), '$userName');";
                    $Insert = $db->RunQueryData($query2, $electionName, $developmentMode);
                    
                    if($Insert){
                        $data["error"] = false;
                        $data["message"] = "Shop Document added succussfully!";
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
