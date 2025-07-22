<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if(isset($_POST['shopCd']) && !empty($_POST['shopCd'])){

    // echo "<pre>"; print_r($_POST);exit;

    $Code = $electionName;

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

            $CallCatSrNo = 6;
            $StageSrNo = 18;

            if(isset($_POST['renewFlag']) && !empty($_POST['renewFlag']) && $_POST['renewFlag'] === 1){
                $RenewalDate = $sd['RenewalDate'];
                $LicenseRenewalDate = (clone $RenewalDate)->modify('+1 day')->format("Y-m-d");
                $CallCatSrNo = 12;
                $StageSrNo = 15;
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

                $MaxBillingQuery = 'SELECT MAX(Billing_Cd) as Max_CD FROM ShopBilling'; 
                $MaxBillingDB = new DbOperation();
                $MaxBillingResult = $MaxBillingDB->ExecutveQuerySingleRowSALData($MaxBillingQuery, $electionName, $developmentMode);
                $MaxBillingCd = 0;
                if (!empty($MaxBillingResult)) {
                    $LastInsertId = $MaxBillingResult['Max_CD'];
                    $Billing_Cd = $LastInsertId;
                    $BillNo = $Code.'-'.$FinYear.'/'.$shopCd.'-'.$Billing_Cd;

                    $UpdateQuery = "UPDATE ShopBilling SET BillNo = '$BillNo' WHERE Billing_Cd = $Billing_Cd";
                    $UpdateDB = new DBOperation();
                    $result = $UpdateDB->RunQuerySALData($UpdateQuery, $electionName, $developmentMode);
                }


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

                    $CallCategoryQuery = "SELECT Calling_Category_Cd, Calling_Category FROM CallingCategoryMaster WHERE IsActive = 1 AND SrNo = $CallCatSrNo AND Calling_Type = 'Collection'";
                    $CallCategoryDB = new DbOperation();
                    $CallCategoryResult = $CallCategoryDB->ExecutveQuerySingleRowSALData($CallCategoryQuery, $electionName, $developmentMode);

                    if($CallCategoryResult){
                        $ScheduleCall_Cd = 0;
                        $Calling_Category_Cd = $CallCategoryResult['Calling_Category_Cd'];
                        $Calling_Category = $CallCategoryResult['Calling_Category'];

                        $ExistScheduleQuery = "SELECT ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $Calling_Category_Cd";
                        $ExistScheduleDB = new DbOperation();
                        $ExistScheduleResult = $ExistScheduleDB->ExecutveQuerySingleRowSALData($ExistScheduleQuery, $electionName, $developmentMode);

                        
                        if($ExistScheduleResult){
                            $ScheduleCall_Cd = $ExistScheduleResult['ScheduleCall_Cd'];

                            $UpdateScheduleQuery = "UPDATE ScheduleDetails SET Shop_Cd = $shopCd, Calling_Category_Cd = $Calling_Category_Cd, IsActive = 1, CallReason = '$Calling_Category', UpdatedDate = GETDATE() WHERE ScheduleCall_Cd = $ScheduleCall_Cd";
                            $UpdateScheduleDB = new DBOperation();
                            $schedule = $UpdateScheduleDB->RunQuerySALData($UpdateScheduleQuery, $electionName,$developmentMode);
                            
                        }else{
                            $InsertScheduleQuery = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, CallReason, IsActive, UpdatedDate) VALUES($shopCd, $Calling_Category_Cd, '$Calling_Category', 1, GETDATE())";
                            $InsertScheduleDB = new DBOperation();
                            $schedule = $InsertScheduleDB->RunQuerySALData($InsertScheduleQuery, $electionName, $developmentMode);

                            $MaxScheduleIdQuery = "SELECT MAX(ScheduleCall_Cd) as ScheduleCall_Cd FROM ScheduleDetails";
                            $MaxScheduleIdDB = new DbOperation();
                            $MaxScheduleIdResult = $MaxScheduleIdDB->ExecutveQuerySingleRowSALData($MaxScheduleIdQuery, $electionName, $developmentMode);
                            $ScheduleCall_Cd = $MaxScheduleIdResult['ScheduleCall_Cd'];
                        }

                        if($ScheduleCall_Cd !== 0){
                             $StageQuery = "SELECT DropDown_Cd, DValue, DTitle FROM DropDownMaster WHERE DTitle = 'StageName' AND IsActive = 1 AND  SerialNo = $StageSrNo";
                            $StageDB = new DbOperation();
                            $StageResult = $StageDB->ExecutveQuerySingleRowSALData($StageQuery, $electionName, $developmentMode);
                            
                            if($StageResult){
                                $StageCd = $StageResult['DropDown_Cd'];
                                $StageName = $StageResult['DValue'];

                                $ExistTrackQuery = "SELECT ST_Cd FROM ShopTracking WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $shopCd AND Calling_Category_Cd = $Calling_Category_Cd AND ST_StageName = '$StageName'";
                                $ExistTrackDB = new DbOperation();
                                $ExistTrackResult = $ExistTrackDB->ExecutveQuerySingleRowSALData($ExistTrackQuery, $electionName, $developmentMode);

                                if($ExistTrackResult){
                                    $ST_Cd  = $ExistTrackResult['ST_Cd'];
                                    $TrackQuery = "UPDATE ShopTracking SET ST_StageName = '$StageName', ScheduleCall_Cd = $ScheduleCall_Cd, Shop_Cd = $shopCd, Calling_Category_Cd = $Calling_Category_Cd, UpdatedDate = GETDATE(), ST_Status = 1, ST_DateTime = GETDATE() WHERE ST_Cd = $ST_Cd";
                                    $TrackDB = new DbOperation();
                                    $TrackDB->RunQuerySALData($TrackQuery, $electionName, $developmentMode);
                                }else{
                                    $InsertTrackQuery = "INSERT INTO ShopTracking (ST_StageName, ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd, ST_DateTime, UpdatedDate, ST_Status) VALUES('$StageName', $ScheduleCall_Cd, $shopCd, $Calling_Category_Cd, GETDATE(), GETDATE(), 1)";
                                    $InsertTrackDB = new DbOperation();
                                    $InsertTrackDB->RunQuerySALData($InsertTrackQuery, $electionName, $developmentMode);
                                }
                            }
                        }
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