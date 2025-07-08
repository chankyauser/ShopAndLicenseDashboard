<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['pocketCd']) && !empty($_GET['pocketCd']) ){

    try  
        {  
            $fromDate = $_GET['fromDate'];
            $toDate = $_GET['toDate'];
            $pocketCd = $_GET['pocketCd'];
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

