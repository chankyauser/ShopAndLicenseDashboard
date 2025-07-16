<?php
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $nodeData = array();
    $businessCatData = array();

    if(!isset($_SESSION['SAL_Node_Name'])){
        $_SESSION['SAL_Node_Name'] = "All";
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = $_SESSION['SAL_Node_Name'];
    }

    if(!isset($_SESSION['SAL_Shop_Name'])){
        $_SESSION['SAL_Shop_Name'] = "All";
        $shopName = $_SESSION['SAL_Shop_Name'];
    }else{
        $shopName = $_SESSION['SAL_Shop_Name'];
    }

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    
    if(!isset($_SESSION['SAL_search_Owner_Name'])){
        $_SESSION['SAL_search_Owner_Name'] = "";
        $searchOwner = $_SESSION['SAL_search_Owner_Name'];
    }else{
        $searchOwner = $_SESSION['SAL_search_Owner_Name'];
    }

    if(!isset($_SESSION['SAL_search_mobile'])){
        $_SESSION['SAL_search_mobile'] = "";
        $searchMobile = $_SESSION['SAL_search_mobile'];
    }else{
        $searchMobile = $_SESSION['SAL_search_mobile'];
    }

    if($nodeName == "All"){
        $nodeNameCondition = "  ";
    }else{
        $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName'  ";   
    }

    if($nodeCd != "All"){
        $nodeCondition = " AND NodeMaster.Node_Cd = $nodeCd ";
    }else{
        $nodeCondition = "";
    }

    if($searchMobile != ''){
        $mobCondition = " AND (ShopMaster.ShopOwnerMobile LIKE '$searchMobile' OR ShopMaster.ShopKeeperMobile LIKE '$searchMobile') ";
    }else{
        $mobCondition = " ";
    }

    if($searchOwner != ''){
        $ownerCondition = " AND (ShopMaster.ShopOwnerName LIKE '%$searchOwner%' OR ShopMaster.ShopKeeperName LIKE '%$searchOwner%') ";
    }else{
        $ownerCondition = " ";
    }

    $dataNodeName = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
        ISNULL(NodeMaster.NodeName,'') as NodeName,
        ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar
        FROM NodeMaster 
        INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
        INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
        WHERE NodeMaster.IsActive = 1 
        GROUP BY NodeMaster.NodeName, NodeMaster.NodeNameMar
        ORDER BY NodeMaster.NodeName";
    $db=new DbOperation();
    $dataNodeName = $db->ExecutveQueryMultipleRowSALData($dataNodeName, $electionName, $developmentMode);

    $queryNode = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
            ISNULL(NodeMaster.Node_Cd,0) as Node_Cd,
            ISNULL(NodeMaster.NodeName,'') as NodeName,
            ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar,
            ISNULL(NodeMaster.Ac_No,0) as Ac_No,
            ISNULL(NodeMaster.Ward_No,0) as Ward_No,
            ISNULL(NodeMaster.Address,'') as Address,
            ISNULL(NodeMaster.Area,'') as Area
            FROM NodeMaster 
            INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
            INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
            WHERE NodeMaster.IsActive = 1  
            $nodeNameCondition
            GROUP BY NodeMaster.Node_Cd, NodeMaster.NodeName,
            NodeMaster.NodeNameMar, NodeMaster.Ac_No,
            NodeMaster.Ward_No, NodeMaster.Address, NodeMaster.Area
            ORDER BY NodeMaster.Ward_No";
    $db=new DbOperation();
    $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
         
    $searchShopCondition="";
    if(!empty($shopName)){
        if ($shopName == trim($shopName) && strpos($shopName, ' ') !== false) {
            $strArr = explode(" ", $shopName);
            foreach($strArr as $valueShop){
                $searchShopCondition .= " AND ShopMaster.ShopName like '%$valueShop%' ";
            }
        }else{
             $searchShopCondition = " AND ShopMaster.ShopName like '%$shopName%' ";
        }

    }

    $totalRecords = 0;
    $maxPageNo = 0;

    if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "GridView"){
        $recordPerPage = 20;
    }else{
        $recordPerPage = 10;
    }

    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo']=1;
    }else{
        $pageNo = 1;  
        $_SESSION['SAL_Pagination_PageNo'] = $pageNo;
    }

    
    $db1=new DbOperation();

   
    $total_count = array();
    $query = " SELECT ISNULL(
        (SELECT Count(t1.Shop_Cd) FROM (
            SELECT Shop_Cd
            FROM ShopMaster 
            LEFT JOIN NodeMaster on NodeMaster.Ward_No = ShopMaster.Ward_No
            WHERE ShopMaster.IsActive = 1  AND ShopMaster.ShopName IS NOT NULL
            $mobCondition
            $ownerCondition
            $nodeNameCondition
            $nodeCondition
            $searchShopCondition
        ) as t1 
       ),0)  as FilteredShop";


    $total_count = $db1->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode); 
    $totalRecords = $total_count["FilteredShop"];

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) / $recordPerPage) as TotalShop";
    $ShopTotalCountData = $db1->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];

    $db2=new DbOperation();
    $query1 = "SELECT   ISNULL(ShopMaster.Shop_Cd , '') AS Shop_Cd,
                        ISNULL(ShopMaster.ShopOutsideImage1, '') AS ShopOutsideImage1,
                        ISNULL(ShopMaster.ShopOutsideImage2, '') AS ShopOutsideImage2,
                        ISNULL(ShopMaster.ShopOwnerAadharNo, '') AS ShopOwnerAadharNo,
                        ISNULL(ShopMaster.ShopOwnerPinCode, '') AS ShopOwnerPinCode,
                        ISNULL(BusinessCategoryMaster.BusinessCatName, '') AS BusinessCatName,
                        ISNULL(CASE
                            WHEN ShopMaster.ShopKeeperName = '.....' OR NULLIF(ShopMaster.ShopKeeperName, '') IS NULL THEN ShopOwnerName
                            ELSE ShopKeeperName
                        END,'') AS ShopKeeperName,
                        ISNULL(NULLIF(ShopMaster.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                        ISNULL(NULLIF(ShopMaster.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                        ISNULL(ShopMaster.ShopOwnerAddress, '') AS ShopOwnerAddress,
                        ISNULL(ShopMaster.FirstName, '') AS FirstName,
                        ISNULL(ShopMaster.MiddleName, '') AS MiddleName,
                        ISNULL(ShopMaster.LastName, '') AS LastName,
                        ISNULL(ShopMaster.ShopName, '') AS ShopName,
                        ISNULL(ParwanaMaster.Parwana_Name_Eng, '') AS BusinessDetails,
                        ISNULL(ParwanaDetails.Amount,'') as Amount,
                        ISNULL(ShopMaster.ShopLength,0) as ShopLength,
                        ISNULL(ShopMaster.ShopWidth,0) as ShopWidth,
                        ISNULL(ShopMaster.ShopHeight,0) as ShopHeight,
                        ISNULL(ShopAreamaster.ShopAreaName, '') as ShopAreaName, 
                        ISNULL(ShopAreamaster.ShopAreaNameMar, '') as ShopAreaNameMar,
                        ISNULL(CONCAT(ShopMaster.ShopAddress_1, 
                            CASE 
                        WHEN ShopMaster.ShopAddress_2 IS NOT NULL AND ShopMaster.ShopAddress_2 != '' 
                            THEN CONCAT(', ', ShopAddress_2)
                            ELSE ''END), '') AS ShopAddress,
                        ISNULL(ShopMaster.ShopCategory, '') AS ShopCategory,
                        ISNULL(ShopMaster.IsCertificateIssued, '') AS IsCertificateIssued,
                        ISNULL(CONVERT(VARCHAR,ShopMaster.BusinessStartDate,23),'') as BusinessStartDate,
                        ISNULL(CONVERT(VARCHAR,ShopMaster.RenewalDate,23),'') as RenewalDate,
                        ISNULL(ShopMaster.ShopOutsideImage1, '') AS ShopOutsideImage1,
                        ISNULL(ShopMaster.ShopOwnStatus, '') AS ShopOwnStatus,
                        ISNULL(ShopMaster.BusinessCat_Cd, '') AS BusinessCat_Cd,
                        ISNULL(ShopMaster.ShopNameMar, '') AS ShopNameMar,
                        ISNULL(ShopMaster.Ward_No, '') AS Ward_No,
                        ISNULL(NodeMaster.Area, '') AS WardArea,
                        ISNULL(NodeMaster.NodeName, '') AS NodeName
                            FROM ShopMaster
                            LEFT JOIN ParwanaDetails ON (ParwanaDetails.ParwanaDetCd = ShopMaster.ParwanaDetCd)
                            LEFT JOIN ParwanaMaster ON (ParwanaMaster.Parwana_Cd = ParwanaDetails.Parwana_Cd)
                            LEFT JOIN BusinessCategoryMaster ON (BusinessCategoryMaster.BusinessCat_Cd=ShopMaster.BusinessCat_Cd)
                            LEFT JOIN NodeMaster ON (NodeMaster.Ward_No = ShopMaster.Ward_No) AND (NodeMaster.IsActive = 1)
                            LEFT JOIN ShopAreamaster ON (ShopMaster.ShopArea_Cd = ShopAreamaster.ShopArea_Cd) 
                            WHERE  ShopMaster.IsActive = 1 AND ShopMaster.ShopName IS NOT NULL
                            $mobCondition
                            $ownerCondition
                            $nodeNameCondition
                            $nodeCondition
                            $searchShopCondition
                            ORDER BY ShopMaster.Shop_Cd DESC
                        OFFSET ($pageNo - 1) * $recordPerPage ROWS 
                        FETCH NEXT $recordPerPage ROWS ONLY;";

    $shopListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?>

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-12 col-sm-12">
                <div class="breadcrumb">
                    <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="#" class="inactiveLink "> <i class="fi-rs-location-alt"></i> Ward : </a>
                    <?php if($nodeName!="All"){ echo $nodeName." - "; } ?>
                    <?php if($nodeCd != "All"){ if(sizeof($nodeData)>0){ echo $nodeData["Ward_No"]." - ".$nodeData["Area"]; } }else{ echo $nodeCd; } ?>
                    <span> Shops : <strong class="text-brand"
                            style="font-size: 17px;font-weight: bold;"><?php echo $total_count["FilteredShop"]; ?>
                            found!</strong> </span>
                </div>
            </div>

            <div class="col-lg-4 col-md-5 col-12 col-sm-12 text-right">
                <div class="pagination-area" style="float:right;">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">

                            <?php 
                               
                                $maxPagesToShow = 5;
                                $totalPages = $totalRecords; 
                                $pageNo = max(1, $pageNo); 
                                $pageNo = min($pageNo, $totalPages); 

                                $loopStart = max(1, $pageNo - floor($maxPagesToShow / 2));
                                $loopStop = $loopStart + $maxPagesToShow - 1;

                                if ($loopStop > $totalPages) {
                                    $loopStop = $totalPages;
                                    $loopStart = max(1, $loopStop - $maxPagesToShow + 1);
                                }
                            ?>


                            <?php if ($pageNo > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" onclick="setShopOwnerDetailFilter(<?php echo ($pageNo - 1); ?>)">
                                    <i class="fi-rs-arrow-small-left"></i>
                                </a>
                            </li>
                            <?php } ?>

                            <?php for ($i = $loopStart; $i <= $loopStop; $i++) {
                                $activePageCondition = ($pageNo == $i) ? "active" : "";
                            ?>
                            <li class="page-item <?php echo $activePageCondition; ?>">
                                <a class="page-link" onclick="setShopOwnerDetailFilter(<?php echo $i; ?>)">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($pageNo < $totalPages) { ?>
                            <li class="page-item">
                                <a class="page-link" onclick="setShopOwnerDetailFilter(<?php echo ($pageNo + 1); ?>)">
                                    <i class="fi-rs-arrow-small-right"></i>
                                </a>
                            </li>
                            <?php } ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>