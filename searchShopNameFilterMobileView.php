<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
        include 'api/includes/DbOperation.php'; 
      
      if(isset($_GET['pageNo']) && !empty($_GET['pageNo']) ){

        try  
            {  
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $_SESSION['SAL_Pagination_PageNo'] = $_GET['pageNo'];
                $shopName = $_GET['shopName'];
                $_SESSION['SAL_Search_ShopName'] = $shopName;
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

