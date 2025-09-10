<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

session_start();  

$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$userId = $_SESSION['SAL_UserId'];

include "../../api/includes/DbOperation.php";

$db = new DbOperation();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

$baseURL = $protocol  . '://' . $host . '/ShopAndLicenseDashboard/Client/uploads/notices/';


$targetDir = '../uploads/notices/';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if ($_POST['action'] === 'insertNotice') {

    $Calling_Category_Cd = $_POST['Calling_Category_Cd'] ?? 'NULL';
    $Notice_Type = $_POST['Notice_Type'] ?? '';
    $Subject = $_POST['Subject'] ?? '';
    $Description = $_POST['Description'] ?? '';
    $Remark = $_POST['Remark'] ?? '';
    $Response_Received = $_POST['Response_Received'] ?? '';
    $Status = $_POST['Status'] ?? '';
    $Acknowledged_Date = $_POST['Acknowledged_Date'] ?? null;
    $Notice_date = $_POST['Notice_date'] ?? null;
    $DeliveredBy = $_POST['DeliveredBy'] ?? 'NULL';
    $Shop_Cd = $_POST['Shop_Cd'] ?? 'NULL';
    $fileName = '';

    $fileURL = '';
    if (isset($_FILES["NoticeFileURL"]) && $_FILES["NoticeFileURL"]["error"] === UPLOAD_ERR_OK) {
        $fileName = time() . '_' . basename($_FILES["NoticeFileURL"]["name"]);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES["NoticeFileURL"]["tmp_name"], $targetFile)) {
            $fileURL = $baseURL . $fileName;
        }
    } elseif (!empty($_POST['capturedImageData'])) {
        $imageData = $_POST['capturedImageData'];
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'png' ])) {
                echo json_encode(['status' => 'fail', 'message' => 'Unsupported image type.']);
                exit;
            }

            $imageData = base64_decode($imageData);
            if ($imageData === false) {
                echo json_encode(['status' => 'fail', 'message' => 'Base64 decode failed.']);
                exit;
            }

            $fileName = time() . '_captured.' . $type;
            $filePath = $targetDir . $fileName;

            if (file_put_contents($filePath, $imageData)) {
                $fileURL = $baseURL . $fileName;
            } else {
                echo json_encode(['status' => 'fail', 'message' => 'Failed to save captured image.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Invalid image data format.']);
            exit;
        }
    }


    $insertSQL = "INSERT INTO ShopNoticeDetails (
        Calling_Category_Cd, Shop_Cd, Notice_Date, Notice_Type, Subject, Description,
        NoticeFileURL, Remark, Response_Received, Status, IsActive,
        Acknowledged_Date, AddedBy, AddedDate, DeliveredBy, DeliveredDate
    ) VALUES (
        $Calling_Category_Cd, $Shop_Cd, '$Notice_date', '$Notice_Type', '$Subject', '$Description',
        '$fileURL', '$Remark', '$Response_Received', '$Status', 1,
        '$Acknowledged_Date', $userId, GETDATE(), $DeliveredBy, '$Acknowledged_Date'
    )";

    $result = $db->RunQueryData($insertSQL, $electionName, $developmentMode);
 

    $Notice_Id = '';
    if($result){
        $NoticeIdQuery = "SELECT MAX(Notice_Id) as Notice_Id FROM ShopNoticeDetails";
        $Res = $db->ExecutveQuerySingleRowSALData($NoticeIdQuery, $electionName, $developmentMode);
        // echo "<pre>"; print_r($NoticeId);echo "</pre>";exit;
        if($Res){
            $Notice_Id = $Res['Notice_Id'];
        }
    }

    echo json_encode(['status' => $result ? 'success' : 'fail', 'Id' => $Notice_Id]);
    exit;
}

