<?php

include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $shop_cd = isset($_POST['shop_cd']) ? trim($_POST['shop_cd']) : '';
    $shopcategory = isset($_POST['shopcategory']) ? trim($_POST['shopcategory']) : '';
    $businesscategory = isset($_POST['businesscategory']) ? trim($_POST['businesscategory']) : '';
    $nameofbusiness = isset($_POST['nameofbusiness']) ? trim($_POST['nameofbusiness']) : '';
    $businessdetails = isset($_POST['businessdetails']) ? trim($_POST['businessdetails']) : '';
    $estimatedate = isset($_POST['estimatedate']) ? trim($_POST['estimatedate']) : '';
    $spacetype = isset($_POST['spacetype']) ? trim($_POST['spacetype']) : '';
    $shopownstatus = isset($_POST['shopownstatus']) ? trim($_POST['shopownstatus']) : '';
    $length = isset($_POST['length']) ? trim($_POST['length']) : '';
    $width = isset($_POST['width']) ? trim($_POST['width']) : '';
    $height = isset($_POST['height']) ? trim($_POST['height']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $zoneno = isset($_POST['zoneno']) ? trim($_POST['zoneno']) : '';
    $wardno = isset($_POST['wardno']) ? trim($_POST['wardno']) : '';
    $area = isset($_POST['area']) ? trim($_POST['area']) : '';
    $shopfess = isset($_POST['shopfees']) ? trim($_POST['shopfees']) : '';
    $ShopOwnPeriod = isset($_POST['ShopOwnPeriod']) ? trim($_POST['ShopOwnPeriod']) : '';
 

    $Db = new DbOperation();
    $ParwanaQuery = "SELECT ParwanaDetCd FROM ParwanaDetails WHERE COALESCE(IsRenewal,0) = 0 AND Parwana_Cd = $businessdetails";
    $Parwana = $Db->ExecutveQuerySingleRowSALData($ParwanaQuery, $electionName, $developmentMode);
    $ParwanaDetCd = $Parwana['ParwanaDetCd'];

    // echo "<pre>"; print_r($_POST); exit;

    // exit;

    $db = new DbOperation();

    if (empty($shop_cd)) {
        $sql = "INSERT INTO ShopMaster 
                        (ShopCategory, BusinessCat_Cd, ShopName,ShopOwnStatus, ShopLength,BusinessStartDate, ShopWidth,ShopHeight,ShopAddress_1, Ward_No, ShopArea_Name, ParwanaDetCd, ShopArea_Cd, ShopOwnPeriod, AddedDate, IsActive) 
                 VALUES (
                            '$shopcategory', '$businesscategory', '$nameofbusiness', '$shopownstatus', '$length', 
                            '$estimatedate', '$width', '$height', '$address', '$wardno', '$area', '$ParwanaDetCd', '$spacetype', '$ShopOwnPeriod', GETDATE(), 1
                        )";

        $messaage = "Shop Details Saved successfully";
    } else {

        $sql = "UPDATE ShopMaster 
                SET   
                    ShopCategory = '$shopcategory', 
                    BusinessCat_Cd = '$businesscategory', 
                    ShopName = '$nameofbusiness', 
                    ShopOwnStatus = '$shopownstatus', 
                    ShopLength = '$length', 
                    BusinessStartDate = '$estimatedate', 
                    ShopWidth = '$width', 
                    ShopHeight = '$height', 
                    ShopAddress_1 = '$address', 
                    ShopAddress_2 = '',
                    Ward_No = '$wardno', 
                    ShopArea_Name = '$area',
                    ParwanaDetCd = '$ParwanaDetCd',
                    ShopArea_Cd = '$spacetype', 
                    ShopOwnPeriod = '$ShopOwnPeriod',
                    UpdatedDate = GETDATE(),
                    IsActive = 1
                WHERE Shop_Cd = '$shop_cd'";
        $messaage = "Shop Details Updated successfully";
    }
    // echo $sql;exit;

    $db = new DBOperation();
    $result = $db->RunQuerySALData($sql, $electionName, $developmentMode);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => $messaage
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to save or update data. Please try again.'
        ]);
    }

   


}
?>