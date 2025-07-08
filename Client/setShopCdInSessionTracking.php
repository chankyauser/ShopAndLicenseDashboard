<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['ShopCd']) && !empty($_GET['ShopCd']) ){

    try  
        {  
            $ShopCd = $_GET['ShopCd'];
            $_SESSION['SAL_Shop_Cd'] = $ShopCd;
           
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

