<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
      
      if(isset($_GET['viewType']) && !empty($_GET['viewType']) ){

        try  
            {  
                
                $_SESSION['SAL_View_Type'] = $_GET['viewType'];
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

