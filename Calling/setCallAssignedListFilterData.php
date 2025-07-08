<?php
  session_start();

include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['callingResponseFilter']) && !empty($_GET['callingResponseFilter']) ){

    try  
        {  
            
            $_SESSION['SAL_SHOP_LIST_CallingStatusFilter'] = $_GET['callingStatusFilter'];
            $_SESSION['SAL_SHOP_LIST_CallingDateFilter'] = $_GET['callingDateFilter'];
            $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'] = $_GET['callingResponseFilter'];
            
            // die();
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

