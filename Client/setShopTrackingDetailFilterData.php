<style type="text/css">
     embed.docimg1{
        transition: 0.4s ease;
        transform-origin: 10% 30%;
        width: 100%;
    }
    embed.docimg1:hover{
        z-index: 9999999990909090990909;
        transform: scale(4.2); 
    }
        
    .card {
        box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,0.03), 0 0.9375rem 1.40625rem rgba(4,9,20,0.03), 0 0.25rem 0.53125rem rgba(4,9,20,0.05), 0 0.125rem 0.1875rem rgba(4,9,20,0.03);
        border-width: 0;
        transition: all .2s;
    }
    
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(26,54,126,0.125);
        border-radius: .25rem;
    }
    
    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem;
    } 
    .vertical-timeline {
        width: 100%;
        position: relative;
        padding: 1.5rem 0 1rem;
    }
    
    .vertical-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 65px;
        height: 100%;
        width: 4px;
        /* background: #e9ecef; */
        background: #FFF;
        border-radius: .25rem;
    }
    
    .vertical-timeline-element {
        position: relative;
        margin: 0 0 2rem;
    }
    
    .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
        visibility: visible;
        animation: cd-bounce-1 .8s;
    }
    .vertical-timeline-element-icon {
        position: absolute;
        /* top: 10px; */
        /* left: 45px; */
        font-size: 1rem;
        background: green;
        border-radius: 5px;
        padding: 6px 10px;
        color: #FFFFFF;
    }
    
    .vertical-timeline-element-icon .badge-dot-xl {
        box-shadow: 0 0 0 5px #fff;
    }
    
    .badge-dot-xl {
        width: 18px;
        height: 18px;
        position: relative;
    }
    .badge:empty {
        display: none;
    }
    
    
    .badge-dot-xl::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: .25rem;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -5px 0 0 -5px;
        background: #fff;
    }
    
    .vertical-timeline-element-content {
        position: relative;
        margin-left: 90px;
        font-size: .8rem;
    }
    
    .vertical-timeline-element-content .timeline-title {
        font-size: 1.2rem;
/*        margin: 0 0 .5rem;*/
/*        padding: 2px 0 0;*/
        font-weight: bold;
        line-height: 1rem;
    }
    .vertical-timeline-element-content .vertical-timeline-element-date {
        display: block;
        position: absolute;
        left: -110px;
        top: 45px;
        line-height: 1.2rem;
        padding-right: 10px;
        text-align: center;
        color: #C90D41;
        font-size: .8rem;
        white-space: nowrap;
    }
    
    .vertical-timeline-element-content:after {
        content: "";
        display: table;
        clear: both;
    }
    .th{
        font-size:16px;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #AA8;
        border-radius: 3px;
        width: 10pc;
        height: 34px;
        padding: 5px;
        background-color: transparent;
        margin-left: 3px;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        padding: 4px;
        width: 56px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        color: #F01954!important;
        border: 1px solid transparent;
        border-radius: 2px;
    }
    </style>



