<?php
$mid = "108"; 
$paymentId = "19185111";
$terminalId = "Getepay.merchant61062@icici";
$description = "check status";
$request = array(
    "mid" => $mid,
    "paymentId" => $paymentId,
    "referenceNo" => "40776_STUDENT_TERM_FEE_2022_JANUARY",
    "status" => "Success",
    "terminalId" => $terminalId,
    "vpa" => $terminalId,
);

$json_requset = json_encode($request);
$key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
$iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g==');

// Encryption Code
$ciphertext_raw = openssl_encrypt($json_requset, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
$ciphertext = bin2hex($ciphertext_raw);
$newCipher = strtoupper($ciphertext);

$request = array(
    "mid" => $mid,
    "terminalId" => $terminalId,
    "req" => $newCipher
);
$url = 'https://pay1.getepay.in:8443/getepayPortal/pg/invoiceStatus'; // Uat
// $url = 'https://portal.getepay.in:8443//getepayPortal/pg/invoiceStatus'; //Portal

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLINFO_HEADER_OUT, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
));

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
$result = curl_exec($curl);
curl_close($curl);

$jsonDecode = json_decode($result);

$jsonResult = $jsonDecode->response;

// Decrypt the response
$ciphertext_raw = hex2bin($jsonResult);
$original_plaintext = openssl_decrypt($ciphertext_raw, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);

// Decode the decrypted JSON
$data = json_decode($original_plaintext);
// print_r($data);
// die();
// Print the decoded JSON in a simple format
print_r($data);
print_r($data->txnStatus);

?>
