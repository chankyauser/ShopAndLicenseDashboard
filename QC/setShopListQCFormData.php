<?php
  if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
  {
  
    if(isset($_GET['shopid']) && !empty($_GET['shopid']) )
    {

      session_start();
      include '../api/includes/DbOperation.php';


      try  
        {  
          

            $Shop_Cd = $_GET['shopid'];
            $srNo = $_GET['srNo'];

            include 'getShopListQCFormData.php';
        
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


      

