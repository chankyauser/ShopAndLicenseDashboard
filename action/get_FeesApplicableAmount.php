<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$amount = [];

if (isset($_POST['ParwanaCd'])) {
    $ParwanaCd = $_POST['ParwanaCd'];
    if($ParwanaCd != ''){
        $sql1 = "SELECT ParwanaDetCd, Amount, IsRenewal FROM ParwanaDetails WHERE Parwana_Cd = $ParwanaCd AND COALESCE(IsRenewal,0) = 0";
        $db = new DBOperation();
        $amount = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
       
    }

    echo json_encode($amount);
  
}
?>