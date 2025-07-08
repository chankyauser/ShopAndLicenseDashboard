<section id="dashboard-analytics">
<?php

$db=new DbOperation();
   $userName=$_SESSION['SAL_UserName'];
   $appName=$_SESSION['SAL_AppName'];
   $electionName=$_SESSION['SAL_ElectionName'];
   $developmentMode=$_SESSION['SAL_DevelopmentMode'];

   $currentDate = date('Y-m-d');
   $fromDate = $currentDate." ".$_SESSION['StartTime'];
   $toDate =$currentDate." ".$_SESSION['EndTime'];
   $searchvalue = '';

if(isset($_GET['Shop_Cd']) && $_GET['Shop_Cd'] != 0 && isset($_GET['action']))
{

   $Shop_Cd = $_GET['Shop_Cd'];
   $action = $_GET['action'];

}
else if(isset($_POST['ShopName']))
{
   $searchvalue = $_POST['ShopName'];
   $Shop_Cd = $searchvalue;

}
else
{
   $dbC =new DbOperation();
   $shopque = "SELECT Top 1 
   COALESCE(Shop_Cd, 0) as Shop_Cd,
   COALESCE(ShopName, '') as ShopName
   FROM ShopMaster";
   $shop_lst = $dbC->ExecutveQuerySingleRowSALData($shopque, $electionName, $developmentMode);

   $Shop_Cd = $shop_lst["Shop_Cd"];
   
}

    $db1=new DbOperation();
    $shop_Details = array();

    $query1 = "SELECT 
               COALESCE(ShopName, '') as ShopName,
               (SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
               WHERE BusinessCat_Cd = ShopMaster.BusinessCat_Cd ) as Nature_of_Business,
               COALESCE(ShopKeeperName, '') as ShopKeeperName,
               COALESCE(ShopKeeperMobile, '') as ShopKeeperMobile,
               COALESCE(ShopAddress_1, '') as ShopAddress_1,
               COALESCE(ShopAddress_2, '') as ShopAddress_2,
               COALESCE(ShopStatus, '') as ShopStatus,
               COALESCE(ShopCategory, '') as ShopCategory,
               COALESCE(MuncipalWN, '') as MuncipalWN,
               COALESCE(ShopInsideImage1, '') as ShopInsideImage1,
               COALESCE(ShopOutsideImage1, '') as ShopOutsideImage1,
               COALESCE(ShopInsideImage2, '') as ShopInsideImage2,
               COALESCE(ShopOutsideImage2, '') as ShopOutsideImage2,
               COALESCE(ShopLatitude, '') as ShopLatitude,
               COALESCE(ShopLongitude, '') as ShopLongitude
               FROM ShopMaster WHERE Shop_Cd = $Shop_Cd;";

   $shop_Details = $db1->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

   $shop_Documents = array();
   $db2 = new DbOperation();

   $query2 = "  SELECT 
   COALESCE(sm.Document_Cd, 0) as Document_Cd,
   COALESCE(sm.FileURL, '') as FileURL,
   (SELECT DocumentName FROM ShopDocumentMaster WHERE Document_Cd = sm.Document_Cd) as DocumentName
   FROM ShopDocuments as sm
   WHERE sm.Shop_Cd = $Shop_Cd ;";     

   $shop_Documents = $db2->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

   $schedule_Details = array();
   $db3 = new DbOperation();

   $query3 = "SELECT 
         COALESCE(ST_Cd, 0) as ST_Cd,
         COALESCE(ST_StageName, '') as TrackStageName,
         convert(varchar, UpdatedDate, 100) as UpdatedDate
         FROM ShopTracking WHERE Shop_Cd = $Shop_Cd
         ORDER BY UpdatedDate;";
         
   $schedule_Details = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);


                $query5 = "SELECT 
                COALESCE(sm.Shop_Cd, '') as Shop_Cd, 
                COALESCE(sm.ShopName, '') as ShopName
                FROM ShopMaster AS sm 
                WHERE sm.IsActive = 1;";
        
   $ShopListCallingData = $db->ExecutveQueryMultipleRowSALData($query5, $electionName, $developmentMode);


