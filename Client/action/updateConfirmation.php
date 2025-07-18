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