<style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
    table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
        /* cursor: pointer;
        position: relative; */
        display: none;
    }
    table.dataTable,table.dataTable th, table.dataTable td {
        border: none;
    }
 </style>
 <style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 70% 70%;}

    img.galleryimg:hover{
        transform: scale(3.2);
        z-index: 9999;
    }

</style>
 <section id="nav-justified">
<?php
        
        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    

        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = $currentDate;
        $toDate = $currentDate;

        if(isset($_GET['fromDate']) && !empty($_GET['fromDate'])){
            $_SESSION['SAL_FromDate'] = $_GET['fromDate'];
        }

        if(isset($_GET['toDate']) && !empty($_GET['toDate'])){
            $_SESSION['SAL_ToDate'] = $_GET['toDate'];
        }


        if(!isset($_SESSION['SAL_FromDate'])){
            // $queryShopListStartDate = "SELECT ISNULL(CONVERT(VARCHAR,MIN(AddedDate),23),'') as MinDate FROM ShopMaster WHERE IsActive = 1;";
            // $ShopListStartDate = $db->ExecutveQuerySingleRowSALData($queryShopListStartDate, $electionName, $developmentMode);
            // print_r($ShopListStartDate);
            // if(sizeof($ShopListStartDate)>0){
            //     $fromDate = $ShopListStartDate["MinDate"];
            // }else{
            //    // $fromDate 
            // }
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }else{
            $fromDate  = $_SESSION['SAL_FromDate'];
        }

        if(!isset($_SESSION['SAL_ToDate'])){
            $_SESSION['SAL_ToDate'] = $toDate;
        }else{
            $toDate = $_SESSION['SAL_ToDate'];
            // if($toDate != date('Y-m-d')){
            //     $_SESSION['SAL_ToDate'] = date('Y-m-d');
            //     $toDate = $_SESSION['SAL_ToDate'];
            // }
        }

        if(isset($_GET['dateFilter']) && $_GET['dateFilter']=="All"){
            $_SESSION['SAL_DateFilter'] = "All";
            header('Location:home.php?p=pocket-wise-shops-list'); 
        }else{
           $_SESSION['SAL_DateFilter'] = ""; 
        }

        if(isset($_SESSION['SAL_DateFilter']) && !empty($_SESSION['SAL_DateFilter'])){
           $dateFilter = $_SESSION['SAL_DateFilter'];
        }else{
            $dateFilter = "";
        }

        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
            if(isset($_GET['node_Name'])){
                $nodeName = $_GET['node_Name'];
                $_SESSION['SAL_Node_Name'] = $nodeName;
            }
        }else {
            $nodeName = "All";
        }

        if(isset($_GET['nodeId'])){
            $nodeCd = $_GET['nodeId'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }else if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            if(isset($_GET['nodeId'])){
                $nodeCd = $_GET['nodeId'];
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
            }
        }else {
            $nodeCd = "All";
        }
        
        if(isset($_GET['pocketId'])){
            $pocketCd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocket_Cd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocketCd = $_SESSION['SAL_Pocket_Cd'];    
        }else{
            $pocketCd = "All";  
        }



    ?>


    <div id="listingSurveyWiseDataId">                               
        <?php include 'datatbl/tblGetShopListingSurveyFilterData.php'; ?>
    </div>    

</section>


        