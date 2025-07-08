<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');
    
    $db=new DbOperation();
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

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
        header('Location:../index.php?p=login');
    }

     $userName=$_SESSION['SAL_UserName'];
    
    $updatedByUser = $userName;
   
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
    if(!isset($_SESSION['SAL_View_Type'])){
        $_SESSION['SAL_View_Type'] = "TableView";
        $viewType = $_SESSION['SAL_View_Type'];
    }else{
        $viewType = $_SESSION['SAL_View_Type'];
    }

    $_SESSION['SAL_Document_Status'] = "Verified";
    $documentStatus = $_SESSION['SAL_Document_Status'];
 

    if(!isset($_SESSION['SAL_License_Status'])){
        $_SESSION['SAL_License_Status'] = "All";
        $licenseStatus = $_SESSION['SAL_License_Status'];
    }else{
        $licenseStatus = $_SESSION['SAL_License_Status'];
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


   
    $licenseStatusName = "";
    if($licenseStatus == "All"){
        $documentStatusCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND ShopMaster.ShopStatus = 'Verified' ";
        $doc_InReviewOrRejectedCondition = " WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) ";
        $doc_InReviewOrRejectedColumnValue = " CASE WHEN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) <> 0 THEN 1 ELSE 0 END AS DocFlag,   ";
        
        $licenseStatusCondition = "  ";

        $licenseStatusName = " All ";
    }else {
        $documentStatusCondition = " AND ShopMaster.SurveyDate IS NOT NULL AND ShopMaster.ShopStatus = 'Verified' ";
        $doc_InReviewOrRejectedCondition = " WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) ";
        $doc_InReviewOrRejectedColumnValue = " CASE WHEN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) <> 0 THEN 1 ELSE 0 END AS DocFlag,   ";
        
        $licenseStatusCondition = " AND ShopMaster.ShopApproval = '$licenseStatus' ";   
        $licenseStatusName = $licenseStatus;     
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
        (SELECT Count(t1.Shop_Cd) 

        FROM (
            SELECT Shop_Cd
            FROM ShopMaster 
            INNER JOIN PocketMaster on  ShopMaster.pocket_Cd = PocketMaster.pocket_Cd 
            INNER JOIN NodeMaster on NodeMaster.Node_Cd = PocketMaster.Node_Cd
            WHERE ShopMaster.IsActive = 1 
            $nodeNameCondition
            $nodeCondition
            $documentStatusCondition
            $licenseStatusCondition
            $searchShopCondition
        ) as t1 

        $doc_InReviewOrRejectedCondition

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
            $doc_InReviewOrRejectedColumnValue
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
            ISNULL(CONVERT(VARCHAR, ShopMaster.BillGeneratedDate, 100), '') as BillGeneratedDate
            
    FROM ShopMaster 
    INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 
    $documentStatusCondition
    $licenseStatusCondition
    $searchShopCondition )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
    LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
    LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
    LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) 

    WHERE ShopMaster.IsActive = 1 
    $nodeNameCondition
    $nodeCondition
    
    
    ) as t1
    $doc_InReviewOrRejectedCondition

    ORDER BY t1.AddedDate ASC 


    

    ;";

