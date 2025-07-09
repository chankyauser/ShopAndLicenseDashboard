<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if(isset($_POST['shopCd']) && !empty($_POST['shopCd'])){

    // if($electionName === 'CSMC'){
    //     $Code = 'CSMC';
    // }else{
        $Code = $electionName;
    // }

    $shopCd = trim($_POST['shopCd']);

    $currentDate = new DateTime();
    $startYear = (int)$currentDate->format("Y");
    $endDate = clone $currentDate;
    $endDate->add(new DateInterval('P1Y'))->sub(new DateInterval('P1D'));
    $endYear = (int)$endDate->format("Y");
    $FinYear = $startYear . '-' . substr($endYear, -2);

    $LicenseStartDate = $currentDate->format("Y-m-d");
    $LicenseEndDate = $endDate->format("Y-m-d");


    $LicenseRenewalDate = (clone $endDate)->modify('+1 day')->format("Y-m-d");

    $TaxRateQuery = "SELECT SUM(PercentageOfTax) as Tax FROM TaxMaster WHERE TaxName IN ('C. GST', 'S. GST')";
    $TaxDB = new DbOperation();
    $TaxRateResult = $TaxDB->ExecutveQuerySingleRowSALData($TaxRateQuery, $electionName, $developmentMode);
    $taxRate = $TaxRateResult['Tax'];


    $ShopDetailsQuery = "SELECT ISNULL(sm.Shop_Cd, 0) AS Shop_Cd, 
                                ISNULL(CONVERT(VARCHAR,sm.BusinessStartDate,23),'') AS BusinessStartDate,
                                ISNULL(sm.ParwanaDetCd, 0) AS ParwanaDetCd,
                                ISNULL(pd.Parwana_Cd, 0) AS Parwana_Cd, 
                                ISNULL(pd.Amount, '') AS Amount,
                                ISNULL(pd.IsRenewal, 0) AS IsRenewal,
                                ISNULL(CONVERT(VARCHAR,sm.RenewalDate,23),'') AS RenewalDate
                         FROM ShopMaster as sm
                         LEFT JOIN ParwanaDetails as pd ON sm.ParwanaDetCd = pd.ParwanaDetCd AND pd.IsActive = 1
                         WHERE sm.Shop_Cd = '$shopCd'
                         AND sm.IsActive = 1";
    $shopDB = new DbOperation();
    $ShopDetails = $shopDB->ExecutveQueryMultipleRowSALData($ShopDetailsQuery,$electionName, $developmentMode);
    // echo json_encode($ShopDetails);exit;
    if(!empty($ShopDetails)){
        foreach($ShopDetails as $sd){
            $shopCd = $sd['Shop_Cd'];
            $businessStartDate = $sd['BusinessStartDate'];
            $parwanaDetCd = $sd['ParwanaDetCd'];
            $CatAmount = $sd['Amount'];
            $IsRenewal = $sd['IsRenewal'];
            
            $Parwana_Cd = $sd['Parwana_Cd'];

            $startDate = new DateTime($businessStartDate);
            $businessYear = (int)$startDate->format("Y");
            $businessMonth = (int)$startDate->format("m");
            $BillingDate = $currentDate->format('Y-m-d');

            if(isset($_POST['renewFlag']) && !empty($_POST['renewFlag']) && $_POST['renewFlag'] === 1){
                $RenewalDate = $sd['RenewalDate'];
                $LicenseRenewalDate = (clone $RenewalDate)->modify('+1 day')->format("Y-m-d");
            }

            $RenewalFlag = 0;
            $IsRenewalQuery = "SELECT ISNULL(Billing_Cd, 0) as Billing_Cd FROM ShopBilling WHERE Shop_Cd = $shopCd AND IsActive = 1";
            $IsRenewalDB = new DbOperation();
            $IsRenewalResult = $IsRenewalDB->ExecutveQueryMultipleRowSALData($IsRenewalQuery,$electionName, $developmentMode);
            if(!empty($IsRenewalResult)){
                $RenewalFlag = 1;
            }
            
            $Amount  = round($CatAmount,2);

            // $TaxAmount = ( $Amount * ($taxRate / 100) );

            // $TotalAmount = $Amount + $TaxAmount;

            $isExistsQuery = "SELECT ISNULL(Billing_Cd, 0) as Billing_Cd FROM ShopBilling WHERE Shop_Cd = $shopCd AND IsActive = 1 AND FinYear = '$FinYear'";
            $isExistsDB = new DbOperation();
            $isExistsResult = $isExistsDB->ExecutveQuerySingleRowSALData($isExistsQuery, $electionName, $developmentMode);
            

            if(empty($isExistsResult)){
                $MaxBillingQuery = 'SELECT MAX(Billing_Cd) as Max_CD FROM ShopBilling'; 
                $MaxBillingDB = new DbOperation();
                $MaxBillingResult = $MaxBillingDB->ExecutveQuerySingleRowSALData($MaxBillingQuery, $electionName, $developmentMode);
                $MaxBillingCd = 0;
                if(!empty($MaxBillingResult)){
                    $MaxBillingCd = $MaxBillingResult['Max_CD'];
                }
                
                
                $Billing_Cd = $MaxBillingCd + 1;

                $BillNo = $Code.'-'.$FinYear.'/'.$shopCd.'-'.$Billing_Cd;
                $LicenseNumber = $Code.'-'.$FinYear.'/'.$shopCd;
                $InsertQuery = "INSERT INTO ShopBilling (Shop_Cd, IsLicenseRenewal, BillingDate, BillNo, FinYear, LicenseFees, ExpiryDate, BillAmount, IsActive,  AddedDate, LicenseStartDate, LicenseEndDate, LicenseNumber) VALUES($shopCd, $RenewalFlag, '$BillingDate', '$BillNo', '$FinYear','$CatAmount', '$LicenseEndDate', '$Amount', 1, GETDATE(), '$LicenseStartDate', '$LicenseEndDate', '$LicenseNumber')";
                // echo $InsertQuery;exit;
                $InsertDB = new DBOperation();
                $result = $InsertDB->RunQuerySALData($InsertQuery, $electionName, $developmentMode);

                 if($result){
                    $ParwanaDetailQuery = "SELECT ISNULL(ParwanaDetCd, 0) as ParwanaDetCd FROM ParwanaDetails WHERE Parwana_Cd = $Parwana_Cd AND IsActive = 1 AND IsRenewal = 1";
                    $ParwanaDetailDB = new DbOperation();
                    $ParwanaDetailResult = $ParwanaDetailDB->ExecutveQuerySingleRowSALData($ParwanaDetailQuery, $electionName, $developmentMode);

                    if(!empty($ParwanaDetailResult)){
                        $ParwanaDetCd = $ParwanaDetailResult['ParwanaDetCd'];
                        $UpdateRenewalFlagQuery = "UPDATE ShopMaster SET ParwanaDetCd = $ParwanaDetCd, RenewalDate = '$LicenseRenewalDate', LicenseNumber = '$LicenseNumber' WHERE Shop_Cd = $shopCd AND IsActive = 1";
                        $UpdateRenewalDB = new DBOperation();
                        $UpdateRenewalDB->RunQuerySALData($UpdateRenewalFlagQuery, $electionName, $developmentMode);
                    }

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Bill Generate Successfully',
                        'Billing_Id' => $Billing_Cd,
                        'Amount' => $Amount,
                        'ShopCd' => $shopCd
                    ]);
                    
                }else{
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to generate bill',
                    ]);
                }  
            }


           
        }
    }
}