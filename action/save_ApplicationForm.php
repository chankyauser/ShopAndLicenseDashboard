<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if (isset($_POST['fullname'])) {
    // Retrieve form data
    $title = trim($_POST['title']);
    $firstname = $_POST['firstname'];
    $parentname = $_POST['parentname'];
    $surname = $_POST['surname'];
    $fullname = $_POST['fullname'];
    $ShopOwnerName = $firstname . " " . $parentname . " " . $surname;
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $aadharno = $_POST['aadharno'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];
    $shopCd = isset($_POST['shop_cd']) ? $_POST['shop_cd'] : 0;

    if (empty($shopCd)) {
        $sql = "INSERT INTO ShopMaster 
                    (Title,ShopOwnerName, ShopKeeperName,ShopOwnerMobile, ShopEmailAddress, ShopOwnerAadharNo, ShopOwnerPinCode, ShopOwnerAddress, FirstName, MiddleName, LastName, IsActive, AddedDate) 
                VALUES ('$title','$ShopOwnerName','$ShopOwnerName', '$mobile', '$email', '$aadharno', '$pincode', '$address', '$firstname', '$parentname', '$surname', 1, GETDATE())";
        
        $messaage = "Shop Application Saved successfully";
    } else {

        $sql = "UPDATE ShopMaster 
                SET 
                    Title = '$title',
                    ShopOwnerName = '$ShopOwnerName', 
                    ShopKeeperName = '$ShopOwnerName', 
                    ShopOwnerMobile = '$mobile', 
                    ShopEmailAddress = '$email', 
                    ShopOwnerAadharNo = '$aadharno', 
                    ShopOwnerPinCode = '$pincode', 
                    ShopOwnerAddress = '$address',
                    FirstName = '$firstname',
                    MiddleName = '$parentname',
                    LastName = '$surname',
                    IsActive = 1,
                    UpdatedDate = GETDATE()
                WHERE Shop_Cd = '$shopCd'";

        $messaage = "Shop Application Updated successfully";
    }

    $db = new DBOperation();
    $result = $db->RunQuerySALData($sql, $electionName, $developmentMode);

    if(empty($shopCd)){
        $Query = "SELECT MAX(Shop_Cd) as shop_cd  FROM ShopMaster";
        $result = $db->ExecutveQuerySingleRowSALData($Query, $electionName, $developmentMode);
        $shopCd = $result['shop_cd'];
    }
   
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => $messaage,
            'Shop_Cd' => $shopCd

        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to save or update data. Please try again.'
        ]);
    }
}
?>