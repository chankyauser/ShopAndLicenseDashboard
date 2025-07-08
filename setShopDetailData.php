<?php

    if(isset($_POST['shopId']) && !empty($_POST['shopId']) ){
        session_start();
        try  
            {  
                $_SESSION['SAL_ElectionName'] = $_POST['electionName'];
                $_SESSION['SAL_Shop_Cd'] = $_POST['shopId'];
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                              

      }else{

    }

?>