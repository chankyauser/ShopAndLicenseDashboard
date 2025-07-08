<?php
  

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['pocketCd']) && !empty($_GET['pocketCd']) ){
    session_start();
    include '../api/includes/DbOperation.php'; 
    try  
        {  
            $pageNo = $_GET['pageNo'];
            $pocketCd = $_GET['pocketCd'];
            $executiveCd = $_GET['executiveCd'];
            $electionName = $_GET['electionName'];
            $nodeCd = $_GET['nodeCd'];
            $node_Name = $_GET['node_Name'];
            $from_Date = $_GET['fromDate'];
            $to_Date = $_GET['toDate'];
            $_SESSION['SAL_Pagination_PageNo'] = $pageNo;
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
            $_SESSION['SAL_QC_Executive_Cd'] = $executiveCd;
            $_SESSION['SAL_ElectionName'] = $electionName;
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
            $_SESSION['SAL_Node_Name'] = $node_Name;
            $_SESSION['SAL_FromDate'] = $from_Date;
            $_SESSION['SAL_ToDate'] = $to_Date;
           

            include 'datatbl/tblShopsQCLogDetailData.php';


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

