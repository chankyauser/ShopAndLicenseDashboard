<?php
  session_start();

include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['CallAssignDate']) && !empty($_GET['CallAssignDate']) ){

    try  
        {  
            
            $_SESSION['SAL_SHOP_LIST_Call_Assign_Date'] = $_GET['CallAssignDate'];
            
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

