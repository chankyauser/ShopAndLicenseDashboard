<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['ccExecutive']) && !empty($_GET['ccExecutive']) ){

    try  
        {  
            $ccExecutive = $_GET['ccExecutive'];
            $_SESSION['SAL_CC_Executive_Cd'] = $ccExecutive;
           
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

