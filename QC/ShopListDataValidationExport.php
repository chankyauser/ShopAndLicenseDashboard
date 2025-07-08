<?php
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');
	   include '../api/includes/DbOperation.php';
$valType = $_POST['valType'];
$filename = $valType.'.csv';
//$export_data = unserialize($_POST['export_data']);
ob_start();
session_start();
 $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = date('Y-m-d', strtotime('-7 days'));
        $toDate = $currentDate;
        if(!isset($_SESSION['SAL_FromDate'])){
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }else{
            $fromDate  = $_SESSION['SAL_FromDate'];
        }
		
		
        if(isset($_GET['minDate']) && !empty($_GET['minDate'])){
            $_SESSION['SAL_FromDate'] = $_GET['minDate'];
        }

        if(isset($_GET['maxDate']) && !empty($_GET['maxDate'])){
            $_SESSION['SAL_ToDate'] = $_GET['maxDate'];
        }

        if(!isset($_SESSION['SAL_SHOP_Data_Validation'])){
            $valType = "MobilePending";
            $_SESSION['SAL_SHOP_Data_Validation'] = $valType;
        }else{
            $valType = $_SESSION['SAL_SHOP_Data_Validation'];
        }

 $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
    $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];

    $nodeCd = "All";
    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }
    
    if($nodeCd == 'All'){
        $nodeCondition = "  ";
    }else{
        $nodeCondition = " AND nm.Node_Cd = $nodeCd ";
    }
$joinCondition = "";

        if($valType == 'All'){
            $valTypeCondition = " ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NOT NULL ";
        }else if($valType == 'MobilePending'){
            $valTypeCondition = " AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
			AND (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 ) ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NOT NULL ";
        }
        else if($valType == 'PhotoPending'){
            $valTypeCondition = " AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
								AND ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NOT NULL ";
        }
        else if($valType == 'DocumentPending'){
            $valTypeCondition = " AND sd.Shop_Cd IS NULL AND sm.ShopStatus = 'Pending' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NOT NULL ";
        }
        else if($valType == 'PermanentlyClosed'){
            $valTypeCondition = " AND sm.ShopStatus = 'Permanently Closed' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NULL ";
        }
        else if($valType == 'NonCooperative'){
            $valTypeCondition = " AND sm.ShopStatus = 'Non-Cooperative' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NULL ";
        }
        else if($valType == 'PermissionDenied'){
            $valTypeCondition = " AND sm.ShopStatus = 'Permission Denied' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NULL ";
        }


        if($valType == 'DocumentPending')
        {
            $joinCondition = " LEFT JOIN ShopDocuments AS sd ON (sm.Shop_Cd = sd.Shop_Cd) ";

        }
        else
        {
            $joinCondition = " ";

        }
		 $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
	$queryExport = "SELECT 
            sm.Shop_Cd, ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName,
            ISNULL(nm.NodeName,'') as NodeName,
            ISNULL(nm.Ward_No,0) as Ward_No,
            ISNULL(nm.Area,'') as Area,
            'https://www.google.com/maps/search/?api=1&query='+sm.ShopLatitude+','+sm.ShopLongitude+'' as LocationUrl,
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory,  
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate,
            ISNULL((SELECT Remarks FROM Survey_Entry_Data..User_Master WHERE UserName = sm.AddedBy),'') as AddedByName,
            ISNULL((SELECT Mobile FROM Survey_Entry_Data..User_Master WHERE UserName = sm.AddedBy),'') as AddedMobile,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate,
            ISNULL((SELECT Remarks FROM Survey_Entry_Data..User_Master WHERE UserName = sm.SurveyBy),'') as SurveyByName,
            ISNULL((SELECT Mobile FROM Survey_Entry_Data..User_Master WHERE UserName = sm.SurveyBy),'') as SurveyMobile,
            ISNULL(sm.QC_Flag,0) as QC_Flag,
            ISNULL(sm.ShopStatus,'') as ShopStatus,
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,100),'') as ShopStatusDate,
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark
        FROM ShopMaster sm
        INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
        INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
        INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd)
        $joinCondition
        WHERE sm.IsActive = 1
        $dateConditon
        $valTypeCondition
        $nodeCondition
        ORDER BY sm.SurveyDate ASC;";
		//echo $queryExport;
		$ShopListExportData = $db->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);   
//$serialize_ShopListData = serialize($ShopListExportData);		
//print_r($serialize_ShopListData);
// file creation
$file = fopen($filename,"w");

    $header_array = array("ShopCd", "ShopUID", "ShopName", "ShopKeeperName", 
    "ShopKeeperMobile","PocketName", "NodeName", "Ward_No", "Area", "LocationUrl", "ShopAddress_1", 
    "ShopAddress_2", "ShopOutsideImage1", "ShopOutsideImage2", "ShopInsideImage1", "ShopInsideImage2",
     "Nature_of_Business", "ShopArea_Cd", "ShopAreaName", "ShopCategory", "IsCertificateIssued", 
     "AddedDate", "AddedByName", "AddedByMobile", "SurveyDate", "SurveyByName", "SurveyByMobile", "QC_Flag", 
    "ShopStatus", "ShopStatusDate", "ShopStatusRemark");

fputcsv($file, $header_array);

foreach ($ShopListExportData as $line){
 fputcsv($file,$line);
}

fclose($file);

// download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/csv; "); 

readfile($filename);

// deleting file
unlink($filename);
exit();