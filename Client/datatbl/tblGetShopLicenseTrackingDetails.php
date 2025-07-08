<section id="dashboard-analytics">
<?php
$db=new DbOperation();
$userName=$_SESSION['SAL_UserName'];
$appName=$_SESSION['SAL_AppName'];
$electionName=$_SESSION['SAL_ElectionName'];
$developmentMode=$_SESSION['SAL_DevelopmentMode'];

$currentDate = date('Y-m-d');


if(isset($_GET['Shop_Cd']) && $_GET['Shop_Cd'] != 0 && isset($_GET['action'])){

   $Shop_Cd = $_GET['Shop_Cd'];
   $action = $_GET['action'];

   $db=new DbOperation();
   $userName=$_SESSION['SAL_UserName'];
   $appName=$_SESSION['SAL_AppName'];
   $electionName=$_SESSION['SAL_ElectionName'];
   $developmentMode=$_SESSION['SAL_DevelopmentMode'];

   $currentDate = date('Y-m-d');
   $fromDate = $currentDate." ".$_SESSION['StartTime'];
   $toDate =$currentDate." ".$_SESSION['EndTime'];

   $searchvalue = '';
   if(isset($_POST['ShopName'])){
      $searchvalue = $_POST['ShopName'];
      $Shop_Cd = $searchvalue;
   }
      

    $shop_Details = array();

    $db1=new DbOperation();

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

   $query2 = "SELECT 
         COALESCE(Document_Cd, 0) as Document_Cd,
         COALESCE(FileURL, '') as FileURL
         FROM ShopDocuments WHERE Shop_Cd = $Shop_Cd AND IsActive = 1;";
         

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
                -- WHERE CCExecutive_Cd = 881 AND CCAssignedDate = CONVERT(VARCHAR, GETDATE(), 23) 
                WHERE CCExecutive_Cd = 881 AND CCAssignedDate = CONVERT(VARCHAR, '2022-06-01', 23) 
                AND sm.IsActive = 1;";
        

   $ShopListCallingData = $db->ExecutveQueryMultipleRowSALData($query5, $electionName, $developmentMode);


?>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">

                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" target="_blank">
                               <div class="row">

                                    <div class="col-sm-4">
                                       <div class="form-group">
                                       <label>Shop Name</label>
                                          <div class="controls"> 
                                          <select class="select2 form-control" required name="ShopName" id="ShopName" required>
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
                                                   <button style="margin-top:6px;" type="submit" class="btn btn-primary mr-1 mb-1" onclick="ShowDiv()">Track</button>
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





<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
         </div>
         <div class="card-content">
                     <div class="card-body">
                        <div class="col-md-12">
                           <div class="col-md-3" style="float:left;">

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
                           </br></br></br>

               
                           </div>

                        
                        <div class="col-md-12" style="float:left;">
                           <div class="img_div" style="float:left;">
                           <?php if($shop_Details["ShopOutsideImage2"] != '')
                           { ?>
                              <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shop_Details['ShopOutsideImage2'];?>" width="180" height="180">&nbsp;&nbsp;
                           <?php } ?>   
                           </div>
                           <div class="img_div" style="float:left;">
                           <?php if($shop_Details["ShopInsideImage1"] != '')
                           { ?>
                              <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shop_Details['ShopInsideImage1'];?>" width="180" height="180">&nbsp;&nbsp;
                           <?php } ?>   
                           </div>
                           <div class="img_div" style="float:left;">
                           <?php if($shop_Details["ShopInsideImage2"] != '')
                           { ?>
                              <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shop_Details['ShopInsideImage2'];?>" width="180" height="180">&nbsp;&nbsp;</br></br>
                           <?php } ?> 
                           </div>
               
                           <div class="img_div" style="float:left;"></br>
                           <?php foreach($shop_Documents as $shop_doc) 
                           { ?>
                           <?php if($shop_doc["FileURL"] != '')
                           { ?>
                                 <embed src="<?php echo $shop_doc['FileURL']; ?>" width="180" height="180">&nbsp;
                        <?php } 
                     }?> 
                        <p></p><p></P>
                           </div>
                        </div>
                     </div>

               <!-- </div>
            </div>
         </div>
      </div>
   </div>
</div> -->
<!-- First Div Ends Here -->

<!-- Main Tracking Second DIV Starts Here-->
<!-- <div class="row">
   <div class="col-md-12" style="text">
      <div class="card">
         <div class="col-md-12"> -->
            <!-- Nav Justified Starts -->
            <!-- <section id="nav-justified">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card overflow-hidden">
                        <div class="card-header">
                        </div>
                        <div class="card-content">-->
                           <div class="card-body"> 
                        
                              <!-- Tab panes -->
                              <div class="tab-content pt-1">
                                 <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">
                  
                                 <h5 style="color:#C90D41;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shop Details / License Renewal </h5>
                                    <div class="card-content">
                                    <div class="card-body">
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
                               
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- Nav Justified Ends -->
         </div>
      </div>
   </div>
</div>

<?php
}
?>