<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
    {
      
        if(isset($_GET['schedulecallid']) && !empty($_GET['schedulecallid']) && isset($_GET['shopid']) && !empty($_GET['shopid']) )
        {

            session_start();
            include '../api/includes/DbOperation.php';

        try  
            {  
              

                $ScheduleCall_Cd = $_GET['schedulecallid'];
                $Shop_Cd = $_GET['shopid'];
                $srNo = $_GET['srNo'];
          
                include 'getShopSurveyAndDocumentQCFormData.php';
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                    
        } else{
            echo "<script> alert('Failed'); </script>";
        }

    }

?>