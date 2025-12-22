<?php
session_start();
include '../api/includes/DbOperation.php';
$db = new DbOperation();
$SAL_ElectionName = $_SESSION['SAL_ElectionName'];
// $Shop_Cd = $_SESSION['ShopOwner_Shop_Cd'] || 123;

$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$userId = isset($_SESSION['SAL_UserId']) ? $_SESSION['SAL_UserId'] : NULL;

// echo "<pre>";print_r($_POST);exit;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $targetFolder = '../uploads/';
    if (!is_dir($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    $Shop_Cd = $_POST['Shop_Cd'];

    $reqFileType = $_POST['document_type'];
    $document_cd = $_POST['document_cd'];


    $approvalStatuses = isset($_POST['approval_status']) ? $_POST['approval_status'] : [];
    $rejectReasons = $_POST['reject_reason'] ?? [];
    $remarks = $_POST['remark'] ?? [];
    // $Client=$_POST['Client'];


    $allFilesUploaded = true;

    foreach ($_FILES['file']['name'] as $index => $fileName) {

        $doc_cd = $document_cd[$index];
        $approvalStatus = !empty($approvalStatuses[$index]) ? $approvalStatuses[$index] : NULL;
        $rejectReason = !empty($rejectReasons[$index]) ? $rejectReasons[$index] : NULL;
        $remark = !empty($remarks[$index]) ? $remarks[$index] : NULL;

        $file_url = NULL;


        if (!empty($fileName)) {
            $fileTmpName = $_FILES['file']['tmp_name'][$index];
            $fileSize = $_FILES['file']['size'][$index];
            $doc_cd = $document_cd[$index];
    
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
            $allowedTypes = ['pdf'];
    
            if($reqFileType[$index] == 'image'){
                $allowedTypes = ['jpg', 'jpeg', 'png'];
            }
    
            if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                $response['message'] = "Invalid file type: " . $fileExtension . ". Only " . implode(', ', $allowedTypes) . " files are allowed.";
                $allFilesUploaded = false;
                break;
            }

            $newFileName = time() . "_ShopDocuments_" . $doc_cd . "_" . $Shop_Cd . "_" . $SAL_ElectionName . "." . $fileExtension;
            $filePath = $targetFolder . $newFileName;

            if (!move_uploaded_file($fileTmpName, $filePath)) {
                $response['message'] = "Error moving the file: " . $fileName;
                $allFilesUploaded = false;
                break;
            }

            $file_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ShopLicense/uploads/' . $newFileName;
        }


        $DocExistDB = new DbOperation();
        $DocExistQuery = "SELECT ShopDocDet_Cd FROM ShopDocuments WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $doc_cd AND IsActive = 1";

        $DocExist = $DocExistDB->ExecutveQuerySingleRowSALData($DocExistQuery, $electionName, $developmentMode);

        if (!empty($DocExist)) {

            $ShopDocDet_Cd = $DocExist['ShopDocDet_Cd'];

            $updateFields = [];
            if ($file_url)
                $updateFields[] = "FileURL = '$file_url'";
            $updateFields[] = "UpdatedDate = GETDATE()";
            $updateFields[] = "Verification_Status = " . ($approvalStatus ? "'$approvalStatus'" : 'NULL');
            $updateFields[] = "Verification_Done_By = " . ($userId ? $userId : 'NULL');
            $updateFields[] = "Verification_Done_Date = GETDATE()";
            $updateFields[] = "Verification_Rejection_Id = " . ($rejectReason ? $rejectReason : 'NULL');
            // $updateFields[] = "Verification_Rejection_Reason = ".($remark ? "'$remark'" : 'NULL');

            if (strtolower($approvalStatus) === 'hold') {
                $updateFields[] = "Verification_Hold_Reason = " . ($remark ? "'$remark'" : 'NULL');
                $updateFields[] = "Verification_Rejection_Reason = " . 'NULL';
            } else {
                $updateFields[] = "Verification_Rejection_Reason = " . ($remark ? "'$remark'" : 'NULL');
                $updateFields[] = "Verification_Hold_Reason = " . 'NULL';
            }

            $updateDocQuery = "UPDATE ShopDocuments SET " . implode(',', $updateFields) . " WHERE ShopDocDet_Cd = $ShopDocDet_Cd";
            // echo $updateDocQuery;exit;

            $updateDocDB = new DbOperation();
            $result = $updateDocDB->RunQueryData($updateDocQuery, $electionName, $developmentMode);
        } else {

            if ($file_url) {
                $db1 = new DbOperation();
                $sql = "INSERT INTO ShopDocuments(Shop_Cd, Document_Cd, FileURL, IsActive, UpdatedDate)
                            VALUES($Shop_Cd, $doc_cd, '$file_url', 1, GETDATE())";
                $result = $db1->RunQueryData($sql, $electionName, $developmentMode);
            }
        }

    }

    if ($allFilesUploaded) {
        $response['status'] = 200;
        $response['message'] = "Files Uploaded successfully.";

        $response['isLoggedIn'] = isset($_SESSION['SAL_FullName']) && (isset($_SESSION['SAL_RoleName']) || isset($_SESSION['SAL_UserType'])) ? 1 : 0;

        if (!empty($_SESSION['SAL_RoleName']) || !empty($_SESSION['SAL_UserType'])) {
            unset($_SESSION['SAL_ShopKeeperMobile']);
        }
        if (empty($_SESSION['SAL_RoleName']) && empty($_SESSION['SAL_UserType'])) {

            $Db = new DbOperation();
            $sql = "SELECT ShopOwnerMobile FROM ShopMaster WHERE Shop_Cd = $Shop_Cd";
            $shopData = $Db->ExecutveQuerySingleRowSALData($sql, $electionName, $developmentMode);
            
            if($shopData) {
                $_SESSION['SAL_ShopKeeperMobile'] = $shopData['ShopOwnerMobile'];
            }
        }
        
    //    echo $_SESSION['SAL_ShopKeeperMobile'];exit;
    }

    
    
    echo json_encode($response);
} else {
    echo json_encode(["status" => 400, "message" => "No files were uploaded."]);
}


?>