<?php
if(isset($_GET['pocketCd'])){
    session_start();
    include '../api/includes/DbOperation.php';
}

$userName=$_SESSION['SAL_UserName'];
$appName=$_SESSION['SAL_AppName'];
$electionName=$_SESSION['SAL_ElectionName'];
$developmentMode=$_SESSION['SAL_DevelopmentMode'];
$pocketCd = 0;
$from_Date = "";
$to_Date = "";

    if(isset($_GET['pocketCd'])){
        $pocketCd = $_GET['pocketCd'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else if(isset($_SESSION['SAL_Pocket_Cd'])){
        $pocketCd = $_SESSION['SAL_Pocket_Cd'];
    }else if(isset($_GET['pocketId'])){
        $pocketCd = $_GET['pocketId'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
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

    $fromDate = $from_Date." 00:00:00.000";
    $toDate = $to_Date." 23:59:59.999";

    $pocketCondition = "";
    if(isset($_SESSION['SAL_Pocket_Cd']) && $_SESSION['SAL_Pocket_Cd'] != 0)
    {
        $pocketCondition = " AND sm.Pocket_Cd = $pocketCd ";
    }
    else
    {
        $pocketCondition = " AND sm.Pocket_Cd <> '' ";
    }
    
    $db2=new DbOperation();
    $query1 = "SELECT 
    ISNULL(sm.Shop_Cd, 0) as Shop_Cd, 
    ISNULL(sm.ShopName, '') as ShopName, 
    ISNULL(sm.ShopKeeperName, '') as ShopKeeperName, 
    ISNULL(sm.ShopKeeperMobile, '') as ShopKeeperMobile, 
    ISNULL(sm.ShopAddress_1, '') as ShopAddress_1, 
    ISNULL(sm.ShopAddress_2, '') as ShopAddress_2,
    ISNULL(sm.ShopLatitude,'0') as Latitude,
    ISNULL(sm.ShopLongitude,'0') as Longitude,
    convert(varchar, sm.PLCreatedDate, 100) as PLCreatedDate, 
    ISNULL(sm.ShopStatus,'') as ShopStatus,
    ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
    (SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
    WHERE BusinessCat_Cd = sm.BusinessCat_Cd ) as Nature_of_Business
    FROM ShopMaster as sm
    INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
    INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
    WHERE CONVERT(VARCHAR, sm.PLCreatedDate ,120) BETWEEN '$fromDate' AND '$toDate'
    AND sm.IsActive = 1 
    AND pm.IsActive = 1 
    AND nm.IsActive = 1 
    $pocketCondition
    AND ISNULL(sm.ShopLatitude,'0')  <> '0' ;";
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    $db3=new DbOperation();
    $query3 ="SELECT 
    PocketName
    FROM PocketMaster WHERE Pocket_Cd = $pocketCd";
    $dataPocket = $db3->ExecutveQuerySingleRowSALData($query3, $electionName, $developmentMode);

?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shop Survey Detail - <?php if($pocketCd != 0) {echo $dataPocket["PocketName"]; } else { echo "All";}?> - (<?php echo sizeof($pocketShopsSurveyMapAndListDetail); ?>)</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="mapIcon-tab" data-toggle="tab" href="#mapIcon" aria-controls="home" role="tab" aria-selected="true"> <i class="feather icon-map"></i> Map View</a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="listIcon-tab" data-toggle="tab" href="#listIcon" aria-controls="profile" role="tab" aria-selected="false"><i class="feather icon-list"></i> List View</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="mapIcon" aria-labelledby="mapIcon-tab" role="tabpanel">
                                <div id="mapShopSurveyMap" style="margin-top: 15px;" class="height-500"></div>
                                
                            </div>
                            <div class="tab-pane" id="listIcon" aria-labelledby="listIcon-tab" role="tabpanel">

                                <?php 
                                    if (sizeof($pocketShopsSurveyMapAndListDetail)>0){
                                ?>
                                    <div class="table-responsive">
                                        <table  id="data-list-view1" class="table w-100" style="padding: 0px !important;">
                                            <tbody>
                                           <?php 
                                                foreach($pocketShopsSurveyMapAndListDetail as $shopData){ 
                                            ?>
                                                 <tr>
                                                    <td>
                                                        <div class="card card-employee-task" style="margin-bottom: -20px;">
                                                          
                                                           <div class="card-body">
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
                                                                           }
                                                                           else
                                                                            {
                                                                            ?>  &nbsp;&nbsp;<b style="color:black;"> <?php
                                                                               echo "";
                                                                               ?>  </b> <?php
                                                                           }
                                                                            
                                                                          ?>
                                                                        
                                                                        </h5>
                                                                         </br>
                                                                           <h6><?php echo $shopData["Nature_of_Business"]; ?></h6>
                                                                           <h6><b><?php echo $shopData["ShopKeeperName"]; ?> - <?php echo $shopData["ShopKeeperMobile"]; ?></b></h6>
                                                                           <h6><?php echo $shopData["ShopAddress_1"].$shopData["ShopAddress_2"]; ?></h6>
                                                                           <h6><?php echo "Created On : ".$shopData["PLCreatedDate"]; ?></h6>
                                                                          
                                                                          
                                                                       
                                                                       </div>
                                                                       <div style="float:right;">
                                                                           <?php $shop_Cd=$shopData["Shop_Cd"]; ?>
                                                                       <p></br><a href="tel:<?php echo $shopData["ShopKeeperMobile"];?>"><i class="feather icon-phone" style="font-size: 2.2rem;color:#c90d41;"></i></a></br></br>
                                                                       <a target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 2.2rem;color:#c90d41;"></i></a></br></br>
                                                                       <a href="home.php?p=shop-license-tracking&shop_Cd=<?php echo $shop_Cd ?>"><i class="feather icon-eye" style="font-size: 2.2rem;color:#c90d41;"></i></a></p>
                                                                      </div>
                                                                   </div>
                                                                   <div class="d-flex align-items-center">
                                                                       <small class="text-muted mr-75"></small>
                                                                       <div class="employee-task-chart-primary-1"></div>
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
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>