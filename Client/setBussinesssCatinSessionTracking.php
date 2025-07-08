<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['BusinessCatCd']) && !empty($_GET['BusinessCatCd']) ){

    try  
        {  
            $BusinessCatCd = $_GET['BusinessCatCd'];
            $_SESSION['SAL_Category'] = $BusinessCatCd;
           
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