if ($_POST['action'] === 'updateNotice') {

    $Notice_Id = $_POST['Notice_Id'] ?? '';
    $Calling_Category_Cd = $_POST['Calling_Category_Cd'] ?? 'NULL';
    $Notice_Type = $_POST['Notice_Type'] ?? '';
    $Subject = $_POST['Subject'] ?? '';
    $Description = $_POST['Description'] ?? '';
    $Remark = $_POST['Remark'] ?? '';
    $Response_Received = $_POST['Response_Received'] ?? '';
    $Status = $_POST['Status'] ?? '';
    $Acknowledged_Date = $_POST['Acknowledged_Date'] ?? null;
    $Notice_date = $_POST['Notice_date'] ?? null;
    $DeliveredBy = $_POST['DeliveredBy'] ?? 'NULL';
    $Shop_Cd = $_POST['Shop_Cd'] ?? 'NULL';
    $fileNameSQL = '';

    // Optional file upload handling
    $fileURLSQL = ''; // Will hold SQL snippet if file uploaded

    if (isset($_FILES['NoticeFileURL']) && $_FILES['NoticeFileURL']['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . '_' . basename($_FILES["NoticeFileURL"]["name"]);
        $targetFile = $targetDir . $fileName;

        // if (move_uploaded_file($_FILES["NoticeFileURL"]["tmp_name"], $targetFile)) {
        //     $fileURL = $baseURL . $fileName;
        //     $fileURLSQL = ", NoticeFileURL = '$fileURL'";
        // } else {
        //     echo json_encode(['status' => 'fail', 'message' => 'Failed to move uploaded file.']);
        //     exit;
        // }

        if ($_FILES["NoticeFileURL"]["error"] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'fail', 'message' => 'Upload error code: ' . $_FILES["NoticeFileURL"]["error"]]);
            exit;
        }

        if (!is_uploaded_file($_FILES["NoticeFileURL"]["tmp_name"])) {
            echo json_encode(['status' => 'fail', 'message' => 'File is not uploaded via HTTP POST.']);
            exit;
        }

        if (move_uploaded_file($_FILES["NoticeFileURL"]["tmp_name"], $targetFile)) {
            $fileURL = $baseURL . $fileName;
            $fileURLSQL = ", NoticeFileURL = '$fileURL'";
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Failed to move uploaded file.']);
            exit;
        }
    }
    if (empty($fileURLSQL) && !empty($_POST['capturedImageData'])) {
        $imageData = $_POST['capturedImageData'];
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, [ 'jpg', 'jpeg', 'png' ])) {
                echo json_encode(['status' => 'fail', 'message' => 'Unsupported image type.']);
                exit;
            }

            $imageData = base64_decode($imageData);
            if ($imageData === false) {
                echo json_encode(['status' => 'fail', 'message' => 'Base64 decode failed.']);
                exit;
            }

            $fileName = time() . '_captured.' . $type;
            $filePath = $targetDir . $fileName;

            if (file_put_contents($filePath, $imageData)) {
                $fileURL = $baseURL . $fileName;
                $fileURLSQL = ", NoticeFileURL = '$fileURL'";
            } else {
                echo json_encode(['status' => 'fail', 'message' => 'Failed to save captured image.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Invalid captured image format.']);
            exit;
        }
    }

    $updateSQL = "UPDATE ShopNoticeDetails SET
        Calling_Category_Cd = $Calling_Category_Cd,
        Shop_Cd = $Shop_Cd,
        Notice_Date = '$Notice_date',
        Notice_Type = '$Notice_Type',
        Subject = '$Subject',
        Description = '$Description'
        $fileURLSQL,
        Remark = '$Remark',
        Response_Received = '$Response_Received',
        Status = '$Status',
        Acknowledged_Date = '$Acknowledged_Date',
        DeliveredBy = $DeliveredBy,
        UpdatedBy = $userId,
        UpdatedDate = GETDATE()
        WHERE Notice_Id = $Notice_Id";

    $result = $db->RunQueryData($updateSQL, $electionName, $developmentMode);
    echo json_encode(['status' => $result ? 'success' : 'fail', 'Id' => $Notice_Id]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
