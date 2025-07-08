<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['nodeName']) && !empty($_GET['nodeName']) ){

    try  
        {  
            $node_Name = $_GET['nodeName'];
            if(isset($_SESSION['SAL_Node_Name'])){
                if($_SESSION['SAL_Node_Name'] != $node_Name){
                    unset($_SESSION['SAL_Node_Cd']);
                    unset($_SESSION['SAL_Pocket_Cd']);
                }
            }
            $_SESSION['SAL_Node_Name'] = $node_Name;
           
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

