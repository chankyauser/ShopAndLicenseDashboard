<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['callingDate']) && !empty($_GET['callingDate']) ){

    try  
        {  
            
            $_SESSION['SAL_Calling_Date'] = $_GET['callingDate'];
            
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

