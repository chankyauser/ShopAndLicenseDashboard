<?php
session_start();
include '../api/includes/DbOperation.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $appName = $_SESSION['SAL_AppName'];
    $electionName = $_SESSION['SAL_ElectionName'];
    $developmentMode = $_SESSION['SAL_DevelopmentMode'];

    $shopCd = $_POST['Shop_Cd'] ?? 0;


    // $billdetails = "SELECT
    //                         COALESCE(sb.Billing_Cd, 0) AS Billing_Cd,
    //                         -- COALESCE(sb.Shop_Cd, 0) AS Shop_Cd,
    //                         -- COALESCE(sb.RenewalFlag, 0) AS RenewalFlag,
    //                         ISNULL(CONVERT(VARCHAR,sb.BillingDate, 23),'') as BillingDate,
    //                         COALESCE(sb.BillNo, '') AS BillNo,
    //                         COALESCE(sb.FinYear, '') AS FinYear,
    //                         COALESCE(sb.LicenseFees, 0.0) AS LicenseFees,
    //                         COALESCE(sb.TaxRate, 0.0) AS TaxRate,
    //                         COALESCE(sb.TaxAmount, 0.0) AS TaxAmount,
    //                         COALESCE(sb.PastDues, 0.0) AS PastDues,
    //                         COALESCE(sb.PenaltyAmount, 0.0) AS PenaltyAmount,
    //                         COALESCE(sb.RemainingBal, 0.0) AS RemainingBal,
    //                         COALESCE(sb.DiscountAmount, 0.0) AS DiscountAmount,
    //                         COALESCE(sb.BillAmount, 0.0) AS BillAmount,
    //                         COALESCE(sb.BillFile_Url, '') AS BillFile_Url,
    //                         COALESCE(sb.ExpiryDate, GETDATE()) AS ExpiryDate,
    //                         COALESCE(sb.IsLicenseRenewal, 0) AS IsLicenseRenewal,
    //                         COALESCE(sb.BillAmount, 0.0) AS BillAmount,
    //                         ISNULL(CONVERT(VARCHAR,sb.LicenseStartDate, 23),'') as LicenseStartDate,
    //                         ISNULL(CONVERT(VARCHAR,sb.LicenseEndDate, 23),'') as LicenseEndDate,
    //                         COALESCE(td.PaymentStatus, '') AS PaymentStatus,
    //                         COALESCE(td.paymentMode, '') AS paymentMode,
    //                         COALESCE(td.TransNumber, '') AS TransNumber,
    //                         COALESCE(td.Transaction_Cd, '') AS Transaction_Cd,
    //                         COALESCE(CONVERT(VARCHAR,td.TranDateTime, 120),'') AS TranDateTime
    //                 FROM ShopBilling sb
    //                 LEFT JOIN TransactionDetails td ON td.Billing_Cd=sb.Billing_Cd
    //                 where sb.Shop_Cd= $shopCd";


   $billdetails = "SELECT COALESCE(sb.Billing_Cd, 0) AS Billing_Cd,
                        -- COALESCE(sb.Shop_Cd, 0) AS Shop_Cd,
                        -- COALESCE(sb.RenewalFlag, 0) AS RenewalFlag,
                        ISNULL(CONVERT(VARCHAR, sb.BillingDate, 23), '') AS BillingDate,
                        COALESCE(sb.BillNo, '') AS BillNo,
                        COALESCE(sb.FinYear, '') AS FinYear,
                        COALESCE(sb.LicenseFees, 0.0) AS LicenseFees,
                        COALESCE(sb.TaxRate, 0.0) AS TaxRate,
                        COALESCE(sb.TaxAmount, 0.0) AS TaxAmount,
                        COALESCE(sb.PastDues, 0.0) AS PastDues,
                        COALESCE(sb.PenaltyAmount, 0.0) AS PenaltyAmount,
                        COALESCE(sb.RemainingBal, 0.0) AS RemainingBal,
                        COALESCE(sb.DiscountAmount, 0.0) AS DiscountAmount,
                        COALESCE(sb.BillAmount, 0.0) AS BillAmount,
                        COALESCE(sb.BillFile_Url, '') AS BillFile_Url,
                        COALESCE(sb.ExpiryDate, GETDATE()) AS ExpiryDate,
                        COALESCE(sb.IsLicenseRenewal, 0) AS IsLicenseRenewal,
                        ISNULL(CONVERT(VARCHAR, sb.LicenseStartDate, 23), '') AS LicenseStartDate,
                        ISNULL(CONVERT(VARCHAR, sb.LicenseEndDate, 23), '') AS LicenseEndDate,
                        COALESCE(td.PaymentStatus, '') AS PaymentStatus,
                        COALESCE(td.paymentMode, '') AS paymentMode,
                        COALESCE(td.TransNumber, '') AS TransNumber,
                        COALESCE(td.Transaction_Cd, '') AS Transaction_Cd,
                        COALESCE(CONVERT(VARCHAR, td.TranDateTime, 120), '') AS TranDateTime
                    FROM ShopBilling sb
                    LEFT JOIN TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd  
                    WHERE sb.Shop_Cd = $shopCd";

    // echo $billdetails;
    $db = new DbOperation();
    $billdetailsData = $db->ExecutveQueryMultipleRowSALData($billdetails, $electionName, $developmentMode);
    // print_r($billdetailsData);
    // header('Content-Type: application/json');
    echo json_encode($billdetailsData);
    // exit;


}

?>