<style type="text/css">
.avatar .avatar-content .avatar-icon {
   font-size: 2.2rem;
}

</style>
<section id="nav-justified">
<?php 

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


   $currentDate = date('Y-m-d');
   $curDate = date('Y');
   $fromDate = $currentDate;
   $toDate = $currentDate;

   if(!isset($_SESSION['SAL_FromDate'])){
       $_SESSION['SAL_FromDate'] = $fromDate ;
   }else{
       $fromDate  = $_SESSION['SAL_FromDate'];
   }

   if(!isset($_SESSION['SAL_ToDate'])){
       $_SESSION['SAL_ToDate'] = $toDate;
   }else{
       $toDate = $_SESSION['SAL_ToDate'];
       // if($toDate != date('Y-m-d')){
       //     $_SESSION['SAL_ToDate'] = date('Y-m-d');
       //     $toDate = $_SESSION['SAL_ToDate'];
       // }
   }

   if(isset($_GET['nodeCd'])){
    $nodeCd = $_GET['nodeCd'];
    $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }else if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    else{
        $nodeCd = 'All';
    }

if(isset($_GET['fromDate'])){
    $from_Date = $_GET['fromDate'];
    $_SESSION['SAL_FromDate'] = $from_Date;
}else if(isset($_SESSION['SAL_FromDate'])){
    $from_Date = $_SESSION['SAL_FromDate'];
}

if(isset($_GET['toDate'])){
    $to_Date = $_GET['toDate'];
    $_SESSION['SAL_ToDate'] = $from_Date;
}else if(isset($_SESSION['SAL_ToDate'])){
    $to_Date = $_SESSION['SAL_ToDate'];
}

if($nodeCd == 'All'){
    $nodeCondition = " AND pm.Node_Cd <> 0  "; 
}else{
    $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> 0  "; 
}

if($nodeName == 'All'){
    $nodeNameCondition = " AND nm.NodeName <> '' ";
}else{
    $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
}

$fromDate = $from_Date." ".$_SESSION['StartTime'];
$toDate = $to_Date." ".$_SESSION['EndTime'];

