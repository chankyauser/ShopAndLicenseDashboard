<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

if (isset($json) && !empty($json)) {
    $data = json_decode($json, true);
    $getepayTxnId = $data['getepayTxnId'];
    $txnAmount = $data['txnAmount'];
    $txnStatus = $data['txnStatus'];
    $merchantOrderNo = $data['merchantOrderNo'];
    $paymentStatus = $data['paymentStatus'];
    $txnDate = $data['txnDate'];
    $totalAmount = $data['totalAmount'];
    $paymentMode = $data['paymentMode'];
    $mobileNo = $data['udf1'];
    $txtnote = $data['txnNote'];
    $CallCatSrNo = 7;
    $StageSrNo  = 14;

    if(!isset($_SESSION['SAL_ElectionName'])){
        $_SESSION['SAL_ElectionName']='CSMC';
        $_SESSION['SAL_DevelopmentMode']='Live';
    }
    
    $_SESSION['SAL_ShopKeeperMobile'] = $mobileNo;

    $UpdateQuery = "UPDATE TransactionDetails 
        SET 
            getepayTxnId = '$getepayTxnId',
            Amount = '$txnAmount',
            TransStatus = '$txnStatus',
            TranDateTime = '$txnDate',
            paymentMode = '$paymentMode',
            paymentStatus = '$paymentStatus',
            txnAmount = '$totalAmount',
            TransNumber = '$getepayTxnId',
            txnNote = '$txtnote',
            ConfirmationStatus = 'Pending'
        WHERE Transaction_Cd = $merchantOrderNo";

    $UpdateDB = new DBOperation();
    $result = $UpdateDB->RunQuerySALData($UpdateQuery, $electionName, $developmentMode);
    
    
    if ($result) {
        $DB = new DBOperation();
        $query = "SELECT Billing_Cd,TransNumber FROM TransactionDetails WHERE Transaction_Cd = $merchantOrderNo";
        $result = $DB->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        
        $billingId = $result['Billing_Cd'];
        $transNumber = $result['TransNumber'];

        $query = "SELECT LicenseEndDate, LicenseStartDate, LicenseNumber, Shop_Cd FROM ShopBilling WHERE Billing_Cd = $billingId";
        $result = $DB->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
    
        $licenseEndDate = $result['LicenseEndDate'];
        $licenseStartDate = $result['LicenseStartDate'];
        $licenseNumber = $result['LicenseNumber'];
        $shopCd = $result['Shop_Cd'];

        $CallCategoryQuery = "SELECT Calling_Category_Cd, Calling_Category FROM CallingCategoryMaster WHERE IsActive = 1 AND SrNo = $CallCatSrNo AND Calling_Type = 'Collection'";
        $CallCategoryDB = new DbOperation();
        $CallCategoryResult = $CallCategoryDB->ExecutveQuerySingleRowSALData($CallCategoryQuery, $electionName, $developmentMode);

        if($CallCategoryResult){
            $ScheduleCall_Cd = 0;
            $Calling_Category_Cd = $CallCategoryResult['Calling_Category_Cd'];
            $Calling_Category = $CallCategoryResult['Calling_Category'];

            $ExistScheduleQuery = "SELECT ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $Calling_Category_Cd";
            $ExistScheduleDB = new DbOperation();
            $ExistScheduleResult = $ExistScheduleDB->ExecutveQuerySingleRowSALData($ExistScheduleQuery, $electionName, $developmentMode);

            if($ExistScheduleResult){
                $ScheduleCall_Cd = $ExistScheduleResult['ScheduleCall_Cd'];

                $UpdateScheduleQuery = "UPDATE ScheduleDetails SET Shop_Cd = $shopCd, Calling_Category_Cd = $Calling_Category_Cd, IsActive = 1, CallReason = '$Calling_Category', UpdatedDate = GETDATE() WHERE ScheduleCall_Cd = $ScheduleCall_Cd";
                $UpdateScheduleDB = new DBOperation();
                $schedule = $UpdateScheduleDB->RunQuerySALData($UpdateScheduleQuery, $electionName,$developmentMode);           
            }else{
                    $InsertScheduleQuery = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, CallReason, IsActive, UpdatedDate) VALUES($shopCd, $Calling_Category_Cd, '$Calling_Category', 1, GETDATE())";
                    $InsertScheduleDB = new DBOperation();
                    $schedule = $InsertScheduleDB->RunQuerySALData($InsertScheduleQuery, $electionName, $developmentMode);

                    $MaxScheduleIdQuery = "SELECT MAX(ScheduleCall_Cd) as ScheduleCall_Cd FROM ScheduleDetails";
                    $MaxScheduleIdDB = new DbOperation();
                    $MaxScheduleIdResult = $MaxScheduleIdDB->ExecutveQuerySingleRowSALData($MaxScheduleIdQuery, $electionName, $developmentMode);
                    $ScheduleCall_Cd = $MaxScheduleIdResult['ScheduleCall_Cd'];
            }

            if($ScheduleCall_Cd !== 0){
                $StageQuery = "SELECT DropDown_Cd, DValue, DTitle FROM DropDownMaster WHERE DTitle = 'StageName' AND IsActive = 1 AND  SerialNo = $StageSrNo";
                $StageDB = new DbOperation();
                $StageResult = $StageDB->ExecutveQuerySingleRowSALData($StageQuery, $electionName, $developmentMode);
                            
                if($StageResult){
                    $StageCd = $StageResult['DropDown_Cd'];
                    $StageName = $StageResult['DValue'];

                    $ExistTrackQuery = "SELECT ST_Cd FROM ShopTracking WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $shopCd AND Calling_Category_Cd = $Calling_Category_Cd AND ST_StageName = '$StageName'";
                    $ExistTrackDB = new DbOperation();
                    $ExistTrackResult = $ExistTrackDB->ExecutveQuerySingleRowSALData($ExistTrackQuery, $electionName, $developmentMode);

                    if($ExistTrackResult){
                        $ST_Cd  = $ExistTrackResult['ST_Cd'];
                        $TrackQuery = "UPDATE ShopTracking SET ST_StageName = '$StageName', ScheduleCall_Cd = $ScheduleCall_Cd, Shop_Cd = $shopCd, Calling_Category_Cd = $Calling_Category_Cd, UpdatedDate = GETDATE(), ST_Status = 1, ST_DateTime = GETDATE() WHERE ST_Cd = $ST_Cd";
                        $TrackDB = new DbOperation();
                        $TrackDB->RunQuerySALData($TrackQuery, $electionName, $developmentMode);
                    }else{
                        $InsertTrackQuery = "INSERT INTO ShopTracking (ST_StageName, ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd, ST_DateTime, UpdatedDate, ST_Status) VALUES('$StageName', $ScheduleCall_Cd, $shopCd, $Calling_Category_Cd, GETDATE(), GETDATE(), 1)";
                        $InsertTrackDB = new DbOperation();
                        $InsertTrackDB->RunQuerySALData($InsertTrackQuery, $electionName, $developmentMode);
                    }
                }
            }
        }

        //UAT -----------------
            $key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
            $iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g==');

        // LIVE -----------------
        // $key = base64_decode('tPjvm0W0iIO4lpX/Ry9VQcGGcx0gAB1D1salkTrtpP4=');
        // $iv = base64_decode('FRaquqRsN0nrEStG0ukNOA==');

        $data = json_encode([
            'billingId' => $billingId,
            'licenseStartDate' => $licenseStartDate,
            'licenseEndDate' => $licenseEndDate,
            'licenseNumber' => $licenseNumber,
            'transNumber' => $transNumber,
        ]);

        $QRKey_raw = openssl_encrypt($data, "AES-256-CBC", $key, $options = OPENSSL_RAW_DATA, $iv);
        $QRKeytext = bin2hex($QRKey_raw);
        $QRKey = strtoupper($QRKeytext);

        include('../../phpqrcode/qrlib.php');

        $billingId = intval($billingId);
        $QRKey = trim($QRKey);

        $fileName = 'QR_' . $billingId . '.png';
        // $QRDataURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/ShopAndLicenseDashboard/action/LicenseQR.php?QRKey=' . urlencode($QRKey);
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];

        $QRDataURL = $protocol . '://' . $host . '/ShopAndLicenseDashboard/action/LicenseQR.php?QRKey=' . urlencode($QRKey);

        $Path = '../../app-assets/qrcodes/' . $fileName;

        QRcode::png($QRDataURL, $Path, QR_ECLEVEL_L, 10);
        $QRImageURL = $protocol . '://' . $host . '/ShopAndLicenseDashboard/app-assets/qrcodes/' . $fileName;

        $UpdateQuery = "UPDATE ShopBilling SET QRCode_URL = '$QRImageURL', QRCode_Key = '$QRKey' WHERE Billing_Cd = $billingId";
        $UpdateDB = new DBOperation();
        $result = $UpdateDB->RunQuerySALData($UpdateQuery, $electionName, $developmentMode);

        

    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentStatus = '<?php echo strtolower($paymentStatus); ?>';
    const billing_id = '<?php echo $billingId; ?>';

    if (paymentStatus === 'success') {

        $.ajax({
            url: "../../mail_files/sendApplicationMail.php",
            type: "POST",
            data: {
                Billing_Cd: billing_id,
                operation: 'licensePayment'
            },
            success: function(response) {
                console.log(response);
            }
        });

        Swal.fire({
            icon: 'success',
            title: 'Payment Successful',
            text: 'Redirecting...',
            timer: 2000,
            showConfirmButton: false,
            didClose: () => {
                window.location.href =
                    "../../index.php?p=ShopDetalisListOfOwner";
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Payment Failed',
            text: 'Oops! Your payment could not be processed.',
            showConfirmButton: true,
            didClose: () => {
                window.location.href = "../../index.php?p=ShopDetalisListOfOwner";
            }
        });
    }
});
</script>
<?php
    }
}else{
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Payment Failed',
        text: 'Oops! Your payment could not be processed.',
        showConfirmButton: false,
        didClose: () => {
            window.location.href = "../../index.php?p=ShopDetalisListOfOwner";
        }
    });
});
</script>
<?php
}
?>