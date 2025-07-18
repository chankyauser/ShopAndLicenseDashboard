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

        $query = "SELECT LicenseEndDate, LicenseStartDate, LicenseNumber FROM ShopBilling WHERE Billing_Cd = $billingId";
        $result = $DB->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);

        $licenseEndDate = $result['LicenseEndDate'];
        $licenseStartDate = $result['LicenseStartDate'];
        $licenseNumber = $result['LicenseNumber'];

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
        $QRDataURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/ShopAndLicenseDashboard/action/LicenseQR.php?QRKey=' . urlencode($QRKey);

        $Path = '../../app-assets/qrcodes/' . $fileName;

        QRcode::png($QRDataURL, $Path, QR_ECLEVEL_L, 10);
        $QRImageURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/ShopAndLicenseDashboard/app-assets/qrcodes/' . $fileName;

        $UpdateQuery = "UPDATE ShopBilling SET QRCode_URL = '$QRImageURL', QRCode_Key = '$QRKey' WHERE Billing_Cd = $billingId";
        $UpdateDB = new DBOperation();
        $result = $UpdateDB->RunQuerySALData($UpdateQuery, $electionName, $developmentMode);

    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentStatus = '<?php echo strtolower($paymentStatus); ?>';

    if (paymentStatus === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Payment Successful',
            text: 'Redirecting...',
            timer: 2000,
            showConfirmButton: false,
            didClose: () => {
                window.location.href = "../../index.php?p=ShopDetalisListOfOwner";
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