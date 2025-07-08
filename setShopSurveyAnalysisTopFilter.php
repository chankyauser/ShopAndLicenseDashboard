<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
        include 'api/includes/DbOperation.php'; 
      
      if(isset($_GET['refreshFlag']) && !empty($_GET['refreshFlag']) ){

        try  
            {  
                
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $_SESSION['SAL_Node_Cd'] = $_GET['nodeCd'];
                $_SESSION['SAL_BusinessCat_Cd'] = $_GET['businessCatCd'];
                

                if(!isset($_SESSION['SAL_View_Type'])){
                    $_SESSION['SAL_View_Type'] = 'GridView';
                }

                include 'setShopAnalysisFilterData.php';
                include 'datatbl/tblSurveyAnalysisData.php';
             
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

