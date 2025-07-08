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

    if(!isset($_SESSION['SAL_Node_Name'])){
        $_SESSION['SAL_Node_Name'] = "All";
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = $_SESSION['SAL_Node_Name'];
    }

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }

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
   
    if($nodeName == "All"){
        $nodeNameCondition = "  ";
    }else{
        $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName'  ";   
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
        WHERE Node_Cd = $nodeCd
        $nodeNameCondition
        ";
        $db1=new DbOperation();
        $nodeData = $db1->ExecutveQuerySingleRowSALData($queryNode, $electionName, $developmentMode);
    }else{
        $nodeCondition = " AND PocketMaster.Node_Cd <> 0  ";
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
    // print_r($dataNodeName);

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
            ORDER BY NodeMaster.Area";
    $db=new DbOperation();
    $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
    // print_r($dataNode);

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
        (   
            SELECT
                COUNT(t1.Billing_Cd)
            FROM 
            (
                SELECT
                    sb.Billing_Cd, sb.Shop_Cd, t.TransStatuses
                FROM(
                    SELECT 
                        a.Billing_Cd, a.Shop_Cd, STRING_AGG(tsd.TransStatus,'') as TransStatuses
                    FROM (
                        SELECT 
                            sb.Billing_Cd, sb.Shop_Cd
                        FROM ShopBilling sb
                        INNER JOIN ShopMaster on ( ShopMaster.Shop_Cd = sb.Shop_Cd 
                        AND DATEDIFF(day, CONVERT(VARCHAR,sb.ExpiryDate,23),CONVERT(VARCHAR,GETDATE(),23)) <= 90 
                        AND ShopMaster.IsActive = 1 )
                        INNER JOIN PocketMaster ON ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd
                        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
                        WHERE ShopMaster.IsActive = 1
                        $nodeNameCondition
                        $nodeCondition
                    ) a
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = a.Billing_Cd 
                    GROUP BY a.Billing_Cd, a.Shop_Cd
                ) as t
                INNER JOIN ShopBilling sb on ( sb.Billing_Cd = t.Billing_Cd AND ( t.TransStatuses not like '%done%' OR  t.TransStatuses iS NULL ) )
            ) as t1 

       ),0)  as FilteredShop";
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
            t1.*
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
                t.Billing_Cd,
                ISNULL(( SELECT
                        TOP 1 CONVERT(VARCHAR, sb.BillingDate, 100)
                    FROM ShopBilling sb 
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
                    INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                    LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
                ,'') as BillingDate,
                ISNULL(( SELECT
                        TOP 1 CONVERT(VARCHAR, sb.ExpiryDate, 100)
                    FROM ShopBilling sb 
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
                    INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                    LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
                ,'') as ExpiryDate,
                ISNULL(( SELECT
                        TOP 1 CONVERT(VARCHAR, tsd.TranDateTime, 108)
                    FROM ShopBilling sb 
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
                    INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                    LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                    WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd)
                ,'') as TransactionDate,
                ISNULL(( SELECT
                        TOP 1 sb.TotalBillAmount
                    FROM ShopBilling sb 
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
                    INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                    LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
                ,'') as TotalBillAmount,
                ISNULL(( SELECT
                        TOP 1 tsd.TransType
                    FROM ShopBilling sb 
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
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
                        AND sb.IsLicenseRenewal = pd.IsRenewal AND sb.Billing_Cd = t.Billing_Cd)
                    INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                    LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                    WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd 
                    ORDER BY tsd.TranDateTime DESC)
                ,'') as TransStatus,
            t.TransStatuses
            FROM (
                SELECT 
                    a.Billing_Cd, a.Shop_Cd, STRING_AGG(tsd.TransStatus,'') as TransStatuses
                FROM (
                    SELECT 
                        sb.Billing_Cd, sb.Shop_Cd
                    FROM ShopBilling sb
                    INNER JOIN ShopMaster on ( ShopMaster.Shop_Cd = sb.Shop_Cd 
                        AND DATEDIFF(day, CONVERT(VARCHAR,sb.ExpiryDate,23),CONVERT(VARCHAR,GETDATE(),23)) <= 90 
                        AND ShopMaster.IsActive = 1 )
                    INNER JOIN PocketMaster ON ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd
                    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
                    WHERE ShopMaster.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ) a
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = a.Billing_Cd 
                GROUP BY a.Billing_Cd, a.Shop_Cd
            ) as t
        INNER JOIN ShopBilling sbb on ( sbb.Billing_Cd = t.Billing_Cd AND ( t.TransStatuses not like '%done%' OR  t.TransStatuses iS NULL ) )
        INNER JOIN ShopMaster on ( ShopMaster.Shop_Cd = t.Shop_Cd )
        INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sbb.ScheduleCall_Cd
        INNER JOIN PocketMaster ON ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd
        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
        LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
        LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
        LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
        LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
        LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) 
        WHERE ShopMaster.IsActive = 1 
        
        ) as t1
    ORDER BY ExpiryDate ASC 


    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $shopListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?>

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-12 col-sm-12">
                <div class="breadcrumb">
                    <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> <a href="#" class="inactiveLink " >  <i class="fi-rs-location-alt"></i> Ward : </a> <?php if($nodeName!="All"){ echo $nodeName." - "; } ?>  <?php if($nodeCd != "All"){ if(sizeof($nodeData)>0){ echo $nodeData["Ward_No"]." - ".$nodeData["Area"]; } }else{ echo $nodeCd; } ?> <span></span> <a href="#" class="inactiveLink" > <i class="fi-rs-document"></i> Shop License Defaulters : </a>  <span> Shops :  <strong class="text-brand" style="font-size: 17px;font-weight: bold;"><?php echo $total_count["FilteredShop"]; ?> found!</strong> </span>
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
                                <li class="page-item"><a class="page-link" onclick="setShopLicenseDefaultersFilter(<?php  if($loopStart==1){ echo "1"; }else{ echo ($loopStart - 1); } ?>)" ><i class="fi-rs-arrow-small-left"></i></a></li>
                            <?php } ?>

                            <?php
                                for($i=$loopStart;$i<=$loopStop;$i++){ 

                                        $activePageCondition = ""; 
                                        if($pageNo == $i){
                                            $activePageCondition = "active";                                
                                        }
                                    ?>
                                    <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopLicenseDefaultersFilter(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php if($totalRecords > $loopStop){ ?> 
                                <li class="page-item"><a class="page-link"  onclick="setShopLicenseDefaultersFilter(<?php echo ($loopStop + 1);  ?>)" ><i class="fi-rs-arrow-small-right"></i></a></li>
                            <?php }  ?>

                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>
</div>
