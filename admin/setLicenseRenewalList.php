<?php
  session_start();
  include '../api/includes/DbOperation.php';

  if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
  {
  
  if(isset($_GET['fromDate']) && !empty($_GET['toDate']) )
  {
    try  
        {  
            $from_Date = $_GET['fromDate'];
            $to_Date = $_GET['toDate'];
            $pocketCd = $_GET['pocketCd'];

            $_SESSION['SAL_FromDate_Renewal'] = $from_Date;
            $_SESSION['SAL_ToDate_Renewal'] = $to_Date;
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
           
        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                
       // echo "<script> window.location.href='home.php?p=shop-license-defaulters-detail'; </script>";

  }
  else{
    echo "<script> alert('Failed'); </script>";
  }

}

?>