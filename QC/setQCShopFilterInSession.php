<?php
  session_start();

// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['fromDate']) && !empty($_GET['fromDate']) && isset($_GET['toDate']) && !empty($_GET['toDate']) ){

    try  
        {  
            
            $_SESSION['SAL_FromDate'] = $_GET['fromDate'];
            $_SESSION['SAL_ToDate'] = $_GET['toDate'];
            $_SESSION['SAL_SHOP_QC_Type'] = $_GET['qcType'];
            $_SESSION['SAL_SHOP_QC_Filter'] = $_GET['qcFilter'];
            $_SESSION['SAL_Node_Cd'] = $_GET['nodeCd'];
            $_SESSION['SAL_SHOP_Executive_Cd'] = $_GET['shopExecutiveCd'];
            $_SESSION['SAL_ShopName'] = $_GET['shopName'];
            $_SESSION['SAL_ShopStatus'] = $_GET['shopStatus'];
            $_SESSION['SAL_ShopKeeperMobile'] = $_GET['shopKeeperMobile'];
            
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

