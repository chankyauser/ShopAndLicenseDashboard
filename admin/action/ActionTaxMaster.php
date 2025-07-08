<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkStatus = array();
$InsertStatus = array();
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    if(isset($_POST['Tax_Cd']) && !empty($_POST['Tax_Cd']))
    {

        if  (
            (isset($_POST['TaxName']) && !empty($_POST['TaxName'])) && 
            (isset($_POST['PercentageOfTax']) && !empty($_POST['PercentageOfTax'])) && 
            (isset($_POST['Remark']) && !empty($_POST['Remark'])) && 
            (isset($_POST['IsActive']) && !empty($_POST['IsActive'])) 
        )
        {
    
            $Tax_Cd = $_POST['Tax_Cd'];
            $TaxName = $_POST['TaxName'];
            $PercentageOfTax = $_POST['PercentageOfTax'];
            $Remark = $_POST['Remark'];
            $IsActive = $_POST['IsActive'];

            $query1 ="SELECT Tax_Cd FROM TaxMaster WHERE TaxName = '$TaxName' 
            AND Tax_Cd != $Tax_Cd AND IsActive = 1 ;";
            $chkTax = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkTax) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "Tax Name already present!";

            }
            else
            {
                
                $query1 ="UPDATE TaxMaster SET
                TaxName = '$TaxName',
                PercentageOfTax = $PercentageOfTax ,
                Remark = N'$Remark',
                IsActive = $IsActive
                WHERE Tax_Cd = $Tax_Cd ;";

               $UpdateTax = $db->RunQuerySALData($query1, $electionName, $developmentMode);

    
                $data["error"] = false;
                $data["message"] = "Tax Entry updated successfully!";
            }
                 
        }
        else 
        {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  
    }
    else
    {

        if  (
            (isset($_POST['TaxName']) && !empty($_POST['TaxName'])) && 
            (isset($_POST['PercentageOfTax']) && !empty($_POST['PercentageOfTax'])) && 
            (isset($_POST['Remark']) && !empty($_POST['Remark'])) && 
            (isset($_POST['IsActive']) && !empty($_POST['IsActive'])) 
        )
    {
            $TaxName = $_POST['TaxName'];
            $PercentageOfTax = $_POST['PercentageOfTax'];
            $Remark = $_POST['Remark'];
            $IsActive = $_POST['IsActive'];

            $query1 ="SELECT Tax_Cd FROM TaxMaster WHERE TaxName = '$TaxName' AND IsActive = 1;";
            $chkTax = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkTax) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "Tax already present!";

            }
            else
            {

            $query2 ="INSERT INTO TaxMaster (TaxName, PercentageOfTax, Remark, IsActive, UpdatedDate, UpdatedByUser) 
            VALUES('$TaxName', $PercentageOfTax, N'$Remark', $IsActive , GETDATE() , '$userName');";
            $InsertTax = $db->RunQuerySALData($query2, $electionName, $developmentMode);

            $data["error"] = false;
            $data["message"] = "Tax Entry added successfully!";
                
            }
       
    }
    else 
    {
        $data["error"] = true;
        $data["message"] = "Required data is empty !";
    }  
  }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
