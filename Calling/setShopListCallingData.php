<?php
  session_start();
  include '../api/includes/DbOperation.php';

  if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
  {
  
  if(isset($_GET['callassigndate']) && !empty($_GET['callassigndate']) )
  {
    try  
        {  
            $callassigndate = $_GET['callassigndate'];
      
            $_SESSION['SAL_ShopListCalling_Date'] = $callassigndate;
      
           
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