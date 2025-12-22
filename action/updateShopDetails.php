<?php
session_start();
include '../api/includes/DbOperation.php';

$db = new DbOperation();
$SAL_ElectionName = $_SESSION['SAL_ElectionName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$userId = isset($_SESSION['SAL_UserId']) ? $_SESSION['SAL_UserId'] : NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetFolder = '../uploads/';
    if (!is_dir($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    $Shop_Cd = $_POST['Shop_Cd'] ?? 0;
    $reqFileType = $_POST['document_type'] ?? [];
    $document_cd = $_POST['document_cd'] ?? [];

    $approvalStatuses = $_POST['approval_status'] ?? [];
    // print_r($approvalStatuses);exit;
    $rejectReasons = $_POST['reject_reason'] ?? [];
 
    $remarks = $_POST['remark'] ?? [];
       

    $allFilesUploaded = true;
    $response = [];
// print_r($_POST);exit;
   
    $files = $_FILES['file'] ?? [];

  
    $fileNames = $files['name'] ?? [];

    foreach ($document_cd as $index => $doc_cd) {

        $fileName = $fileNames[$index] ?? '';
        $approvalStatus = $approvalStatuses[$index] ?? NULL;
        $rejectReason   = $rejectReasons[$doc_cd] ?? NULL;
        $remark         = $remarks[$doc_cd] ?? NULL;

        $file_url = NULL;

        if (!empty($fileName) && isset($files['tmp_name'][$index])) {
            $fileTmpName = $files['tmp_name'][$index];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            $allowedTypes = ['pdf'];
            if (($reqFileType[$index] ?? '') == 'image') {
                $allowedTypes = ['jpg', 'jpeg', 'png'];
            }

            if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                $response['message'] = "Invalid file type: " . $fileExtension;
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

            $file_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ShopAndLicenseDashboard/uploads/' . $newFileName;
        }

       
        $DocExistDB = new DbOperation();
        $DocExistQuery = "SELECT ShopDocDet_Cd, FileURL FROM ShopDocuments WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $doc_cd AND IsActive = 1";
        $DocExist = $DocExistDB->ExecutveQuerySingleRowSALData($DocExistQuery, $electionName, $developmentMode);

        if (!empty($DocExist)) {
            $ShopDocDet_Cd = $DocExist['ShopDocDet_Cd'];

            if (!$file_url) $file_url = $DocExist['FileURL'];

            $updateFields = [];

          
            if ($file_url) {
                $updateFields[] = "FileURL = '$file_url'";
            } else {
                $updateFields[] = "FileURL = '{$DocExist['FileURL']}'";
            }

            $updateFields[] = "UpdatedDate = GETDATE()";

           
            $updateFields[] = "Verification_Status = " . (!empty($approvalStatus) ? "'$approvalStatus'" : "NULL");

            
            $updateFields[] = "Verification_Done_By = " . (!empty($userId) ? $userId : "NULL");
            $updateFields[] = "Verification_Done_Date = GETDATE()";

          
            if (!empty($rejectReason) || $rejectReason === '0') {
                $updateFields[] = "Verification_Rejection_Id = $rejectReason";
            } else {
                $updateFields[] = "Verification_Rejection_Id = NULL";
            }

          
            if (strtolower($approvalStatus) === 'rejected') {
                $updateFields[] = "Verification_Rejection_Reason = " . (!empty($remark) ? "'$remark'" : 'NULL');
            }

            $updateDocQuery = "UPDATE ShopDocuments SET " . implode(',', $updateFields) . " WHERE ShopDocDet_Cd = $ShopDocDet_Cd";

            $updateDocDB = new DbOperation();
            $updateDocDB->RunQueryData($updateDocQuery, $electionName, $developmentMode);

        } else {
            if ($file_url) {
                $db1 = new DbOperation();
                $sql = "INSERT INTO ShopDocuments(Shop_Cd, Document_Cd, FileURL, IsActive, UpdatedDate)
                        VALUES($Shop_Cd, $doc_cd, '$file_url', 1, GETDATE())";
                $db1->RunQueryData($sql, $electionName, $developmentMode);
            }
        }
    }

    if ($allFilesUploaded) {
        $response['status'] = 200;
        $response['message'] = "Files and statuses updated successfully.";

        $Db = new DbOperation();
        $sql = "SELECT ShopOwnerMobile FROM ShopMaster WHERE Shop_Cd = $Shop_Cd";
        $result = $Db->ExecutveQuerySingleRowSALData($sql, $electionName, $developmentMode);
        $_SESSION['SAL_ShopKeeperMobile'] = $result['ShopOwnerMobile'];
    }

    echo json_encode($response);
} else {
    echo json_encode(["status" => 400, "message" => "No files were uploaded."]);
}
