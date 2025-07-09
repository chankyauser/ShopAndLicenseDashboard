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
            TransNumber = '$getepayTxnId'
        WHERE Transaction_Cd = $merchantOrderNo";

    $UpdateDB = new DBOperation();
    $result = $UpdateDB->RunQuerySALData($UpdateQuery, $electionName, $developmentMode);

    if ($result) {
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