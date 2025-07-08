<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['NodeCd']) && !empty($_GET['NodeCd']) ){

    try  
        {  
            $NodeCd = $_GET['NodeCd'];
            $_SESSION['SAL_nodeCd'] = $NodeCd;
           
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

