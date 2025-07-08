<?php 

    
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
        $supervisorCondition = " AND ShopMaster.PlExecutive_Cd = $executiveCd ";
    }


    if($dateFilter == "All" ){
        $dateCondition = " AND ShopMaster.AddedDate IS NOT NULL  ";
    }else{
        $dateCondition = " AND CONVERT(VARCHAR, ShopMaster.AddedDate ,120) BETWEEN '$fromDate' AND '$toDate'  ";
    }

    $totalRecords = 0;
    $maxPageNo = 0;
    $recordPerPage = 10;
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
    AND ISNULL(ShopLatitude,'0')  <> '0' ;";
    // echo $queryTotal;
    $dbTotal=new DbOperation();
    $total_count = $dbTotal->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
    $totalRecords = $total_count["ShopListingCount"];
    // print_r($total_count);

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $dbTotal->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];

    $query1 = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopName,'') as ShopName, 
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
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate ASC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $pocketShopsListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    $queryExport = "SELECT 
    ISNULL(ShopMaster.ShopName, '') as ShopName,
    ISNULL(PocketMaster.PocketName,'') as PocketName,
    ISNULL(NodeMaster.Ward_No,0) as Ward_No,
    ISNULL(NodeMaster.Area,'') as WardArea,
    ISNULL(NodeMaster.NodeName,'') as NodeName,
    ISNULL(ShopMaster.ShopOutsideImage1,'') as ShopOutsideImage1,
    ISNULL(ShopMaster.ShopCategory,'') as ShopCategory,
    ISNULL((SELECT top (1) BusinessCatName FROM BusinessCategoryMaster WHERE BusinessCat_Cd = ShopMaster.BusinessCat_Cd ),'') as Nature_of_Business,
    ISNULL((SELECT top (1) ShopAreaName FROM ShopAreaMaster WHERE ShopArea_Cd = ShopMaster.ShopArea_Cd ),'') as ShopAreaName,
    'https://www.google.com/maps/search/?api=1&query='+ShopMaster.ShopLatitude+','+ShopMaster.ShopLongitude+'' as LocationUrl, 
    ISNULL(ShopMaster.AddedBy,'') as AddedBy,
    ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate

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
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate ASC;";
    $pocketShopsListExport = $db2->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);
?>
<div class="row">
    <div class="col-md-3 col-sm-12 col-12">
        <div class="form-group">
            <label for="fromDate">From Date</label>
            <input type='text' name="fromDate" value="<?php echo $from_Date;?>" class="form-control pickadate-disable-forwarddates"  />
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-12">
        <div class="form-group">
            <label for="toDate">To Date</label>
            <input type='text' name="toDate" value="<?php echo $to_Date;?>" class="form-control pickadate-disable-forwarddates" />
        </div>
    </div>
    <input type="hidden" value="<?php echo $nodeName; ?>" name="node_Name">
    <input type="hidden" value="<?php echo $pocketCd; ?>" name="pocket_Name">

    <div class="col-md-2 col-sm-12 col-12">
       <?php include 'dropdown-nodecd-and-wardno-shoplisting.php'; ?>
    </div>

    <div class="col-md-3 col-sm-12 col-12">
       <?php include 'dropdown-executives-name-node-cd-date-shop-listing.php'; ?>
    </div>

    <div class="col-md-1 col-sm-12 col-12 text-right"   style="margin-top: 15px;">
         <div class="form-group">
            <label for="refesh" ></label>
            <button type="button" name="refesh" class="btn btn-primary" onclick="getPocketWiseShopsListing()" ><i class="feather icon-refresh-cw"></i></button>
        </div>
    </div>
                              
    <div class="col-md-3 col-sm-12 col-12">
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <form method='post' action='ShopListingDetailDataExport.php'>
            <input type='submit' value='Export-<?php echo $total_count["ShopListingCount"]; ?>' name='Export' class="btn btn-success" >

              <?php 
                $serialize_ShopListingDetailData = serialize($pocketShopsListExport);
               ?>
            
            <textarea name='export_data' style='display: none;'><?php echo $serialize_ShopListingDetailData; ?></textarea>
        </form>
    </div>

    <div class="col-12 col-sm-12 col-md-9 text-right">
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
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
                    <li class="page-item prev"><a class="page-link" onclick="setShopListingDetailPaginationPageNo(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                <?php } ?>

                <?php
                    for($i=$loopStart;$i<=$loopStop;$i++){ 

                            $activePageCondition = ""; 
                            if($pageNo == $i){
                                $activePageCondition = "active";                                
                            }
                        ?>
                        <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopListingDetailPaginationPageNo(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                <?php } ?>
                    <!-- <li class="page-item" > <a class="page-link"><?php //echo " of ".$total_count["SurveyDone"]; ?></a></li> -->
                <?php if($totalRecords > $loopStop){ ?> 
                    <li class="page-item next"><a class="page-link"  onclick="setShopListingDetailPaginationPageNo(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                <?php }  ?>
            </ul>
        </nav>
    </div>

  

    <?php 
        // print_r($pocketShopsListDetail);
    
    if (sizeof($pocketShopsListDetail)>0){
            $srNo = 0;
            if($pageNo!=1){
                $srNo = (($pageNo * $recordPerPage) - ($recordPerPage));
            }
                foreach($pocketShopsListDetail as $shopData){ 
                    $srNo = $srNo+1;
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-content">
                        <?php 
                            $shopListExecutive = "";
                            $shopSurveyExecutive = "";
                            if(strpos($shopData["AddedBy"], "_") !== false){
                                $shpListExecutiveArr = explode("_", $shopData["AddedBy"]);
                                $shopListExecutive = "  |  By : ".$shpListExecutiveArr[0];
                            }else{
                                $shopListExecutive = "  |  By : ".$shopData["AddedBy"];
                            }

                            if(strpos($shopData["SurveyBy"], "_") !== false){
                                $shpSurveyExecutiveArr = explode("_", $shopData["SurveyBy"]);
                                $shopSurveyExecutive = "  |  By : ".$shpSurveyExecutiveArr[0];
                            }else{
                                $shopSurveyExecutive = "  |  By : ".$shopData["SurveyBy"];
                            }
                        ?>

                        <h5 class="mb-0" style="color:#c90d41;"> <?php echo $srNo.") "; ?><?php echo $shopData["ShopName"]. " on ".$shopData["AddedDate"]." ".$shopListExecutive; ?></h5>
                        <div class="row">

                            <div class="col-xl-11">
                                <div class="employee-task d-flex justify-content-between align-items-top">
                                    
                                        <div class="media">
                                            
                                           <div class="avatar mr-75">

                                                <?php if($shopData["ShopOutsideImage1"] != ''){ ?>
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                               <?php }else { ?>   
                                                    <img src="pics/shopDefault.jpeg" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                               <?php } ?>
                                            </div>
                                           <div class="media-body my-10px" style="margin-top:10px;">
                                            
                                            
                                               <!-- <h6><b><?php //echo $shopData["ShopKeeperName"]; ?> - <?php //echo $shopData["ShopKeeperMobile"]; ?></b></h6> -->
                                               <h6><?php echo $shopData["Nature_of_Business"]; ?></h6>
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
                            <div class="col-xl-1 text-right">
                              
                               
                                <div class="position-relative d-inline-block mr-2" style="margin-top: 1.1rem;">
                                   <a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin font-medium-5 text-primary"></i> </a>
                                </div>
                               
                            </div>

                        </div>

                    </div>

               </div>
            </div>
        </div>
    
           <?php
            }  
       
    }
    ?>

</div>