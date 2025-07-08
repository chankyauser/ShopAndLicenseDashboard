<?php
        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        // $query = "SELECT
        //     ISNULL(a.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
        //     ISNULL(a.Shop_Cd,0) as Shop_Cd, 
        //     ISNULL(a.Calling_Category_Cd,0) as Calling_Category_Cd,
        //     ISNULL(a.ST_Exec_Cd,0) as ST_Exec_Cd,
        //     ISNULL(a.ST_Status,0) as ST_Status,
        //     ISNULL(a.ST_StageName,'') as ST_StageName,
        //     ISNULL(a.ST_Remark_1,'') as ST_Remark_1,
        //     ISNULL(a.ST_Remark_2,'') as ST_Remark_2,
        //     ISNULL(a.ST_Remark_3,'') as ST_Remark_3,
        //     ISNULL(CONVERT(VARCHAR,a.ST_DateTime,121),'') as ST_DateTime,
        //     ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
        //     ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
        //     ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,121),'') as Call_DateTime, 
        //     ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
        //     ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
        //     ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
        //     ISNULL(cd.GoodCall,0) as GoodCall, 
        //     ISNULL(cd.QC_Flag,0) as QC_Flag, 
        //     ISNULL(cd.Appreciation,0) as Appreciation, 
        //     ISNULL(cd.AudioListen,0) as AudioListen, 
        //     ISNULL(cd.Remark1,'') as Remark1, 
        //     ISNULL(cd.Remark2,'') as Remark2, 
        //     ISNULL(cd.Remark3,'') as Remark3,
        //     ISNULL(em.ExecutiveName,0) as ExecutiveName,
        //     ISNULL(em.MobileNo,'') as MobileNo,
        //     ISNULL(sm.Shop_UID,'') as Shop_UID,
        //     ISNULL(sm.ShopName,'') as ShopName,
        //     ISNULL(sm.ShopNameMar,'') as ShopNameMar,
        //     ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
        //     ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
        //     ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
        //     ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
        //     ISNULL(sm.ShopLatitude,'') as Latitude,
        //     ISNULL(sm.ShopLongitude,'') as Longitude,
        //     ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
        //     ISNULL(sm.ShopStatus,'') as ShopStatus,
        //     ISNULL(sm.ShopCategory,'') as ShopCategory,
        //     ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
        //     ISNULL(CONVERT(VARCHAR,sm.RenewalDate,23),0) as RenewalDate,
        //     ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
        //     ISNULL(ccm.Calling_Category,'') as Calling_Category,
        //     ISNULL(crm.Call_Response,'') as Call_Response
        // FROM (
        //     SELECT
        //         st.ScheduleCall_Cd, st.Shop_Cd, st.Calling_Category_Cd,
        //         st.ST_DateTime, st.ST_Exec_Cd, st.ST_Status, st.ST_StageName, 
        //         st.ST_Remark_1, st.ST_Remark_2, st.ST_Remark_3
        //     FROM ShopTracking st
        //     INNER JOIN ShopMaster sm on ( sm.Shop_Cd = st.Shop_Cd AND sm.IsActive=1 )
        //     INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        //     INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        //     WHERE $callingDateCondition
        //     $callingStatusCondition
        //     $callingCategoryCondition
        //     AND st.AssignExec_Cd = $executiveCd
        // ) a
        // LEFT JOIN CallingDetails cd on ( a.ScheduleCall_Cd = cd.ScheduleCall_Cd
        //     AND a.Shop_Cd = cd.Shop_Cd AND  a.Calling_Category_Cd = cd.Calling_Category_Cd
        // )
        // INNER JOIN ShopMaster sm on ( sm.Shop_Cd = a.Shop_Cd AND sm.IsActive=1 )
        // INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        // INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        // INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        // INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
        // INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
        // INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = cd.Executive_Cd";
        
        $query = "SELECT
                a.Shop_Cd, ISNULL(sm.ShopName,'') as ShopName, 
                ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
                ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
                ISNULL(pm.PocketName,'') as PocketName,
                ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
                ISNULL(CONVERT(VARCHAR,sm.RenewalDate,105),'') as RenewalDate,
                ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                ISNULL(bcm.BusinessCatName, '') as BusinessCatName, 
                ISNULL(sm.ShopStatus,'') as ShopStatus,
                ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate,
                ISNULL(a.AssignDate,'') as AssignDate,
                ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
                ISNULL(STRING_AGG(cd.Calling_Cd, ','),'Insert') as Action,
                ISNULL(STRING_AGG(cd.Calling_Cd, ','),'') as Calling_Cds,
                STRING_AGG(a.ScheduleCall_Cd, ', ') as ScheduleCall_Cds,
                STRING_AGG(ccm.Calling_Category_Cd, ', ') as Calling_Category_Cds,
                STRING_AGG(ccm.Calling_Category, ', ') as Calling_Categories,
                max(a.ST_Status) as ST_Status,
                max(cd.Call_Response_Cd) as Call_Response_Cd,
                ISNULL(max(cd.QC_Flag),0) as QC_Flag,
                ISNULL(max(cd.GoodCall),0) as GoodCall,
                max(crm.Call_Response) as Call_Response,
                max(cd.AudioFile_Url) as AudioFile_Url,
                ISNULL(CONVERT(VARCHAR,max(cd.Call_DateTime),121),'') as Call_DateTime
            FROM (
                SELECT
                    st.ScheduleCall_Cd, st.Shop_Cd, st.Calling_Category_Cd,
                    st.ST_DateTime, st.ST_Exec_Cd, st.ST_Status,CONVERT(VARCHAR,st.AssignDate,105) as AssignDate
                FROM ShopTracking st
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = st.Shop_Cd AND sm.IsActive=1 )
                INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                WHERE 
                $callingDateCondition
                $callingStatusCondition
                AND st.AssignExec_Cd = $executiveCd
                AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                    FROM CallingCategoryMaster WHERE Calling_Type = 'Calling')
            ) a
            LEFT JOIN CallingDetails cd on ( a.ScheduleCall_Cd = cd.ScheduleCall_Cd
                AND a.Shop_Cd = cd.Shop_Cd AND a.Calling_Category_Cd = cd.Calling_Category_Cd
            )
            INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd=a.Calling_Category_Cd
            INNER JOIN ShopMaster sm on sm.Shop_Cd=a.Shop_Cd
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
            LEFT JOIN Call_Response_Master crm on crm.Call_Response_Cd=cd.Call_Response_Cd
            $callingResponseCondition
            GROUP BY a.Shop_Cd,sm.ShopName, sm.ShopKeeperName, sm.ShopKeeperMobile,pm.PocketName,
            sm.IsCertificateIssued, sm.RenewalDate, sm.ShopOutsideImage1, a.AssignDate,
            bcm.BusinessCatName, sm.ShopStatus,sm.ShopStatusDate,sm.ShopStatusRemark
            ORDER BY Call_DateTime DESC;";
            // echo $query;
        $ShopListCallingData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

        
