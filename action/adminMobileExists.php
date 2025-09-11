<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

$appName = 'ShopAndLicence';
if (isset($_POST['mobileNumber'])) {

    $mobileNumber = $_POST['mobileNumber'];
    $sql1 = "SELECT User_Id
            FROM Survey_Entry_Data..User_Master  
            WHERE Mobile = '$mobileNumber' AND AppName = '$appName'";
    $db = new DBOperation();
    $exists = $db->ExecutveQueryMultipleRowSALData($sql1, $electionName, $developmentMode);
    // print_r($exists);
    // die();
    if ($exists && count($exists) > 0) {
        echo json_encode(['exists' => 1, 'message' => 'Mobile number exists', 'data' => $exists]);
    } else {
        unset($_SESSION['SAL_ShopKeeperMobile']);
        echo json_encode(['exists' => 0, 'message' => 'Mobile number does not exist']);

    }
}
?>