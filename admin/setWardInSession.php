<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['Ward_No']) && !empty($_GET['Ward_No']) ){

    try  
        {  
            
            $_SESSION['SAL_Node_Cd'] = $_GET['Node_Cd'];
            $_SESSION['SAL_Ward_No'] = $_GET['Ward_No'];
            
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

