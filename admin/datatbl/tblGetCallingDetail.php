 <?php 
        $db = new DbOperation();
         $queryExe = "SELECT top (1)
                ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
                FROM Survey_Entry_Data..Executive_Master em
                WHERE Executive_Cd = $executiveCd ";
        $dataExe = $db->ExecutveQuerySingleRowSALData($queryExe, $electionName, $developmentMode);
        if(sizeof($dataExe)>0){
            $excutiveName = $dataExe["ExecutiveName"];
        }else{
            $excutiveName = "";
        }
?>

<?php 
    if($executiveCd != 0 ){
?>


<div class="row">

    <?php 
        $db = new DbOperation();
         $queryExe = "SELECT top (1)
                ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
                FROM Survey_Entry_Data..Executive_Master em
                WHERE Executive_Cd = $executiveCd ";
        $dataExe = $db->ExecutveQuerySingleRowSALData($queryExe, $electionName, $developmentMode);
        if(sizeof($dataExe)>0){
            $excutiveName = $dataExe["ExecutiveName"];
        }else{
            $excutiveName = "";
        }


        $query = "SELECT 
                ISNULL(cccm.Calling_Category_Cd,0) as Calling_Category_Cd,
                ISNULL(cccm.Calling_Category,'') as Calling_Category,
                ISNULL(cccm.Calling_Type, '') as  Calling_Type,
                ISNULL((
                    SELECT COUNT(DISTINCT(cdt.Calling_Cd))
                    FROM CallingDetails cdt
                    WHERE CONVERT(VARCHAR,cdt.Call_DateTime,23) =  '$callingDate'
                    AND cdt.Executive_Cd = $executiveCd
                    AND cdt.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND cdt.Call_Response_Cd = 4
                ),0) as TotalCallsCount
                FROM CallingCategoryMaster cccm 
                WHERE cccm.Calling_Type = 'Calling';";
                // echo $query;
        $CallingSummaryCountData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
        // print_r($CallingSummaryCountData);

        if(sizeof($CallingSummaryCountData)>0){
            if(!isset($_SESSION['SAL_Calling_Category_Cd'])){
                $callingCategoryCd = $CallingSummaryCountData[0]["Calling_Category_Cd"];
                $_SESSION['SAL_Calling_Category_Cd'] = $callingCategoryCd;
            }
        }
 
        $subTotalCalling = 0;
        foreach($CallingSummaryCountData AS $CallingCountData)
        {
            $subTotalCalling = $subTotalCalling + $CallingCountData['TotalCallsCount'];
    ?>

            <div class="col-xl-3 col-md-3 col-sm-12 col-12">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar bg-light-danger p-50  mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-shopping-bag avatar-icon p-50  mr-2"></i>
                                </div>  
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="text-white font-weight-bolder mb-0"><?php echo $CallingCountData['TotalCallsCount'];?></h4>
                                <p class="text-white font-medium-2 mb-0"><?php echo $CallingCountData['Calling_Category'];?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php   
        } 
    ?>

</div>
                
       

                                             
 <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Calling Detail :: <?php echo $excutiveName; ?></h5>
                </div>
                <?php
                    $queryCCListExecST = "
                                SELECT ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate,
                                ISNULL(st.AssignExec_Cd,0) as Executive_Cd,
                                ISNULL(em.ExecutiveName,0) as ExecutiveName,
                                ISNULL(em.MobileNo,0) as MobileNo,
                                ISNULL(nm.NodeName,'') as NodeName,
                                ISNULL(pm.Node_Cd,0) as Node_Cd,
                                ISNULL(pm.PocketName,'') as PocketName,
                                ISNULL(sm.Pocket_Cd,0) as Pocket_Cd,
                                ISNULL(st.Shop_Cd,0) as Shop_Cd,
                                ISNULL(sm.Shop_UID,'') as Shop_UID,
                                ISNULL(sm.ShopName,'') as ShopName,
                                ISNULL(sm.ShopNameMar,'') as ShopNameMar,
                                ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
                                ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
                                ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
                                ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
                                ISNULL(sm.ShopLatitude,'') as Latitude,
                                ISNULL(sm.ShopLongitude,'') as Longitude,
                                ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                                ISNULL(sm.ShopCategory,'') as ShopCategory,
                                ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
                                ISNULL(st.ST_Cd,0) as ST_Cd,
                                ISNULL(st.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                                ISNULL(st.Calling_Category_Cd,0) as Calling_Category_Cd,
                                ISNULL(ccm.Calling_Category,'') as Calling_Category,
                                ISNULL(st.ST_Exec_Cd,0) as ST_Exec_Cd,
                                ISNULL(st.ST_Status,0) as ST_Status,
                                ISNULL(st.ST_StageName,'') as ST_StageName,
                                ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
                                ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
                                ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
                                ISNULL(CONVERT(VARCHAR,st.ST_DateTime,121),'') as ST_DateTime,
                                ISNULL(crm.Call_Response,'') as Call_Response,
                                ISNULL(CONVERT(VARCHAR,cdt.Call_DateTime,121),'') as Call_DateTime,
                                ISNULL(cdt.AudioFile_Url,'') as AudioFile_Url,
                                ISNULL(cdt.CallRecordStatus,0) as CallRecordStatus,
                                ISNULL(cdt.GoodCall,0) as GoodCall,
                                ISNULL(cdt.QC_Flag,0) as QC_Flag,
                                ISNULL(cdt.Appreciation,0) as Appreciation,
                                ISNULL(cdt.AudioListen,0) as AudioListen,
                                ISNULL(cdt.Remark1,'') as Remark1,
                                ISNULL(cdt.Remark2,'') as Remark2,
                                ISNULL(cdt.Remark3,'') as Remark3
                                FROM ShopTracking st 
                                INNER JOIN LoginMaster lm on ( lm.Executive_Cd = st.AssignExec_Cd 
                                    AND lm.User_Type like '%Calling%' AND st.AssignExec_Cd = $executiveCd
                                )
                                INNER JOIN ScheduleDetails scd on ( 
                                    scd.ScheduleCall_Cd = st.ScheduleCall_Cd AND scd.Shop_Cd = st.Shop_Cd 
                                )
                                LEFT JOIN CallingDetails cdt on (  st.AssignExec_Cd = cdt.Executive_Cd
                                    AND  st.ScheduleCall_Cd  = cdt.ScheduleCall_Cd 
                                    AND CONVERT(VARCHAR,cdt.Call_DateTime,23) =  '$callingDate'
                                    AND cdt.Executive_Cd = $executiveCd
                                )
                                INNER JOIN ShopMaster sm on st.Shop_Cd = sm.Shop_Cd
                                INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = st.AssignExec_Cd
                                INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cdt.Call_Response_Cd
                                INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cdt.Calling_Category_Cd
                                INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                                INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
                                INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
                                WHERE sm.IsActive = 1 AND pm.IsActive = 1
                                order by ShopOutsideImage1 desc, ST_Status desc
                                ";
                            // echo $queryCCListExecST;
                    $db7 = new DbOperation();
                    $dataCCListExecST = $db7->ExecutveQueryMultipleRowSALData($queryCCListExecST, $electionName, $developmentMode);
                    // print_r($dataCCListExecST);
                 ?>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered complex-headers zero-configuration">
                                <thead>
                                    <tr>
                                    
                                        <th colspan="2" style="text-align:center;">Shop Detail </th>
                                        <th colspan="5" style="text-align:center;">Calling Status</th>
                                        
                                    </tr>
                                    <tr>
                                    
                                        <th style="text-align:center;">Sr<br>No</th>
                                        <th style="text-align:left;">Shop Name</th>
                                        <th style="text-align:left;">Calling Date</th>
                                        <th style="text-align:center;">Audio</th>
                                        <th style="text-align:center;">Remark</th>
                                        <th style="text-align:center;">Status</th>
                                        <!-- <th style="text-align:center;">Action</th> -->
                                        <!-- <th style="text-align:center;">Edit</th>
                                        <th style="text-align:center;">Track</th>
                                        <th style="text-align:center;">Map</th> -->
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $srNo = 0;
                                        foreach ($dataCCListExecST as $key => $value) {
                                            $srNo = $srNo + 1;
                                    ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $srNo; ?></td>
                                            <td style="text-align:left;">
                                                 <div class="media mb-2">
                                                    <?php 
                                                        if(!empty($value["ShopOutsideImage1"])){
                                                    ?>
                                                        <a class="mr-2 my-25" href="#">
                                                            <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$value["ShopOutsideImage1"]; ?>" alt="Shop Outside Image" class="users-avatar-shadow rounded" height="85" width="70">
                                                        </a>
                                                    <?php    
                                                        }else{
                                                    ?>
                                                        <a class="mr-2 my-25" href="#">
                                                            <img src="pics/shopDefault.jpeg" alt="Shop Outside Image" class="users-avatar-shadow rounded" height="85" width="70">
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    <div class="media-body mt-50">
                                                        <p>
                                                            <?php echo $value["ShopName"]."<br>".$value["ShopKeeperName"]."<br>".$value["ShopKeeperMobile"]."<br>".$value["PocketName"]; ?>
                                                        </p>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align:left;">
                                                <?php if(!empty($value["Call_DateTime"])){ echo date('d/m/Y h:i a',strtotime($value["Call_DateTime"])); } ?>
                                                <br>
                                                <?php echo $value["Calling_Category"]; ?>
                                                <br>
                                                <?php echo $value["Call_Response"]; ?>
                                            </td>
                                    
                                            <td style="text-align:left;">
                                                <?php 
                                                    if(!empty($value["AudioFile_Url"])){
                                                ?>
                                                    <audio controls preload="none">
                                                        <source src="<?php echo $value["AudioFile_Url"]; ?>" type="audio/mpeg" />
                                                    </audio>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align:left;"><?php echo $value["ST_Remark_1"]."<br>".$value["ST_Remark_2"]."<br>".$value["ST_Remark_3"]; ?></td>
                                            <td style="text-align:center;">
                                                <button type="button" class="btn bg-gradient-<?php if($value["ST_Status"] == 1){ echo "success"; }else{ echo "danger"; }  ?> waves-effect waves-light" title="Calling Status"><?php if($value["ST_Status"] == 1){ echo "Done"; }else{  echo "Pending"; } ?></button>
                                            </td>
                                            <!-- <td style="text-align:center;">
                                                <a><i class="feather icon-edit" style="font-size: 1.8rem;color:#c90d41;"></i></a>
                                                <br>
                                                <a href=""><i class="feather icon-truck" style="font-size: 1.8rem;color:#c90d41;"></i></a>
                                                
                                            </td> -->
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

<?php
    }
?>           
    
