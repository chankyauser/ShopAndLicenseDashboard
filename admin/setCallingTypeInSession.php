<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['callingType']) && !empty($_GET['callingType']) ){

    try  
        {  
            
            $_SESSION['SAL_Calling_Type'] = $_GET['callingType'];
            unset($_SESSION['SAL_Executive_Cd']);
            
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

