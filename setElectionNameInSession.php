<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['electionName']) && !empty($_GET['electionName']) ){

    try  
        {  
            
            $_SESSION['SAL_ElectionName'] = $_GET['electionName'];

            unset($_SESSION['SAL_Node_Cd']);
            unset($_SESSION['SAL_Ward_No']);
            unset($_SESSION['SAL_Node_Name']);
            unset($_SESSION['SAL_Pocket_Cd']);
            unset($_SESSION['SAL_Executive_Cd']);
           
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

