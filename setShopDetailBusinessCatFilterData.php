<?php
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    // include 'api/includes/DbOperation.php';

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }
    
    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $nodeData = array();
    $businessCatData = array();

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    
    if(!isset($_SESSION['SAL_BusinessCat_Cd'])){
        $_SESSION['SAL_BusinessCat_Cd'] = "All";
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
    }else{
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
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
        $businessCatCondition = " AND prm.BusinessCat_Cd = $businessCatCd  ";
        $queryBusinessCat = "SELECT
            ISNULL(BusinessCat_Cd,0) as BusinessCat_Cd,
            ISNULL(BusinessCatName,'') as BusinessCatName,
            ISNULL(BusinessCatNameMar,'') as BusinessCatNameMar
            FROM BusinessCategoryMaster
        WHERE BusinessCat_Cd = $businessCatCd";
        $db1=new DbOperation();
        $businessCatData = $db1->ExecutveQuerySingleRowSALData($queryBusinessCat, $electionName, $developmentMode);
    }else{
        $businessCatCondition = " AND prm.BusinessCat_Cd <> 0 ";
    }

    $searchShopCondition="";
    if(!empty($shopName)){
        // echo $shopName;
        if ($shopName == trim($shopName) && strpos($shopName, ' ') !== false) {
            $strArr = explode(" ", $shopName);
            foreach($strArr as $valueShop){
                $searchShopCondition .= " AND ShopMaster.ShopName like '%$valueShop%' ";
            }
        }else{
             $searchShopCondition = " AND ShopMaster.ShopName like '%$shopName%' ";
        }

    }

     if($businessCatCd != "All"){
        $queryParwanaShopCount = "SELECT 
            prm.Parwana_Cd, prm.Parwana_Name_Eng, prm.Parwana_Name_Mar, bcm.BusinessCatImage,
            ISNULL((
                SELECT
                    COUNT(DISTINCT(ShopMaster.Shop_Cd))
                FROM ShopMaster 
                INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 
                
                $searchShopCondition
                )
                INNER JOIN ParwanaDetails ON ParwanaDetails.ParwanaDetCd = ShopMaster.ParwanaDetCd AND ParwanaDetails.Parwana_Cd = prm.Parwana_Cd
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
                WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
                $nodeCondition
            ),0) as ParwanaCatShopCount
        FROM ParwanaMaster prm
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = prm.BusinessCat_Cd
        WHERE prm.BusinessCat_Cd = $businessCatCd
        $businessCatCondition";
        $db2=new DbOperation();
        $shopParwanaDetail = $db2->ExecutveQueryMultipleRowSALData($queryParwanaShopCount, $electionName, $developmentMode);
        // echo $queryParwanaShopCount;
        // if(sizeof($shopParwanaDetail)>0){
        //     $_SESSION['SAL_Parwana_Cd'] = $shopParwanaDetail[0]["Parwana_Cd"];
        //     $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
        // }else{
        //     $_SESSION['SAL_Parwana_Cd'] = "All";
        //     $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
        // }
    }else{
        $shopParwanaDetail = array();
    }

     if(!isset($_SESSION['SAL_Parwana_Cd'])){
        $_SESSION['SAL_Parwana_Cd'] = "All";
        $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
    }else{
        $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
    }

    

    if($businessCatCd != "All" && $parwanaCd != "All"){
        $parwanaCondition = " AND prm.BusinessCat_Cd = $businessCatCd AND prm.Parwana_Cd = $parwanaCd ";
    }else{
        $parwanaCondition = "  ";
    }
 

    $totalRecords = 0;
    $maxPageNo = 0;

    if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){
        $recordPerPage = 15;
    }else{
        $recordPerPage = 20;
    }

    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo']=1;
    }else{
        $pageNo = 1;  
    }

    
    $db1=new DbOperation();
    $queryBusinessCatTotal = "SELECT
        ISNULL((SELECT Count(*) 
        FROM ShopMaster 
        INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
        INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
        LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
        LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) 
        WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
        $nodeCondition
        $businessCatCondition
        $searchShopCondition
        ), 0) as FilteredBusinessCatShop";
        // echo $query;
    $BusinessCatTotalCount = $db1->ExecutveQuerySingleRowSALData($queryBusinessCatTotal, $electionName, $developmentMode); 
   
    $total_count = array();
    $query = "SELECT
        ISNULL((SELECT Count(*) 
        FROM ShopMaster 
        INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
        INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
        LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
        LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) 
        WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
        $nodeCondition
        $businessCatCondition
        $searchShopCondition
        $parwanaCondition
        ), 0) as FilteredShop";
        // echo $query;
    $total_count = $db1->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode); 
    $totalRecords = $total_count["FilteredShop"];

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) / $recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $db1->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];

    $db2=new DbOperation();
    $query1 = "
        SELECT
            t1.*,
            CASE WHEN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) <> 0 THEN 1 ELSE 0 END AS DocFlag
        FROM ( 
            SELECT 
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
            ISNULL(pd.PDFullEng,'') as PDFullEng,
            ISNULL(pd.IsRenewal,'') as IsRenewal,
            ISNULL(pd.Amount,'') as ParwanaAmount,
            
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
            ISNULL(bcm.BusinessCatImage, '') as BusinessCatImage,

            ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
            ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,

            ISNULL(ShopMaster.AddedBy,'') as AddedBy,
            ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
            ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
            ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate,

            ISNULL(ShopMaster.ShopApproval, '') as ShopApproval, 
            ISNULL(ShopMaster.ShopApprovalBy, '') as ShopApprovalBy, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.ShopApprovalDate, 100), '') as ShopApprovalDate, 
            ISNULL(ShopMaster.ShopApprovalRemark, '') as ShopApprovalRemark,

            ISNULL(ShopMaster.IsNewCertificateIssued, 0) as IsNewCertificateIssued,  
            ISNULL(ShopMaster.BillGeneratedFlag, 0) as BillGeneratedFlag,  
            ISNULL(ShopMaster.BillGeneratedBy, '') as BillGeneratedBy,  
            ISNULL(CONVERT(VARCHAR, ShopMaster.BillGeneratedDate, 100), '') as BillGeneratedDate,
            ISNULL(( SELECT
                    TOP 1 sb.Billing_Cd
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,0) as Billing_Cd,
            ISNULL(( SELECT
                    TOP 1 CONVERT(VARCHAR, sb.BillingDate, 100)
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as BillingDate,
            ISNULL(( SELECT
                    TOP 1 CONVERT(VARCHAR, sb.ExpiryDate, 100)
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as ExpiryDate,
            ISNULL(( SELECT
                    TOP 1 CONVERT(VARCHAR, tsd.TranDateTime, 108)
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd)
            ,'') as TransactionDate,
            ISNULL(( SELECT
                    TOP 1 sb.TotalBillAmount
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as TotalBillAmount,
            ISNULL(( SELECT
                    TOP 1 tsd.TransType
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd 
                ORDER BY tsd.TranDateTime DESC)
            ,'') as TransType,
            ISNULL(( SELECT
                    TOP 1 tsd.TransStatus
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd 
                ORDER BY tsd.TranDateTime DESC)
            ,'') as TransStatus
            
    FROM ShopMaster 
    INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 
    
    $searchShopCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) 
    WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
    $nodeCondition
    $parwanaCondition
    $businessCatCondition
    ) as t1
    ORDER BY t1.AddedDate ASC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $shopListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?>

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="row">

            <input type="hidden" name="nodeName" value="<?php echo "All"; ?>">
            <input type="hidden" name="documentStatus" value="<?php echo "Verified"; ?>">
            <input type="hidden" name="licenseStatus" value="<?php echo "All"; ?>">
            <input type="hidden" name="transactionStatus" value="<?php echo "All"; ?>">
            <input type="hidden" name="pageNo" value="<?php echo $pageNo; ?>">
            <input type="hidden" name="viewType" value="<?php echo $_SESSION['SAL_View_Type']; ?>">
            <input type="hidden" name="pageName" value="<?php if(isset($_GET['p'])){ echo $_GET['p']; } ?>" />
            
            
            <div class="col-lg-6 col-md-5 col-12 col-sm-12">
                <div class="breadcrumb">
                    <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> <a href="#" class="inactiveLink " >  <i class="fi-rs-location-alt"></i> Ward : </a> <?php if($nodeCd != "All"){ if(sizeof($nodeData)>0){ echo $nodeData["Ward_No"]." - ".$nodeData["Area"]; } }else{ echo $nodeCd; } ?> <span></span> <a href="#" class="inactiveLink" > <i class="fi-rs-apps"></i> Categories : </a> <?php if($businessCatCd != "All"){ if(sizeof($businessCatData)>0){ echo $businessCatData["BusinessCatName"]; } }else{ echo $businessCatCd; } ?> <span> Shop Search Result :  <strong class="text-brand" style="font-size: 17px;font-weight: bold;"><?php echo $total_count["FilteredShop"]; ?> shops found!</strong> </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-12 col-sm-12 text-right">
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
                                <li class="page-item"><a class="page-link" onclick="setShopBusinessCategoriesFilter(<?php  if($loopStart==1){ echo "1"; }else{ echo ($loopStart - 1); } ?>, '<?php echo $businessCatCd; ?>')" ><i class="fi-rs-arrow-small-left"></i></a></li>
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
            <div class="col-lg-2 col-md-2 col-12 col-sm-12">
                <ul class="page-view-area" style="float:right;">
                    <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){ ?> active <?php }?>" onclick="setShopBusinessCategoriesView(<?php echo $pageNo; ?>,'ListView', '<?php echo $businessCatCd; ?>')"><i class="fa-solid fa-list"></i></li>
                    <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "GridView"){ ?> active <?php }?>" onclick="setShopBusinessCategoriesView(<?php echo $pageNo; ?>,'GridView', '<?php echo $businessCatCd; ?>')"><i class="fi-rs-grid"></i></li>
                    <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "TableView"){ ?> active <?php }?>" onclick="setShopBusinessCategoriesView(<?php echo $pageNo; ?>,'TableView', '<?php echo $businessCatCd; ?>')"><i class="fa-solid fa-table-list"></i></li>
                </ul>
            </div>
        </div>
    </div>
</div>
