<?php
  session_start();

include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['ShopListExecutiveNameCd']) && !empty($_GET['ShopListExecutiveNameCd']) ){

    try  
        {  
            
            $_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'] = $_GET['ShopListExecutiveNameCd'];
            
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

