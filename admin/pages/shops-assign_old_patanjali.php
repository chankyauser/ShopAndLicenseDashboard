 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
   
 </style>

<section id="dashboard-analytics">

<?php 
        if(!isset($_SESSION['SAL_Calling_Type'])){
            $callingType = "Survey";
            $_SESSION['SAL_Calling_Type'] = $callingType;
        }else{
            $callingType = $_SESSION['SAL_Calling_Type'];
        }
        
        // $currentDate = date('Y-m-d');
        // $curDate = date('Y');
        // $assign_date = $currentDate;

        $assign_date = '';
        if(isset($_GET['assignDate'])){
            $assign_date = $_GET['assignDate'];
        }else{
            if(!isset($_SESSION['SAL_Assign_Date'])){
                $currentDate = date('Y-m-d');
                $curDate = date('Y');
                $assign_date = $currentDate;
            }else{
                $assign_date = $_SESSION['SAL_Assign_Date'];
            }
            
        }

        // if($assign_date < date('Y-m-d')){
        //     $assign_date = date('Y-m-d');
        //     $_SESSION['SAL_Assign_Date'] = $assign_date;
        // }

        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Survey Assign</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                       
                            <div class="row">
                                <input type="hidden" name="electionName" value="<?php echo $electionName; ?>">
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-calling-type.php'; ?>
                                </div>
                                <div class="col-md-4 col-12" style="display: none;">
                                    <?php //include 'dropdown-calling-category.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="assign_date">Assign Date</label>
                                        <input type='text' name="assign_date" value="<?php echo $assign_date;?>" class="form-control pickadate-disable-assigndates" onchange="setAssignDateInSession()"  />
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4 col-12">
                                    <?php include 'dropdown-assign-executive-name.php'; ?>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="shops">Assign Shops</label>
                                        <input type="text" class="form-control" name="shopsAssignCount" value="" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12" >
                                   <!--  <div class="form-group">
                                        <label for="pockets">Selected Pockets</label>
                                        
                                    </div> -->
                                </div>
                                <input type="hidden" class="form-control" name="pocketsCount" value="" disabled>
                                <input type="hidden" class="form-control" name="shopsCount" value="" disabled>
                                <div class="col-md-2 col-12">
                                   <!--  <div class="form-group">
                                        <label for="shops">Selected Shops</label>
                                        <input type="text" class="form-control" name="shopsCount" value="" disabled>
                                    </div> -->
                                </div>

                                

                                <div class="col-md-2 col-12 text-right"  style="margin-top: 25px;">
                                     <div class="form-group">
                                        <input type="hidden" class="form-control" name="multiplePockets" >
                                        <label for="refesh"></label>
                                        <button id="submitShopsAssignBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setAssignShopsToExecutiveByPockets()" >Assign</button>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-xl-12" >
                                    <span id="idAssignShopsMsgSuccess" class="btn btn-success" style="display: none;"></span>
                                    <span id="idAssignShopsMsgFailure" class="btn btn-danger" style="display: none;"></span>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $dataSurveyAssignSummary = array();
        $db3=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
        }else{
            $nodeName = "All";
        }
        
        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
        }else{
            $nodeCd = "All";
        }
        
        if(isset($_SESSION['SAL_Calling_Category_Cd'])){
            $callingCategoryCd = $_SESSION['SAL_Calling_Category_Cd'];
        }

        if($nodeName == 'All'){
            $nodeNameCondition = " AND nm.NodeName <> '' ";
        }else{
            $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
        }

        if($nodeCd == 'All'){
            $nodeWardCondition = " AND pm.Node_Cd <> '' ";
        }else{
            $nodeWardCondition = " AND pm.Node_Cd = $nodeCd ";
        }

            // $query3 = "SELECT 
            //     ISNULL(sm.Pocket_Cd,0) as Pocket_Cd,
            //     ISNULL(pm.PocketName,'') as PocketName,
            //     ISNULL(pm.Node_Cd,0) as Node_Cd,
            //     sum(case when (sm.SRExecutive_Cd <> 0) then 1 else 0 end) as Assigned,
            //     sum(case when (sm.SRExecutive_Cd is null or sm.SRExecutive_Cd = 0) then 1 else 0 end) as NotAssigned,
            //     count(sm.Shop_Cd) as ShopCount

            //     FROM ShopMaster sm 
            //     LEFT JOIN PocketMaster pm
            //     ON sm.Pocket_Cd = pm.Pocket_Cd
            //     LEFT JOIN NodeMaster nm
            //     ON nm.Node_Cd = pm.Node_Cd
            //     INNER JOIN ScheduleDetails sd 
            //     ON sd.Shop_Cd = sm.Shop_Cd
            //     WHERE CONVERT(VARCHAR,sd.CallingDate,23) = '$assign_date'
            //     $nodeNameCondition
            //     $nodeWardCondition
            //     AND sm.SRAssignedDate is null
            //     AND sd.Calling_Category_Cd = $callingCategoryCd
            //     GROUP BY sm.Pocket_Cd, pm.Node_Cd, pm.PocketName 
            //     having sum(case when (sm.SRExecutive_Cd is null or sm.SRExecutive_Cd = 0) then 1 else 0 end) > 0
            //     ";
    
            $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                     FROM (
                        SELECT 
                           sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                          sm.Pocket_Cd
                        FROM ScheduleDetails sd
                        INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                                AND sm.IsActive = 1
                            )
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                        WHERE st.ScheduleCall_Cd IS NULL
                        $nodeNameCondition
                        $nodeWardCondition
                      ) a,
                      PocketMaster pm, NodeMaster nm
                      WHERE pm.Pocket_Cd = a.Pocket_Cd
                      AND nm.Node_Cd = pm.Node_Cd
                     
                      GROUP BY a.Pocket_Cd,pm.PocketName,
                      nm.Ward_No,nm.NodeName
                      ORDER BY nm.Ward_No ";
                      $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
       
    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5> Shops Assigning for <?php echo $callingType; ?>  -  <?php echo date('d/m/Y',strtotime($assign_date)); ?>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered complex-headers">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Pocket Name</th>
                                        <th>Ward No</th>
                                        <th>Zone Office</th>
                                        <th>Shops</th>
                                        <?php 
                                           // if($callingType != "Calling"){
                                        ?>
                                            <th>Action</th>
                                        <?php
                                          //  }
                                        ?>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($dataSurveyAssignSummary as $key => $value) {
                                    ?>
                                        <tr>
                                            <td> 
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="<?php echo $value["Pocket_Cd"]; ?>,<?php echo $value["ShopCount"]; ?>" name="assignPockets" onclick="setSelectMultiplePockets()" >
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><?php echo $value["PocketName"]; ?></td>
                                            <td><?php echo "W-".$value["Ward_No"]; ?></td>
                                            <td><?php echo $value["NodeName"]; ?></td>
                                            <td><?php echo $value["ShopCount"]; ?></td>
                                            <?php 
                                                //if($callingType != "Calling"){
                                            ?>
                                                <td>
                                                    <a href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&pocktCd=<?php echo $value["Pocket_Cd"]; ?>&action=assign" ><i class="feather icon-layers" style="font-size: 1.5rem;color:#c90d41;" title="Assign Shops"></i></a>
                                                </td>
                                            <?php
                                                //}
                                            ?>
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

            $query4 = "SELECT
                    a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
                    em.MobileNo, lm.User_Type,
                    COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
                    COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
                    COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
                    COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
                    ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
                FROM
                (
                    SELECT st.ScheduleCall_Cd,
                    st.Shop_Cd, st.AssignExec_Cd, 
                    st.Calling_Category_Cd, st.ST_DateTime,
                    CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
                    CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
                    sm.Pocket_Cd
                    FROM ShopTracking st,
                    ShopMaster sm, PocketMaster pm 
                    WHERE CONVERT(VARCHAR,st.AssignDate,23)  = '$assign_date'
                    AND sm.Shop_Cd = st.Shop_Cd
                    AND pm.Pocket_Cd = sm.Pocket_Cd
                    AND st.Calling_Category_Cd in (SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                    AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                    AND sm.IsActive = 1
                ) a
                INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
                INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
                GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";

        $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Executive <?php echo $callingType; ?> Summary - <?php echo date('d/m/Y',strtotime($assign_date)); ?> </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered complex-headers">
                                <thead>
                                    <tr>
                                    
                                        <th colspan="2" style="text-align:center;">Executive </th>
                                        <th colspan="2" style="text-align:center;">Assigned</th>
                                        <th colspan="2" style="text-align:center;">Completed</th>
                                        <th colspan="2" style="text-align:center;">Last Active</th>
                                       
                                        
                                    </tr>
                                    <tr>
                                    
                                        <th style="text-align:center;">Sr.No.</th>
                                        <th style="text-align:center;">Executive Name</th>
                                        <th style="text-align:center;">Pockets</th>
                                        <th style="text-align:center;">Shops</th>
                                        <th style="text-align:center;">Pockets</th>
                                        <th style="text-align:center;">Shops</th>
                                        <th style="text-align:center;">Datetime</th>
                                        <th style="text-align:center;">Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $srNo=1;
                                        foreach ($dataAssignExeSummary as $key => $value) {
                                    ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $srNo++; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ExecutiveName"]; ?></br><?php echo $value["MobileNo"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["PocketCount"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ShopCount"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["PocketsCompleted"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ShopsCompleted"]; ?></td>
                                            <td style="text-align:center;"><?php if(!empty($value["LastActiveTime"])){ echo date('h:i a', strtotime($value["LastActiveTime"])); }  ?></td>
                                            <td style="text-align:center;">
                                                <a title="View" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=view" ><i class="feather icon-eye" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a title="Edit" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=edit" ><i class="feather icon-edit" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a title="Transfer" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=transfer" ><i class="feather icon-log-out" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;

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

</section>