<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['executiveCd']) && !empty($_GET['executiveCd']) ){

    try  
        {  
            $executiveCd = $_GET['executiveCd'];
            $fromDate = $_GET['fromDate'];
            $toDate = $_GET['toDate'];
           
            $_SESSION['SAL_Executive_Cd'] = $executiveCd;
            $_SESSION['SAL_FromDate'] = $fromDate;
            $_SESSION['SAL_ToDate'] = $toDate;

             include 'datatbl/tblGetExecutiveWiseSurveyDetail.php';
           
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