?>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">

                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                               <div class="row">

                                    <div class="col-sm-4">
                                       <div class="form-group">
                                       <label>Shop Name</label>
                                          <div class="controls"> 
                                          <select class="select2 form-control" required name="ShopName" id="ShopName" style="height:35px;" required>
                                             <option value="">--Select--</option>
                                             <?php if (sizeof($ShopListCallingData)>0) 
                                                      {
                                                         foreach($ShopListCallingData as $key => $value)
                                                         {
                                                               if($Shop_Cd == $value["Shop_Cd"])
                                                               {
                                                               ?> 
                                                                  <option selected="true" value="<?php echo $value['Shop_Cd'];?>"><?php echo $value['ShopName'];?></option>
                                                                  <?php }
                                                                  else
                                                                  { ?>
                                                                  <option value="<?php echo $value["Shop_Cd"];?>"><?php echo $value["ShopName"];?></option>
                                                         <?php }
                                                         }
                                                      } ?>

                                          </select>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-4 text-left">
                                          <div class="form-group">
                                             <br>
                                             <div class="controls"> 
                                                   <button type="submit" class="btn btn-primary" style="padding: 8px 10px;" onclick="ShowDiv()">Track <i class="fi fi-rs-truck mr-10"></i></button>
                                             </div>
                                          </div>
                                    </div>

                              </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

                <section id="number-tabs">

