<?php


include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
if(isset($_POST['billing_id']) && !empty($_POST['billing_id']) && 
isset($_POST['amount']) && !empty($_POST['amount']) && 
isset($_POST['shopCd']) && !empty($_POST['shopCd'])){

    $billing_id = trim($_POST['billing_id']);
    $amount = trim($_POST['amount']);
    $shopCd = trim($_POST['shopCd']);

    $IsExistQuery = "SELECT ISNULL(Transaction_Cd, 0) as TrasId, COALESCE(TransStatus,'') AS TransStatus FROM TransactionDetails WHERE Billing_Cd = $billing_id";
    $db = new DbOperation();
    $IsExist = $db->ExecutveQuerySingleRowSALData($IsExistQuery, $electionName, $developmentMode);
  
    $OwnerQuery = "SELECT ISNULL(NULLIF(ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                            ISNULL(NULLIF(ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                            ISNULL(CASE
                                WHEN ShopKeeperName = '.....' OR NULLIF(ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                ELSE ShopKeeperName
                            END,'') AS ShopKeeperName
                        FROM ShopMaster WHERE Shop_Cd = $shopCd";
    $Ownerdb = new DbOperation();
    $OwnerDetails = $Ownerdb->ExecutveQuerySingleRowSALData($OwnerQuery, $electionName, $developmentMode);

    if($OwnerDetails){
        $ShopKeeperMobile = $OwnerDetails['ShopKeeperMobile'];
        $ShopEmailAddress = $OwnerDetails['ShopEmailAddress'];
        $ShopKeeperName = $OwnerDetails['ShopKeeperName'];              
    }
    
    if(!empty($IsExist)){
        $TransId = $IsExist['TrasId'];
        $TransStatus = $IsExist['TransStatus'];
        if(strtolower($TransStatus) == "success"){
            echo json_encode([
                        'statusCode' => 204,
                        'status' => 'exists',
                        'message' => 'Transaction has been done against this bill',
            ]);
        }else{
           include('../PHP-GetEPay/PG/GetePayInvoicePg.php');
        }
    }else{
        $InsertTransationQuery = "INSERT INTO TransactionDetails (Billing_Cd, Shop_Cd, txnAmount) VALUES ('$billing_id', '$shopCd', '$amount')";
        $InsertDB = new DBOperation();
        $result = $InsertDB->RunQuerySALData($InsertTransationQuery, $electionName, $developmentMode);
        if($result){
            $TransIdQuery = "SELECT ISNULL(MAX(Transaction_Cd), 0) as TrasId FROM TransactionDetails WHERE Billing_Cd = $billing_id AND Shop_Cd = $shopCd";
            $Transdb = new DbOperation();
            $TransIdResult = $Transdb->ExecutveQuerySingleRowSALData($TransIdQuery, $electionName, $developmentMode);
            $TransId = $TransIdResult['TrasId'];
            include('../PHP-GetEPay/PG/GetePayInvoicePg.php');
        }
    }

}