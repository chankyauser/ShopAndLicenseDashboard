<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
      
      if(isset($_GET['parwanaCd']) && !empty($_GET['parwanaCd']) ){

        try  
            {  
                
                $_SESSION['SAL_Parwana_Cd'] = $_GET['parwanaCd'];
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

