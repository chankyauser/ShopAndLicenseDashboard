<?php 
session_start();

if(isset($_GET['mobile'])){
    $_SESSION['SAL_Mobile'] = $_GET['mobile'];
    $_SESSION['SAL_FullName'] = $_GET['fullName'];
    $_SESSION['SAL_UserName'] = $_GET['userName'];
    $_SESSION['SAL_AppName'] = $_GET['appName'];
    $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
	$_SESSION['SAL_DevelopmentMode'] = $_GET['developmentMode'];
	$_SESSION['SAL_UserId'] = $_GET['userCd'];
    $_SESSION['SAL_UserType'] = $_GET['user_type'];
	
	if($_SESSION['SAL_UserName'] == 'RAM_B30'){
		header('Location:client/index.php');  
	}else{
		header('Location:index.php?p=home-dashboard');  
	}
	
}else{
    
}
?>