$frDate = date("Y-m-d",strtotime($fromDate));
$tDate = date("Y-m-d",strtotime($toDate));


   if(isset($_SESSION['SAL_Node_Cd'])){
       $nodeCd = $_SESSION['SAL_Node_Cd'];
       if($nodeCd != 'All' ){
           $query2 = "SELECT
               ISNULL(Node_Cd,0) as Node_Cd,
               ISNULL(NodeName,'') as NodeName,
               ISNULL(NodeNameMar,'') as NodeNameMar,
               ISNULL(Ac_No,0) as Ac_No,
               ISNULL(Ward_No,0) as Ward_No,
               ISNULL(Address,'') as Address,
               ISNULL(Area,'') as Area
               FROM NodeMaster
               WHERE Node_Cd = $nodeCd";
           $db2=new DbOperation();
           $userName=$_SESSION['SAL_UserName'];
           $appName=$_SESSION['SAL_AppName'];
           $electionName=$_SESSION['SAL_ElectionName'];
           $developmentMode=$_SESSION['SAL_DevelopmentMode'];
           $dataNode = $db2->ExecutveQuerySingleRowSALData($query2, $electionName, $developmentMode);
           if(sizeof($dataNode)>0){
               $_SESSION['SAL_Node_Name'] = $dataNode["NodeName"];
           }    
       }
   }

            $queTotalCount = "SELECT
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as ShopsListed,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND ( sm.SurveyDate IS NOT NULL )
            --OR (sm.ShopStatus = 'Permanently Closed' OR sm.ShopStatus = 'Non-Cooperative' OR sm.ShopStatus = 'Permission Denied') )
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
            --OR ( sm.ShopStatus = 'Permanently Closed' OR sm.ShopStatus = 'Non-Cooperative' OR sm.ShopStatus = 'Permission Denied') 
            ),0)as ShopsSurveyed,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND ( sm.SurveyDate IS NULL )
            --OR (sm.ShopStatus = 'Permanently Closed' OR sm.ShopStatus = 'Non-Cooperative' OR sm.ShopStatus = 'Permission Denied') )
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
            --OR ( sm.ShopStatus = 'Permanently Closed' OR sm.ShopStatus = 'Non-Cooperative' OR sm.ShopStatus = 'Permission Denied') 
            ),0)as SurveyPending,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NULL AND sm.ShopStatus = 'Permission Denied' AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as PermissionDenied,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NULL AND sm.ShopStatus = 'Permanently Closed' AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as PermanantlyClosed,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NULL AND sm.ShopStatus IS NULL AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as Pending,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NULL AND sm.ShopStatus = 'Non-Cooperative' AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as NonCooperative,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NOT NULL 
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
            AND (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) 
            OR LEN(ShopKeeperMobile) != 10 )),0 ) as MobilePending,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NOT NULL 
            AND ( ShopOutsideImage1 IS NULL AND ShopOutsideImage2 IS NULL AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate')),0)as PhotoPending,
            ISNULL((SELECT COUNT(sm.Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            LEFT JOIN ShopDocuments AS sd ON (sm.Shop_Cd = sd.Shop_Cd)
            WHERE sm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.IsActive = 1 
            AND nm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL
            AND sd.Shop_Cd IS NULL AND sm.ShopStatus = 'Pending' AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'),0)as DocumentPending,
            ISNULL((SELECT COUNT(DISTINCT qd.Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN QcDetails qd on qd.Shop_Cd = sm.Shop_Cd
            WHERE sm.IsActive = 1
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            AND qd.QC_Type = 'ShopList'
            AND qd.QC_Flag = 1
            $nodeCondition
            $nodeNameCondition
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as ShopListQcDone,
            ISNULL((SELECT COUNT(DISTINCT qd.Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN QcDetails qd on qd.Shop_Cd = sm.Shop_Cd
            WHERE sm.IsActive = 1
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            AND qd.QC_Type = 'ShopSurvey'
            AND qd.QC_Flag = 2
            $nodeCondition
            $nodeNameCondition
            AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' ),0)as ShopSurveyQcDone";
            $db3=new DbOperation();
            $dataTotalCount = $db3->ExecutveQuerySingleRowSALData($queTotalCount, $electionName, $developmentMode);

?>
<div class="row">
   <div class="col-md-12">
       <div class="card">
           <!-- <div class="card-header">
               <h4 class="card-title">Pocket Survey Summary</h4>
           </div> -->
           <div class="card-content">
               <div class="card-body">
                   <form class="form-horizontal" novalidate>
                       <div class="row">
                           <div class="col-md-3 col-12">
                               <div class="form-group">
                                   <label for="fromDate">From Date</label>
                                   <input type='text' name="fromDate" value="<?php echo $frDate;?>" class="form-control pickadate-disable-forwarddates" onchange="setFromAndToDateInSession()" />
                               </div>
                           </div>
                           <div class="col-md-3 col-12">
                               <div class="form-group">
                                   <label for="toDate">To Date</label>
                                   <input type='text' name="toDate" value="<?php echo $tDate;?>" class="form-control pickadate-disable-forwarddates" onchange="setFromAndToDateInSession()" />
                               </div>
                           </div>
                           <div class="col-md-3 col-12">
                               <?php include 'dropdown-node.php'; ?>
                           </div>
                           <div class="col-md-3 col-12">
                               <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                           </div>
                           <input type="hidden" name="pocket_Name" value="All">
                           <input type="hidden" name="executive_Name" value="All">
                           <!-- <div class="col-md-2 col-12 text-right"  style="margin-top: 25px;">
                                <div class="form-group">
                                   <label for="refesh"></label>
                                   <button type="button" name="refesh" class="btn btn-primary" onclick="getPocketWiseSurveySummary()" >Refresh</button>
                               </div>
                           </div> -->
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>

<div class="row">

        <div class="col-lg-2 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">

                <div class="col-lg-12 col-sm-12 col-12">
                    <div>
                        <h2 class="text-bold-700 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=All"><?php echo IND_money_format($dataTotalCount['ShopsListed']); ?></a> </h2>
                        <h6>Shops Listed</h6>
                    </div>
                    <!-- <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div> -->
                </div>
                </div>
                </div>
                </div>

            <div class="col-lg-5 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">

                <div class="col-lg-4 col-sm-12 col-12">
                    <div>
                        <h2 class="text-bold-700 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=All"><?php echo IND_money_format($dataTotalCount['ShopsSurveyed']); ?></a></h2>
                        <h6>Survey Done</h6>
                    </div>
                    <!-- <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div> -->
                </div>

                <div class="col-lg-8 col-sm-12 col-12">
                <div class="d-flex justify-content-between mt-2 mb-2">
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=MobilePending"><?php echo $dataTotalCount['MobilePending'];?></a></p>
                        <span class="">Mobile &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                    </div>
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=PhotoPending"><?php echo $dataTotalCount['PhotoPending'];?></a></p>
                        <span class="">Photo &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                    </div>
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=DocumentPending"><?php echo $dataTotalCount['DocumentPending'];?></a></p>
                        <span class="">Document </br>Pending</span>&nbsp;&nbsp;
                    </div>
                </div>
                </div>


                </div>
                </div>
                </div>

                <div class="col-lg-5 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">

                <div class="col-lg-4 col-sm-12 col-12">
                    <div>
                        <h2 class="text-bold-700 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=SurveyPending"><?php echo IND_money_format($dataTotalCount['SurveyPending']); ?></a></h2>
                        <h6>Survey Pending</h6>
                    </div>
                    <!-- <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div> -->
                </div>

                <div class="col-lg-8 col-sm-12 col-12">
                <div class="d-flex justify-content-between mt-2 mb-2">
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=PermanantlyClosed"><?php echo $dataTotalCount['PermanantlyClosed'];?></a></p>
                        <span class="">P &nbsp;&nbsp;&nbsp;&nbsp;</br>C</span>&nbsp;&nbsp;
                    </div>
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=PermissionDenied"><?php echo $dataTotalCount['PermissionDenied'];?></a></p>
                        <span class="">P &nbsp;&nbsp;&nbsp;&nbsp;</br>D</span>&nbsp;&nbsp;
                    </div>
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=NonCooperative"><?php echo $dataTotalCount['NonCooperative'];?></a></p>
                        <span class="">N &nbsp;&nbsp;&nbsp;&nbsp;</br>C</span>&nbsp;&nbsp;
                    </div>
                    <div class="followers">
                        <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=Pending"><?php echo $dataTotalCount['Pending'];?></a></p>
                        <span class="">Pending &nbsp;&nbsp;&nbsp;&nbsp;</br></span>&nbsp;&nbsp;
                    </div>
                </div>
                </div>


                </div>
                </div>
                </div>

                

</div>

<!-- <div class="row">

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">

                <div class="col-lg-3 col-sm-6 col-12">
                    <div>
                        <h2 class="text-bold-700 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=All"><?php echo IND_money_format($dataTotalCount['ShopsListed']); ?></a>    /      <a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=All"><?php echo IND_money_format($dataTotalCount['ShopsSurveyed']); ?></a></h2>
                        <h6>Shops Listed    /   Shops Surveyed</h6>
                    </div> -->
                    <!-- <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div> -->
                <!-- </div>

                <div class="col-lg-9 col-sm-6 col-12">
                    <div class="d-flex justify-content-between mt-2 mb-2">
                                            <div class="followers">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=PermanantlyClosed"><?php echo $dataTotalCount['PermanantlyClosed'];?></a></p>
                                                <span class="">Permanantly &nbsp;&nbsp;</br>Closed</span>&nbsp;&nbsp;
                                            </div>
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=PermissionDenied"><?php echo $dataTotalCount['PermissionDenied'];?></a></p>
                                                <span class="">Permission &nbsp;&nbsp;</br> Denied</span>&nbsp;&nbsp;
                                            </div>
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopList&FilterName=NonCooperative"><?php echo $dataTotalCount['NonCooperative'];?></a></p>
                                                <span class="">Non &nbsp;&nbsp;</br>Cooprative</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp; -->
                                            <!-- <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><?php echo $dataTotalCount['ShopListQcDone'];?></p>
                                                <span class="">QC &nbsp;&nbsp;</br>Done</span>&nbsp;&nbsp;
                                            </div> -->
                                            <!-- <div class="followers">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=MobilePending"><?php echo $dataTotalCount['MobilePending'];?></a></p>
                                                <span class="">Mobile &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=PhotoPending"><?php echo $dataTotalCount['PhotoPending'];?></a></p>
                                                <span class="">Photo &nbsp;&nbsp;&nbsp;&nbsp;</br> Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=DocumentPending"><?php echo $dataTotalCount['DocumentPending'];?></a></p>
                                                <span class="">Document &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><?php echo $dataTotalCount['ShopSurveyQcDone'];?></p>
                                                <span class="">QC &nbsp;&nbsp;&nbsp;&nbsp;</br>Done</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                        </div>
                
                </div>
            </div>
        </div>
        </div> -->

        <!-- <div class="col-lg-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=All"><?php echo IND_money_format($dataTotalCount['ShopsSurveyed']); ?></a></h2>
                        <h6>Shops Survey </h6>
                    </div>
                    <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                                            <div class="followers">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=MobilePending"><?php echo $dataTotalCount['MobilePending'];?></a></p>
                                                <span class="">Mobile &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=PhotoPending"><?php echo $dataTotalCount['PhotoPending'];?></a></p>
                                                <span class="">Photo &nbsp;&nbsp;&nbsp;&nbsp;</br> Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><a href="home.php?p=listing-survey-filter&FilterType=ShopSurvey&FilterName=DocumentPending"><?php echo $dataTotalCount['DocumentPending'];?></a></p>
                                                <span class="">Document &nbsp;&nbsp;&nbsp;&nbsp;</br>Pending</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                            <div class="following">
                                                <p class="font-weight-bold font-medium-2 mb-0"><?php echo $dataTotalCount['ShopSurveyQcDone'];?></p>
                                                <span class="">QC &nbsp;&nbsp;&nbsp;&nbsp;</br>Done</span>&nbsp;&nbsp;
                                            </div>&nbsp;&nbsp;
                                        </div>
                
                </div>
            </div>
        </div> -->

</div>

<div id="tblShopsFilterList">

<?php 
if(isset($_GET['FilterType']) && !empty($_GET['FilterType']) && $_GET['FilterType'] == 'ShopList')
{
    $FilterType = $_GET['FilterType'];
    $_SESSION['SAL_ListingSurveyFilterType'] = $FilterType;

    $FilterName = $_GET['FilterName'];
    $_SESSION['SAL_ListingSurveyFilterName'] = $FilterName;
   include 'datatbl/tblGetShopListingDataWithFilter.php'; 
}
else if(isset($_GET['FilterType']) && !empty($_GET['FilterType']) && $_GET['FilterType'] == 'ShopSurvey')
{
    $FilterType = $_GET['FilterType'];
    $_SESSION['SAL_ListingSurveyFilterType'] = $FilterType;

    $FilterName = $_GET['FilterName'];
    $_SESSION['SAL_ListingSurveyFilterName'] = $FilterName;
    include 'datatbl/tblGetShopSurveyDataWithFilter.php'; 
}
?>
</div>

               
</section>


   