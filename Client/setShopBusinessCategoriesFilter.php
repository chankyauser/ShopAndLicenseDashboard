<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
        include '../api/includes/DbOperation.php'; 
      
      if(isset($_GET['pageNo']) && !empty($_GET['pageNo']) ){

        try  
            {  
                
                //$_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $_SESSION['SAL_Pagination_PageNo'] = $_GET['pageNo'];
                // $pageNo = $_GET['pageNo'];
                $nodeCd = $_GET['nodeCd'];
                $businessCatCd = $_GET['businessCatCd'];

                if(!isset($_SESSION['SAL_View_Type'])){
                    $_SESSION['SAL_View_Type'] = 'GridView';
                }

                include 'setShopDetailBusinessCatFilterData.php';
                if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "GridView"){
                    include 'datatbl/tblShopGridData.php';
                }else if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){
                    include 'datatbl/tblShopListData.php';
                }
             
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

