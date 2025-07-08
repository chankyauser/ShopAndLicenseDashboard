<?php
    session_start();

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['pageNo']) && !empty($_GET['pageNo']) ){

    try  
        {  
            
            $_SESSION['SAL_Pagination_PageNo'] = $_GET['pageNo'];
           
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