<?php 
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    $db2=new DbOperation();
    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    $shopDetail = array();
    
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

    
    if(isset($_SESSION['SAL_ST_Shop_Cd']) && !empty($_SESSION['SAL_ST_Shop_Cd'])){
       $shopCd = $_SESSION['SAL_ST_Shop_Cd'];
    }else{
        $db1=new DbOperation();
        if(empty($shopCd)){
            $shopData = $db1->ExecutveQuerySingleRowSALData("SELECT TOP 1 Shop_Cd FROM ShopMaster INNER JOIN PocketMaster on ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd WHERE ShopMaster.IsActive = 1 $nodeCondition $businessCatCondition ", $electionName, $developmentMode);
            $shopCd = $shopData["Shop_Cd"];
        }else{
            $shopCd = 0;
        }
    }

   $searchShopCondition="";
   if(isset($_SESSION['SAL_Shop_Name']) && !empty($_SESSION['SAL_Shop_Name'])){
        $shopName = $_SESSION['SAL_Shop_Name'];
   }else{
        $shopName = ""; 
   }
   
   // echo $shopName;
        
    if(!empty($shopName)){
        
        if ($shopName == trim($shopName) && strpos($shopName, ' ') !== false) {
            $strArr = explode(" ", $shopName);
            foreach($strArr as $valueShop){
                $searchShopCondition .= " AND ( ShopMaster.ShopName like '%$valueShop%'  OR ShopMaster.Shop_UID like '%$valueShop%') ";
            }
        }else{
             $searchShopCondition .= " AND ( ShopMaster.ShopName like '%$shopName%' OR ShopMaster.Shop_UID like '%$shopName%') ";
        }

        if(isset($_SESSION['SAL_ST_Shop_Cd']) && !empty($_SESSION['SAL_ST_Shop_Cd'])){
            $searchShopCondition .= " AND ShopMaster.Shop_Cd = $shopCd  ";
        }
    }else{
        $searchShopCondition = " AND ShopMaster.Shop_Cd = $shopCd  ";
    }

    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $db=new DbOperation();
        $userData = $db->ExecutveQuerySingleRowSALData("SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
        if(sizeof($userData)>0){
            $_SESSION['SAL_UserName'] = $userData["UserName"];
        }
    }else{
        session_unset();
        session_destroy();
        header('Location:index.php?p=login');
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


    $total_count = array();
    $db1=new DbOperation();
    $query = "SELECT
        ISNULL((SELECT Count(*) 
        FROM ShopMaster 
        INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
        INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
        WHERE ShopMaster.IsActive = 1
        $searchShopCondition
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
    $businessCatCondition
    $searchShopCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    WHERE ShopMaster.IsActive = 1
    
    $nodeCondition
    ) as t1
    ORDER BY t1.AddedDate ASC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";

        // echo $query1;
        
       if(!empty($shopName)){
            $shopDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
       }else{
            $shopDetail = $db2->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
       } 
        
        
        // print_r($shopDetail);

        if( sizeof($shopDetail) > 0 && empty($shopName) ){

            $query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                    ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                    ISNULL(sd.Document_Cd,0) as Document_Cd,
                    ISNULL(sd.FileURL,'') as FileURL,
                    ISNULL(sd.IsVerified,0) as IsVerified,
                    ISNULL(sd.QC_Flag,0) as QC_Flag,
                    ISNULL(sd.IsActive,0) as IsActive,
                    ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                    ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                    ISNULL(sdm.DocumentName,'') as DocumentName,
                    ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                    ISNULL(sdm.DocumentType,'') as DocumentType,
                    ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
                FROM ShopDocuments sd
                INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
                LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
                WHERE sd.Shop_Cd = $shopCd AND sd.IsActive = 1 AND ISNULL(sd.QC_Flag,0) <> 0;";

            $shopDocumentsList = $db2->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

            $queryTrac = "SELECT Calling_Category,Calling_Type, Fa_Icon, ScheduleReason, ScheduleRemark, 
            CONVERT(varchar, ScheduleDate, 103) as Schedule_Date, ISNULL(CONVERT(varchar, AssignDate, 103),'') as AssignDate,
            ST_Cd, CONVERT(varchar, ST_DateTime, 103) as ST_Date, ST_StageName,
            ISNULL(CONVERT(VARCHAR(10), CAST(CONVERT(VARCHAR,ST_DateTime,121) AS TIME), 0),'') as ST_Time,
            ST_Status, ST_Remark_1, Call_Response_Cd, Call_DateTime, AudioFile_Url, GoodCall
                FROM View_ScheduleDetails vsd
                WHERE vsd.Shop_Cd = $shopCd;";

            $TracData = $db2->ExecutveQueryMultipleRowSALData($queryTrac, $electionName, $developmentMode);
        }

       

?>

<div class="page-content pt-10">
    <div class="container">
 
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <h4 class="mt-10 mb-10">Shop Tracking</h4>
                    </div>
                    <div class="col-lg-5 mx-auto">
                        <div class="sidebar-widget-2 widget_search mb-10">
                            <div class="search-form">
                                <!-- <form> -->
                                    <input type="text" name="shopUID" placeholder="Search Shop by Name OR UID "  onkeydown = "if (event.keyCode == 13) document.getElementById('submitSearchBtnId').click()" value="" />
                                    <button id="submitSearchBtnId" type="button" onclick="setSearchShopTracking(<?php echo $pageNo; ?>)"><i class="fi-rs-search"></i></button>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    if(sizeof($shopDetail)>0 && empty($shopName) ){
                ?>
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-8 col-lg-8">
                                <div class="row">
                                    <div class="col-xl-11">
                                        <div class="product-detail accordion-detail">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                    <div class="detail-gallery">
                                                        <div class="product-image-slider">
                                                            <?php if(!empty($shopDetail["ShopOutsideImage1"])){ ?>
                                                                <figure class="border-radius-10">
                                                                    <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage1"]; ?>" alt="Shop Image" height="250" width="100%"   />
                                                                </figure>
                                                            <?php }else if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                                                                <figure class="border-radius-10">
                                                                    <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image" height="250" width="100%" />
                                                                </figure>
                                                            <?php } ?>

                                                                

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-12 col-xs-12">
                                                    <div class="detail-info pr-0 pl-0">
                                                        <h4 class="title-detail mb-5"><?php echo $shopDetail["ShopName"]; ?></h4>
                                                        <span class="stock-status out-stock"> <?php echo $shopDetail["BusinessCatName"]; ?> </span>
                                                        <span class="stock-status out-stock"> <?php echo $shopDetail["ShopAreaName"]; ?> </span>
                                                        <h5 class="title-detail mt-5"><?php echo $shopDetail["ShopKeeperName"]." - ".$shopDetail["ShopKeeperMobile"]; ?></h5>
                                                        <h6 class="title-detail"><?php echo wordwrap($shopDetail["ShopAddress_1"],90,"<br>\n"); ?></h6>

                                                        <?php 
                                                            $getShopOwnStatus = $shopDetail["ShopOwnStatus"];
                                                            $getShopOwnPeriod = $shopDetail["ShopOwnPeriod"];
                                                            
                                                            if($getShopOwnPeriod == 0){
                                                                $getShopOwnPeriodYrs = 0;
                                                                $getShopOwnPeriodMonths = 0;
                                                                $shopOwnPeriod = "";
                                                            }else if($getShopOwnPeriod < 12){
                                                                $getShopOwnPeriodYrs = 0;
                                                                $getShopOwnPeriodMonths = $getShopOwnPeriod;
                                                                $shopOwnPeriod = "".$getShopOwnPeriodMonths." months";
                                                            }else if($getShopOwnPeriod == 12){
                                                                $getShopOwnPeriodYrs = 1;
                                                                $getShopOwnPeriodMonths = 0;
                                                                $shopOwnPeriod = "".$getShopOwnPeriodYrs." year";
                                                            }else if($getShopOwnPeriod > 12){
                                                                $yrMonthVal = $getShopOwnPeriod / 12;
                                                                $yrMonthValArr = explode(".", $yrMonthVal);
                                                                $getShopOwnPeriodYrs = $yrMonthValArr[0];
                                                                $getShopOwnPeriodMonths = ( $getShopOwnPeriod - ($yrMonthValArr[0] * 12) );
                                                                if($getShopOwnPeriodMonths!=0){
                                                                    $shopOwnPeriod = "".$getShopOwnPeriodYrs." years ".$getShopOwnPeriodMonths." months";  
                                                                }else{
                                                                    $shopOwnPeriod = "".$getShopOwnPeriodYrs." years ";
                                                                }
                                                                
                                                            }

                                                        ?>
                                                        <div class="font-xs" style="margin-top:5px;">
                                                            <ul class="mr-50 float-start">
                                                                <!-- <li>UID : <span class="text-brand"> <?php echo $shopDetail["Shop_UID"]; ?></span></li>
                                                                <li>Pocket : <span class="text-brand"> <?php echo $shopDetail["PocketName"]; ?> </span></li>
                                                                <li>Executive : <span class="text-brand"> <?php echo $shopDetail["SurveyExecutive"]; ?></span></li> -->
                                                                <li>Own Status : <span class="text-brand"> <?php echo $shopDetail["ShopOwnStatus"]." since ".$shopOwnPeriod; ?> </span></li>
                                                            <!-- </ul>
                                                            <ul class="float-start"> -->
                                                                <li>Dimension : <a href="#" class="inactiveLink"> <?php echo $shopDetail["ShopDimension"]." sq. ft."; ?></a></li>
                                                                <li>Ward : <a href="#" class="inactiveLink"> <?php echo $shopDetail["Ward_No"]." ".$shopDetail["WardArea"]; ?></a></li>
                                                                <!-- <li class="mb-2">Survey : <a href="#" class="inactiveLink"> <?php echo $shopDetail["SurveyDate"]; ?></a></li> -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Detail Info -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1">

                                    </div>
                                    <div class="col-xl-12 sidebar-widget widget_instagram mb-10">
                                        <h5 class="section-title style-1 mb-10">Documents</h5>
                                        <div class="instagram-gellay">
                                            <ul class="insta-feed">
                                                <?php 
                                                    $imgDimension="150";
                                                    foreach ($shopDocumentsList as $key => $valueDoc) {
                                                        if($valueDoc["DocumentType"]=="image" || $valueDoc["DocumentType"]=="pdf"){
                                                ?> 
                                                        <li>
                                                            <embed <?php if($valueDoc["DocumentType"]=='image'){ ?> <?php }else if($valueDoc["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?> class="rounded docimg1"   title="<?php echo $valueDoc["DocumentName"]; ?>" src="<?php echo $valueDoc["FileURL"]; ?>" height="<?php echo $imgDimension; ?>"></embed>
                                                        </li>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-4 mt-0">
                                <ul>
                                    <div class="card-body">
                                        <?php if(sizeof($TracData) > 0){?>
                                        <h5 class="card-title section-title style-1 mb-10">Shop Tracking Details</h5>
                                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                            
                                            <?php 
                                                $srNo = 0;
                                                foreach($TracData as $key => $val){ 
                                                    // $srNo++; 
                                            ?>
                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in <?php if($val["ST_Status"]== 1){ ?> bg-success <?php }else if($val["ST_Cd"] != 0 && $val["ST_Status"]== 0 && !empty($val["AssignDate"])){ ?> bg-warning <?php }else{ ?> bg-danger <?php } ?> ">
                                                               <i class="<?php echo $val["Fa_Icon"]; ?>"></i>
                                                            </span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h5>
                                                                    <?php echo $val['Calling_Category']; ?>
                                                                </h5>
                                                                <p><?php echo $val['ScheduleReason']; ?></p>
                                                                <span><?php echo $val['ScheduleRemark'];?></span>
                                                                <p><?php if($val["ST_Status"]== 1){ echo $val['ST_StageName']; } ?></p> 
                                                                <span class="title-detail"><?php echo $val['ST_Remark_1'];?></span>
                                                                <span class="vertical-timeline-element-date">
                                                                    <?php if($val["ST_Status"]== 1){ echo $val['ST_Date']; }else{ echo $val['Schedule_Date']; } ?> 
                                                                    <br>
                                                                    <?php if($val["ST_Status"]== 1){ echo $val['ST_Time'];  }else{  } ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php } 
                                            }?>
                                        </div>
                                    </div>
                                </ul>
                           
                            </div>


                        </div>
                    </div>
                </div>
            <?php 
                }
            ?>

           
    </div>
</div>

<?php
    unset($_SESSION['SAL_ST_Shop_Cd']);
?>