?>

<style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;}

    img.galleryimg:hover{
        transform: scale(4.2);
    }
</style>

        <!-- <div class="col-xl-12 col-md-12 col-xs-12"> -->
            <div class="card">
                        <div class="row">
                            <div class="col-xl-11 col-md-11 col-xs-11">
                                <div class="card-header">
                                    <h4 class="card-title">
                                    Calls Assigned - Shop Calling Details 
                                    </h4>
                                </div>
                            </div>
                        </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered complex-headers zero-configuration" width="100%">
                                    <thead>
                                        <tr>
                                        
                                            <th colspan="2" style="text-align:center;">Shop Detail </th>
                                            <th colspan="5" style="text-align:center;">Calling Detail</th>
                                            
                                        </tr>
                                        <tr>
                                        
                                            <th style="text-align:center;">Sr<br>No</th>
                                            <th style="text-align:left;">Shop Name</th>
                                            <th style="text-align:left;">Calling Status</th>
                                            <th style="text-align:center;">Audio</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">QC</th>
                                            <th style="text-align:center;">Action</th>
                                            <!-- <th style="text-align:center;">Edit</th>
                                            <th style="text-align:center;">Track</th>
                                            <th style="text-align:center;">Map</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $srno = 1;
                                        foreach($ShopListCallingData as $shoplist){
                                            ?>
                                        <tr>
                                            <td><?php echo $srno++; ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-xl-5">
                                                        <img class="galleryimg" src="<?php echo $shoplist['ShopOutsideImage1'];?>" height="100%" width="130" />        
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <h5><?php echo $shoplist['ShopName']?></h5>
                                                        <h6><span  class="badge badge-<?php if($shoplist['ShopStatus'] == "Verified"){ echo "success"; }else if($shoplist['ShopStatus'] == "In-Review"){ echo "info"; }else if($shoplist['ShopStatus'] == "Pending"){  echo "warning"; }else if($shoplist['ShopStatus'] == "Rejected"){ echo "danger"; }  ?>" title="Shop Status"><?php echo $shoplist['ShopStatus']; ?></span></h6>
                                                        <h6><?php echo $shoplist['ShopKeeperName']?></h6>
                                                        <h6><?php echo $shoplist['ShopKeeperMobile']?></h6>
                                                        <h6><?php echo $shoplist['BusinessCatName']?></h6>
                                                    </div>
                                                </div>
                                                
                                                
                                            </td>
                                            
                                            <td>
                                                <h5><?php echo "Assign Date : ".$shoplist['AssignDate'];?>
                                                <h6><?php if(!empty($shoplist["Call_DateTime"])){ echo "Calling Date : ".date('d/m/Y h:i a',strtotime($shoplist["Call_DateTime"])); } ?></h6>
                                                <h6><?php echo $shoplist["Calling_Categories"]; ?></h6>
                                                <h6><?php echo $shoplist["Call_Response"]; ?></h6>
                                            </td>
                                            <td>
                                                 <?php 
                                                    if(!empty($shoplist["AudioFile_Url"])){
                                                ?>
                                                    <audio controls preload="none">
                                                        <source src="<?php echo $shoplist["AudioFile_Url"]; ?>" type="audio/mpeg" />
                                                    </audio>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td>
                                                <span  class="badge badge-<?php if($shoplist["ST_Status"] == 1){ echo "success"; }else{ echo "danger"; }  ?>" title="Calling Status"><?php if($shoplist["ST_Status"] == 1){ echo "Done"; }else{  echo "Pending"; } ?></span>
                                            </td>
                                            <td>
                                                <span  class="badge badge-<?php if($shoplist["QC_Flag"] == 1){ echo "success"; }else{ echo "danger"; }  ?>" title="QC"><?php if($shoplist["QC_Flag"] == 1){ echo "QC"; }else{  echo ""; } ?></span>
                                                <span  class="badge badge-<?php if($shoplist["GoodCall"] == 1){ echo "success"; }else{ echo "danger"; }  ?>" title="Good Call"><?php if($shoplist["GoodCall"] == 1){ echo "Good Call"; }else{  echo ""; } ?></span>
                                            </td>
                                            <td>
                                                <a href="home.php?p=shoplist-edit&action=edit&Shop_Cd=<?php echo $shoplist["Shop_Cd"]; ?>&scheduleCallCds=<?php echo $shoplist["ScheduleCall_Cds"]; ?>&tab=calling-remark" title="Edit Calling Remark" target="_blank"><i class="feather icon-phone-call"></i></a>
                                                <a href="home.php?p=shoplist-edit&action=edit&Shop_Cd=<?php echo $shoplist["Shop_Cd"]; ?>" title="Edit Shop" target="_blank"><i class="feather icon-edit"></i></a>
                                                <!-- <a href="home.php?p=shoplist-view&action=view&Shop_Cd=<?php //echo $shoplist["Shop_Cd"]; ?>" target="_blank"><i style="margin-left:3px;" class="feather icon-eye"></i></a> -->
                                                <a href="home.php?p=shoplist-track&action=track&Shop_Cd=<?php echo $shoplist["Shop_Cd"]; ?>" title="Application Tracking"  target="_blank">
                                                    <i class="feather icon-truck"></i>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>