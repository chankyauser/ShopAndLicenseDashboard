<?php
    session_start();
// include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(
    (isset($_GET['Condition']) && !empty($_GET['Condition'])) &&
    (isset($_GET['ConditionName']) && !empty($_GET['ConditionName']))
  ){

    try  
        {  
            $_SESSION['SAL_FilterCondition'] = $_GET['Condition'];
            $_SESSION['SAL_FilterConditionName'] = $_GET['ConditionName'];
            
            // die();
        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
            
        if($_SESSION['SAL_ListingSurveyFilterType'] == 'ShopList')
        {
          include 'datatbl/tblGetShopListWithFilterApplied.php';
        }
        else if($_SESSION['SAL_ListingSurveyFilterType'] == 'ShopSurvey')
        {
          include 'datatbl/tblGetShopSurveyWithFilterApplied.php';
        }

  }else{
    //echo "ddd";
  }

}
?>

