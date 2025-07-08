<?php
    
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
        $nCondition = "  ";
    }else{
        $nodeCondition = " AND nm.Node_Cd = $nodeCd ";
        $nCondition = " AND NodeMaster.Node_Cd = $nodeCd ";
    }

    // $searchShopCondition = "";
    // if(!empty($shop_Name_Post)){
    //     if ($shop_Name_Post == trim($shop_Name_Post) && strpos($shop_Name_Post, ' ') !== false) {
    //         $strArr = explode(" ", $shop_Name_Post);
    //         foreach($strArr as $value){
                
    //            $searchShopCondition .= " and sm.ShopName like '%$value%' ";
    //         }

    //     }else{
    //          $searchShopCondition = " and sm.ShopName like '%$shop_Name_Post%' ";
    //     }

    
    // }
    
    $totalRecords = 0;
    $maxPageNo = 0;
    $recordPerPage = 15;
    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo'] = "";
    }else{
        $pageNo = 1;  
    }
    

    $ShopListData = array();

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
        // else if($valType == 'DocumentPending'){
        //     $valTypeCondition = " AND sd.Shop_Cd IS NULL AND sm.ShopStatus = 'Pending' ";
        //     $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' AND sm.SurveyDate IS NOT NULL ";
        // }
        else if($valType == 'PermanentlyClosed'){
            $valTypeCondition = " AND sm.ShopStatus = 'Permanently Closed' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ";
        }
        else if($valType == 'NonCooperative'){
            $valTypeCondition = " AND sm.ShopStatus = 'Non-Cooperative' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ";
        }
        else if($valType == 'PermissionDenied'){
            $valTypeCondition = " AND sm.ShopStatus = 'Permission Denied' ";
            $dateConditon = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ";
        }


        if($valType == 'DocumentPending')
        {
            //$joinCondition = " LEFT JOIN ShopDocuments AS sd ON (sm.Shop_Cd = sd.Shop_Cd) ";
            $valTypeCondition = " ";
            $dateConditon = " AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ";
            $dTConditon = " AND CONVERT(varchar,ShopMaster.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ";

            $joinCondition = "  LEFT JOIN ShopDocuments AS sd ON sd.Shop_Cd = sm.Shop_Cd
            WHERE sm.IsActive=1 AND sm.SurveyDate IS NOT NULL AND sd.Shop_Cd IS NULL";

        }
        else
        {
            $joinCondition = " WHERE sm.IsActive = 1 ";

        }


        if($valType == 'DocumentPending')
        {
            $queryTotal = "SELECT 
            SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as TotalShopForQC
            
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
                    WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL 
                    $dTConditon
                    $valTypeCondition
                    $nCondition
                    --AND CONVERT(varchar,ShopMaster.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
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

        }
        else
        {
            $queryTotal = "SELECT COUNT(sm.Shop_Cd) as TotalShopForQC
            FROM ShopMaster sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd)
            $joinCondition
            $dateConditon
            $valTypeCondition
            $nodeCondition
            ";
        }
        
        $ShopTotalData = $db->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalData["TotalShopForQC"];

        $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShopForQC";
        // echo $totalDivideIntoPageQuery;
        $ShopTotalCountData = $db->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalCountData["TotalShopForQC"];

        $query = "SELECT 
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
        $dateConditon
        $valTypeCondition
        $nodeCondition
        ORDER BY sm.SurveyDate ASC 
        OFFSET ($pageNo - 1) * $recordPerPage ROWS 
        FETCH NEXT $recordPerPage ROWS ONLY;";

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
        $dateConditon
        $valTypeCondition
        $nodeCondition
        ORDER BY sm.SurveyDate ASC;";

    $executiveCd = 0;
    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
        if(sizeof($exeData)>0){
            $executiveCd = $exeData["Executive_Cd"];
        }
    }

    if($executiveCd==669){
        // echo $query;
        // echo "<br>";
        // echo "<br>";
        // echo $queryTotal;
    }
    
    
    if(!empty($query)){
        $db=new DbOperation();
      
        if($executiveCd==669){
            $ShopListData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);    
            $ShopListExportData = $db->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);    
            
        }else{

            $ShopListData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);    
            $ShopListExportData = $db->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);    
            
        }
    }
    
    // print_r($ShopListData);
    // print_r($ShopTotalData);

        
?>

<style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;}

    img.galleryimg:hover{
        transform: scale(2.2);
        z-index: 9999;
    }
  /*  table.dataTable th{
        display: none;
    }*/
    h4,h5{
        color: #C90D41;
        font-weight: 900;
    }