<main class="main">
        <!-- <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Fillter
                </div>
            </div>
        </div> -->
        <div class="container mb-30 mt-30">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <a class="shop-filter-toogle" href="#">
                        <span class="fi-rs-filter mr-5"></span>
                        Filters
                        <i class="fi-rs-angle-small-down angle-down"></i>
                        <i class="fi-rs-angle-small-up angle-up"></i>
                    </a> -->
                    <div class="shop-product-fillter-header">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">Basic Information</h5>
                                    <div class="categories-dropdown-wrap font-heading">
                                    <?php if($shop_Details["ShopOutsideImage1"] != '')
                           { ?>
                           <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shop_Details['ShopOutsideImage1'];?>" width="180" height="180">
                           <?php }
                           else 
                           { ?>
                              <img src="pics/shopDefault.jpeg" width="180" height="180" alt="Avatar" />
                           <?php } ?>
                           </div>
                           <div class="col-md-9" style="float:left;margin-left:0px;">
                           <h5 style="font-size:18px;color:#C90D41;"><?php echo $shop_Details['ShopName'];?> &nbsp;&nbsp;
                        
                        <?php if($shop_Details["ShopStatus"] == "Verified")
                              {
                                 ?> &nbsp;&nbsp;<b style="color:green;"> 
                                 <?php echo "Verified";
                                 ?>  </b><i class="fa fa-check-circle" style="color:green;font-size:22px"></i><?php
                              }
                              else if($shop_Details["ShopStatus"] == "Pending")
                              {
                              ?>  &nbsp;&nbsp;<b style="color:#ff8c00;"> <?php
                                 echo "Pending";
                                 ?>   </b><i class="fa fa-exclamation-circle" style="color:#ff8c00;font-size:22px"></i> <?php
                              }
                              else if($shop_Details["ShopStatus"] == "In-Review")
                              {
                              ?>  &nbsp;&nbsp;<b style="color:grey;"> <?php
                                 echo "In-Review";
                                 ?>  </b><i class="fa fa-check-circle" style="color:grey;font-size:22px"></i> <?php
                              }
                              else if($shop_Details["ShopStatus"] == "Rejected")
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
                              ?> </h5>
                              <!-- <div style="float:right;">
                                 <a href="tel:<?php echo $shop_Details["ShopKeeperMobile"];?>"><i class="feather icon-phone" style="font-size: 2.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;
                                 <a href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shop_Details['ShopLatitude'].','.$shop_Details['ShopLongitude'].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 2.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;
                              </div> -->
                                                                  </br>
                              <h6 style="font-size:15px;"><?php echo $shop_Details['Nature_of_Business'];?> </h6>
                              <h6 style="font-size:15px;"><b><?php echo $shop_Details["ShopKeeperName"]; ?> - <?php echo $shop_Details['ShopKeeperMobile'];?></b></h6>
                              <h6 style="font-size:15px;"><?php echo $shop_Details['ShopAddress_1'].$shop_Details['ShopAddress_2'];?> </h6>
                              <h6 style="font-size:15px;"><?php echo $shop_Details['ShopCategory'];?> </h6>
                              <h6 style="font-size:15px;"><?php echo $shop_Details['MuncipalWN'];?></h6>
                                    </div>
                                </div>
                            </div>

                            <?php if(sizeof($shop_Documents) > 0) { ?>
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <!-- <h5 class="mb-30">Shop Dcouments</h5> -->
                                    <div class="d-flex">
                                        
                                    <div class="sidebar-widget widget_instagram mb-50">
                                <h5 class="mb-30">Shop Dcouments</h5>
                                <div class="instagram-gellay">
                                    <ul class="insta-feed">
                                   
                                       <?php foreach($shop_Documents as $key=> $val) { ?>
                                        <li>
                                            <a href="#"><img class="border-radius-5" src="<?php echo $val['FileURL'];?>" width="100" height="100" alt="" /></a>
                                            <p> <?php echo $val['DocumentName'];?> </p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <?php if(sizeof($ShopListCallingData) > 0) { ?>
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">Calling Information</h5>
                                    <div class="d-flex">
                                        
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if(sizeof($schedule_Details) > 0) { ?>
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                                <div class="card">
                                    <h5 class="mb-30">Shop Tracking</h5>
                                    <div class="sidebar-widget widget-tags">
                                    <ul class="activity-timeline timeline-left list-unstyled">

<?php 
foreach($schedule_Details as $survey_det)
{ 
    if( $survey_det["TrackStageName"] != '' && $survey_det["UpdatedDate"] != '' )
    {
       ?>

        <li>
        
            <?php if($survey_det["TrackStageName"] == 'Establishment Listing') 
            {?>
                  <div class="timeline-icon bg-success">
            <?php }
            else if($survey_det["TrackStageName"] == 'Establishment survey') 
            {?>
                  <div class="timeline-icon bg-success">
            <?php }
            else if($survey_det["TrackStageName"] == 'Document verification call') 
            {?>
                  <div class="timeline-icon bg-warning">
            <?php }
            else if($survey_det["TrackStageName"] == 'Document rejected') 
            {?>
                  <div class="timeline-icon bg-danger">
            <?php }
            else if($survey_det["TrackStageName"] == 'Re-visit appointment schedule') 
            {?>
                  <div class="timeline-icon bg-success">
            <?php }
            else if($survey_det["TrackStageName"] == 'Document collection') 
            {?>
                  <div class="timeline-icon bg-info">
            <?php }
            else if($survey_det["TrackStageName"] == 'Document verification call') 
            {?>
                  <div class="timeline-icon bg-warning">
            <?php }
            else if($survey_det["TrackStageName"] == 'Application verfication complete') 
            {?>
                     <div class="timeline-icon bg-info">
            <?php }
            else if($survey_det["TrackStageName"] == 'Licence fee paid') 
            {?>
                  <div class="timeline-icon bg-success">
            <?php }
            else if($survey_det["TrackStageName"] == 'Licence issue') 
            {?>
                  <div class="timeline-icon bg-info">
            <?php }
            else {?>
                  <div class="timeline-icon bg-success">
            <?php } ?>


                
         <?php if($survey_det["TrackStageName"] == 'Establishment Listing') {?>
                  <i class="feather icon-book font-medium-2"></i>
         <?php } 
         else if($survey_det["TrackStageName"] == 'Establishment survey') 
         {?>
               <i class="feather icon-book font-medium-2"></i>
         <?php } 
          else if($survey_det["TrackStageName"] == 'Document verification call') 
         {?>
               <i class="feather icon-phone font-medium-2"></i>
            <?php } 
         else if($survey_det["TrackStageName"] == 'Document rejected')
         {?>
               <i class="feather icon-x-square font-medium-2"></i>
         <?php }  
         else if($survey_det["TrackStageName"] == 'Re-visit appointment schedule')
         {?>
               <i class="feather icon-book font-medium-2"></i>
         <?php } 
         else if($survey_det["TrackStageName"] == 'Document collection') 
         {?>
               <i class="feather icon-clipboard font-medium-2"></i>
         <?php } 
         else if($survey_det["TrackStageName"] == 'Document verification call') 
         {?>
                  <i class="feather icon-phone font-medium-2"></i>
         <?php }
         else if($survey_det["TrackStageName"] == 'Application verfication complete') 
         {?>
               <i class="feather icon-check font-medium-2"></i>
         <?php }
         else if($survey_det["TrackStageName"] == 'Licence fee paid') 
         {?>
               <i class="feather icon-dollar-sign font-medium-2"></i>
         <?php }
         else if($survey_det["TrackStageName"] == 'Licence issue') 
         {?>
                   <i class="feather icon-check-square font-medium-2"></i>
         <?php }
         else {?>
               <i class="feather icon-check font-medium-2"></i>
         <?php } ?>

            
            </div>
            <div class="timeline-info">
                <p class="font-weight-bold"><?php echo $survey_det["TrackStageName"]; ?></p>
                <span><?php echo $survey_det["UpdatedDate"]; ?></span>
            </div>
            <small class=""></small>
        </li>

      <?php } 
   } ?>
       
    </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
</div>
</div>
</main>