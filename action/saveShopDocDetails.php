<?php
session_start();
include '../api/includes/DbOperation.php';
$db = new DbOperation();
$SAL_ElectionName = $_SESSION['SAL_ElectionName'] ;
// $Shop_Cd = $_SESSION['ShopOwner_Shop_Cd'] || 123;

$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode= $_SESSION['SAL_DevelopmentMode'];

// echo "<pre>";print_r($_POST);exit;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $targetFolder = '../uploads/';
    if (!is_dir($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    $Shop_Cd = $_POST['Shop_Cd'];

    $reqFileType = $_POST['document_type'];
    $document_cd = $_POST['document_cd'];

    $allFilesUploaded = true;

    foreach ($_FILES['file']['name'] as $index => $fileName) {

        if(!empty($fileName)){
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
    
            $newFileName = time()."_".'ShopDocuments_'.$doc_cd. "_" . time() ."_".$Shop_Cd."_".$SAL_ElectionName. "." . $fileExtension;
            $filePath = $targetFolder . $newFileName;
            // echo $filePath;exit;
    
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $file_url = 'http://' . $_SERVER['HTTP_HOST'] . '/ShopLicense/uploads/' . $newFileName;
    
                $DocExistDB = new DbOperation();
                $DocExistQuery  = "SELECT ShopDocDet_Cd FROM ShopDocuments WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $doc_cd AND IsActive = 1";
                $DocExist = $DocExistDB->ExecutveQuerySingleRowSALData($DocExistQuery, $electionName, $developmentMode);
                // echo "<pre>"; print_r($DocExist);exit;
    
                if(!empty($DocExist)){
                    $ShopDocDet_Cd = $DocExist['ShopDocDet_Cd'];
                    $updateDocDB = new DbOperation();
                    $updateDocQuery = "UPDATE ShopDocuments SET Shop_Cd = $Shop_Cd, Document_Cd = $doc_cd, FileURL = '$file_url', IsActive = 1, UpdatedDate = GETDATE() WHERE ShopDocDet_Cd = $ShopDocDet_Cd";
                    $result = $updateDocDB->RunQueryData($updateDocQuery, $electionName, $developmentMode);
                }else{
                    $db1 = new DbOperation();
                    $sql = "INSERT INTO ShopDocuments(Shop_Cd, Document_Cd, FileURL, IsActive, UpdatedDate) VALUES($Shop_Cd, $doc_cd, '$file_url', 1, GETDATE())";
                    $result = $db1->RunQueryData($sql, $electionName, $developmentMode);
                }

    
                if ($result) {
                    $response['status'] = 200;
                    $response['message'] = "File uploaded successfully.";
                } else {
                    $response['message'] = "Failed to save document details to the database.";
                    $allFilesUploaded = false;
                }
            }else {
                $response['message'] = "Error moving the file: " . $fileName;
                $allFilesUploaded = false;
                break;
            }
        }
    }

    if ($allFilesUploaded) {
        $response['status'] = 200;
        $response['message'] = "Files Uploaded successfully.";

        $Db = new DbOperation();
        $sql = "SELECT ShopOwnerMobile FROM ShopMaster WHERE Shop_Cd = $Shop_Cd";
        $result = $Db->ExecutveQuerySingleRowSALData($sql, $electionName, $developmentMode);
        $_SESSION['SAL_ShopKeeperMobile'] = $result['ShopOwnerMobile'];
    }

    
    
    echo json_encode($response);
} else {
    echo json_encode(["status" => 400, "message" => "No files were uploaded."]);
}


?>