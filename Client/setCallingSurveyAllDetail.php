<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['calling_Category']) && !empty($_GET['calling_Category']) ){

    try  
        {  
            $calling_Category = $_GET['calling_Category'];
            $fromDate = $_GET['fromDate'];
            $toDate = $_GET['toDate'];
            $pocketCd = $_GET['pocketCd'];
            $_SESSION['SAL_Calling_Category_Cd'] = $calling_Category;
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
            $_SESSION['SAL_FromDate'] = $fromDate;
            $_SESSION['SAL_ToDate'] = $toDate;
           
        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                                                          

  }else{
    //echo "ddd";
  }

}
?>

