<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['callingCategoryCd']) && !empty($_GET['callingCategoryCd']) ){

    try  
        {  
            
            $_SESSION['SAL_Calling_Category_Cd'] = $_GET['callingCategoryCd'];
            
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

