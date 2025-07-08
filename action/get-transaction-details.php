<?php
session_start();
include '../api/includes/DbOperation.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $appName = $_SESSION['SAL_AppName'];
    $electionName = $_SESSION['SAL_ElectionName'];
    $developmentMode = $_SESSION['SAL_DevelopmentMode'];

    $shopCd = $_POST['Shop_Cd'] ?? 0;
    // echo $shopCd;

    $paymentdetails = "SELECT 
                        COALESCE(Transaction_Cd, '') AS Transaction_Cd,
                        COALESCE(TransType, '') AS TransType,
                        COALESCE(Amount, 0) AS Amount,
                        COALESCE(TransNumber, '') AS TransNumber,
                        COALESCE(Shop_Cd, '') AS Shop_Cd,
                        COALESCE(Billing_Cd, '') AS Billing_Cd,
                        COALESCE(User_Cd, '') AS User_Cd,
                        COALESCE(TranDateTime, '1900-01-01') AS TranDateTime,
                        COALESCE(TransStatus, '') AS TransStatus,
                        COALESCE(Remark, '') AS Remark,
                        COALESCE(UpdatedDate, '1900-01-01') AS UpdatedDate,
                        COALESCE(UpdatedByUser, '') AS UpdatedByUser,
                        COALESCE(getepayTxnId, '') AS getepayTxnId,
                        COALESCE(mid, '') AS mid,
                        COALESCE(txnAmount, 0) AS txnAmount,
                        COALESCE(custRefNo, '') AS custRefNo,
                        COALESCE(paymentMode, '') AS paymentMode,
                        COALESCE(paymentStatus, '') AS paymentStatus,
                        COALESCE(surcharge, 0) AS surcharge
                    FROM TransactionDetails
                    where Shop_Cd= $shopCd";

    // echo $paymentdetails;
    $db = new DbOperation();
    $paymentdetailsData = $db->ExecutveQueryMultipleRowSALData($paymentdetails, $electionName, $developmentMode);
    // print_r($paymentdetailsData);
    header('Content-Type: application/json');
    echo json_encode($paymentdetailsData);
    exit;


}

?>