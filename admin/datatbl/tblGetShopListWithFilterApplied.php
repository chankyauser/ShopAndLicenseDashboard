<section id="nav-justified">
    <div>
<?php 
$Condition = "";
$ConditionName = "";

include '../api/includes/DbOperation.php'; 

if(
    (isset($_POST['Condition']) && $_POST['Condition']) &&
    (isset($_POST['ConditionName']) && $_POST['ConditionName'])
  )
{
    echo $Condition = $_POST['Condition'];
    echo $ConditionName = $_POST['ConditionName'];

    $_SESSION['SAL_FilterCondition'] = $Condition;
    $_SESSION['SAL_FilterConditionName'] = $ConditionName;
}
else if(
    (isset($_SESSION['SAL_FilterCondition']) && $_SESSION['SAL_FilterCondition']) &&
    (isset($_SESSION['SAL_FilterConditionName']) && $_SESSION['SAL_FilterConditionName'])
    )
{
    $Condition = $_SESSION['SAL_FilterCondition'];
    $ConditionName = $_SESSION['SAL_FilterConditionName'];
}

$userName=$_SESSION['SAL_UserName'];
$appName=$_SESSION['SAL_AppName'];
$electionName=$_SESSION['SAL_ElectionName'];
$developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $executiveFilterCondition = "";
    $wardFilterCondition = "";

    if($Condition == 'ExecutiveWise')
    {
        $exeNameQue = "SELECT ExecutiveName FROM Survey_Entry_Data..Executive_Master 
        WHERE Executive_Cd = $ConditionName ;";
        $dbName=new DbOperation();
        $exeNameData = $dbName->ExecutveQuerySingleRowSALData($exeNameQue, $electionName, $developmentMode); 

        $executiveFilterCondition = " AND ShopMaster.PLExecutive_Cd = $ConditionName ";
        $wardFilterCondition = " ";

    }
    else if($Condition == 'WardWise')
    {
        $executiveFilterCondition = " ";
        $wardFilterCondition = " AND NodeMaster.Ward_No = $ConditionName ";
    }

?>

<?php 

$dateFilter = "";

if(isset($_GET['FilterType']) && !empty($_GET['FilterType']) && $_GET['FilterType'] == 'ShopList')
{
    $FilterType = $_GET['FilterType'];
}
else
{
    $FilterType = 'ShopList';
}

if(isset($_GET['FilterName']) && !empty($_GET['FilterName']))
{
    $FilterName = $_GET['FilterName'];
}
elseif(isset($_SESSION['SAL_ListingSurveyFilterName']) && !empty($_SESSION['SAL_ListingSurveyFilterName']))
{
    $FilterName = $_SESSION['SAL_ListingSurveyFilterName'];
}
else
{
    $FilterName = '';
}

if($FilterName == 'All')
{
    $FilterNameCondition = "";
}
elseif($FilterName == 'PermanantlyClosed')
{
    $FilterNameCondition = " AND ShopMaster.ShopStatus = 'Permanently Closed' ";
}
elseif($FilterName == 'PermissionDenied')
{
    $FilterNameCondition = " AND ShopMaster.ShopStatus = 'Permission Denied' ";
}
elseif($FilterName == 'NonCooperative')
{
    $FilterNameCondition = " AND ShopMaster.ShopStatus = 'Non-Cooperative' ";
}
elseif($FilterName == 'SurveyPending')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NULL ";
}
elseif($FilterName == 'Pending')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NULL AND ShopMaster.ShopStatus IS NULL ";
}
else 
{
    $FilterNameCondition = " ";
}

//echo $FilterNameCondition;

if(isset($_GET['pocketCd'])){
    $pocketCd = $_GET['pocketCd'];
    $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
}else if(isset($_SESSION['SAL_Pocket_Cd'])){
    $pocketCd = $_SESSION['SAL_Pocket_Cd'];
}else if(isset($_GET['pocketId'])){
    $pocketCd = $_GET['pocketId'];
    $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
}else{
    $pocketCd = "All";
    $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
}

