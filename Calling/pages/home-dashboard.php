

<div class="content-body">
    <section id="dashboard-analytics">

    <?php
            if(!isset($_SESSION['SAL_SHOP_LIST_CallingDateFilter'])){
                $callingDateFilter = "Today";
                $_SESSION['SAL_SHOP_LIST_CallingDateFilter'] = $callingDateFilter;
            }else{
                $callingDateFilter = $_SESSION['SAL_SHOP_LIST_CallingDateFilter'];
            }
            if(!isset($_SESSION['SAL_SHOP_LIST_CallingStatusFilter'])){
                $callingStatusFilter = "All";
                $_SESSION['SAL_SHOP_LIST_CallingStatusFilter'] = $callingDateFilter;
            }else{
                $callingStatusFilter = $_SESSION['SAL_SHOP_LIST_CallingStatusFilter'];
            }
            if(!isset($_SESSION['SAL_SHOP_LIST_CallingResponseFilter'])){
                $callingResponse = "All";
                $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'] = $callingResponse;
            }else{
                $callingResponse = $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'];
            }
            
            
            $currentDate = date('Y-m-d');
            
            $callingDate = $currentDate;
            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            
            $executiveCd = 0;
            $userId = $_SESSION['SAL_UserId'];
            if($userId != 0){
                $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
                if(sizeof($exeData)>0){
                    $executiveCd = $exeData["Executive_Cd"];
                }
            }else{
                session_unset();
                session_destroy();
                header('Location:../index.php?p=login'); 
            }

