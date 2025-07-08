<?php  
ob_start();
session_start();

ini_set('max_execution_time', '1000'); // 5 min

// $formLanguageArray = array('English','Marathi','Hindi');
$formLanguageArray = array('English');
if(!isset($_SESSION['Form_Language'])){
    $_SESSION['Form_Language'] = 'English';
}


if(!isset($_SESSION['SAL_Mobile']))
{
    header('Location:../index.php?p=login');
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
      $_SESSION['SAL_ElectionName']='PCMC';
    }
}

    if(isset($_SESSION['SAL_UserName']) && isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType'] == 'Admin'  ){
           //header('Location:index.php');  
    }else if(isset($_SESSION['SAL_UserName']) && isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType'] == 'Calling'  ){
           header('Location:../Calling/index.php');  
    }else if(isset($_SESSION['SAL_UserName']) && isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType'] == 'QC'  ){
           header('Location:../QC/index.php');  
    }else if(isset($_SESSION['SAL_UserName']) && isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType'] == 'Client'  ){
           header('Location:../client/index.php');  
    }else{
          header('Location:../index.php?p=login');
    }
  
}
?>