// OFFSET ($pageNo - 1) * $recordPerPage ROWS 
//     FETCH NEXT $recordPerPage ROWS ONLY

    // echo $query1;
    $shopListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);


    foreach ($shopListDetail as $key => $value) {
        $isLicenseRenewal = $value["IsRenewal"];
        $licenseAmount = $value["ParwanaAmount"];
        $billGeneratedFlag = $value["BillGeneratedFlag"];
        $shopCd = $value['Shop_Cd'];
        
        if($value['ShopApproval']=="Verified" && $billGeneratedFlag == 0){

            
            
            $qcRemark1 = "";
            $qcRemark2 = "";
            $qcRemark3 = "";
        
            if (strpos($qcRemark1, "'")) {
                $qcRemark1 = str_replace("'", "''", $qcRemark1);
            }

            if (strpos($qcRemark2, "'")) {
                $qcRemark2 = str_replace("'", "''", $qcRemark2);
            }

            if (strpos($qcRemark3, "'")) {
                $qcRemark3 = str_replace("'", "''", $qcRemark3);
            }

            $query = "SELECT top (1) sm.Shop_Cd, ISNULL(sm.BusinessCat_Cd,0) as BusinessCat_Cd, bcm.BusinessCatName, ISNULL(sm.ShopArea_Cd,0) as ShopArea_Cd, sam.ShopAreaName, sm.ShopCategory, sm.ShopName, sm.ShopNameMar, sm.ShopKeeperName, sm.ShopKeeperMobile, sm.ShopContactNo_1, sm.ShopContactNo_2, sm.ShopAddress_1, sm.ShopAddress_2, ISNULL(sm.ParwanaDetCd,0) as ParwanaDetCd, sm.ConsumerNumber, sm.ShopOwnStatus, sm.ShopOwnPeriod, sm.ShopDimension, sm.GSTNno, sm.ContactNo3, sm.MaleEmp, sm.FemaleEmp, sm.OtherEmp, sm.ShopOwnerName, sm.ShopOwnerMobile, sm.ShopEmailAddress, sm.ShopOwnerAddress, sm.ShopApproval, sm.ShopApprovalRemark, sm.IsNewCertificateIssued, sm.BillGeneratedFlag FROM ShopMaster sm LEFT JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd LEFT JOIN ShopAreaMaster sam on sam.ShopArea_Cd = sm.ShopArea_Cd WHERE sm.Shop_Cd = $shopCd ;";
            $isShopExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
            if( sizeof($isShopExists) > 0 )
            {

                /*Approve Verified Shop Licenses*/
                
                $dbSD=new DbOperation();

                $dataCallingCategory = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Collection' AND QC_Type = 'ShopLicense' ", $electionName, $developmentMode);
                if(sizeof($dataCallingCategory)>0){


                    $sql2 = "UPDATE ShopMaster
                         SET 

                            ShopApproval = 'Approved',
                            ShopApprovalBy = '$updatedByUser',
                            ShopApprovalDate = GETDATE(),


                            QC_Flag = '6',
                            QC_UpdatedByUser = '$updatedByUser',
                            QC_UpdatedDate = GETDATE()
                         WHERE Shop_Cd = $shopCd;";
                    $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
                    if($updateQC){

                        $updateQCDetail['Flag'] = 'U';

                       


                        $scheduleCategory = $dataCallingCategory["Calling_Category_Cd"];


                        $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,null,GETDATE(),'Approve Shop License',null,1,'$updatedByUser',GETDATE());";
                        $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                            // echo $sqlSDDet;

                        if($insertSDDet){
                            

                            $dataScheduleDetails = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $scheduleCategory AND CallReason = 'Approve Shop License' ", $electionName, $developmentMode);

                            if(sizeof($dataScheduleDetails)>0){
                                $scheduleCallCd = $dataScheduleDetails["ScheduleCall_Cd"];

                                $dbST=new DbOperation();
                                $sqlSTDet = "INSERT INTO ShopTracking(ScheduleCall_Cd,Shop_Cd,Calling_Category_Cd,AssignDate,AssignExec_Cd,AssignTempExec_Cd,ST_StageName,ST_DateTime,ST_Exec_Cd,ST_Status,ST_Remark_1,ST_Remark_2,ST_Remark_3,UpdatedByUser,UpdatedDate) VALUES($scheduleCallCd,$shopCd,$scheduleCategory,GETDATE(),null,null,'Application Approved',GETDATE(),null,1,null,null,null,'$updatedByUser',GETDATE());";
                                $insertSTDet = $dbST->RunQueryData($sqlSTDet, $electionName, $developmentMode);
                            
                                if($insertSTDet){

                                    $dbQC=new DbOperation();

                                    $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,null,null,GETDATE(),'ShopLicense','6',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                    $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                                    $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];


                                    if($isShopExists["ShopApproval"] != "Verified"){
                                        $oldValue = $isShopExists["ShopApproval"];
                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Status',N'ShopApproval',N'$oldValue',N'Approved',null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Status Date',N'ShopApprovalDate','',CONVERT(VARCHAR, GETDATE(),100),null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                    }



                                }
                            

                            }
                        } 

                    }
                           

                }



                /*Generate License Start*/
                $dbSD=new DbOperation();

                $dataCallingCategory = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Collection' AND QC_Type = 'GenerateLicense' ", $electionName, $developmentMode);
                if(sizeof($dataCallingCategory)>0){

                        $scheduleCategory = $dataCallingCategory["Calling_Category_Cd"];


                        $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,null,GETDATE(),'Issuing Shop Act License',null,1,'$updatedByUser',GETDATE());";
                        $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                            // echo $sqlSDDet;

                        if($insertSDDet){
                            

                            $dataScheduleDetails = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $scheduleCategory AND CallReason = 'Issuing Shop Act License' ", $electionName, $developmentMode);

                            if(sizeof($dataScheduleDetails)>0){
                                $scheduleCallCd = $dataScheduleDetails["ScheduleCall_Cd"];

                                $dbST=new DbOperation();
                                $sqlSTDet = "INSERT INTO ShopTracking(ScheduleCall_Cd,Shop_Cd,Calling_Category_Cd,AssignDate,AssignExec_Cd,AssignTempExec_Cd,ST_StageName,ST_DateTime,ST_Exec_Cd,ST_Status,ST_Remark_1,ST_Remark_2,ST_Remark_3,UpdatedByUser,UpdatedDate) VALUES($scheduleCallCd,$shopCd,$scheduleCategory,GETDATE(),null,null,'Licence Issued',GETDATE(),null,1,null,null,null,'$updatedByUser',GETDATE());";
                                $insertSTDet = $dbST->RunQueryData($sqlSTDet, $electionName, $developmentMode);
                            
                                if($insertSTDet){

                                    $nextRenewalDate = date('Y-m-d', strtotime('+365 days'));

                                    $sql2 = "UPDATE ShopMaster
                                         SET 

                                            IsNewCertificateIssued = 1,
                                            BillGeneratedFlag = 1,
                                            BillGeneratedBy = '$updatedByUser',
                                            BillGeneratedDate = GETDATE(),
                                            RenewalDate = '$nextRenewalDate',

                                            QC_Flag = '7',
                                            QC_UpdatedByUser = '$updatedByUser',
                                            QC_UpdatedDate = GETDATE()
                                         WHERE Shop_Cd = $shopCd;";
                                    $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
                                    if($updateQC){

                                        $updateQCDetail['Flag'] = 'U';

                                    }


                                    $dbQC=new DbOperation();

                                    $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,null,null,GETDATE(),'GenerateLicense','7',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                    $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                                    $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                                    if($isShopExists["IsNewCertificateIssued"] != ""){
                                        $oldValue = $isShopExists["IsNewCertificateIssued"];
                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'License Issued',N'IsNewCertificateIssued',N'$oldValue','1',null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                    }

                                    if($isShopExists["BillGeneratedFlag"] != ""){
                                        $oldValue = $isShopExists["BillGeneratedFlag"];
                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Bill Generate',N'BillGeneratedFlag',N'$oldValue','1',null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Bill Generate Date',N'BillGeneratedDate','',CONVERT(VARCHAR, GETDATE(),100),null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                    }



                                }
                            

                            }
                        } 

                }
                /*Generate License End*/



                /*Bill Generation Start*/
                $dbSD=new DbOperation();

                $dataCallingCategory = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Collection' AND QC_Type = 'LicensePayment' ", $electionName, $developmentMode);
                if(sizeof($dataCallingCategory)>0){

                        $scheduleCategory = $dataCallingCategory["Calling_Category_Cd"];

                        $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,null,GETDATE(),'License Bill Generation',null,1,'$updatedByUser',GETDATE());";
                        $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                            // echo $sqlSDDet;

                        if($insertSDDet){
                            
                            $billExpiryDate = date('Y-m-d', strtotime('+90 days'));

                            $dataScheduleDetails = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $scheduleCategory AND CallReason = 'License Bill Generation' ", $electionName, $developmentMode);

                            if(sizeof($dataScheduleDetails)>0){
                                $scheduleCallCd = $dataScheduleDetails["ScheduleCall_Cd"];
                                
                                $dbSB=new DbOperation();
                                $sqlSBDet = "INSERT INTO ShopBilling(Shop_Cd,BillingDate,ExpiryDate,IsLicenseRenewal,BillAmount,IsActive,AddedBy,AddedDate,TotalBillAmount,ScheduleCall_Cd) VALUES ($shopCd,GETDATE(),'$billExpiryDate',$isLicenseRenewal,'$licenseAmount','1','$updatedByUser',GETDATE(),'$licenseAmount',$scheduleCallCd);";
                                $insertSBDet = $dbSB->RunQueryData($sqlSBDet, $electionName, $developmentMode);

                            }
                        } 

                }
                /*Generate License End*/
        ?>
              <!--   <script type="text/javascript">
                    $(document).ready(function () {
                         document.getElementById('selectLicenseId').value = 'Approved';
                    });

                </script> -->
        <?php

            }

        }else if($value['ShopApproval']=="Verified" && $billGeneratedFlag == 1){
                $sql2 = "UPDATE ShopMaster
                     SET 

                        ShopApproval = 'Approved',
                        ShopApprovalBy = '$updatedByUser',
                        ShopApprovalDate = GETDATE(),


                        QC_Flag = '6',
                        QC_UpdatedByUser = '$updatedByUser',
                        QC_UpdatedDate = GETDATE()
                     WHERE Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updateQC){

                }
        }

    }
?>