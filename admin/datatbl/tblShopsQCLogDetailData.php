<?php
    
    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $to_Date = $from_Date;
    $currentDate = $to_Date;

    if(!isset($_SESSION['SAL_QC_Executive_Cd'])){
        $qcExecutiveCd = "All";
        $_SESSION['SAL_QC_Executive_Cd'] = $qcExecutiveCd;
    }else{
        $qcExecutiveCd = $_SESSION['SAL_QC_Executive_Cd'];
    }  
    $fromDate = $from_Date." ".$_SESSION['StartTime'];
    $toDate = $to_Date." ".$_SESSION['EndTime'];

    $totalRecords = 0;
    $maxPageNo = 0;
    $recordPerPage = 15;
    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo']=1;
    }else{
        $pageNo = 1;  
    } 

    if($qcExecutiveCd == "All"){
        $qcExecutiveCondition = " ";
    }else{
        $qcExecutiveCondition = " AND qd.Executive_Cd = $qcExecutiveCd ";
    }

    $queryTotal = "SELECT COUNT(DISTINCT(qd.Shop_Cd)) as ShopQCCount
        FROM QCLogDetails qld
        INNER JOIN  QCDetails qd on qd.QC_Detail_Cd = qld.QC_Detail_Cd
        INNER JOIN ShopMaster sm on sm.Shop_Cd = qd.Shop_Cd
        INNER JOIN PocketMaster ON sm.pocket_Cd = PocketMaster.Pocket_Cd
        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
        WHERE qd.QC_DateTime BETWEEN '$fromDate' AND '$toDate'
        $qcExecutiveCondition
        ;";

    // echo $queryTotal;
    $dbTotal=new DbOperation();
    $total_count = $dbTotal->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
    $totalRecords = $total_count["ShopQCCount"];
    // print_r($total_count);

    $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShop";
    // echo $totalDivideIntoPageQuery;
    $ShopTotalCountData = $dbTotal->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
    $totalRecords = $ShopTotalCountData["TotalShop"];


    $query = "SELECT qd.Shop_Cd, sm.ShopName, sm.ShopNameMar, sm.ShopOutsideImage1, qd.Executive_Cd, em.ExecutiveName,
            bcm.BusinessCatName, pm.PocketName, nm.NodeName, nm.Area as WardArea, nm.Ward_No,

        ISNULL(sm.ShopAddress_1, '') as ShopAddress_1, 
        ISNULL(sm.ShopAddress_2, '') as ShopAddress_2, 
        ISNULL(sm.ShopKeeperName, '') as ShopKeeperName, 
        ISNULL(sm.ShopKeeperMobile, '') as ShopKeeperMobile,
        ISNULL(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
        ISNULL(CONVERT(VARCHAR, sm.SurveyDate, 100), '') as SurveyDate, 
        ISNULL(sm.ShopStatus, '') as ShopStatus, 
        ISNULL(stm.TextColor, '') as ShopStatusTextColor, 
        ISNULL(stm.FaIcon, '') as ShopStatusFaIcon, 
        ISNULL(stm.IconUrl, '') as ShopStatusIconUrl, 
        ISNULL(CONVERT(VARCHAR, sm.ShopStatusDate, 100), '') as ShopStatusDate, 
        ISNULL(sm.ShopStatusRemark, '') as ShopStatusRemark,  

        CONVERT(VARCHAR,min(qd.QC_DateTime),100) as QC_DateTime 
        FROM QCLogDetails qld
        INNER JOIN  QCDetails qd on qd.QC_Detail_Cd = qld.QC_Detail_Cd
        INNER JOIN ShopMaster sm on sm.Shop_Cd = qd.Shop_Cd
        LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = qd.Executive_Cd
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
        INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd 
        WHERE qd.QC_DateTime BETWEEN '$fromDate' AND '$toDate'
        $qcExecutiveCondition
        GROUP BY qd.Shop_Cd, sm.ShopName, sm.ShopNameMar, sm.ShopOutsideImage1, qd.Executive_Cd, em.ExecutiveName,
        bcm.BusinessCatName, pm.PocketName, nm.NodeName, nm.Area, nm.Ward_No, sm.ShopStatus, sm.ShopStatusRemark,
        stm.TextColor, stm.FaIcon, stm.IconUrl, sm.ShopStatusDate,
        sm.ShopAddress_1, sm.ShopAddress_2, sm.ShopKeeperName, sm.ShopKeeperMobile, sm.AddedDate, sm.SurveyDate
        ORDER BY min(qd.QC_DateTime) DESC 
        OFFSET ($pageNo - 1) * $recordPerPage ROWS 
        FETCH NEXT $recordPerPage ROWS ONLY;";

    // echo $query;
    $qcShopLogData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    // print_r($qcShopLogData);
?>
<div class="row">
    
    <div class="col-md-12 col-sm-12">
        <div class="card">

            <div class="card-content">
                <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-3 col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="qcDate">QC Date</label>
                                    <input type='text' name="fromDate" value="<?php echo $currentDate;?>" class="form-control pickadate" />
                                    <input type='hidden' name="toDate" value="<?php echo $currentDate;?>" class="form-control" />
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-2 col-sm-12">
                                
                                <!-- <input type="hidden" name="executiveCd" value="All" > -->
                                <?php include 'dropdown-qc-executive-name.php' ?>
                            </div>
                            <input type="hidden" name="node_Name" value="All" >
                            <input type="hidden" name="node_Cd" value="All" >
                            <input type="hidden" name="pocket_Name" value="All" >


                            <div class="col-12 col-md-4 col-sm-12">
                                <label>Pagination</label>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-start ">

                                       
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
                                            <li class="page-item prev"><a class="page-link" onclick="setShopQCLogDetailData(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                                        <?php } ?>

                                        <?php
                                            for($i=$loopStart;$i<=$loopStop;$i++){ 

                                                    $activePageCondition = ""; 
                                                    if($pageNo == $i){
                                                        $activePageCondition = "active";                                
                                                    }
                                                ?>
                                                <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setShopQCLogDetailData(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                                        <?php } ?>
                                            <!-- <li class="page-item" > <a class="page-link"><?php //echo " of ".$total_count["SurveyDone"]; ?></a></li> -->
                                        <?php if($totalRecords > $loopStop){ ?> 
                                            <li class="page-item next"><a class="page-link"  onclick="setShopQCLogDetailData(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                                        <?php }  ?>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-2 col-12">
                                <label>Records &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type='button' value='<?php echo $total_count["ShopQCCount"]; ?>' name='Export' class="btn btn-success" >
                            </div>
                                                    
                            <div class="col-12 col-md-1 col-sm-12 text-right" style="margin-top: 7px;">
                                <div class="form-group">
                                    <label for="update"></label>
                                    <button type="button" class="btn btn-primary" onclick="setShopQCLogDetailData(1)"><i class="feather icon-refresh-cw"></i></button>
                                </div>
                            </div>

                        </div>
                    
                </div>
            </div>
        </div>
    </div>

        <?php

            $srLogNo = 0;
            if($pageNo!=1){
                $srLogNo = (($pageNo * $recordPerPage) - ($recordPerPage));
            }

            foreach ($qcShopLogData as $key => $value) {
                $srLogNo = $srLogNo + 1;
                $Shop_Cd = $value["Shop_Cd"];
                $getShopName = $value["ShopName"];
                $getShopNameMar = $value["ShopNameMar"];

                $getPocketName = $value["PocketName"];
                $getNodeName = $value["NodeName"];
                $getWardNo = $value["Ward_No"];
                $getWardArea = $value["WardArea"];

                $getShopOutsideImage1 = $value["ShopOutsideImage1"];

                $getShopAddress_1 = $value["ShopAddress_1"];
                $getShopAddress_2 = $value["ShopAddress_2"];

                $getShopKeeperName = $value["ShopKeeperName"];
                $getShopKeeperMobile = $value["ShopKeeperMobile"];

                $getAddedDate = $value["AddedDate"];
                $getSurveyDate = $value["SurveyDate"];

                $getShopStatus = $value["ShopStatus"];
                $getShopStatusTextColor = $value["ShopStatusTextColor"];
                $getShopStatusFaIcon = $value["ShopStatusFaIcon"];
                $getShopStatusIconUrl = $value["ShopStatusIconUrl"];
                $getShopStatusDate = $value["ShopStatusDate"];
                $getShopStatusRemark = $value["ShopStatusRemark"];

                $getNature_of_Business = $value["BusinessCatName"];

                $getQCExecutiveName = $value["ExecutiveName"];
                $getQCDateTime = $value["QC_DateTime"];
        ?>
     
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">   
                                <div class="col-12 col-sm-12 col-md-9">
                                    <div class="row">
                                        

                                        <div class="media-body my-10px col-md-9" style="margin-top: 10px;">
                                            <h5>    
                                                <b> <?php echo $srLogNo.") "; ?><?php echo $getShopNameMar; ?></b> 
                                            </h5>
                                            <h6><b><?php echo $getShopKeeperName; ?> - <?php echo $getShopKeeperMobile; ?></b></h6>
                                            
                                            
                                            <h6><?php echo $getNature_of_Business; ?></h6>
                                            <h6><?php echo "Pocket : ".$getPocketName.", Ward : ".$getWardNo.", ".$getWardArea.", ".$getNodeName; ?></h6>
                                            <h6><?php echo $getShopAddress_1; ?></h6>
                                            <h6><span class="badge badge-success"><?php echo "QC By : ".$getQCExecutiveName." on ".$getQCDateTime; ?></span></h6>
                                            
                                        </div>

                                        <div class=" mr-75 col-md-3">
                                            <?php if($getShopOutsideImage1 != ''){ ?>
                                                <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$getShopOutsideImage1; ?>" title="Outside Image 1" class="avatar rounded galleryimg" width="100%" height="160" />
                                            <?php } else { ?>   
                                                <img src="pics/shopDefault.jpeg" class="avatar rounded galleryimg" title="Outside Image 1" width="100%" height="160" />
                                            <?php } ?>
                                        </div>
                                        
                                    </div>

                                </div>

                                

                                <div class="col-12 col-sm-12 col-md-3 text-right" >
                                    <div class="media">
                                        <div class="media-body my-10px">
                                            <h5>
                                                <?php if(!empty($getShopStatus)) { ?> 
                                                    <b style="color:<?php echo $getShopStatusTextColor; ?>;"><?php echo $getShopStatus; ?></b>
                                                    <i class="<?php echo $getShopStatusFaIcon; ?>" style="color:<?php echo $getShopStatusTextColor; ?>;font-size:22px"></i>
                                                <?php } ?>
                                            </h5>
                                            <h6><?php echo "<b>Shop Listed : </b>  ".$getAddedDate; ?></h6>
                                            <h6><?php if(!empty($getSurveyDate)){ echo "<b>Survey Date : </b>".$getSurveyDate; }  ?></h6>
                                            <h6><?php if(!empty($getShopStatusDate)){ echo "<b>Status Date : </b>".$getShopStatusDate; }  ?></h6>
                                            <?php 
                                 

                                                foreach ($qcTypeArray as $key => $valueQC) {
                                                    $qc_Type_Data = $valueQC["QC_Type"];
                                                        $queryQCDet = "SELECT 
                                                            QC_Flag, QC_Type, 
                                                            ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                                                        FROM QCDetails
                                                        WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qc_Type_Data'
                                                        GROUP BY QC_Flag, QC_Type;";
                                                       // echo $queryQCDet;
                                                    $shopQCDetailsData = $db->ExecutveQuerySingleRowSALData($queryQCDet, $electionName, $developmentMode);
                                                        if(sizeof($shopQCDetailsData)>0){ 
                                                ?>
                                                            <span class="badge badge-success"><?php echo $valueQC["QC_Title"]." QC on ".$shopQCDetailsData["MaxQCDateTime"]; ?></span>
                                                <?php
                                                        }
                                                }

                                            ?>
                                            
                                        </div>

                                    </div>
                                </div>

                                    <?php

                                        $queryQCLog = "SELECT CONVERT(VARCHAR(10), CAST(CONVERT(VARCHAR,qd.QC_DateTime,121) AS TIME), 0) as QC_DateTime, qld.ColumnAlias, qld.Old_Value, qld.QC_Value,qd.QC_Type FROM QCLogDetails qld INNER JOIN QCDetails qd on qd.QC_Detail_Cd = qld.QC_Detail_Cd WHERE qd.Shop_Cd = $Shop_Cd ORDER BY qd.QC_DateTime ASC";
                                        $qcShopLogDetailData = $db->ExecutveQueryMultipleRowSALData($queryQCLog, $electionName, $developmentMode);

                                    ?>

                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered complex-headers zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>QC Time</th>
                                                    <th>QC Columns</th>
                                                    <th>Old Value</th>
                                                    <th>QC Value</th>
                                                    <th>QC Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $srNo = 0;
                                                    foreach ($qcShopLogDetailData as $key => $valueQCLog) {
                                                        $srNo = $srNo+1;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $srNo; ?></td>
                                                        <td><?php echo $valueQCLog["QC_DateTime"]; ?></td>
                                                        <td><?php echo $valueQCLog["ColumnAlias"]; ?></td>
                                                        <td>
                                                            <?php 
                                                                $url =$valueQCLog["Old_Value"];
                                                                $pattern = '/\bhttp\b/';
                                                               if (preg_match($pattern, $url) == true) { ?>
                                                                       <embed src="<?php echo $url; ?>" width="200" height="70"></embed>
                                                            <?php  } else { 
                                                                    echo $valueQCLog["Old_Value"];  
                                                                }  
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $url =$valueQCLog["QC_Value"];
                                                                $pattern = '/\bhttp\b/';
                                                               if (preg_match($pattern, $url) == true) { ?>
                                                                       <embed src="<?php echo $url; ?>" width="200" height="70"></embed>
                                                            <?php  } else { 
                                                                    echo $valueQCLog["QC_Value"];  
                                                                }  
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                foreach ($qcTypeArray as $key => $valueQC) {
                                                                    if($valueQC["QC_Type"] == $valueQCLog["QC_Type"]){
                                                                        echo $valueQC["QC_Title"];
                                                                    }
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
                    </div>
                </div>
            </div>    
        
    <?php
        }
    ?>

</div>