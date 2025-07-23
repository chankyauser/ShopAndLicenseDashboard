<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include "../../api/includes/DbOperation.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format']);
        exit;
    }
    
    $UpdatedBY = $_SESSION['SAL_UserId'];
    $electionName = $_SESSION['SAL_ElectionName'];
    $developmentMode = $_SESSION['SAL_DevelopmentMode'];

    if (isset($data['transactionIds']) && isset($data['status'])) {
        $transactionIds = $data['transactionIds'];
        $status = $data['status'];
        $holdReason = isset($data['holdReason']) ? $data['holdReason'] : '';

        
        $db = new DbOperation();

        foreach ($transactionIds as $transCd) {

           $query = "UPDATE TransactionDetails  SET ConfirmationStatus = '$status', HoldReason = '$holdReason',ConfirmationUpdatedBy = $UpdatedBY, ConfirmationUpdatedDate = GETDATE() WHERE Transaction_Cd = '$transCd'";
           $result = $db->RunQueryData($query, $electionName, $developmentMode);

           if($status == 'Confirm'){
                $db1 = new DbOperation();
                $query = "SELECT Shop_Cd FROM TransactionDetails WHERE Transaction_Cd = '$transCd'";
                $result = $db1->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                $shopCd = $result['Shop_Cd'];

                $CallCatSrNo = 5; 
                $StageSrNo = 16;

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

                


           }
           
        }

        if($result === false) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
            exit;

        }
        echo json_encode(['status' => 'success', 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required data (transactionIds or status)']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}