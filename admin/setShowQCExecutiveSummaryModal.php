<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    
    <!-- Data List View -->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <section id="dashboard-analytics">
        <?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(
    (isset($_GET['QCfromDate']) && !empty($_GET['QCfromDate'])) &&  
    (isset($_GET['QCtoDate']) && !empty($_GET['QCtoDate'])) &&  
    (isset($_GET['executiveCd']) && !empty($_GET['executiveCd'])) 
    )
    {
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $qcTypeArray = array(array('QC_Title' => 'Shop Listing', 'SH_Action' => 'Shop Listed', 'QC_Type' =>'ShopList', 'QC_Flag' =>1, 'QC_Color' =>'dark'), array('QC_Title' => 'Shop Survey', 'SH_Action' => 'Shop Surveyed', 'QC_Type' =>'ShopSurvey', 'QC_Flag' =>2, 'QC_Color' =>'primary'), array('QC_Title' => 'Shop Board', 'SH_Action' => 'Shop Board Details', 'QC_Type' =>'ShopBoard', 'QC_Flag' =>5, 'QC_Color' =>'info'), array('QC_Title' => 'Shop Document', 'SH_Action' => 'Shop Document Collected', 'QC_Type' =>'ShopDocument', 'QC_Flag' =>3, 'QC_Color' =>'danger'), array('QC_Title' => 'Shop Calling', 'SH_Action' => 'Shop Called', 'QC_Type' =>'ShopCalling', 'QC_Flag' =>4, 'QC_Color' =>'warning'));

        $QCfromDate = $_GET['QCfromDate'];
        $QCtoDate = $_GET['QCtoDate'];
        $executiveCd = $_GET['executiveCd'];

        $fr_date = strtotime($QCfromDate);
        $to_date = strtotime($QCtoDate);
        $datediff = $to_date - $fr_date;
        $NoOfDaysByDates = round($datediff / (60 * 60 * 24));

        $shopListingQCTodayRowTotal = 0;
        $shopSurveyQCTodayRowTotal = 0;
        $shopBoardQCTodayRowTotal = 0;
        $shopDocumentQCTodayRowTotal = 0;
        $shopCallingQCTodayRowTotal = 0;

        $shopListingQCRowTotal = 0;
        $shopSurveyQCRowTotal = 0;
        $shopBoardQCRowTotal = 0;
        $shopDocumentQCRowTotal = 0;
        $shopCallingQCRowTotal = 0;

        $shopSurveySDRowTotal = 0;
        $shopDocumentSDRowTotal = 0;
        $QC_CountTodayTotal = 0;

                    $queryQCExe="SELECT
                    qd.Executive_Cd, em.ExecutiveName,
                    (SELECT COUNT(DISTINCT CONVERT(varchar, qds.QC_DateTime, 23)) FROM QCDetails as qds WHERE qds.Executive_Cd = qd.Executive_Cd
                    AND CONVERT(VARCHAR,qds.QC_DateTime,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59') as NoOfDays
                    FROM QCDetails qd
                    INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = qd.Executive_Cd
                    WHERE CONVERT(VARCHAR,qd.QC_DateTime,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59'
                    
                    GROUP BY qd.Executive_Cd, em.ExecutiveName";
                    $dbQC=new DbOperation();
                    $QCExeData = $dbQC->ExecutveQueryMultipleRowSALData($queryQCExe, $electionName, $developmentMode); ?>

                    <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h5>QC Summary - Executive Wise : <?php echo date('d/m/Y',strtotime($QCfromDate))." - ".date('d/m/Y',strtotime($QCtoDate)); ?></h5>
                                    <div class="table-responsive">
                                        <table id="QCSummaryTableId" class="table table-striped complex-headers table-bordered zero-configuration" width="100%">
                                            <thead>
                                                <tr>
                                                    <th> Executive Name </th>
                                                    <th> Shop Listing </th>
                                                    <th> Shop Survey </th>
                                                    <th> Shop Board </th>
                                                    <th> Shop Document </th>
                                                    <th> Shop Calling </th>
                                                    <th> QC Shop Count</th>
                                                    <th> QC Days </th>
                                                    <th> QC Average </th>
                                                </tr>
                                            </thead>
                                            <tbody> 

                        <?php foreach($QCExeData as $value){
                            $qcExecutiveCd = $value["Executive_Cd"];   ?>

                            <tr>
                                
                                <td> <?php  echo $value["ExecutiveName"]; ?> </td> 
                            

                            <?php foreach ($qcTypeArray as $key => $qcTypeValue) {
                                $shopQCTodayShopColumnCondition ="";
                                $shopQCShopListCondition ="";

                                $shopScheduleCondition ="";
                                                        
                                $qcTitle = $qcTypeValue["QC_Title"];
                                $shAction = $qcTypeValue["SH_Action"];
                                $qcType = $qcTypeValue["QC_Type"];
                                $qcFlag = $qcTypeValue["QC_Flag"];

                                
                                if($qcType == 'ShopList'){
                                    $shopQCShopListCondition =" AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59' AND CONVERT(VARCHAR,sm.QC_UpdatedDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59'   ";

                                    $shopQCTodayShopColumnCondition = "   ";

                                    $shopScheduleCondition =" ,
                                            0 AS SD_Count
                                    ";
                                }else if($qcType == 'ShopSurvey'){
                                    $shopQCTodayShopColumnCondition = " 
                                        INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND qd.ScheduleCall_Cd = sd.ScheduleCall_Cd)
                                        INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                            AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59'  
                                        )
                                        INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey') 
                                        )
                                    ";
                             

                                    $shopScheduleCondition =" ,
                                    ISNULL((
                                        SELECT
                                            COUNT(DISTINCT(sm.Shop_Cd))
                                        FROM ShopMaster sm
                                        INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59' AND sd.Executive_Cd = $qcExecutiveCd  )
                                        
                                        INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd AND ccm.QC_Type in ('ShopSurvey') )
                                        ),0) AS SD_Count
                                    ";

                                }else if($qcType == 'ShopBoard'){
                                    $shopQCTodayShopColumnCondition = " 
                                     INNER JOIN ShopBoardDetails sbd on ( sbd.Shop_Cd=sm.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sbd.UpdatedDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59' AND sbd.BoardID = qd.BoardID AND CONVERT(VARCHAR,sbd.QC_UpdatedDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59' AND sbd.QC_Flag IS NOT NULL )
                                    ";

                                    $shopScheduleCondition =" ,
                                            0 AS SD_Count
                                    ";
                                }else if($qcType == 'ShopDocument'){
                                    $shopQCTodayShopColumnCondition = " 
                                        INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND qd.ScheduleCall_Cd = sd.ScheduleCall_Cd )
                                        INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                            AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59'  
                                        )
                                        INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument') 
                                        )
                                    ";


                                    $shopScheduleCondition =" ,
                                    ISNULL((
                                        SELECT
                                            COUNT(DISTINCT(sm.Shop_Cd))
                                        FROM ShopMaster sm
                                        INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59' AND sd.Executive_Cd = $qcExecutiveCd  )
                                        
                                        INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd AND ccm.QC_Type in ('ShopDocument') )
                                        ),0) AS SD_Count
                                    ";
                                }else if($qcType == 'ShopCalling'){
                                      $shopQCTodayShopColumnCondition = " 
                                        INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND sd.ScheduleCall_Cd = qd.ScheduleCall_Cd )
                                        INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                            AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$QCfromDate'+' 00:00:00'  AND '$QCtoDate'+' 23:59:59'  
                                        )
                                        INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Calling' 
                                        )
                                        INNER JOIN CallingDetails cd ON ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND cd.Call_Response_Cd = 4 AND ISNULL(cd.AudioFile_Url,'') <> '' AND qd.Calling_Cd = cd.Calling_Cd)
                                    ";



                                    $shopScheduleCondition =" ,
                                            0 AS SD_Count
                                    ";
                                }


                                $qcTypeTotalTodayRowCount = 0;
                                $qcTypeTodayRowCount = 0;
                                $smScheduledRowCount = 0;
                                $queryQC = "SELECT 
                                    ISNULL((
                                        SELECT
                                            COUNT(DISTINCT(qd.Shop_Cd))
                                        FROM QCDetails qd
                                        INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$QCfromDate'+' 00:00:00' AND '$QCtoDate'+' 23:59:59' AND qd.QC_Type = '$qcType' AND qd.Executive_Cd = $qcExecutiveCd )
                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                        WHERE sm.IsActive = 1
                                    ),0) AS QC_Count ,
                                    ISNULL((
                                        SELECT
                                            COUNT(DISTINCT(qd.Shop_Cd))
                                        FROM QCDetails qd

                                        INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$QCfromDate'+' 00:00:00' AND '$QCtoDate'+' 23:59:59' AND qd.QC_Type = '$qcType' AND qd.Executive_Cd = $qcExecutiveCd )
                                        $shopQCTodayShopColumnCondition
                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                        WHERE sm.IsActive = 1
                                        $shopQCShopListCondition
                                    ),0) AS QC_TodayShop_Count

                                    $shopScheduleCondition

                                  ;  ";
                                    
                                $dbQCC=new DbOperation();
                                $QC_CountData = $dbQCC->ExecutveQuerySingleRowSALData($queryQC, $electionName, $developmentMode);

                                $qcTypeTodayRowCount = $QC_CountData["QC_TodayShop_Count"];
                                $qcTypeTotalTodayRowCount = $QC_CountData["QC_Count"];
                                $smScheduledRowCount = $QC_CountData["SD_Count"];

                                if($qcType == 'ShopList'){
                                    $shopListingQCTodayRowTotal = $shopListingQCTodayRowTotal + $qcTypeTodayRowCount;
                                    $shopListingQCRowTotal = $shopListingQCRowTotal + $qcTypeTotalTodayRowCount;
                                }else if($qcType == 'ShopSurvey'){
                                    $shopSurveyQCTodayRowTotal = $shopSurveyQCTodayRowTotal + $qcTypeTodayRowCount;
                                    $shopSurveyQCRowTotal = $shopSurveyQCRowTotal + $qcTypeTotalTodayRowCount;
                                    $shopSurveySDRowTotal = $shopSurveySDRowTotal + $smScheduledRowCount;
                                }else if($qcType == 'ShopBoard'){
                                    $shopBoardQCTodayRowTotal = $shopBoardQCTodayRowTotal + $qcTypeTodayRowCount;
                                    $shopBoardQCRowTotal = $shopBoardQCRowTotal + $qcTypeTotalTodayRowCount;
                                }else if($qcType == 'ShopDocument'){
                                    $shopDocumentQCTodayRowTotal = $shopDocumentQCTodayRowTotal + $qcTypeTodayRowCount;
                                    $shopDocumentQCRowTotal = $shopDocumentQCRowTotal + $qcTypeTotalTodayRowCount;
                                    $shopDocumentSDRowTotal = $shopDocumentSDRowTotal + $smScheduledRowCount;
                                }else if($qcType == 'ShopCalling'){
                                    $shopCallingQCTodayRowTotal = $shopCallingQCTodayRowTotal + $qcTypeTodayRowCount;
                                    $shopCallingQCRowTotal = $shopCallingQCRowTotal + $qcTypeTotalTodayRowCount;
                                }
                                
                               
                        ?>
                             <td style="text-align:center;">
                              
                              

                               <span class="badge badge-dark badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Total QC Done on <?php echo date('d/m/Y', strtotime($QCfromDate))." - ".date('d/m/Y', strtotime($QCtoDate)); ?>"><?php echo $qcTypeTotalTodayRowCount; ?></span>
                               
                                <?php 
                                    if($qcType == 'ShopList'){

                                    }else if($qcType == 'ShopSurvey'){
                                ?>
                                        
                                        
                                <?php 
                                    }else if($qcType == 'ShopBoard'){

                                    }else if($qcType == 'ShopDocument'){
                                    ?>
                                        
                                       
                                <?php 
                                    }else if($qcType == 'ShopCalling'){

                                    }
                                ?>

                            </td>

                            
                        <?php
                             }
                        ?>
                         <td  style="text-align:center;">
                            <?php
                                $queryQCToday = "SELECT 
                                    ISNULL((
                                        SELECT
                                            COUNT(DISTINCT(qd.Shop_Cd))
                                        FROM QCDetails qd
                                        INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$QCfromDate'+' 00:00:00' AND '$QCtoDate'+' 23:59:59'  AND qd.Executive_Cd = $qcExecutiveCd )
                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                        WHERE sm.IsActive = 1 
                                    ),0) AS QC_Count";
                                $dbQCC=new DbOperation();
                                $QC_CountTodayData = $dbQCC->ExecutveQuerySingleRowSALData($queryQCToday, $electionName, $developmentMode);
                                $QC_CountTodayTotal = $QC_CountTodayTotal + $QC_CountTodayData["QC_Count"];
                            ?>
                            <span class="badge badge-dark badge-md  " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Total No. of Shops QC Done on <?php echo date('d/m/Y', strtotime($QCfromDate))." - ".date('d/m/Y', strtotime($QCtoDate)); ?>"><?php echo $QC_CountTodayData["QC_Count"]; ?></span>
                         </td> 
                         <?php //if($NoOfDaysByDates <= $value['NoOfDays']) { $finalDays = $NoOfDaysByDates; } else { $finalDays = $value['NoOfDays']; }; ?>
                         <td  style="text-align:center;">
                            <span class="badge badge-dark badge-md  " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Total No. of Shops QC Done on <?php echo date('d/m/Y', strtotime($QCfromDate))." - ".date('d/m/Y', strtotime($QCtoDate)); ?>"><?php echo $value['NoOfDays']; ?></span>
                         </td> 
                         <td  style="text-align:center;">
                         <span class="badge badge-dark badge-md  " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Total No. of Shops QC Done on <?php echo date('d/m/Y', strtotime($QCfromDate))." - ".date('d/m/Y', strtotime($QCtoDate)); ?>"><?php echo round($QC_CountTodayData["QC_Count"] / $value['NoOfDays']); ?></span>
                         </td> 
                    </tr>
        <?php   } 

             
        ?>
                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </section>
            <?php


        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                                                          

  }else{
    //echo "ddd";
  }

}
?>
<script src="app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
<script src="app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>