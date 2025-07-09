
<?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        header("Access-Control-Allow-Origin: *"); 
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
      
            $date = date('D M d H:i:s') . ' IST ' . date('Y');
            $returnUrl = 'https://csmcshoplicenses.com/PHP-GetEPay/PG/response.php';
            
            // $data = $_POST['data'];
            // $amount = $_POST['Amount'];
            // $ShopKeeperMobile = $_POST['MobileNo'];
            // $ShopEmailAddress = $_POST['Email'];
            // $ShopKeeperName = $_POST['Name'];
            // $TransId = $_POST['TransID'];

            // "merchantTransactionId"=> str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
            // "transactionDate"=>"Mon Oct 03 13:54:33 IST 2022",

            $request=array(
                // "mid"=>"108",
                // Live
                "mid"=>"1325212",
                "amount"=> "$amount",
                "merchantTransactionId"=>$TransId,
                "transactionDate"=>"$date",
                // "terminalId"=>"Getepay.merchant61062@icici",
                // Live
                "terminalId"=>"getepay.merchant689865@icici",
                "udf1" => "$ShopKeeperMobile",
                "udf2"=>"$ShopEmailAddress",
                "udf3"=>"$ShopKeeperName",
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
                "txnNote"=>"",
                // "vpa"=>"Getepay.merchant61062@icici"
                // Live
                "vpa"=>"getepay.merchant689865@icici"
            );
            $json_requset = json_encode($request);
            
            //UAT -----------------
            // $key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
            // $iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g==');

            // LIVE -----------------
            $key = base64_decode('tPjvm0W0iIO4lpX/Ry9VQcGGcx0gAB1D1salkTrtpP4=');
            $iv = base64_decode('FRaquqRsN0nrEStG0ukNOA==');

            // Encryption Code //
            $ciphertext_raw = openssl_encrypt($json_requset, "AES-256-CBC", $key, $options = OPENSSL_RAW_DATA, $iv);
            $ciphertext = bin2hex($ciphertext_raw);
            $newCipher = strtoupper($ciphertext);
            
            //UAT -----------------
                // $request=array(
                //     "mid"=>'108',
                //     "terminalId"=>'Getepay.merchant61062@icici',
                //     "req"=>$newCipher
                // );

            // LIVE -----------------
                $request=array(
                    "mid"=>'1325212',
                    "terminalId"=>'getepay.merchant689865@icici',
                    "req"=>$newCipher
                );
            
            // UAT -----------------
            // $url = "https://pay1.getepay.in:8443/getepayPortal/pg/generateInvoice";
            
            // LIVE -----------------
            $url = "https://portal.getepay.in:8443/getepayPortal/pg/generateInvoice";

            $curl = curl_init();   
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json',
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
            $result = curl_exec($curl);
            
            if (curl_errno($curl)) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'cURL Error: ' . curl_error($curl)
                ]);
                curl_close($curl);
                exit;
            }
            curl_close($curl);

            $jsonDecode = json_decode($result);
            if (!$jsonDecode || !isset($jsonDecode->response)) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Invalid response from GetePay: ' . $result
                ]);
                exit;
            }

            // $jsonResult = $jsonDecode->response;
            $jsonResult = $jsonDecode->response ?? null;
            
            if (!$jsonResult) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Response is missing from GetePay'
                ]);
                exit;
            }
            
            // $ciphertext_raw = hex2bin($jsonResult);
            $ciphertext_raw = @hex2bin($jsonResult);
            if (!$ciphertext_raw) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Failed to decode hex string'
                ]);
                exit;
            }

            $original_plaintext = openssl_decrypt($ciphertext_raw,  "AES-256-CBC", $key, $options=OPENSSL_RAW_DATA, $iv);
        
            $json = json_decode($original_plaintext);
  
            $pgUrl = $json->paymentUrl;
            // redirect($pgUrl,'refresh');
            // header("Location: " . $pgUrl);
            // exit;

            if (!empty($pgUrl)) {
                echo json_encode([
                    'statusCode' => 200,
                    'data' => $pgUrl
                ]);
            } else {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Failed to generate payment URL'
                ]);
            }

            exit;
        ?>