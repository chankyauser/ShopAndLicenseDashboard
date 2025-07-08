<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shaFilterType']) && !empty($_GET['shaFilterType']) ){

    try  
        {  
            
            $_SESSION['SAL_ShopAssign_Filter_Type'] = $_GET['shaFilterType'];
            
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

