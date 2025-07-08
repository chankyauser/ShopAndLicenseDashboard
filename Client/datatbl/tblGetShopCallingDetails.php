<?php
if(isset($_GET['pocketCd'])){
    session_start();
    include '../api/includes/DbOperation.php';
}

$userName=$_SESSION['SAL_UserName'];
$appName=$_SESSION['SAL_AppName'];
$electionName=$_SESSION['SAL_ElectionName'];
$developmentMode=$_SESSION['SAL_DevelopmentMode'];
$Calling_Category_Cd = 0;
$pocketCd = 0;
$from_Date = "";
$to_Date = "";

    if(isset($_GET['pocketCd'])){
        $pocketCd = $_GET['pocketCd'];
        echo $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else if(isset($_SESSION['SAL_Pocket_Cd'])){
        $pocketCd = $_SESSION['SAL_Pocket_Cd'];
    }else if(isset($_GET['pocketId'])){
        $pocketCd = $_GET['pocketId'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }

    if(isset($_GET['Calling_Category_Cd'])){
        $Calling_Category_Cd = $_GET['Calling_Category_Cd'];
        $_SESSION['SAL_Calling_Category_Cd'] = $Calling_Category_Cd;
    }else if(isset($_SESSION['SAL_Calling_Category_Cd'])){
        $Calling_Category_Cd = $_SESSION['SAL_Calling_Category_Cd'];    
    }else{
        $Calling_Category_Cd = 0;  
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


    if($Calling_Category_Cd == 0){
        $CallingCategoryCondition = " AND sm.Calling_Category_Cd <> '' ";
    }else{
        $CallingCategoryCondition = " AND sm.Calling_Category_Cd = $Calling_Category_Cd ";
    }


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
    ISNULL(sm.ShopContactNo_1, '') as ShopContactNo_1,
    ISNULL(sm.ShopContactNo_2, '') as ShopContactNo_2,
    ISNULL(sm.ShopCategory, '') as ShopCategory,
    ISNULL(sm.SRExecutive_Cd, 0) as SRExecutive_Cd,
    ISNULL(sm.ShopOutsideImage1, '') as ShopOutsideImage1,
	ISNULL(sm.ShopOutsideImage2, '') as ShopOutsideImage2,
	ISNULL(sm.ShopStatus, '') as ShopStatus,
    ISNULL(sm.SRAssignedDate, '') as SRAssignedDate,
	(SELECT BusinessCatName FROM BusinessCategoryMaster WHERE BusinessCat_Cd = sm.BusinessCat_Cd) as Nature_of_Business,
	ISNULL(sm.ShopLatitude, 0) as Latitude,
	ISNULL(sm.ShopLatitude, 0) as Longitude,
    (SELECT ISNULL(Calling_Category,'') FROM CallingCategoryMaster WHERE Calling_Category_Cd = sm.Calling_Category_Cd) as Calling_Category,
    (SELECT ISNULL(Call_Response,'') FROM Call_Response_Master WHERE Call_Response_Cd = cd.Call_Response_Cd) as Call_Response,
    ISNULL(CONVERT(varchar, cd.Call_DateTime, 23),'') as Call_DateTime,
    IsNULL(cd.AudioFile_Url,'') as AudioFile_Url,
    IsNull(cd.Executive_Cd, 0) as Executive_Cd,
    (SELECT ExecutiveName FROM Survey_Entry_Data..Executive_Master WHERE Executive_Cd = cd.Executive_Cd) as ExecutiveName,
    ISNULL(cd.CallRecordStatus,0) as CallRecordStatus,
    ISNULL(cd.CallDuration, '') as CallDuration,
    ISNULL(cd.AudioDuration, '') as AudioDuration,
    ISNULL(cd.GoodCall, '') as GoodCall,
    ISNULL(cd.UpdatedByUser, '') as UpdatedByUser,
    ISNULL(cd.UpdatedDate, '') as UpdatedDate
    FROM ShopMaster as sm
    INNER JOIN CallingDetails as cd
    ON cd.Shop_Cd = sm.Shop_Cd 
    WHERE sm.IsActive = 1
    $pocketCondition
    $CallingCategoryCondition
    AND CONVERT(VARCHAR, sm.SRAssignedDate ,120) BETWEEN '$fromDate' AND '$toDate'
   ;";

    $callingShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

    $db3=new DbOperation();
    $query3 ="SELECT 
    PocketName
    FROM PocketMaster WHERE Pocket_Cd = $pocketCd";
    $dataPocket = $db3->ExecutveQuerySingleRowSALData($query3, $electionName, $developmentMode);

    $db4=new DbOperation();
    $query4 ="SELECT 
    Calling_Category
    FROM CallingCategoryMaster WHERE Calling_Category_Cd = $Calling_Category_Cd";
    $dataCallingCategory = $db4->ExecutveQuerySingleRowSALData($query4, $electionName, $developmentMode);

?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Shop Survey Detail - <?php if($pocketCd != 0) {echo $dataPocket["PocketName"]; } else { echo "All";}?>
                    <?php if($Calling_Category_Cd != 0) {echo $dataCallingCategory["Calling_Category"]; }?> - (<?php echo sizeof($callingShopsSurveyMapAndListDetail); ?>)</h4>
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
                                <div id="mapCallingShops" style="margin-top: 15px;" class="height-500"></div>
                                
                            </div>
                            <div class="tab-pane" id="listIcon" aria-labelledby="listIcon-tab" role="tabpanel">

                                <?php 
                                    if (sizeof($callingShopsSurveyMapAndListDetail)>0){
                                ?>
                                    <div class="table-responsive">
                                        <table  id="data-list-view1" class="table w-100" style="padding: 0px !important;">
                                            <tbody>
                                           <?php 
                                                foreach($callingShopsSurveyMapAndListDetail as $shopData){ 
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
                                                                           <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" class="rounded" width="200" height="200" alt="Avatar" />
                                                                           <?php } 
                                                                           else { ?>   
                                                                           <img src="pics/shopDefault.jpeg" class="rounded" width="200" height="200" alt="Avatar" />
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
                                                                           <h6><?php echo "<b>Executive Name   :   </b>".$shopData["ExecutiveName"]; ?></h6>
                                                                           <h6><?php echo "<b>Calling Category :   </b>".$shopData["Calling_Category"]."<b>     &nbsp;&nbsp;&nbsp;&nbsp;Call Response :   </b>".$shopData["Call_Response"]; ?></h6>
                                                                           <h6><?php echo "<b>Calling Date :   </b>".$shopData["Call_DateTime"]."<b>     &nbsp;&nbsp;&nbsp;&nbsp;Call Duration :   </b>".$shopData["CallDuration"]."<b>&nbsp;&nbsp;&nbsp;&nbsp;";
                                                                           
                                                                           if($shopData["GoodCall"] == 1)
                                                                           { ?><span class="badge badge-success">Good Call
                                                                               <i class="feather icon-thumbs-up"></i>
                                                                           </span> <?php }?>
                                                                           </h6>
                                                                          
                                                                           <!-- <h6><?php //echo "Created On : ".$shopData["PLCreatedDate"]; ?></h6> -->
                                                                          
                                                                          
                                                                       
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