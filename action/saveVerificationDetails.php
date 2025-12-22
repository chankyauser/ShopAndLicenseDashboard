<?php
session_start();
include '../api/includes/DbOperation.php';
$db = new DbOperation();

header('Content-Type: application/json');

$electionName = $_SESSION['SAL_ElectionName'] ?? '';
$userId = $_SESSION['SAL_UserId'] ?? '';
$developmentMode = $_SESSION['SAL_DevelopmentMode'] ?? 0;

$Shop_Cd = $_POST['Shop_Cd'] ?? '';
// $verificationDetails = json_decode($_POST['VerificationDetails'], true);

if (empty($Shop_Cd) ) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}


        $Approval_Stage_Id = $_POST['Approval_Stage_Id']?? 0;
        $Status = $_POST['Status'] ?? '';
        $Rejection_Reason = $_POST['Reason'] ?? null;
        $Remark = $_POST['Remark'] ?? null;

        $Rejection_Remark = null;
        $Hold_Remark = null;

        if (strtolower($Status) === 'rejected') {
            $Rejection_Remark = $Remark;
            $Remark = null; 
        } elseif (strtolower($Status) === 'hold') {
            $Hold_Remark = $Remark;
            $Remark = null; 
        }

  
        $checkQuery = "
            SELECT COUNT(*) AS count 
            FROM Application_Approval_Details 
            WHERE Shop_Cd = '$Shop_Cd' AND Approval_Stage_Id = '$Approval_Stage_Id'
        ";
        $result = $db->ExecutveQuerySingleRowSALData($checkQuery, $electionName, $developmentMode);

        if (!empty($result['count']) && $result['count'] > 0) {
           
            $updateQuery = "
                UPDATE Application_Approval_Details
                SET 
                    Status = " . ($Status ? "'$Status'" : "NULL") . ",
                    Remark = " . ($Remark ? "'$Remark'" : "NULL") . ",
                    Rejection_Reason = " . ($Rejection_Reason ? "'$Rejection_Reason'" : "NULL") . ",
                    Rejection_Remark = " . ($Rejection_Remark ? "'$Rejection_Remark'" : "NULL") . ",
                    Hold_Remark = " . ($Hold_Remark ? "'$Hold_Remark'" : "NULL") . ",
                    Updated_By = '$userId',
                    Updated_Date = GETDATE()
                WHERE Shop_Cd = '$Shop_Cd' AND Approval_Stage_Id = '$Approval_Stage_Id'
            ";
            // echo $updateQuery;die;
            $db->RunQuerySALData($updateQuery, $electionName, $developmentMode);
        } else {
           
            $insertQuery = "
                INSERT INTO Application_Approval_Details
                    (Shop_Cd, Approval_Stage_Id, Status, Remark, Rejection_Reason, Rejection_Remark, Hold_Remark, Updated_By, Updated_Date)
                VALUES (
                    '$Shop_Cd',
                    '$Approval_Stage_Id',
                    " . ($Status ? "'$Status'" : "NULL") . ",
                    " . ($Remark ? "'$Remark'" : "NULL") . ",
                    " . ($Rejection_Reason ? "'$Rejection_Reason'" : "NULL") . ",
                    " . ($Rejection_Remark ? "'$Rejection_Remark'" : "NULL") . ",
                    " . ($Hold_Remark ? "'$Hold_Remark'" : "NULL") . ",
                    '$userId',
                    GETDATE()
                )
            ";
            $db->RunQuerySALData($insertQuery, $electionName, $developmentMode);
        }
    

    echo json_encode(['status' => 'success']);

?>