</style>
<?php if(sizeof($ShopListData)>0){ ?>
            <div class="col-xl-4 col-md-4 col-xs-12" style="margin-top: 5px;">
                <h4>Validation List - <?php if($valType=="MobilePending"){ echo "Mobile Pending"; }else if($valType=="PhotoPending"){ echo "Photo Pending"; }else if($valType=="PermanentlyClosed"){ echo "Permanently Closed"; }else if($valType=="NonCooperative"){ echo "Non Cooperative"; }else if($valType=="PermissionDenied"){ echo "Permission Denied"; } 
                ?> (<?php if( sizeof($ShopTotalData)>0){ echo $ShopTotalData["TotalShopForQC"]; }else{ echo "0"; } ?>)</h4>
            </div>
            <div class="col-xl-5 col-md-5 col-xs-12">
                <?php //if($qcType=="ShopList"){ ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
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
                                <li class="page-item prev"><a class="page-link" onclick="setPaginationPageNoInSession(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                            <?php } ?>

                            <?php
                                for($i=$loopStart;$i<=$loopStop;$i++){ 

                                        $activePageCondition = ""; 
                                        if($pageNo == $i){
                                            $activePageCondition = "active";                                
                                        }
                                    ?>
                                    <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setPaginationPageNoInSession(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php if($totalRecords > $loopStop){ ?>  
                                <li class="page-item next"><a class="page-link"  onclick="setPaginationPageNoInSession(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                            <?php }  ?>
                        </ul>
                    </nav>
                <?php //} ?>
            </div>
            <div class="col-xl-3 col-md-3 col-xs-12 text-right">
                <form method='post' action='ShopListDataValidationExport.php'>
                    <input type='submit' value='Export' name='Export' class="btn btn-success">
                      <?php 
                        $serialize_ShopListData = serialize($ShopListExportData);
                       ?>
                    <input type='hidden' value='<?php echo $valType; ?>' name='valType'>
                    <textarea name='export_data' style='display: none;'><?php echo $serialize_ShopListData; ?></textarea>
                </form>
            </div>
                <?php
                    $srNo = 0;
                    if($pageNo!=1){
                        $srNo = (($pageNo * $recordPerPage) - ($recordPerPage));
                    }
                    //foreach($ShopListData as $shopData){
                        
                ?>
            <div class="col-xl-12 col-md-12 col-xs-12">
            <div class="card">
                
                <!-- <div class="row">
                    <div class="col-xl-11 col-md-11 col-xs-11">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Validation List 
                            </h4>
                        </div>
                    </div>
                </div> -->
                <div class="card-content">
                    <div class="card-body">

                            <div class="table-responsive">
                            <table class="table table-hover-animation table-striped table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th style="font-weight:bold;font-size:15px;color:#c90d41;">Sr No</th> -->
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Shop Name</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Node Name</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Ward No.</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Area</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Listing Date</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Listing Executive</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Survey Date</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Survey Executive</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Status Date</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Shop Status</th>
                                        <th style="font-weight:bold;font-size:15px;color:#c90d41;">Action</th>
                                        
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $srNo = 0;
                                        
                                        foreach ($ShopListData as $key => $value) {
                                            $srNo = $srNo+1;
                                        ?> 
                                            <tr>
                                                <!-- <td ><?php echo $srNo; ?></td> -->
                                                <td ><?php echo $value['ShopName']; ?></td>
                                                <td ><?php echo $value['NodeName']; ?></td>
                                                <td ><?php echo $value['Ward_No']; ?></td>
                                                <td ><?php echo $value['Area']; ?></td>
                                                <td ><?php echo $value['AddedDate']; ?></td>
                                                <td ><?php echo $value['AddedByName']; ?></td>
                                                <td ><?php echo $value['SurveyDate']; ?></td>
                                                <td ><?php echo $value['SurveyByName']; ?></td>
                                                <td ><?php echo $value['ShopStatusDate']; ?></td>
                                                <td ><?php if(!empty($value['ShopStatus'])){ if($value['ShopStatus'] == "Verified"){ ?> <span class="badge badge-success"><?php echo $value['ShopStatus']; ?></span><?php }else{ ?> <span class="badge badge-danger"> <?php echo $value['ShopStatus']; ?></span> <?php } } ?></td>
                                                <td >
                                                    <a href="<?php echo $value["LocationUrl"]; ?>" target="_blank"><i title="View Location" class="feather icon-navigation mr-25"></i></a>
                                                    &nbsp;&nbsp;
                                                    <?php 
                                                        if($valType == 'MobilePending' || $valType == 'PhotoPending' || $valType == 'DocumentPending' || $valType == 'PermanentlyClosed' || $valType == 'NonCooperative' || $valType == 'PermissionDenied'   ){
                                                    ?>
                                                        <a href="home.php?p=shop-qc-list&qcType=ShopList&qcFilter=All&minDate=<?php echo date('Y-m-d',strtotime($value['AddedDate'])); ?>&maxDate=<?php echo date('Y-m-d',strtotime($value['AddedDate'])); ?>&shopId=<?php echo $value['Shop_Cd']; ?>" target="_blank"><i title="QC" class="feather icon-check-square mr-25"></i></a>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <i title="QC" class="feather icon-check-square mr-25"></i>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                           </div>
                        </div>

                    </div>
                                        
                             
                <?php } ?>
                        
                  
 <?php 
 //} 
 ?> 