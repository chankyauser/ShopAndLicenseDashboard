<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];


if (isset($_POST['businessCatCd'])) {
    $businessCatCd = $_POST['businessCatCd'];


    $sql1 = "SELECT Parwana_Cd, Parwana_Name_Eng FROM ParwanaMaster WHERE  BusinessCat_Cd = $businessCatCd";
    $db = new DBOperation();
    $businessDetails = $db->ExecutveQueryMultipleRowSALData($sql1, $electionName, $developmentMode);
    echo json_encode($businessDetails);
}
?>