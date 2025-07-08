<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include 'api/includes/DbOperation.php';

$shopDetail = array();

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
    if(isset($_GET['shopId']) && !empty($_GET['shopId']) ){

        try  
            {  
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $shopId = $_GET['shopId'];
                $_SESSION['SAL_Shop_Cd'] = $shopId;


                include 'pages/view-shop-license-detail.php';


                unset($_SESSION['SAL_Shop_Cd']);
             
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                              

      }else{

    }
}

