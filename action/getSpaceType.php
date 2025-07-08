<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

$sql1 = "SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1";
$dbspace = new DbOperation();
$spacetype = $dbspace->ExecutveQueryMultipleRowSALData($sql1, $electionName, $developmentMode);
echo json_encode($spacetype);

?>