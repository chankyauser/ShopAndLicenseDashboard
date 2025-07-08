<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['assignDate']) && !empty($_GET['assignDate']) ){

    try  
        {  
            
            $_SESSION['SAL_Assign_Date'] = $_GET['assignDate'];
            
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

