<?php
    session_start();

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['fromDate']) && !empty($_GET['fromDate']) && isset($_GET['toDate']) && !empty($_GET['toDate']) ){

    try  
        {  
            
            $_SESSION['SAL_FromDate'] = $_GET['fromDate'];
            $_SESSION['SAL_ToDate'] = $_GET['toDate'];
            
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

