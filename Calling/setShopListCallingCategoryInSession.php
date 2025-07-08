<?php
  session_start();

include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['ShopListCallingCategoryCd']) && !empty($_GET['ShopListCallingCategoryCd']) ){

    try  
        {  
            
            $_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'] = $_GET['ShopListCallingCategoryCd'];
            
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

