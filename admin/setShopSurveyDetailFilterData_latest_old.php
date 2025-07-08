<?php

    // if(isset($_GET['pocketCd'])){
    //     $pocketCd = $_GET['pocketCd'];
    //     $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    // }else if(isset($_SESSION['SAL_Pocket_Cd'])){
    //     $pocketCd = $_SESSION['SAL_Pocket_Cd'];
    // }else if(isset($_GET['pocketId'])){
    //     $pocketCd = $_GET['pocketId'];
    //     $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    // }else{
        $pocketCd = "All";
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    // }
     
    if(isset($_GET['executiveCd'])){
        $executiveCd = $_GET['executiveCd'];
        $_SESSION['SAL_Executive_Cd'] = $executiveCd;
    }else if(isset($_SESSION['SAL_Executive_Cd'])){
        $executiveCd = $_SESSION['SAL_Executive_Cd'];
    }else{
        $executiveCd = "All";
    }
    
    // if(isset($_SESSION['SAL_Node_Name'])){
    //     $nodeName = $_SESSION['SAL_Node_Name'];
    //     if(isset($_GET['node_Name'])){
    //         $nodeName = $_GET['node_Name'];
    //         $_SESSION['SAL_Node_Name'] = $nodeName;
    //     }
    // }else {
        $nodeName = "All";
    // }

    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
        if(isset($_GET['nodeId'])){
            $nodeCd = $_GET['nodeId'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }
    }else {
        $nodeCd = "All";
    }

    $shop_Name_Post= "";
    if(isset($_SESSION['SAL_ShopName']) && !empty($_SESSION['SAL_ShopName'])){
        $shop_Name_Post = $_SESSION['SAL_ShopName'];
        $_SESSION['SAL_ShopName'] = "";
    }


    if(isset($_SESSION['SAL_ShopStatus']) && !empty($_SESSION['SAL_ShopStatus'])){
        $shop_Status_Post = $_SESSION['SAL_ShopStatus'];
        $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;
    }else{
        $shop_Status_Post = "Pending";
        $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;  
    }

    if(isset($_SESSION['SAL_SurveyStatus']) && !empty($_SESSION['SAL_SurveyStatus'])){
        $survey_Status_Post = $_SESSION['SAL_SurveyStatus'];
        $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;
    }else{
        $survey_Status_Post = "All";
        $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;  
    }

    $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
    $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];


    $dateCondition  =  " AND CONVERT(VARCHAR, ShopMaster.AddedDate ,120) BETWEEN '$fromDate' AND '$toDate' 
                         AND ( ShopMaster.SurveyDate IS NOT NULL OR
                            ShopMaster.ShopStatus IN (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)
                            )
                            ";

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
        $executiveCondition = "  ";
    }else{
        $executiveCondition = " AND ShopMaster.SRExecutive_Cd = $executiveCd ";
    }

    // if($shop_Status_Post == "All"){
    //     $shopStatusCondition = " AND ( ISNULL(ShopMaster.ShopStatus,'') <> '' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) "; 
    // }else if($shop_Status_Post == "Pending"){
    //     $shopStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) "; 
    // }else if($shop_Status_Post != "Pending" || $shop_Status_Post != "Rejected" || $shop_Status_Post != "Verified" || $shop_Status_Post != "In-Review"){
    //     $shopStatusCondition = " AND ShopMaster.ShopStatus = '$shop_Status_Post'  "; 
    //     $dateCondition  =  " ";
    // }else{  
    //     $shopStatusCondition = " AND  ShopMaster.ShopStatus = '$shop_Status_Post' ";
    // }

    // if($survey_Status_Post == "All"){
    //     $surveyStatusCondition = "  ";
    //     // $dateCondition = " "; 
    // }else if($survey_Status_Post == "Pending"){
    //     $surveyStatusCondition = " AND ShopMaster.SurveyDate IS NULL  "; 
    //     $dateCondition = " ";
    // }else if($survey_Status_Post == "Completed"){
    //     $surveyStatusCondition = " AND ShopMaster.SurveyDate IS NOT NULL  "; 
    //     $dateCondition = " ";
    // }else{
    //     $surveyStatusCondition = " ";
    // }

    if($shop_Status_Post == "All" && $survey_Status_Post == "All"){
        // $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)  "; 
    }else if($shop_Status_Post == "All" && $survey_Status_Post == "Pending"){
        // $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NULL  AND ISNULL(ShopMaster.ShopStatus,'') = '' )       "; 
    }else if($shop_Status_Post == "All" && $survey_Status_Post == "Completed"){
        /////// $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NOT NULL  OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster
                WHERE IsActive = 1) )       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "All"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "Pending"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND (  ShopMaster.SurveyDate IS NULL)       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "Completed"){
        /////// $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND (  ShopMaster.SurveyDate IS NOT NULL)       "; 
    }else if(( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "All"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' ) AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)       "; 
    }else if(( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "Pending"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' ) AND (  ShopMaster.SurveyDate IS NULL)       "; 
    }else if( ( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "Completed"){
        /////// $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post'  ) AND (  ShopMaster.SurveyDate IS NOT NULL)       "; 
    }

    if(!empty($shop_Name_Post)){
        // echo $shop_Name_Post;
        if ($shop_Name_Post == trim($shop_Name_Post) && strpos($shop_Name_Post, ' ') !== false) {
            $strArr = explode(" ", $shop_Name_Post);
            foreach($strArr as $valueShop){
                $searchShopCondition .= " AND ShopMaster.ShopName like '%$valueShop%' ";
            }
        }else{
             $searchShopCondition = " AND ShopMaster.ShopName like '%$shop_Name_Post%' ";
        }

        $dateCondition = " ";
        $nodeCondition = " ";
        $nodeNameCondition = " ";
        $pcktCondition = " ";
        $executiveCondition = " ";
        $shopStatusCondition = " ";
        $surveyStatusCondition = " ";

    }else{
        $searchShopCondition = " ";
        $shopStatusCondition = " ";
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

    $total_count = array();

    $db1=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT
        ISNULL((SELECT Count(*) 
        FROM ShopMaster 
        INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
        INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
        WHERE ShopMaster.IsActive = 1 
        $dateCondition
        $shopStatusCondition
        $surveyStatusCondition
        $pcktCondition  
        $executiveCondition  
        $nodeCondition
        $nodeNameCondition
        ), 0) as SurveyDone";
        // echo $query;
    $total_count = $db1->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode); 
    $totalRecords = $total_count["SurveyDone"];

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $db1->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];


    $db2=new DbOperation();
    $query1 = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1 $dateCondition
    $shopStatusCondition
    $pcktCondition  
    $executiveCondition  
    
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    
    $nodeCondition
    $nodeNameCondition
    AND ISNULL(ShopLatitude,'0')  <> '0'
    ORDER BY ShopMaster.SurveyDate ASC ;";
    // echo $query1;
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    $queryPocketKML = "SELECT COALESCE(pm.Pocket_Cd, 0) as Pocket_Cd,
        COALESCE(pm.PocketName, '') as PocketName,
        COALESCE(pm.KML_FileUrl, '') as KML_FileUrl
        FROM PocketMaster as pm
        INNER JOIN ShopMaster as sm 
        ON pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1
        INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
        WHERE pm.IsActive = 1 AND COALESCE(pm.KML_FileUrl, '') <> ''
        --$nodeCondition
        --$nodeNameCondition
        --AND CONVERT(VARCHAR, sm.SurveyDate ,120) BETWEEN '$fromDate' AND '$toDate' 
        GROUP BY pm.Pocket_Cd, pm.PocketName, pm.KML_FileUrl
        ORDER BY pm.Pocket_Cd DESC;";
    $dataPocketSummary = $db2->ExecutveQueryMultipleRowSALData($queryPocketKML, $electionName, $developmentMode);

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
    INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 $dateCondition
    $shopStatusCondition
    $surveyStatusCondition
    $pcktCondition  
    $executiveCondition 
    $searchShopCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    WHERE ShopMaster.IsActive = 1 
    
    $nodeCondition
    $nodeNameCondition
    ORDER BY ShopMaster.SurveyDate ASC 
    OFFSET ($pageNo - 1) * $recordPerPage ROWS 
    FETCH NEXT $recordPerPage ROWS ONLY;";
    // echo $query1;
    $pocketShopsSurveyListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
    
    $queryExport = "SELECT 
        ISNULL(ShopMaster.ShopName, '') as ShopName,
        ISNULL(PocketMaster.PocketName,'') as PocketName,
        ISNULL(NodeMaster.Ward_No,0) as Ward_No,
        ISNULL(NodeMaster.Area,'') as WardArea,
        ISNULL(NodeMaster.NodeName,'') as NodeName,
        ISNULL(ShopMaster.ShopStatus, '') as ShopStatus, 
        ISNULL(CONVERT(VARCHAR, ShopMaster.ShopStatusDate, 100), '') as ShopStatusDate, 
        'https://www.google.com/maps/search/?api=1&query='+ShopMaster.ShopLatitude+','+ShopMaster.ShopLongitude+'' as LocationUrl, 
        ISNULL(ShopMaster.AddedBy,'') as AddedBy,
        ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
        ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
        ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate
    FROM ShopMaster 
    INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 $dateCondition
    $shopStatusCondition
    $surveyStatusCondition
    $pcktCondition  
    $executiveCondition 
    $searchShopCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    WHERE ShopMaster.IsActive = 1 
    
    $nodeCondition
    $nodeNameCondition
    ORDER BY ShopMaster.SurveyDate ASC";
    $shopsSurveyDetailExport = $db2->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);
?>

