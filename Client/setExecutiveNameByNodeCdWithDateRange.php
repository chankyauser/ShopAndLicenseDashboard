<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['nodeCd']) && !empty($_GET['nodeCd']) ){

    try  
        {  
            $nodeCd = $_GET['nodeCd'];
            $fromDate = $_GET['fromDate'];
            $toDate = $_GET['toDate'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
            $_SESSION['SAL_FromDate'] = $fromDate;
            $_SESSION['SAL_ToDate'] = $toDate;
           
           include 'dropdown-executive-name-node-cd-date.php';
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

