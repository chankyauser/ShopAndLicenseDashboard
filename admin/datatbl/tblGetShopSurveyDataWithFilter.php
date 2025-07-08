<?php

$dateFilter = "";

if(isset($_GET['FilterType']) && !empty($_GET['FilterType']) && $_GET['FilterType'] == 'ShopList')
{
    $FilterType = $_GET['FilterType'];
}
else
{
    $FilterType = 'ShopSurvey';
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
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL
    --( ShopMaster.SurveyDate IS NOT NULL OR (ShopMaster.ShopStatus = 'Permanently Closed' OR ShopMaster.ShopStatus = 'Non-Cooperative' OR ShopMaster.ShopStatus = 'Permission Denied') ) 
    ";
    $DocumentJoinCondition = " ";
}
elseif($FilterName == 'MobilePending')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND (ShopMaster.ShopKeeperMobile IS NULL OR LEFT(ShopMaster.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(ShopMaster.ShopKeeperMobile) != 10 ) ";
    $DocumentJoinCondition = " ";
}
elseif($FilterName == 'PhotoPending')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND ( ShopMaster.ShopOutsideImage1 IS NULL AND ShopMaster.ShopOutsideImage2 IS NULL ) ";
    $DocumentJoinCondition = " ";
}
elseif($FilterName == 'DocumentPending')
{
    $FilterNameCondition = "  ";
    $DocumentJoinCondition = "  ";
}
elseif($FilterName == 'QCVerified')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND ShopMaster.ShopStatus = 'Verified' ";
    $DocumentJoinCondition = " ";
}
elseif($FilterName == 'QCRejected')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND ( ShopMaster.ShopStatus IN('Pending','In-Review','Rejected')) ";
    $DocumentJoinCondition = " ";
}
elseif($FilterName == 'QCPending')
{
    $FilterNameCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND (ShopMaster.ShopStatus IS NULL OR ShopMaster.ShopStatus = '') ";
    $DocumentJoinCondition = " ";
}
else 
{
    $FilterNameCondition = " ";
    $DocumentJoinCondition = " ";
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
    $nNCondition = " AND nm.NodeName <> '' ";
}else{
    $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName' ";
    $nNCondition = " AND nm.NodeName = '$nodeName' ";
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
    $dateCondition = " AND ShopMaster.AddedDate IS NOT NULL AND ShopMaster.SurveyDate IS NOT NULL";
}else{
    $dateCondition = " AND CONVERT(VARCHAR, ShopMaster.AddedDate ,120) BETWEEN '$fromDate' AND '$toDate' AND ShopMaster.SurveyDate IS NOT NULL";
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
    

    if($FilterName == 'DocumentPending')
    {
        $queryTotal = "SELECT 
            SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as ShopListingCount
        FROM 
        (
            SELECT 
                t.Shop_Cd,sd.Shop_Cd as Shop_Doc_Cd, t.ShopStatus, STRING_AGG(sd.Document_Cd,',') as Document_Cds, 
                STRING_AGG(sd.QC_Flag,',') as QC_Flags,
                t.Ward_No
            FROM (
                SELECT ShopMaster.Shop_Cd, ShopMaster.ShopStatus, NodeMaster.Ward_No FROM ShopMaster 
                INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
                AND PocketMaster.IsActive = 1 ) 
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd 
                WHERE ShopMaster.IsActive=1 AND SurveyDate IS NOT NULL 
                $nodeCondition
                $nodeNameCondition
                AND CONVERT(varchar,ShopMaster.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
                AND ( ShopMaster.ShopStatus = 'Verified' OR
                ISNULL(ShopStatus,'') = '' 
                OR ShopMaster.ShopStatus in  
                ( SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
                AND IsActive = 1 AND ShopStatus <> 'Verified' ) ) 
            ) as t
            LEFT JOIN ShopDocuments sd on ( sd.Shop_Cd = t.Shop_Cd AND sd.IsActive = 1 )
            GROUP BY t.Shop_Cd, t.ShopStatus, sd.Shop_Cd, t.Ward_No
    
        ) as t1
        
    
        ";

    $dbTotal=new DbOperation();
    $total_count = $dbTotal->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
    $totalRecords = $total_count["ShopListingCount"];
    

    }
    else{

    $queryTotal = "SELECT COUNT(ShopMaster.Shop_Cd) as ShopListingCount
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    $DocumentJoinCondition
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    AND ShopMaster.SurveyDate IS NOT NULL
    AND ( 
            ISNULL(ShopMaster.ShopStatus,'') = '' OR 
            ShopMaster.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    $FilterNameCondition
    ;";
     // echo $queryTotal;

    $dbTotal=new DbOperation();
    $total_count = $dbTotal->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
    $totalRecords = $total_count["ShopListingCount"];

    }

    // print_r($total_count);
?>
<?php

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $dbTotal->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];


    if($FilterName == 'DocumentPending')
    {
        $query1 = " SELECT 
		SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as ShopWithNoDoc
		
        FROM 
        (
            SELECT 
                t.Shop_Cd,sd.Shop_Cd as Shop_Doc_Cd, t.ShopStatus, STRING_AGG(sd.Document_Cd,',') as Document_Cds, 
                STRING_AGG(sd.QC_Flag,',') as QC_Flags,
                t.Ward_No
            FROM (
                SELECT ShopMaster.Shop_Cd, ShopMaster.ShopStatus, NodeMaster.Ward_No FROM ShopMaster 
                INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
                AND PocketMaster.IsActive = 1 ) 
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd 
                WHERE ShopMaster.IsActive=1 AND SurveyDate IS NOT NULL 
                $nodeCondition
                $nodeNameCondition
                AND CONVERT(varchar,ShopMaster.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
                AND ( ShopMaster.ShopStatus = 'Verified' OR
                ISNULL(ShopStatus,'') = '' 
                OR ShopMaster.ShopStatus in  
                ( SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
                AND IsActive = 1 AND ShopStatus <> 'Verified' ) ) 
            ) as t
            LEFT JOIN ShopDocuments sd on ( sd.Shop_Cd = t.Shop_Cd AND sd.IsActive = 1 )
            GROUP BY t.Shop_Cd, t.ShopStatus, sd.Shop_Cd, t.Ward_No

        ) as t1
	    ";
        
        $pocketShopsListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    }
    else
    {
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
    $DocumentJoinCondition
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    AND ShopMaster.SurveyDate IS NOT NULL
    AND ( 
            ISNULL(ShopMaster.ShopStatus,'') = '' OR 
            ShopMaster.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.SurveyDate DESC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $pocketShopsListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
    }
?>


<?php
    
    if(sizeof($pocketShopsListDetail) >0)
    {


    if($FilterName == 'DocumentPending')
    {

    //Executive Wise Count
    $exeQue = "SELECT 
    SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as ShopCount,
    t1.SRExecutive_Cd,
    (SELECT MobileNo FROM Survey_Entry_Data..Executive_Master 
    WHERE Executive_Cd = t1.SRExecutive_Cd) as MobileNo,
    (SELECT ExecutiveName FROM Survey_Entry_Data..Executive_Master 
    WHERE Executive_Cd = t1.SRExecutive_Cd) as SRExecutiveName
    FROM 
    (
        SELECT 
            t.Shop_Cd,sd.Shop_Cd as Shop_Doc_Cd, t.ShopStatus, STRING_AGG(sd.Document_Cd,',') as Document_Cds, 
            STRING_AGG(sd.QC_Flag,',') as QC_Flags,
            t.SRExecutive_Cd
        FROM (
        SELECT ShopMaster.Shop_Cd, ShopMaster.ShopStatus, ShopMaster.SRExecutive_Cd FROM ShopMaster 
        INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
        AND PocketMaster.IsActive = 1 ) 
        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd 
        WHERE ShopMaster.IsActive=1 AND SurveyDate IS NOT NULL 
        $dateCondition 
        $pcktCondition  
        $supervisorCondition  
        $nodeCondition
        $nodeNameCondition
        $FilterNameCondition
        AND ( ShopMaster.ShopStatus = 'Verified' OR
        ISNULL(ShopStatus,'') = '' 
        OR ShopMaster.ShopStatus in  
        ( SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
        AND IsActive = 1 AND ShopStatus <> 'Verified' ) ) 
    ) as t
    LEFT JOIN ShopDocuments sd on ( sd.Shop_Cd = t.Shop_Cd AND sd.IsActive = 1 )
    GROUP BY t.Shop_Cd, t.ShopStatus, sd.Shop_Cd, t.SRExecutive_Cd

    ) as t1
    GROUP BY t1.SRExecutive_Cd     

    ;";
    $exeCountData = $db2->ExecutveQueryMultipleRowSALData($exeQue, $electionName, $developmentMode);
    
    //Ward Wise Count
    $wardQue = "SELECT 
    SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as ShopCount,
    t1.NodeName,
    t1.Ward_No
    FROM 
    (
        SELECT 
            t.Shop_Cd,sd.Shop_Cd as Shop_Doc_Cd, t.ShopStatus, STRING_AGG(sd.Document_Cd,',') as Document_Cds, 
            STRING_AGG(sd.QC_Flag,',') as QC_Flags,
            t.Ward_No, t.NodeName
        FROM (
        SELECT ShopMaster.Shop_Cd, ShopMaster.ShopStatus, NodeMaster.Ward_No, NodeMaster.NodeName FROM ShopMaster 
        INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
        AND PocketMaster.IsActive = 1 ) 
        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd 
        WHERE ShopMaster.IsActive=1 AND SurveyDate IS NOT NULL 
        $dateCondition 
        $pcktCondition  
        $supervisorCondition  
        $nodeCondition
        $nodeNameCondition
        $FilterNameCondition
        AND ( ShopMaster.ShopStatus = 'Verified' OR
        ISNULL(ShopStatus,'') = '' 
        OR ShopMaster.ShopStatus in  
        ( SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
        AND IsActive = 1 AND ShopStatus <> 'Verified' ) ) 
    ) as t
    LEFT JOIN ShopDocuments sd on ( sd.Shop_Cd = t.Shop_Cd AND sd.IsActive = 1 )
    GROUP BY t.Shop_Cd, t.ShopStatus, sd.Shop_Cd, t.Ward_No, t.NodeName

    ) as t1
    GROUP BY t1.Ward_No, t1.NodeName   ;";

    $wardCountData = $db2->ExecutveQueryMultipleRowSALData($wardQue, $electionName, $developmentMode);


    }
    else
    {
    //Executive Wise Count
    $exeQue = "SELECT ShopMaster.SRExecutive_Cd,
    (SELECT MobileNo FROM Survey_Entry_Data..Executive_Master 
    WHERE Executive_Cd = ShopMaster.SRExecutive_Cd) as MobileNo,
    (SELECT ExecutiveName FROM Survey_Entry_Data..Executive_Master 
    WHERE Executive_Cd = ShopMaster.SRExecutive_Cd) as SRExecutiveName,
    COUNT(ShopMaster.Shop_Cd) as ShopCount
    FROM ShopMaster
    INNER JOIN PocketMaster ON ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    $DocumentJoinCondition
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    AND ShopMaster.SurveyDate IS NOT NULL
    AND ( 
            ISNULL(ShopMaster.ShopStatus,'') = '' OR 
            ShopMaster.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
    AND NodeMaster.IsActive = 1
    AND ShopMaster.AddedDate IS NOT NULL
    AND ShopMaster.SurveyDate IS NOT NULL
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    GROUP BY ShopMaster.SRExecutive_Cd
    ORDER BY COUNT(ShopMaster.Shop_Cd) DESC ;";
    $exeCountData = $db2->ExecutveQueryMultipleRowSALData($exeQue, $electionName, $developmentMode);
    
    //Ward Wise Count
    $wardQue = "SELECT NodeMaster.Ward_No,
    NodeMaster.NodeName,
    COUNT(ShopMaster.Shop_Cd) as ShopCount
    FROM ShopMaster
    INNER JOIN PocketMaster ON ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1
    $DocumentJoinCondition
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    AND ShopMaster.SurveyDate IS NOT NULL
    AND ( 
            ISNULL(ShopMaster.ShopStatus,'') = '' OR 
            ShopMaster.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
    AND NodeMaster.IsActive = 1
    AND ShopMaster.AddedDate IS NOT NULL
    AND ShopMaster.SurveyDate IS NOT NULL
    $dateCondition 
    $pcktCondition  
    $supervisorCondition  
    $nodeCondition
    $nodeNameCondition
    $FilterNameCondition
    GROUP BY NodeMaster.Ward_No, NodeMaster.NodeName
    ORDER BY COUNT(ShopMaster.Shop_Cd) DESC ;";
    $wardCountData = $db2->ExecutveQueryMultipleRowSALData($wardQue, $electionName, $developmentMode);

    }

     ?>
       <!-- Column selectors with Export Options and print table -->
       
       <div class="row">
        <?php if(sizeof($exeCountData) >0)
    {?>
            <div class="col-6 col-sm-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                    <span class="btn" style="background-color:#c90d41;color:white;font-weight:bold;"> <?php echo $FilterType." - ".$FilterName." - ".$total_count["ShopListingCount"]; ?></span> <b style="font-weight:bold;font-size:16px;">- Executive wise Shop Survey </b>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div>
                                <table id="executiveDataCountId" class="table table-striped" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo 'Shop Survey Executive Name';?></th>
                                                        <th style="text-align:center;"><?php echo 'Mobile No';?></th>
                                                        <th style="text-align:center;"><?php echo 'Shop Count';?></th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                             
                                                    
                                                        <?php 
                                                        $totalShopCount = 0;
                                                       
                                                        foreach($exeCountData as $key=>$val)
                                                        { 
                                                            $totalShopCount += $val['ShopCount'];
                                                            
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $val['SRExecutiveName'];?></td>
                                                        <td style="text-align:center;"><?php echo $val['MobileNo'];?></td>
                                                        <td style="text-align:center;"><span class="badge badge-dark badge-md " style="font-weight:bold;font-size:16px;background-color:#c90d41;color:white;" onclick="setShopListingSurveyDetailFilter('ExecutiveWise','<?php echo $val['SRExecutive_Cd'];?>')"><?php echo $val['ShopCount'];?></span></td>
                                                        
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                        <th colspan="2">Total</th>
                                                        <th style="text-align:center;"><span class="badge badge-dark badge-md " style="font-weight:bold;font-size:16px;background-color:#c90d41;color:white;"><?php echo $totalShopCount;?></span></th>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>Shop Survey Executive Name</th>
                                                        <th style="text-align:center;">Mobile No</th>
                                                        <th style="text-align:center;">Shop Count</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
        </div>
        </div>
        </div>
        </div>
        </div>

        <?php 
        
    }
?>


<?php if(sizeof($wardCountData) >0)
    {?>
            <div class="col-6 col-sm-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                    <span class="btn" style="background-color:#c90d41;color:white;font-weight:bold;"> <?php echo $FilterType." - ".$FilterName." - ".$total_count["ShopListingCount"]; ?></span> <b style="font-weight:bold;font-size:16px;"> - Ward wise Shop Survey </b>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div>
                                <table id="wardDataCountId" class="table table-striped" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo 'Survey Node Name';?></th>
                                                        <th style="text-align:center;"><?php echo 'Survey Ward No';?></th>
                                                        <th style="text-align:center;"><?php echo 'Shop Count';?></th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                             
                                                    
                                                        <?php 
                                                        $totalShopCount = 0;
                                                        $totalQCVerifiedShopCount = 0;
                                                        $totalQCNonVerifiedShopCount = 0;
                                                        foreach($wardCountData as $key=>$val)
                                                        { 
                                                            $totalShopCount += $val['ShopCount'];
                                                           
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $val['NodeName'];?></td>
                                                        <td style="text-align:center;"><?php echo $val['Ward_No'];?></td>
                                                        <td style="text-align:center;"><span class="badge badge-dark badge-md " style="font-weight:bold;font-size:16px;background-color:#c90d41;color:white;" onclick="setShopListingSurveyDetailFilter('WardWise','<?php echo $val['Ward_No'];?>')"><?php echo $val['ShopCount'];?></span></td>
                                                    
                                                        
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                        <th colspan="2">Total</th>
                                                        <th style="text-align:center;"><span class="badge badge-dark badge-md " style="font-weight:bold;font-size:16px;background-color:#c90d41;color:white;"><?php echo $totalShopCount;?></span></th>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>Survey Node Name</th>
                                                        <th style="text-align:center;">Survey Ward No</th>
                                                        <th style="text-align:center;">Shop Count</th>
                                                      
                                                    </tr>
                                                </tfoot>
                                            </table>
        </div>
        </div>
        </div>
        </div>
        </div>

        <?php 
        
    }
?>

        </div>
   
       
<div id="tblGetShopListWithFilterAppliedId"> 
</div>

</div>
<?php } ?>