<?php

ob_start();
session_start();

ini_set('max_execution_time', '1000'); // 5 min

// $formLanguageArray = array('English','Marathi','Hindi');
$formLanguageArray = array('English');
if(!isset($_SESSION['Form_Language'])){
    $_SESSION['Form_Language'] = 'English';
}


if(!isset($_SESSION['SAL_Mobile']) || !isset($_SESSION['SAL_ShopKeeperMobile']))
{
    header('Location:../login.php');
}else{

    date_default_timezone_set('Asia/Kolkata');

    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    $startTime = "00:00:00";
    $endTime = "23:59:59";
    $_SESSION['StartTime']=$startTime;
    $_SESSION['EndTime']=$endTime;

    if(isset($_SESSION['SAL_ElectionName'])){
        if($_SESSION['SAL_ElectionName'] == ""){
          $_SESSION['SAL_ElectionName']='CSMC';
        }
    }
//isset($_SESSION['SAL_UserName']) && 
    if( 
    isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) 
    && ($_SESSION['SAL_UserType'] == 'Client' || $_SESSION['SAL_UserType'] == 'Admin' || isset($_SESSION['SAL_ShopKeeperMobile']) != '') ){
           //header('Location:index.php');  
    }else{
          header('Location:../login.php');
    }
  
}
?>