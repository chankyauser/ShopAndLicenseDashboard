<?php
  session_start();
  include '../api/includes/DbOperation.php';

  if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
  {
  
    if(isset($_GET['fromDate']) && !empty($_GET['toDate']) )
    {
        try  
            {  
                $fromDate = $_GET['fromDate'];
                $toDate = $_GET['toDate'];
                $NodeName = $_GET['NodeName'];
                $nodeCd = $_GET['node_Cd'];
                
                $_SESSION['SAL_FromDate'] = $fromDate;
                $_SESSION['SAL_ToDate'] = $toDate;
                $_SESSION['SAL_Node_Name'] = $NodeName;
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                    
        // echo "<script> window.location.href='home.php?p=shop-license-defaulters-detail'; </script>";

    }
    else
    {
        echo "<script> alert('Failed'); </script>";
    }

}

?>