if(isset($_GET['executiveCd'])){
    $executiveCd = $_GET['executiveCd'];
    $_SESSION['SAL_Executive_Cd'] = $executiveCd;
}else if(isset($_SESSION['SAL_Executive_Cd'])){
    $executiveCd = $_SESSION['SAL_Executive_Cd'];
}else{
    $executiveCd = "All";
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

if(isset($_SESSION['SAL_Node_Cd'])){
    $nodeCd = $_SESSION['SAL_Node_Cd'];
    if(isset($_GET['nodeId'])){
        $nodeCd = $_GET['nodeId'];
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }
}else {
    $nodeCd = "All";
}

if(isset($_SESSION['SAL_FromDate'])){
    $from_Date = $_SESSION['SAL_FromDate'];
}

if(isset($_SESSION['SAL_ToDate'])){
    $to_Date = $_SESSION['SAL_ToDate'];
}

$fromDate = $from_Date." ".$_SESSION['StartTime'];
$toDate = $to_Date." ".$_SESSION['EndTime'];

if($nodeCd == 'All'){
    $nodeCondition = " AND PocketMaster.Node_Cd <> 0  "; 
}else{
    $nodeCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0  "; 
}

if($nodeName == 'All'){
    $nodeNameCondition = " AND NodeMaster.NodeName <> '' ";
}else{
    $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName' ";
}

if($pocketCd == 'All'){
    $pcktCondition = "  ";
}else{
    $pcktCondition = " AND ShopMaster.pocket_Cd = $pocketCd ";
}

if($executiveCd == 'All'){
    $supervisorCondition = "  ";
}else{
    //$supervisorCondition = " AND ShopMaster.PlExecutive_Cd = $executiveCd ";
    $supervisorCondition = "  ";
}


if($dateFilter == "All" ){
    $dateCondition = " AND ShopMaster.AddedDate IS NOT NULL  ";
}else{
    $dateCondition = " AND CONVERT(VARCHAR, ShopMaster.AddedDate ,120) BETWEEN '$fromDate' AND '$toDate'  ";
}

$totalRecords = 0;
    $maxPageNo = 0;
    $recordPerPage = 24;
    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo']=1;
    }else{
        $pageNo = 1;  
    } 


    $db2=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    
    $queryTotal = "SELECT COUNT(ShopMaster.Shop_Cd) as ShopListingCount
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    $executiveFilterCondition
    $wardFilterCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' ;";
    // echo $queryTotal;
    $dbTotal=new DbOperation();
    $total_count = $dbTotal->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
    $totalRecords = $total_count["ShopListingCount"];

    // print_r($total_count);
