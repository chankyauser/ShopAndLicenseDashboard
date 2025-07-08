<?php
        session_start();
        include '../../api/includes/DbOperation.php';
        
        if(!isset($_SESSION['SAL_ElectionName'])){
                $_SESSION['SAL_ElectionName']='CSMC';
                $_SESSION['SAL_DevelopmentMode']='Live';
        }
        $electionName = $_SESSION['SAL_ElectionName'];
        $developmentMode = $_SESSION['SAL_DevelopmentMode'];

	$key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
        $iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g');

	$result = $_POST['response'];
        $ciphertext_raw = hex2bin($result);
        $original_plaintext = openssl_decrypt($ciphertext_raw,  "AES-256-CBC", $key, $options=OPENSSL_RAW_DATA, $iv);
        $original_plaintext = trim($original_plaintext);
        $json = json_decode($original_plaintext, true);
        include('../../action/saveTransaction.php');
?>