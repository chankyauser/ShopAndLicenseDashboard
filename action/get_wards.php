<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];


if (isset($_POST['nodeName'])) {
    $nodeName = $_POST['nodeName'];

    $sql1 = "Select Ward_No FROM [Aurangabad_ShopAndLicense].[dbo].[NodeMaster] where NodeName='$nodeName' ";
    // echo $sql1;
    $db = new DBOperation();
    $zoneno = $db->ExecutveQueryMultipleRowSALData($sql1, $electionName, $developmentMode);
    echo json_encode($zoneno);
}
?>