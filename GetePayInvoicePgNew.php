<html>
    <head>
        <title>Payment Gateway</title>
    </head>
    <body>

        <?php

        date_default_timezone_set('Asia/Calcutta');
        $date = date('D M d H:i:s') . ' IST ' . date('Y');
        $returnUrl="http://localhost/response.php";
        $request=array(
            "mid"=>"108",
            "amount"=>"10.00",
            "merchantTransactionId"=>"sd12121",
            "transactionDate"=>"Mon Oct 03 13:54:33 IST 2022",
            "terminalId"=>"Getepay.merchant61062@icici",
            "udf1"=>"1234567890",
            "udf2"=>"Test@gmail.com",
            "udf3"=>"",
            "udf4"=>"",
            "udf5"=>"",
            "udf6"=>"",
            "udf7"=>"",
            "udf8"=>"",
            "udf9"=>"",
            "udf10"=>"",
            "ru"=>$returnUrl,
            "callbackUrl"=>"",
            "currency"=>"INR",
            "paymentMode"=>"ALL",
            "bankId"=>"",
            "txnType"=>"single",
            "productType"=>"IPG",
            "txnNote"=>"Test Txn",
            "vpa"=>"Getepay.merchant61062@icici"
        );
        $json_requset = json_encode($request);
        
        $key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
        $iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g==');

        // Encryption Code //
        $ciphertext_raw = openssl_encrypt($json_requset, "AES-256-CBC", $key, $options = OPENSSL_RAW_DATA, $iv);
        $ciphertext = bin2hex($ciphertext_raw);
        $newCipher = strtoupper($ciphertext);
//print_r($newCipher);exit;
        $request=array(
            "mid"=>'108',
            "terminalId"=>'Getepay.merchant61062@icici',
            "req"=>$newCipher
        );
$url = "https://pay1.getepay.in:8443/getepayPortal/pg/generateInvoice";
        $curl = curl_init();   
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
         ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
        $result = curl_exec($curl);
        curl_close ($curl);
        $jsonDecode = json_decode($result);
        $jsonResult = $jsonDecode->response;
        $ciphertext_raw = hex2bin($jsonResult);
        $original_plaintext = openssl_decrypt($ciphertext_raw,  "AES-256-CBC", $key, $options=OPENSSL_RAW_DATA, $iv);
        $json = json_decode($original_plaintext);
       // echo "<pre/>"; print_r($json);exit;
        $pgUrl = $json->paymentUrl;
        //redirect($pgUrl,'refresh');
        header("Location:" . $pgUrl);
        ?>
    </body>
</html>

