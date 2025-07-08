<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shopid']) && !empty($_GET['shopid']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $Shop_Cd = $_GET['shopid'];
        $srNo = $_GET['srNo'];



        $loginExecutiveCd = 0;
        $userId = $_SESSION['SAL_UserId'];
        if($userId != 0){
            $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
            if(sizeof($exeData)>0){
                $loginExecutiveCd = $exeData["Executive_Cd"];
            }
        }

        $query14 = "SELECT Type_SrNo, Calling_Type
            FROM CallingCategoryMaster 
            WHERE IsActive = 1
            GROUP BY Type_SrNo, Calling_Type";

        $CallingTypeDropDown = $db->ExecutveQueryMultipleRowSALData($query14, $electionName, $developmentMode);

        

            $queryTracking ="SELECT ScheduleCall_Cd,Shop_Cd, Calling_Category_Cd,ScheduleExe_Cd, ScheduleExeName, 
                CONVERT(VARCHAR,ScheduleDate,100) as ScheduleDate, 
                ScheduleReason,ISNULL(ScheduleRemark,'') as ScheduleRemark, 
                ISNULL(CONVERT(VARCHAR,AssignDate,23),'') as AssignDate, 
                ISNULL(ST_Cd,0) as ST_Cd, 
                ISNULL(AssignExec_Cd,0) as AssignExec_Cd, 
                ISNULL(Calling_Category,'') as Calling_Category, 
                ISNULL(Calling_Type,'') as Calling_Type, 
                ISNULL(AssignExeName,'') as AssignExeName, 
                ISNULL(AssignTempExec_Cd,0) as AssignTempExec_Cd, 
                ISNULL(ST_StageName,'') as ST_StageName,
                ISNULL(CONVERT(VARCHAR,ST_DateTime,100),'') as ST_DateTime, 
                ISNULL(ST_Exec_Cd,0) as ST_Exec_Cd, ISNULL(ST_ExeName,'') ST_ExeName, 
                ISNULL(ST_Status,0) as ST_Status, 
                ISNULL(ST_Remark_1,'') as ST_Remark_1,
                ISNULL(ST_Remark_2,'') as ST_Remark_2,
                ISNULL(ST_Remark_3,'') as ST_Remark_3,
                ISNULL(Calling_Cd,0) as Calling_Cd, ISNULL(Call_Response_Cd,0) as Call_Response_Cd, 
                ISNULL(CONVERT(VARCHAR,Call_DateTime,100),'') as Call_DateTime,
                ISNULL(AudioFile_Url,'') as AudioFile_Url, 
                ISNULL(CallingExe_Cd,0) as CallingExe_Cd, 
                ISNULL(CallingExeName,'') as CallingExeName, 
                ISNULL(AudioDuration,'') as AudioDuration, 
                ISNULL(GoodCall,0) as GoodCall, ISNULL(AudioListen,0) as AudioListen

                FROM View_ScheduleDetails 
                where Shop_Cd=$Shop_Cd";

        $shopTrackingDetails =  $db->ExecutveQueryMultipleRowSALData($queryTracking, $electionName, $developmentMode);
            // print_r($shopTrackingDetails);

        $shopData = $db->ExecutveQuerySingleRowSALData("SELECT ShopName, CONVERT(VARCHAR,SurveyDate,100) as SurveyDate FROM ShopMaster WHERE Shop_Cd = $Shop_Cd ", $electionName, $developmentMode);

    ?>

        <div class="row">
            <legend><b><?php echo $srNo.") "; ?>  <?php echo $shopData["ShopName"]; ?><?php if(!empty($shopData["SurveyDate"])){ echo " - ".date('d/m/Y',strtotime($shopData["SurveyDate"])); }  ?></b></legend>
            <div class="col-12 col-sm-12 col-md-12">
                <div class="table-responsive">
                <table class="table zero-configuration" width="100%">
                    <thead>
                        <tr>
                        
                            <th style="text-align:center;">Sr<br>No</th>
                            <th style="text-align:left;">Shop Schedule Detail</th>
                            <?php
                                foreach ($CallingTypeDropDown as $key => $CallingTypeValue) {
                                    $callingType = $CallingTypeValue["Calling_Type"];
                            ?>
                                <th style="text-align:center;"><?php echo $callingType; ?></th>
                            <?php
                                }
                            ?>
                             
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                            $sr_no = 1;
                            foreach($shopTrackingDetails as $value){
                            $st_Cd = $value["ST_Cd"];        
                            $scheduleCall_Cd = $value["ScheduleCall_Cd"];        
                            $sd_executive_Cd = $value["ScheduleExe_Cd"];        
                            $shop_Cd = $value["Shop_Cd"];        
                            $calling_Category_Cd = $value["Calling_Category_Cd"];        
                            $scheduleDate = $value["ScheduleDate"];        
                            $callingCategory = $value["Calling_Category"];        
                            $scheduleCallType = $value["Calling_Type"];        
                            $scheduleExeName = $value["ScheduleExeName"];        
                            $scheduleReason = $value["ScheduleReason"];        
                            $scheduleRemark = $value["ScheduleRemark"];        
                        ?>
                        <tr>
                            <td><?php echo $sr_no++; ?> 
                                <?php 
                                    if($st_Cd == 0 && $sd_executive_Cd == $loginExecutiveCd){
                                ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="setDeleteScheduledShopDetail(<?php echo $scheduleCall_Cd; ?>)"><i class="feather icon-trash-2 mr-50 font-medium-3"></i></a>
                                <?php
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <h6><b><?php  echo $scheduleDate; ?></b></h6>  
                                <h6><b><?php  echo $callingCategory; ?> </b></h6>   
                                <h6><?php  echo $scheduleReason; ?></h6>   
                                <h6><?php  echo $scheduleRemark; ?></h6>   
                                <h6 class="text-right"><?php  echo "Scheduled By: ".$scheduleExeName; ?></h6>   
                            </td>
                            <?php 
                                foreach ($CallingTypeDropDown as $key => $CallingTypeValue) {
                                    $callingType = $CallingTypeValue["Calling_Type"];
                                    if($scheduleCallType == $callingType){

                                        $AssignDate = $value["AssignDate"];
                                        $ST_DateTime = $value["ST_DateTime"];
                                        $ST_Status = $value["ST_Status"];
                                        $ST_StageName = $value["ST_StageName"];
                                        $ST_Remark_1 = $value["ST_Remark_1"];
                                        $ST_Remark_2 = $value["ST_Remark_2"];
                                        $ST_Remark_3 = $value["ST_Remark_3"];
                                        $ST_ExecutiveName = $value["ST_ExeName"];
                            ?>
                                <td>
                                    <?php if (!empty($AssignDate)){ ?> <h6><b><?php echo "Assigned on : ".$AssignDate; ?></b></h6> <?php } ?> 
                                    
                                    <?php if($ST_Status == 1){ ?>
                                        <h6><b><?php echo "Completed on : ".$ST_DateTime; ?></b></h6>
                                        <h6><?php  echo $ST_StageName; ?></h6>   
                                        <h6><?php  echo $ST_Remark_1; ?></h6>   
                                        <h6><?php  echo $ST_Remark_2; ?></h6>   
                                        <h6><?php  echo $ST_Remark_3; ?></h6>   
                                        <h6><?php  echo "Completed By: ".$ST_ExecutiveName; ?></h6> 
                                    <?php } ?>
                                </td>
                            <?php }else{ ?>
                                 <td></td>
                            <?php } ?>

                            <?php
                                }
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

