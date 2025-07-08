<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['nodeName']) && !empty($_GET['nodeName']) ){

    try  
        {  
            
            $_SESSION['SAL_NodeName'] = $_GET['nodeName'];
            if($_GET['nodeName'] == 'All'){
                $_SESSION['SAL_WardCd'] = "All";
                $_SESSION['SAL_PocketCd'] = "All";    
            }
            
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