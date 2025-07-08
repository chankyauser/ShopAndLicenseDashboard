<?php
   

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['surveyDate']) && !empty($_GET['surveyDate']) ){
    session_start();
    include '../api/includes/DbOperation.php'; 
    try  
        {  
            
            $_SESSION['SAL_Calling_Date'] = $_GET['surveyDate'];
            $_SESSION['SAL_SHOP_QC_Type'] = $_GET['filterType'];
            include 'datatbl/tblFirstAndLastEntryDetail.php';
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