?>
<?php

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $dbTotal->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];

    $query1 = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopName,'') as ShopName, 
    ISNULL(NodeMaster.NodeName,'') as NodeName, 
    ISNULL(NodeMaster.Ward_No,'') as Ward_No, 
    ISNULL(ShopMaster.ShopKeeperName,'') as ShopKeeperName, 
    ISNULL(ShopMaster.ShopKeeperMobile,'') as ShopKeeperMobile, 
    ISNULL(ShopMaster.ShopAddress_1,'') as ShopAddress_1, 
    ISNULL(ShopMaster.ShopAddress_2,'') as ShopAddress_2,
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.AddedBy,'') as AddedBy,
    ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
    ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
    ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate, 
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus, 
    ISNULL(ShopMaster.ShopOutsideImage1,'') as ShopOutsideImage1,
    ISNULL(ShopMaster.ShopCategory,'') as ShopCategory,
    ISNULL((SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
    WHERE BusinessCat_Cd = ShopMaster.BusinessCat_Cd ),'') as Nature_of_Business,
    ISNULL((SELECT top (1) ShopAreaName FROM ShopAreaMaster 
    WHERE ShopArea_Cd = ShopMaster.ShopArea_Cd ),'') as ShopAreaName
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    $executiveFilterCondition
    $wardFilterCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate DESC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $pocketShopsListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    $exportQuery1 = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(REPLACE(ShopMaster.ShopName, '''', ''),'') as ShopName, 
    ISNULL(NodeMaster.NodeName,'') as NodeName, 
    ISNULL(NodeMaster.Ward_No,'') as Ward_No, 
    ISNULL(REPLACE(ShopMaster.ShopKeeperName, '''', ''),'') as ShopKeeperName, 
    ISNULL(ShopMaster.ShopKeeperMobile,'') as ShopKeeperMobile, 
    ISNULL(REPLACE(ShopMaster.ShopAddress_1, '''', ''),'') as ShopAddress_1, 
    ISNULL(ShopMaster.AddedBy,'') as AddedBy,
    ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
    ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
    ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate, 
    ISNULL(REPLACE(ShopMaster.ShopStatus, '''', ''),'') as ShopStatus, 
    ISNULL(REPLACE(ShopMaster.ShopStatusRemark, '''', ''),'') as ShopStatusRemark, 
    ISNULL(ShopMaster.ShopOutsideImage1,'') as ShopOutsideImage1,
    ISNULL(ShopMaster.QC_Flag,0) as QC_Flag,
    ISNULL(CONVERT(varchar,ShopMaster.QC_UpdatedDate, 120),'') as QC_UpdatedDate,
    ISNULL(ShopMaster.QC_UpdatedByUser,'') as QC_UpdatedByUser
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    $executiveFilterCondition
    $wardFilterCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate DESC ;";
    // echo $query1;
    $exportPocketShopsListDetail = $db2->ExecutveQueryMultipleRowSALData($exportQuery1, $electionName, $developmentMode);

?>

<div class="row">

<div class="col-8 col-sm-8 col-md-8">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn" style="background-color:#c90d41;color:white;font-weight:bold;"> <?php echo $FilterType." - ".$FilterName." - ".$total_count["ShopListingCount"]; ?></span> <b style="font-weight:bold;font-size:16px;"><?php if($Condition == 'ExecutiveWise') { echo " - Shop Listing by - ".$exeNameData['ExecutiveName']; } elseif($Condition == 'WardWise') { echo " - Shop Listing Ward No. ".$ConditionName; }?></b>
</div>

<div class="col-4 col-sm-4 col-md-4 text-right">
      
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end ">

               
                <?php 
                    // echo $totalRecords;
                    $loopStart = 1;
                    $loopStop = $totalRecords;

                    if($totalRecords > 5){
                         if($pageNo==1){
                            $loopStart = $pageNo;
                        }else if($pageNo==2){
                            $loopStart = $pageNo - 1;
                        }else if($pageNo>=3){
                            $loopStart = $pageNo - 2;
                        }else{
                            $loopStart = $pageNo ;
                        }
                        
                        $loopStop = $loopStart + 5;
                        if($loopStop>$totalRecords){
                            $loopStop = $totalRecords;
                            $loopStart = $loopStop - 5;
                        }
                    }
                ?>

                <?php
                    if($pageNo != $loopStart ){ 
                ?>  
                    <li class="page-item prev"><a class="page-link" onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                <?php } ?>

                <?php
                    for($i=$loopStart;$i<=$loopStop;$i++){ 

                            $activePageCondition = ""; 
                            if($pageNo == $i){
                                $activePageCondition = "active";                                
                            }
                        ?>
                        <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                <?php } ?>
                    <!-- <li class="page-item" > <a class="page-link"><?php //echo " of ".$total_count["SurveyDone"]; ?></a></li> -->
                <?php if($totalRecords > $loopStop){ ?> 
                    <li class="page-item next"><a class="page-link"  onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                <?php }  ?>
            </ul>
        </nav>
    </div>
                </div>
                <div class="row">
    <?php if (sizeof($pocketShopsListDetail)>0){
            $srNo = 0;
            if($pageNo!=1){
                $srNo = (($pageNo * $recordPerPage) - ($recordPerPage));
            }
                foreach($pocketShopsListDetail as $shopData){ 
                    $srNo = $srNo+1;
            ?>
           
            <div class="col-xl-2">
<div class="card">
    <div class="card-body">
        <div class="card-content">

                        <?php 
                            $shopListExecutive = "";
                            $shopSurveyExecutive = "";
                            if(strpos($shopData["AddedBy"], "_") !== false){
                                $shpListExecutiveArr = explode("_", $shopData["AddedBy"]);
                                $shopListExecutive = "  </br> |  By : ".$shpListExecutiveArr[0];
                            }else{
                                $shopListExecutive = "  </br> |  By : ".$shopData["AddedBy"];
                            }

                            if(strpos($shopData["SurveyBy"], "_") !== false){
                                $shpSurveyExecutiveArr = explode("_", $shopData["SurveyBy"]);
                                $shopSurveyExecutive = "  </br> |  By : ".$shpSurveyExecutiveArr[0];
                            }else{
                                $shopSurveyExecutive = "  </br> |  By : ".$shopData["SurveyBy"];
                            }
                        ?>

                        <h5 class="mb-0" style="color:#c90d41;"> <?php echo $srNo.") "; ?><?php echo $shopData["ShopName"]. " </br> on ".$shopData["AddedDate"]." ".$shopListExecutive; ?></h5>
                        

                            <div class="col-xl-2">
                                <div class="employee-task d-flex justify-content-between align-items-top">
                                    
                                        <div>
                                            
                                           <div class="avatar mr-75">

                                                <?php if($shopData["ShopOutsideImage1"] != ''){ ?>
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                               <?php }else { ?>   
                                                    <img src="pics/shopDefault.jpeg" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                               <?php } ?>
                                            </div>
                                           <div class="media-body my-10px" style="margin-top:10px;">
                                            
                                            
                                               <!-- <h6><b><?php //echo $shopData["ShopKeeperName"]; ?> - <?php //echo $shopData["ShopKeeperMobile"]; ?></b></h6> -->
                                               <h6><?php echo $shopData["Nature_of_Business"]; ?><a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin font-medium-5 text-primary"></i> </a></h6>
                                               <h6><?php echo $shopData["ShopCategory"]; ?></h6>
                                               <h6><?php echo $shopData["ShopAreaName"]; ?></h6>
                                               <h6><?php echo $shopData["ShopAddress_1"]; ?></h6>
                                              
                                               <h6><span style="margin-right:15px;"> <?php if(!empty($shopData["SurveyDate"])){ echo "<b>Survey Date : </b>".$shopData["SurveyDate"]. " ".$shopSurveyExecutive; }  ?></span></h6>
                                           
                                           </div>
                                    
                                    </div>
                                    <div class="d-flex align-items-center">
                                       <small class="text-muted mr-75"></small>
                                       <div class="employee-task-chart-primary-1"></div>
                                    </div>
                                </div> 
                                </div> 

                                <!-- <div class="col-xl-1 text-right">
                              
                               
                                <div class="position-relative d-inline-block mr-2" style="margin-top: 1.1rem;">
                                   <a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin font-medium-5 text-primary"></i> </a>
                                </div>
                            </div> -->
                        

            </div>
        </div>
    </div>
</div>
<?php } }?>
                                               </div>



<div class="row">

<div class="col-4 col-sm-4 col-md-12 text-right">
       
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end ">

               
                <?php 
                    // echo $totalRecords;
                    $loopStart = 1;
                    $loopStop = $totalRecords;

                    if($totalRecords > 5){
                         if($pageNo==1){
                            $loopStart = $pageNo;
                        }else if($pageNo==2){
                            $loopStart = $pageNo - 1;
                        }else if($pageNo>=3){
                            $loopStart = $pageNo - 2;
                        }else{
                            $loopStart = $pageNo ;
                        }
                        
                        $loopStop = $loopStart + 5;
                        if($loopStop>$totalRecords){
                            $loopStop = $totalRecords;
                            $loopStart = $loopStop - 5;
                        }
                    }
                ?>

                <?php
                    if($pageNo != $loopStart ){ 
                ?>  
                    <li class="page-item prev"><a class="page-link" onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                <?php } ?>

                <?php
                    for($i=$loopStart;$i<=$loopStop;$i++){ 

                            $activePageCondition = ""; 
                            if($pageNo == $i){
                                $activePageCondition = "active";                                
                            }
                        ?>
                        <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                <?php } ?>
                    <!-- <li class="page-item" > <a class="page-link"><?php //echo " of ".$total_count["SurveyDone"]; ?></a></li> -->
                <?php if($totalRecords > $loopStop){ ?> 
                    <li class="page-item next"><a class="page-link"  onclick="setShopListingSurveyFilterDetailPaginationPageNo(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                <?php }  ?>
            </ul>
        </nav>
    </div>
                </div>


                                               <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><span class="btn" style="background-color:#c90d41;color:white;font-weight:bold;"> <?php echo $FilterType." - ".$FilterName." - ".$total_count["ShopListingCount"]; ?></span> <b style="font-weight:bold;font-size:16px;"><?php if($Condition == 'ExecutiveWise') { echo " - Shop Survey by - ".$exeNameData['ExecutiveName']; } elseif($Condition == 'WardWise') { echo " - Shop Survey Ward No. ".$ConditionName; }?></b></h5>
                    <form method='post' action='exportShopData.php'>
                                <input type='submit' value='Export' name='Export' style="float:right;width:70px;height:30px;color:white;background-color:grey;">
                                  <?php 
                                    $serialize_dataTree = serialize($exportPocketShopsListDetail);
                                   ?>
                                <textarea name='export_data' style='display: none;'><?php echo $serialize_dataTree; ?></textarea>
                    </form>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div>
                            <table  id="ListingSurveyTableId" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                    
                                        <th style="text-align:center;">Sr No </th>
                                        <th style="text-align:center;">Shop Name</th>
                                        <th style="text-align:center;">Zone</th>
                                        <th style="text-align:center;">Ward_No</th>
                                        <th style="text-align:center;">Listing Date</th>
                                        <th style="text-align:center;">Listing By</th>
                                        <th style="text-align:center;">Nature Of Business</th>
                                        <th style="text-align:center;">Shop Category</th>
                                        <th style="text-align:center;">Shop Area Name</th>
                                        <th style="text-align:center;">Shop Address</th>
                                        <th style="text-align:center;">Survey Date</th>
                                        <th style="text-align:center;">Survey By</th>
                                        <th style="text-align:center;">Location</th>
                                        
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                <?php 
                                $srNo = 0;
                                foreach($pocketShopsListDetail as $shopData){ 
                                $srNo = $srNo+1; ?>
                                    <tr>
                                <td style="text-align:center;"> <?php echo $srNo; ?></td> 
                                <td style="text-align:center;"> <?php echo $shopData['ShopName'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['NodeName'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['Ward_No'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['AddedDate'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['AddedBy'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['Nature_of_Business'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['ShopCategory'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['ShopAreaName'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['ShopAddress_1'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['SurveyDate'];?> </td>
                                <td style="text-align:center;"> <?php echo $shopData['SurveyBy'];?> </td>
                                <td style="text-align:center;"> <a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin font-medium-5 text-primary"></i> </a> </td>
                               
                                               </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    
                                        <th style="text-align:center;">Sr No </th>
                                        <th style="text-align:center;">Shop Name</th>
                                        <th style="text-align:center;">Zone</th>
                                        <th style="text-align:center;">Ward_No</th>
                                        <th style="text-align:center;">Listing Date</th>
                                        <th style="text-align:center;">Listing By</th>
                                        <th style="text-align:center;">Nature Of Business</th>
                                        <th style="text-align:center;">Shop Category</th>
                                        <th style="text-align:center;">Shop Area Name</th>
                                        <th style="text-align:center;">Shop Address</th>
                                        <th style="text-align:center;">Survey Date</th>
                                        <th style="text-align:center;">Survey By</th>
                                        <th style="text-align:center;">Location</th>
                                        
                                    </tr>
                                  
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>