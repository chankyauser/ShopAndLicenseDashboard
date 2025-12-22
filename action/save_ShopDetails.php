<?php

include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   
  
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
    $wardno = isset($_POST['wardno']) ? trim($_POST['wardno']) : 0;
    $area = isset($_POST['area']) ? trim($_POST['area']) : '';
    $shopfess = isset($_POST['shopfees']) ? trim($_POST['shopfees']) : '';
    $ShopOwnPeriod = isset($_POST['ShopOwnPeriod']) ? trim($_POST['ShopOwnPeriod']) : '';

    $targetFolder = '../uploads/';
    if (!is_dir($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }
    $imagePaths = [];

    $existingImages = [];

    if (!empty($shop_cd)) {
        $existingQuery = "SELECT ShopInsideImage1, ShopInsideImage2, ShopOutsideImage1, ShopOutsideImage2 
                        FROM ShopMaster WHERE Shop_Cd = '$shop_cd'";
        $Dbexist = new DbOperation();
        $existingData = $Dbexist->ExecutveQuerySingleRowSALData($existingQuery, $electionName, $developmentMode);
        if ($existingData) {
            $existingImages = $existingData;
        }
    }


    // $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $imageFields = ['innerimage1', 'innerimage2', 'outerimage1', 'outerimage2'];
    $fieldToDbColumnMap = [
        'innerimage1' => 'ShopInsideImage1',
        'innerimage2' => 'ShopInsideImage2',
        'outerimage1' => 'ShopOutsideImage1',
        'outerimage2' => 'ShopOutsideImage2',
    ];

    foreach ($imageFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$field]['tmp_name'];
            $fileName = basename($_FILES[$field]['name']);                                     
            $fileType = mime_content_type($fileTmpPath);

            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExt = ['jpg', 'jpeg', 'png'];

            if (!in_array($ext, $allowedExt)) {
                echo json_encode(['status' => 'error', 'message' => "Only JPEG, JPG, PNG allowed for $field"]);
                exit;
            }

            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = time()."_".'ShopMaster_'.$field. "_".$shop_cd."_".$electionName. "." . $ext;
            $destPath = $targetFolder . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePaths[$field] = 'http://' . $_SERVER['HTTP_HOST'] . '/ShopLicense/uploads/' . $newFileName; 
            } else {
                echo json_encode(['status' => 'error', 'message' => "Failed to upload $field"]);
                exit;
            }
        }  else {
            $columnName = $fieldToDbColumnMap[$field];
            $imagePaths[$field] = isset($existingImages[$columnName]) ? $existingImages[$columnName] : '';
            
            if (empty($shop_cd) && in_array($field, ['innerimage1', 'outerimage1'])) {
                echo json_encode(['status' => 'error', 'message' => "$field is required"]);
                exit;
            }
            // $imagePaths[$field] = ''; 
        }
    }

    // echo $imagePaths['innerimage1'];exit;
    $Db = new DbOperation();
    $ParwanaQuery = "SELECT ParwanaDetCd FROM ParwanaDetails WHERE IsActive = 1 AND COALESCE(IsRenewal,0) = 0 AND Parwana_Cd = $businessdetails";
    $Parwana = $Db->ExecutveQuerySingleRowSALData($ParwanaQuery, $electionName, $developmentMode);
    $ParwanaDetCd = $Parwana['ParwanaDetCd'];


    $db = new DbOperation();

    if (empty($shop_cd)) {
        $sql = "INSERT INTO ShopMaster 
                        (ShopCategory, BusinessCat_Cd, ShopName,ShopOwnStatus, ShopLength,BusinessStartDate, ShopWidth,ShopHeight,ShopAddress_1, Ward_No, ShopArea_Name, ParwanaDetCd, ShopArea_Cd, ShopOwnPeriod, AddedDate, IsActive,ShopInsideImage1,ShopInsideImage2,ShopOutsideImage1,ShopOutsideImage2) 
                 VALUES (
                            '$shopcategory', '$businesscategory', '$nameofbusiness', '$shopownstatus', '$length', 
                            '$estimatedate', '$width', '$height', '$address', '$wardno', '$area', '$ParwanaDetCd', '$spacetype', '$ShopOwnPeriod', GETDATE(), 1,
                            '{$imagePaths['innerimage1']}', '{$imagePaths['innerimage2']}', '{$imagePaths['outerimage1']}', '{$imagePaths['outerimage2']}'
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
                    Ward_No = $wardno,
                    ShopArea_Name = '$area',
                    ParwanaDetCd = '$ParwanaDetCd',
                    ShopArea_Cd = '$spacetype', 
                    ShopOwnPeriod = '$ShopOwnPeriod',
                    ShopInsideImage1 = '{$imagePaths['innerimage1']}',
                    ShopInsideImage2 = '{$imagePaths['innerimage2']}',
                    ShopOutsideImage1 = '{$imagePaths['outerimage1']}',
                    ShopOutsideImage2 = '{$imagePaths['outerimage2']}',
                    UpdatedDate = GETDATE(),
                    IsActive = 1
                WHERE Shop_Cd = '$shop_cd'";
        $messaage = "Shop Details Updated successfully";
    }
    
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