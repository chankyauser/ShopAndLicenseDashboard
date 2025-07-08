<?php
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    // include '../api/includes/DbOperation.php';

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $nodeData = array();
    $businessCatData = array();
    
    if(empty($nodeCd)){
        $nodeCd = "All";
    }
    if(empty($businessCatCd)){
        $businessCatCd = "All";
    }

    if($nodeCd != "All"){
        $nodeCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0 ";
        $queryNode = "SELECT
            ISNULL(Node_Cd,0) as Node_Cd,
            ISNULL(NodeName,'') as NodeName,
            ISNULL(NodeNameMar,'') as NodeNameMar,
            ISNULL(Ac_No,0) as Ac_No,
            ISNULL(Ward_No,0) as Ward_No,
            ISNULL(Address,'') as Address,
            ISNULL(Area,'') as Area
        FROM NodeMaster
        WHERE Node_Cd = $nodeCd";
        $db1=new DbOperation();
        $nodeData = $db1->ExecutveQuerySingleRowSALData($queryNode, $electionName, $developmentMode);
    }else{
        $nodeCondition = " AND PocketMaster.Node_Cd <> 0  ";
    }

    if($businessCatCd != "All"){
        $businessCatCondition = " AND ShopMaster.BusinessCat_Cd = $businessCatCd AND ShopMaster.BusinessCat_Cd <> 0 ";
        $queryBusinessCat = "SELECT
            ISNULL(BusinessCat_Cd,0) as BusinessCat_Cd,
            ISNULL(BusinessCatName,'') as BusinessCatName,
            ISNULL(BusinessCatNameMar,'') as BusinessCatNameMar
            FROM BusinessCategoryMaster
        WHERE BusinessCat_Cd = $businessCatCd";
        $db1=new DbOperation();
        $businessCatData = $db1->ExecutveQuerySingleRowSALData($queryBusinessCat, $electionName, $developmentMode);
    }else{
        $businessCatCondition = " AND ShopMaster.BusinessCat_Cd <> 0 ";
    }


 

    $totalRecords = 0;
    $maxPageNo = 0;

    if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){
        $recordPerPage = 6;
    }else{
        $recordPerPage = 10;
    }

    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo']=1;
    }else{
        $pageNo = 1;  
    }
    $total_count = array();
    $db1=new DbOperation();
    $query = "SELECT
        ISNULL((SELECT Count(*) 
        FROM ShopMaster 
        INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
        INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
        WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
        $nodeCondition
        $businessCatCondition
       
        ), 0) as FilteredShop";
        // echo $query;
    $total_count = $db1->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode); 
    $totalRecords = $total_count["FilteredShop"];

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) / $recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $db1->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];

    $db2=new DbOperation();
    $query1 = "SELECT 
            ISNULL(ShopMaster.Shop_Cd, 0) as Shop_Cd, 
            ISNULL(ShopMaster.ShopName, '') as ShopName, 
            ISNULL(ShopMaster.ShopNameMar, '') as ShopNameMar, 

            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(ShopMaster.ShopCategory, '') as ShopCategory, 

            ISNULL(PocketMaster.PocketName,'') as PocketName,
            ISNULL(NodeMaster.NodeName,'') as NodeName,
            ISNULL(NodeMaster.Ward_No,0) as Ward_No,
            ISNULL(NodeMaster.Area,'') as WardArea,

            ISNULL(ShopMaster.ShopAddress_1, '') as ShopAddress_1, 
            ISNULL(ShopMaster.ShopAddress_2, '') as ShopAddress_2, 

            ISNULL(ShopMaster.ShopKeeperName, '') as ShopKeeperName, 
            ISNULL(ShopMaster.ShopKeeperMobile, '') as ShopKeeperMobile,

            ISNULL(ShopMaster.QC_Flag, 0) as QC_Flag,
            ISNULL(CONVERT(VARCHAR, ShopMaster.QC_UpdatedDate, 100), '') as QC_UpdatedDate, 

            ISNULL(ShopMaster.LetterGiven, '') as LetterGiven, 
            ISNULL(ShopMaster.IsCertificateIssued, 0) as IsCertificateIssued, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.RenewalDate, 105), '') as RenewalDate, 
            ISNULL(ShopMaster.ParwanaDetCd, 0) as ParwanaDetCd, 
            ISNULL(pd.PDetNameEng,'') as PDetNameEng,
            
            ISNULL(ShopMaster.ShopOwnStatus, '') as ShopOwnStatus, 
            ISNULL(ShopMaster.ShopOwnPeriod, 0) as ShopOwnPeriod, 
            ISNULL(ShopMaster.ShopOwnerName, '') as ShopOwnerName, 
            ISNULL(ShopMaster.ShopOwnerMobile, '') as ShopOwnerMobile, 
            ISNULL(ShopMaster.ShopContactNo_1, '') as ShopContactNo_1, 
            ISNULL(ShopMaster.ShopContactNo_2, '') as ShopContactNo_2,
            ISNULL(ShopMaster.ShopEmailAddress, '') as ShopEmailAddress, 
            ISNULL(ShopMaster.ShopOwnerAddress, '') as ShopOwnerAddress,

            ISNULL(ShopMaster.MaleEmp, '') as MaleEmp,
            ISNULL(ShopMaster.FemaleEmp, '') as FemaleEmp,
            ISNULL(ShopMaster.OtherEmp, '') as OtherEmp,
            ISNULL(ShopMaster.ContactNo3, '') as ContactNo3,
            ISNULL(ShopMaster.GSTNno, '') as GSTNno,
            ISNULL(ShopMaster.ConsumerNumber, '') as ConsumerNumber, 

            ISNULL(ShopMaster.ShopOutsideImage1, '') as ShopOutsideImage1, 
            ISNULL(ShopMaster.ShopOutsideImage2, '') as ShopOutsideImage2, 
            ISNULL(ShopMaster.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(ShopMaster.ShopInsideImage2,'') as ShopInsideImage2,

            ISNULL(ShopMaster.ShopDimension, '') as ShopDimension, 

            ISNULL(ShopMaster.ShopStatus, '') as ShopStatus, 
            ISNULL(stm.TextColor, '') as ShopStatusTextColor, 
            ISNULL(stm.FaIcon, '') as ShopStatusFaIcon, 
            ISNULL(stm.IconUrl, '') as ShopStatusIconUrl, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.ShopStatusDate, 100), '') as ShopStatusDate, 
            ISNULL(ShopMaster.ShopStatusRemark, '') as ShopStatusRemark, 

            ISNULL(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
            ISNULL(bcm.BusinessCatName, '') as BusinessCatName, 
            ISNULL(bcm.BusinessCatNameMar, '') as BusinessCatNameMar,

            ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
            ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,

            ISNULL(ShopMaster.AddedBy,'') as AddedBy,
            ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
            ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
            ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate
            
    FROM ShopMaster 
    INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 
    $businessCatCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
    
    $nodeCondition
    ORDER BY ShopMaster.SurveyDate ASC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $shopListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?>

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-12 col-sm-12">
                <div class="breadcrumb">
                    <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> <a href="#" class="inactiveLink " >  <i class="fi-rs-location-alt"></i> Ward : </a> <?php if($nodeCd != "All"){ if(sizeof($nodeData)>0){ echo $nodeData["Ward_No"]." - ".$nodeData["Area"]; } }else{ echo $nodeCd; } ?> <span></span> <a href="#" class="inactiveLink" > <i class="fi-rs-apps"></i> Categories : </a> <?php if($businessCatCd != "All"){ if(sizeof($businessCatData)>0){ echo $businessCatData["BusinessCatName"]; } }else{ echo $businessCatCd; } ?> <span> Search Shop Result :  <strong class="text-brand"><?php echo $total_count["FilteredShop"]; ?></strong> shops found!</span>
                </div>
            </div>
            <div class="col-lg-5 col-md-4 col-12 col-sm-12 text-right">
                <div class="pagination-area" style="float:right;">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">

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
                                if($pageNo != $loopStart && $loopStop >5 ){ 
                            ?>  
                                <li class="page-item"><a class="page-link" onclick="setShopBusinessCategoriesFilter(<?php echo ($loopStart - 1);  ?>, '<?php echo $businessCatCd; ?>')" ><i class="fi-rs-arrow-small-left"></i></a></li>
                            <?php } ?>

                            <?php
                                for($i=$loopStart;$i<=$loopStop;$i++){ 

                                        $activePageCondition = ""; 
                                        if($pageNo == $i){
                                            $activePageCondition = "active";                                
                                        }
                                    ?>
                                    <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopBusinessCategoriesFilter(<?php echo $i; ?>, '<?php echo $businessCatCd; ?>')" ><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php if($totalRecords > $loopStop){ ?> 
                                <li class="page-item"><a class="page-link"  onclick="setShopBusinessCategoriesFilter(<?php echo ($loopStop + 1);  ?>, '<?php echo $businessCatCd; ?>')" ><i class="fi-rs-arrow-small-right"></i></a></li>
                            <?php }  ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>