?>
    
      <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Calling Date</label>
                                            <select class="select2 form-control"  name="callingDateFilter" id="callingDateFilter">
                                                <option <?php echo $callingDateFilter == 'Today' ? 'selected=true' : '';?>  value="Today">Current Date</option>
                                                <option <?php echo $callingDateFilter == 'Previous' ? 'selected=true' : '';?>  value="Previous">Previous Date</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label>Calling Status</label>
                                            <select class="select2 form-control" name="callingStatusFilter" id="callingStatusFilter" >
                                                <option <?php echo $callingStatusFilter == 'All' ? 'selected=true' : '';?>  value="All">All</option>
                                                <option <?php echo $callingStatusFilter == 'Pending' ? 'selected=true' : '';?>  value="Pending">Pending</option>
                                                <option <?php echo $callingStatusFilter == 'Completed' ? 'selected=true' : '';?>  value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    

                                    <div class="col-12 col-md-4">
                                        <?php include 'dropdown-call-response.php';?>
                                    </div>


                                    <div class="col-12 col-md-2 text-right" style="margin-top: 26px;">
                                        <div class="form-group">
                                            <label for="update"></label>
                                            <button type="button" class="btn btn-primary" onclick="setCallAssignedListFilterData()">Refresh</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php 
        if($callingDateFilter == 'Today'){
           $callingDateCondition = " CONVERT(VARCHAR,st.AssignDate,23) = '$callingDate' ";
        }else{
            $callingDateCondition = " CONVERT(VARCHAR,st.AssignDate,23) < '$callingDate' ";
        }

        if($callingStatusFilter == 'Completed'){
            $callingStatusCondition = " AND ISNULL(st.ST_Status,0) = 1 ";
        }else if($callingStatusFilter == 'Pending'){
            $callingStatusCondition = " AND ISNULL(st.ST_Status,0) = 0 ";
        }else{
            $callingStatusCondition = "  ";
        }

         if($callingResponse == 'All'){
            $callingResponseCondition = "  ";
        }else if($callingResponse == 'Received'){
            $callingResponseCondition = " WHERE cd.Call_Response_Cd = 4 ";
        }else if($callingResponse == 'Others'){
            $callingResponseCondition = " WHERE cd.Call_Response_Cd <> 4 ";
        }

       
        // $query = "SELECT
        //             ISNULL(COUNT(*),0) as AssignedCalls,
        //             ISNULL(SUM(CASE WHEN cd.Calling_Cd is NULL then 1 ELSE 0 END),0) as PendingCalls,
        //             ISNULL(SUM(CASE WHEN cd.Calling_Cd is NOT NULL AND cd.Call_Response_Cd = 4 then 1 ELSE 0 END),0) as ReceivedCalls,
        //             ISNULL(SUM(CASE WHEN cd.Calling_Cd is NOT NULL AND cd.Call_Response_Cd <> 4 then 1 ELSE 0 END),0) as OtherCalls
        //         FROM (
        //             SELECT
        //                 st.ScheduleCall_Cd, st.Shop_Cd, st.Calling_Category_Cd,
        //                 st.ST_DateTime, st.ST_Exec_Cd, st.ST_Status
        //             FROM ShopTracking st
        //             INNER JOIN ShopMaster sm on ( sm.Shop_Cd = st.Shop_Cd AND sm.IsActive=1 )
        //             INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        //             INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        //             WHERE $callingDateCondition
        //             $callingStatusCondition
        //             
        //             AND st.AssignExec_Cd = $executiveCd
        //         ) a
        //         LEFT JOIN CallingDetails cd on ( a.ScheduleCall_Cd = cd.ScheduleCall_Cd
        //             AND a.Shop_Cd = cd.Shop_Cd AND  a.Calling_Category_Cd = cd.Calling_Category_Cd
        //         )
        //          $callingResponseCondition";

        $query = "SELECT
                ISNULL(COUNT(distinct(a.Shop_Cd)),0) as AssignedCalls,
                ISNULL(COUNT(distinct(cd.Shop_Cd)),0)  as CompletedCalls,
                (ISNULL(COUNT(distinct(a.Shop_Cd)),0) - ISNULL(COUNT(distinct(cd.Shop_Cd)),0) ) as PendingCalls
            FROM (
                SELECT
                    st.ScheduleCall_Cd, st.Shop_Cd, st.Calling_Category_Cd,
                    st.ST_DateTime, st.ST_Exec_Cd, st.ST_Status
                FROM ShopTracking st
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = st.Shop_Cd AND sm.IsActive=1 )
                INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                WHERE $callingDateCondition
                $callingStatusCondition
                
                AND st.AssignExec_Cd = $executiveCd
                AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                    FROM CallingCategoryMaster WHERE Calling_Type = 'Calling')
            ) a
            LEFT JOIN CallingDetails cd on ( a.ScheduleCall_Cd = cd.ScheduleCall_Cd
                AND a.Shop_Cd = cd.Shop_Cd AND a.Calling_Category_Cd = cd.Calling_Category_Cd
            )
            $callingResponseCondition;";

        $CallCountSummary = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        
    ?>

    <div class="row"  >

            <div class="col-xl-4 col-md-4 col-sm-12 col-12" >
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar bg-light-danger p-50  mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-phone avatar-icon p-50  mr-2"></i>
                                </div>  
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="text-white font-weight-bolder mb-0">Assigned Shops</h4>
                                <h5 class="text-white font-medium-2 mb-0"><?php echo $CallCountSummary['AssignedCalls'];?> </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar bg-light-danger p-50  mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-phone-call avatar-icon p-50  mr-2"></i>
                                </div>  
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="text-white font-medium-2 mb-0">Pending Shops</h4>
                                <h5 class="text-white font-weight-bolder mb-0"><?php echo $CallCountSummary['PendingCalls'];?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-12 col-12" style="">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar bg-light-danger p-50  mr-2">
                                <div class="avatar-content">
                                    <i class="feather icon-phone-forwarded avatar-icon p-50  mr-2"></i>
                                </div>  
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="text-white font-medium-2 mb-0">Completed Shops</h4>
                                <h5 class="text-white font-weight-bolder mb-0"> <?php echo $CallCountSummary['CompletedCalls'];?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           

    </div>

        <div id="shoplist-calling">
            <?php include 'datatbl/tblShopListCallingEdit.php'; ?>
        </div>


    </section>


</div>