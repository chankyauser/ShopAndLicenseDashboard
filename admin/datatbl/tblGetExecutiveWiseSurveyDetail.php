<?php


    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else if(isset($_GET['nodeCd'])){
        $nodeCd = $_GET['nodeCd'];
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }else{
        $nodeCd = "All";
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }

    if(isset($_SESSION['SAL_Node_Name'])){
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = "All";
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
    
    if(isset($_GET['executiveCd'])){
        $executive_Cd = $_GET['executiveCd'];
        $_SESSION['SAL_Executive_Cd'] = $executive_Cd;
    }else if(isset($_SESSION['SAL_Executive_Cd'])){
        $executive_Cd = $_SESSION['SAL_Executive_Cd'];
    }else{
        $executive_Cd = 0;
        $_SESSION['SAL_Executive_Cd'] = $executive_Cd;
    }


    if($nodeCd == 'All'){
        $nodeCondition = " AND pm.Node_Cd <> ''  "; 
    }else{
        $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> ''  "; 
    }

    if($nodeName == 'All'){
        $nodeNameCondition = " AND nm.NodeName <> '' ";
    }else{
        $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
    }

  
    $fromDate = $from_Date." ".$_SESSION['StartTime'];;
    $toDate = $to_Date." ".$_SESSION['EndTime'];

   
?>




<?php
  $db2=new DbOperation();
    $query1 = "SELECT ISNULL(sm.Shop_Cd,0) as Shop_Cd, 
    ISNULL(sm.ShopName,'') as ShopName, 
    ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
    ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
    ISNULL(sm.ShopAddress_1,'') as ShopAddress_1, 
    ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
    ISNULL(sm.ShopLatitude,'0') as Latitude,
    ISNULL(sm.ShopLongitude,'0') as Longitude,
    ISNULL(convert(varchar, sm.AddedDate, 100),'') as AddedDate, 
    ISNULL(convert(varchar, sm.SurveyDate, 100),'') as SurveyDate, 
    ISNULL(sm.ShopStatus,'') as ShopStatus, 
    ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
    ISNULL((SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
    WHERE BusinessCat_Cd = sm.BusinessCat_Cd ),'') as Nature_of_Business
    FROM ShopMaster sm
    INNER JOIN PocketMaster pm ON ( sm.Pocket_Cd = pm.Pocket_Cd  
        AND pm.IsActive = 1
        AND CONVERT(VARCHAR, sm.SurveyDate ,120) BETWEEN '$fromDate' AND '$toDate' 
        AND sm.AddedBy = (SELECT UserName FROM Survey_Entry_Data..User_Master WHERE AppName = '$appName' AND Executive_Cd =  $executive_Cd AND Executive_Cd <> 0 ) 
        $nodeCondition
        
    )
    INNER JOIN NodeMaster nm ON pm.Node_Cd = nm.Node_Cd
    WHERE sm.IsActive = 1
    $nodeNameCondition";
    // echo $query1;
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    if($executive_Cd != 'All'){
        $db3=new DbOperation();
        $query3 ="SELECT ExecutiveName FROM Survey_Entry_Data..User_Master WHERE Executive_Cd = $executive_Cd AND Executive_Cd <> 0 ";
        $dataExecutive = $db3->ExecutveQuerySingleRowSALData($query3, $electionName, $developmentMode);
        if(sizeof($dataExecutive)>0){
            $executiveName = $dataExecutive["ExecutiveName"];
        }else{
            $executiveName = "";
        }
    }
?>

 <?php 
    if (sizeof($pocketShopsSurveyMapAndListDetail)>0){
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Shop Survey Detail  <?php if($executive_Cd != 'All' ){ if(!empty($executiveName)){ echo "  -  ".$executiveName; } }else{ echo "All"; } ?> - (<?php echo sizeof($pocketShopsSurveyMapAndListDetail); ?>)</h4>
                <h4 class="card-title" style="margin-right:15px;"><?php if(isset($_SESSION['SAL_Ward_No'])){ echo "Ward No : ".$_SESSION['SAL_Ward_No'];   } ?></h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                      
                   
                            <div class="table-responsive">
                                <table  id="data-list-view1" class="table w-100" style="padding: 0px !important;">
                                    <tbody>
                                   <?php 
                                        foreach($pocketShopsSurveyMapAndListDetail as $shopData){ 
                                    ?>
                                         <tr>
                                            <td>
                                                <div class="card card-employee-task" style="margin-bottom: -10px;">
                                                  
                                                   <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xl-11">
                                                                <div class="employee-task d-flex justify-content-between align-items-top">
                                                                   <div class="media">
                                                                       <div class="avatar mr-75">

                                                                       <?php if($shopData["ShopOutsideImage1"] != '')
                                                                        { ?>
                                                                           <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" class="rounded" width="170" height="170" alt="Avatar" />
                                                                           <?php } 
                                                                           else { ?>   
                                                                           <img src="pics/shopDefault.jpeg" class="rounded" width="170" height="170" alt="Avatar" />
                                                                           <?php } ?>
                                                                        </div>
                                                                           <div class="media-body my-10px">
                                                                              <h5 class="mb-0" style="color:#c90d41;margin-top: 10px;"> <?php echo $shopData["ShopName"]; ?>&nbsp;&nbsp;
                                                                               <?php 
                                                                              
                                                                                 if($shopData["ShopStatus"] == "Verified")
                                                                                 {
                                                                                     ?> &nbsp;&nbsp;<b style="color:green;"> 
                                                                                     <?php echo "Verified";
                                                                                     ?>  </b><i class="fa fa-check-circle" style="color:green;font-size:22px"></i><?php
                                                                                 }
                                                                                 else if($shopData["ShopStatus"] == "Pending")
                                                                                 {
                                                                                  ?>  &nbsp;&nbsp;<b style="color:#ff8c00;"> <?php
                                                                                     echo "Pending";
                                                                                     ?>   </b><i class="fa fa-exclamation-circle" style="color:#ff8c00;font-size:22px"></i> <?php
                                                                                 }
                                                                                 else if($shopData["ShopStatus"] == "In-Review")
                                                                                 {
                                                                                  ?>  &nbsp;&nbsp;<b style="color:grey;"> <?php
                                                                                     echo "In-Review";
                                                                                     ?>  </b><i class="fa fa-check-circle" style="color:grey;font-size:22px"></i> <?php
                                                                                 }
                                                                                else if($shopData["ShopStatus"] == "Rejected")
                                                                                {
                                                                                ?>  &nbsp;&nbsp;<b style="color:red;"> <?php
                                                                                   echo "Rejected";
                                                                                   ?>  </b><i class="fa fa-check-circle" style="color:Red;font-size:22px"></i> <?php
                                                                               }else if($shopData["ShopStatus"] == "Permission Denied")
                                                                                {
                                                                                ?>  &nbsp;&nbsp;<b style="color:red;"> <?php
                                                                                   echo "Permission Denied";
                                                                                   ?>  </b><i class="fa fa-check-circle" style="color:Red;font-size:22px"></i> <?php
                                                                               }else if($shopData["ShopStatus"] == "Non-Cooperative")
                                                                                {
                                                                                ?>  &nbsp;&nbsp;<b style="color:red;"> <?php
                                                                                   echo "Non-Cooperative";
                                                                                   ?>  </b><i class="fa fa-check-circle" style="color:Red;font-size:22px"></i> <?php
                                                                               }
                                                                               else
                                                                                {
                                                                                ?>   &nbsp;&nbsp;<b style="color:#ff8c00;"> <?php
                                                                                     echo "Pending";
                                                                                     ?>   </b><i class="fa fa-exclamation-circle" style="color:#ff8c00;font-size:22px"></i> <?php
                                                                               }
                                                                                
                                                                              ?>
                                                                            
                                                                            </h5>
                                                                            
                                                                               <h6><b><?php echo $shopData["ShopKeeperName"]; ?> - <?php echo $shopData["ShopKeeperMobile"]; ?></b></h6>
                                                                               <h6><?php echo $shopData["Nature_of_Business"]; ?></h6>
                                                                               <h6><?php echo $shopData["ShopAddress_1"].$shopData["ShopAddress_2"]; ?></h6>
                                                                               <h6><?php echo "<b>Shop Listed : </b>".$shopData["AddedDate"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                                                                                <h6><span style="margin-right:15px;"> <?php if(!empty($shopData["SurveyDate"])){ echo "<b>Survey Date : </b>".$shopData["SurveyDate"]; }  ?></span></h6>
                                                                           
                                                                           </div>
                                                                    
                                                                    </div>
                                                                    <div class="d-flex align-items-center">
                                                                       <small class="text-muted mr-75"></small>
                                                                       <div class="employee-task-chart-primary-1"></div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-xl-1 text-right">
                                                                 <?php $shop_Cd=$shopData["Shop_Cd"]; ?>
                                                                   <p></br><a href="tel:<?php echo $shopData["ShopKeeperMobile"];?>"><i class="feather icon-phone" style="font-size: 2.2rem;color:#c90d41;"></i></a></br></br>
                                                                   <a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 2.2rem;color:#c90d41;"></i></a></br></br>
                                                                   <a href="home.php?p=shop-license-tracking&shop_Cd=<?php echo $shop_Cd ?>"><i class="feather icon-eye" style="font-size: 2.2rem;color:#c90d41;"></i></a></p>
                                                            </div>
                                                          
                                                       </div>
                                                   </div>
                                                </div>
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

<?php 
    }
?>