<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['ccfilterType']) && !empty($_GET['ccfilterType']) ){

    try  
        {  
            $ccfilterType = $_GET['ccfilterType'];
            $_SESSION['SAL_Calling_Filter_Type'] = $ccfilterType;
           
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

