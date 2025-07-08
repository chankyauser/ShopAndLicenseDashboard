<?php
  session_start();
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['fromDate']) && !empty($_GET['fromDate']) && isset($_GET['toDate']) && !empty($_GET['toDate']) ){

    try  
        {  
            
                $_SESSION['SAL_FromDate'] = $_GET['fromDate'];
                $_SESSION['SAL_ToDate'] = $_GET['toDate'];
                $_SESSION['SAL_QC_Executive_Cd'] = $_GET['executiveCd'];
                $_SESSION['SAL_Pocket_Cd'] = $_GET['pocketCd'];
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $_SESSION['SAL_Node_Cd'] = $_GET['nodeCd'];
                $_SESSION['SAL_Node_Name'] = $_GET['node_Name'];
                    
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

