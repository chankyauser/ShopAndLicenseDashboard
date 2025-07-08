
<?php
session_start();
include '../api/includes/DbOperation.php';
$db = new DbOperation();

// $Shop_Cd = 123;
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode= $_SESSION['SAL_DevelopmentMode'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dbshop = new DbOperation();
    $sql = "SELECT DropDown_Cd, DTitle, DValue FROM DropDownMaster WHERE DTitle = 'Category' AND IsActive = 1 ";

    $data = $dbshop->ExecutveQueryMultipleRowSALData($sql, $electionName, $developmentMode);
   
    echo json_encode($data);

}