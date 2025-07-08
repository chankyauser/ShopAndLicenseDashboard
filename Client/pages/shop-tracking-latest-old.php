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
else if(isset($_SESSION['SAL_Shop_Cd']) && $_SESSION['SAL_Shop_Cd'] != 0)
{
    $searchvalue = $_SESSION['SAL_Shop_Cd'];
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

//     $query1 = "SELECT 
//                COALESCE(ShopName, '') as ShopName,
//                (SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
//                WHERE BusinessCat_Cd = ShopMaster.BusinessCat_Cd ) as Nature_of_Business,
//                COALESCE(ShopKeeperName, '') as ShopKeeperName,
//                COALESCE(ShopKeeperMobile, '') as ShopKeeperMobile,
//                COALESCE(ShopAddress_1, '') as ShopAddress_1,
//                COALESCE(ShopAddress_2, '') as ShopAddress_2,
//                COALESCE(ShopStatus, '') as ShopStatus,
//                COALESCE(ShopCategory, '') as ShopCategory,
//                COALESCE(MuncipalWN, '') as MuncipalWN,
//                COALESCE(ShopInsideImage1, '') as ShopInsideImage1,
//                COALESCE(ShopOutsideImage1, '') as ShopOutsideImage1,
//                COALESCE(ShopInsideImage2, '') as ShopInsideImage2,
//                COALESCE(ShopOutsideImage2, '') as ShopOutsideImage2,
//                COALESCE(ShopLatitude, '') as ShopLatitude,
//                COALESCE(ShopLongitude, '') as ShopLongitude
//                FROM ShopMaster WHERE Shop_Cd = $Shop_Cd;";

//    $shop_Details = $db1->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

//    $shop_Documents = array();
//    $db2 = new DbOperation();

//    $query2 = "  SELECT 
//    COALESCE(sm.Document_Cd, 0) as Document_Cd,
//    COALESCE(sm.FileURL, '') as FileURL,
//    (SELECT DocumentName FROM ShopDocumentMaster WHERE Document_Cd = sm.Document_Cd) as DocumentName
//    FROM ShopDocuments as sm
//    WHERE sm.Shop_Cd = $Shop_Cd ;";     

//    $shop_Documents = $db2->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

//    $schedule_Details = array();
//    $db3 = new DbOperation();

//    $query3 = "SELECT 
//          COALESCE(ST_Cd, 0) as ST_Cd,
//          COALESCE(ST_StageName, '') as TrackStageName,
//          convert(varchar, UpdatedDate, 100) as UpdatedDate
//          FROM ShopTracking WHERE Shop_Cd = $Shop_Cd
//          ORDER BY UpdatedDate;";
         
//    $schedule_Details = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);


                $query5 = "SELECT 
                COALESCE(sm.Shop_Cd, '') as Shop_Cd, 
                COALESCE(sm.ShopName, '') as ShopName
                FROM ShopMaster AS sm 
                WHERE sm.IsActive = 1
                ORDER BY sm.ShopName ASC;";
        
   $ShopListCallingData = $db->ExecutveQueryMultipleRowSALData($query5, $electionName, $developmentMode);


?>

<section class="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="position-relative newsletter-inner">
                            <div class="newsletter-content">
                                <h4 class="mb-0 mt-0">
                                   Search Shop Details <br />
                                   
                                </h4>
                                <p class="mb-8">Start tracking details of shop @<span class="text-brand">Bazaar Trace</span></p>
                                
                                <header class="header-area header-style-1 header-height-2">
    
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <!-- <div class="logo logo-width-1">
                        <a href="index.html"><img src="assets/imgs/theme/logo.svg" alt="logo" /></a>
                    </div> -->
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="#">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <select class="select2 form-control" required name="ShopName" id="ShopName" width="400px;">
                                    <option>Search by Shop Name</option>
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
                              <button class="btn" type="submit" onclick="showShopTracking()">Search</button>
                            </form>
                        </div>
                        </div></div></div></div></header>

                       

                                    <!-- <button class="btn" type="submit">Search</button>
                                </form> -->
                            </div>
                            <img src="assets/imgs/banner/banner-13.png" alt="newsletter" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- <div class="row">
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
                                                   <button type="submit" class="btn btn-primary" style="padding: 8px 10px;" onclick="showShopTracking()">Track <i class="fi fi-rs-truck mr-10"></i></button>
                                             </div>
                                          </div>
                                    </div>

                              </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> -->

                <section id="number-tabs">

<main class="main">

<?php 

if(isset($_SESSION['SAL_Shop_Cd']) && !empty($_SESSION['SAL_Shop_Cd'])){


    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');


    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    $shopDetail = array();

    $shopCd = 0;

    if(isset($_SESSION['SAL_Shop_Cd']) && !empty($_SESSION['SAL_Shop_Cd'])){
       $shopCd = $_SESSION['SAL_Shop_Cd'];
    }


    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $userData = $db->ExecutveQuerySingleRowSALData("SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
        if(sizeof($userData)>0){
            $_SESSION['SAL_UserName'] = $userData["UserName"];
        }
    }else{
        session_unset();
        session_destroy();
        header('Location:../index.php?p=login');
    }


    $db2=new DbOperation();
    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $query1 = "SELECT 
            ISNULL(ShopMaster.Shop_Cd, 0) as Shop_Cd, 
            ISNULL(ShopMaster.Shop_UID, '') as Shop_UID, 
            ISNULL(ShopMaster.ShopName, '') as ShopName, 
            ISNULL(ShopMaster.ShopNameMar, '') as ShopNameMar, 

            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(ShopMaster.ShopCategory, '') as ShopCategory, 

            ISNULL(PocketMaster.PocketName,'') as PocketName,
            ISNULL(NodeMaster.NodeName,'') as NodeName,
            ISNULL(NodeMaster.Ward_No,0) as Ward_No,
            ISNULL(NodeMaster.Area,'') as WardArea,

            ISNULL(ShopMaster.ShopAddress_1, '') as ShopAddress_1, 
            ISNULL(ShopMaster.ShopAddress_2, '') as ShopAddress_2, 

            ISNULL(ShopMaster.ShopKeeperName, '') as ShopKeeperName, 
            ISNULL(ShopMaster.ShopKeeperMobile, '') as ShopKeeperMobile,

            ISNULL(ShopMaster.QC_Flag, 0) as QC_Flag,
            ISNULL(CONVERT(VARCHAR, ShopMaster.QC_UpdatedDate, 100), '') as QC_UpdatedDate, 

            ISNULL(ShopMaster.LetterGiven, '') as LetterGiven, 
            ISNULL(ShopMaster.IsCertificateIssued, 0) as IsCertificateIssued, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.RenewalDate, 105), '') as RenewalDate, 
            ISNULL(ShopMaster.ParwanaDetCd, 0) as ParwanaDetCd, 
            ISNULL(pd.PDetNameEng,'') as PDetNameEng,
            
            ISNULL(ShopMaster.ShopOwnStatus, '') as ShopOwnStatus, 
            ISNULL(ShopMaster.ShopOwnPeriod, 0) as ShopOwnPeriod, 
            ISNULL(ShopMaster.ShopOwnerName, '') as ShopOwnerName, 
            ISNULL(ShopMaster.ShopOwnerMobile, '') as ShopOwnerMobile, 
            ISNULL(ShopMaster.ShopContactNo_1, '') as ShopContactNo_1, 
            ISNULL(ShopMaster.ShopContactNo_2, '') as ShopContactNo_2,
            ISNULL(ShopMaster.ShopEmailAddress, '') as ShopEmailAddress, 
            ISNULL(ShopMaster.ShopOwnerAddress, '') as ShopOwnerAddress,

            ISNULL(ShopMaster.MaleEmp, '') as MaleEmp,
            ISNULL(ShopMaster.FemaleEmp, '') as FemaleEmp,
            ISNULL(ShopMaster.OtherEmp, '') as OtherEmp,
            ISNULL(ShopMaster.ContactNo3, '') as ContactNo3,
            ISNULL(ShopMaster.GSTNno, '') as GSTNno,
            ISNULL(ShopMaster.ConsumerNumber, '') as ConsumerNumber, 

            ISNULL(ShopMaster.ShopOutsideImage1, '') as ShopOutsideImage1, 
            ISNULL(ShopMaster.ShopOutsideImage2, '') as ShopOutsideImage2, 
            ISNULL(ShopMaster.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(ShopMaster.ShopInsideImage2,'') as ShopInsideImage2,

            ISNULL(ShopMaster.ShopDimension, '') as ShopDimension, 

            ISNULL(ShopMaster.ShopStatus, '') as ShopStatus, 
            ISNULL(stm.TextColor, '') as ShopStatusTextColor, 
            ISNULL(stm.FaIcon, '') as ShopStatusFaIcon, 
            ISNULL(stm.IconUrl, '') as ShopStatusIconUrl, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.ShopStatusDate, 100), '') as ShopStatusDate, 
            ISNULL(ShopMaster.ShopStatusRemark, '') as ShopStatusRemark, 

            ISNULL(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
            ISNULL(bcm.BusinessCatName, '') as BusinessCatName, 
            ISNULL(bcm.BusinessCatNameMar, '') as BusinessCatNameMar,

            ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
            ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,

            ISNULL((SELECT Remarks  FROM Survey_Entry_Data..User_Master 
                WHERE UserName = ShopMaster.AddedBy),'') as ListingExecutive,
            ISNULL((SELECT Remarks  FROM Survey_Entry_Data..User_Master 
                WHERE UserName = ShopMaster.SurveyBy),'') as SurveyExecutive,

            ISNULL(ShopMaster.AddedBy,'') as AddedBy,
            ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
            ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
            ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate
            
        FROM ShopMaster 
        INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 )
        INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
        LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=ShopMaster.ShopStatus)
        LEFT JOIN BusinessCategoryMaster AS bcm ON (ShopMaster.BusinessCat_Cd = bcm.BusinessCat_Cd) 
        LEFT JOIN ShopAreamaster AS sam ON (ShopMaster.ShopArea_Cd = sam.ShopArea_Cd) 
        LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
        WHERE ShopMaster.IsActive = 1 AND ShopMaster.Shop_Cd = $shopCd
        ORDER BY ShopMaster.SurveyDate ASC;";
        // echo $query1;
        $shopDetail = $db2->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

        $query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                ISNULL(sd.Document_Cd,0) as Document_Cd,
                ISNULL(sd.FileURL,'') as FileURL,
                ISNULL(sd.IsVerified,0) as IsVerified,
                ISNULL(sd.QC_Flag,0) as QC_Flag,
                ISNULL(sd.IsActive,0) as IsActive,
                ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                ISNULL(sdm.DocumentName,'') as DocumentName,
                ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                ISNULL(sdm.DocumentType,'') as DocumentType,
                ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
            FROM ShopDocuments sd
            INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
            LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
            WHERE sd.Shop_Cd = $shopCd AND sd.IsActive = 1 AND ISNULL(sd.QC_Flag,0) <> 0;";

        $shopDocumentsList = $db2->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

        $queryTrac = "SELECT *, CONVERT(varchar, ScheduleDate, 103) as Schedule_Date
            FROM View_ScheduleDetails vsd
            WHERE vsd.Shop_Cd = $shopCd;";

        $TracData = $db2->ExecutveQueryMultipleRowSALData($queryTrac, $electionName, $developmentMode);


    if(sizeof($shopDetail)>0){
?>


        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-12 col-sm-12">
                        <div class="breadcrumb">
                            <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> <a href="#" class="inactiveLink " >  <i class="fi-rs-location-alt"></i> Ward : </a> <?php  echo $shopDetail["Ward_No"]." - ".$shopDetail["WardArea"]; ?> <span></span> <a href="#" class="inactiveLink" > <i class="fi-rs-apps"></i> Categories : </a> <?php  echo $shopDetail["BusinessCatName"];  ?> <span><a href="#" class="inactiveLink " >  <i class="fi-rs-shop"></i></a> <?php  echo $shopDetail["ShopName"];  ?> </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 col-sm-12 text-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-10">
            <div class="row">
                <div class="col-xl-11 col-lg-12 m-auto">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="product-detail accordion-detail">
                                <div class="row mb-5 mt-30">
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                        <div class="detail-gallery">
                                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                            <div class="product-image-slider">
                                                <?php if(!empty($shopDetail["ShopOutsideImage1"])){ ?>
                                                    <figure class="border-radius-10">
                                                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage1"]; ?>" alt="Shop Image"  />
                                                    </figure>
                                                <?php }else if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                                                    <figure class="border-radius-10">
                                                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image" />
                                                    </figure>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                                                    <figure class="border-radius-10">
                                                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image"  />
                                                    </figure>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopInsideImage1"])){ ?>
                                                    <figure class="border-radius-10">
                                                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopInsideImage1"]; ?>" alt="Shop Image"  />
                                                    </figure>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopInsideImage2"])){ ?>
                                                    <figure class="border-radius-10">
                                                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopInsideImage2"]; ?>" alt="Shop Image"  />
                                                    </figure>
                                                <?php } ?>

                                                <?php 
                                                    foreach ($shopDocumentsList as $key => $valueDoc) {
                                                        if($valueDoc["DocumentType"]=="image"){
                                                ?> 
                                                        <figure class="border-radius-10">
                                                            <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueDoc["FileURL"]; ?>" alt="Shop Documents" title="<?php echo $valueDoc["DocumentName"]; ?>" />
                                                        </figure>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                    

                                            </div>
                                            <div class="slider-nav-thumbnails">
                                                <?php if(!empty($shopDetail["ShopOutsideImage1"])){ ?>
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage1"]; ?>" alt="Shop Image"   width="100"  height="100" /></div>
                                                <?php }else if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image"   width="100"  height="100"  /></div>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image"   width="100"  height="100" /></div>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopInsideImage1"])){ ?>
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopInsideImage1"]; ?>" alt="Shop Image"  width="100"  height="100" /></div>
                                                <?php } ?>

                                                <?php if(!empty($shopDetail["ShopInsideImage2"])){ ?>
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopInsideImage2"]; ?>" alt="Shop Image"  width="100"  height="100" /></div>
                                                <?php } ?>

                                                <?php 
                                                    foreach ($shopDocumentsList as $key => $valueDoc) {
                                                        if($valueDoc["DocumentType"]=="image"){
                                                ?>
                                                    <div><img src="<?php echo $valueDoc["FileURL"]; ?>" alt="Shop Documents" width="100"  height="100" /></div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-0 pl-0">
                                            <h3 class="title-detail mb-5"><?php echo $shopDetail["ShopName"]; ?></h3>
                                            <span class="stock-status out-stock"> <?php echo $shopDetail["BusinessCatName"]; ?> </span>
                                            <span class="stock-status out-stock"> <?php echo $shopDetail["ShopAreaName"]; ?> </span>
                                            <h5 class="title-detail mt-5"><?php echo $shopDetail["ShopKeeperName"]." - ".$shopDetail["ShopKeeperMobile"]; ?></h5>
                                            <h6 class="title-detail"><?php echo $shopDetail["ShopAddress_1"]; ?></h6>
                                            <!-- <div class="short-desc mb-30">
                                                <p class="font-lg">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam rem officia, corrupti reiciendis minima nisi modi, quasi, odio minus dolore impedit fuga eum eligendi.</p>
                                            </div>
                                            <div class="attr-detail attr-size mb-30">
                                                <strong class="mr-10">Size / Weight: </strong>
                                                <ul class="list-filter size-filter font-small">
                                                    <li><a href="#">50g</a></li>
                                                    <li class="active"><a href="#">60g</a></li>
                                                    <li><a href="#">80g</a></li>
                                                    <li><a href="#">100g</a></li>
                                                    <li><a href="#">150g</a></li>
                                                </ul>
                                            </div>
                                            <div class="detail-extralink mb-50">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                                <div class="product-extra-link2">
                                                    <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                    <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                            </div> -->
                                            <?php 
                                                $getShopOwnStatus = $shopDetail["ShopOwnStatus"];
                                                $getShopOwnPeriod = $shopDetail["ShopOwnPeriod"];
                                                
                                                if($getShopOwnPeriod == 0){
                                                    $getShopOwnPeriodYrs = 0;
                                                    $getShopOwnPeriodMonths = 0;
                                                    $shopOwnPeriod = "";
                                                }else if($getShopOwnPeriod < 12){
                                                    $getShopOwnPeriodYrs = 0;
                                                    $getShopOwnPeriodMonths = $getShopOwnPeriod;
                                                    $shopOwnPeriod = "".$getShopOwnPeriodMonths." months";
                                                }else if($getShopOwnPeriod == 12){
                                                    $getShopOwnPeriodYrs = 1;
                                                    $getShopOwnPeriodMonths = 0;
                                                    $shopOwnPeriod = "".$getShopOwnPeriodYrs." year";
                                                }else if($getShopOwnPeriod > 12){
                                                    $yrMonthVal = $getShopOwnPeriod / 12;
                                                    $yrMonthValArr = explode(".", $yrMonthVal);
                                                    $getShopOwnPeriodYrs = $yrMonthValArr[0];
                                                    $getShopOwnPeriodMonths = ( $getShopOwnPeriod - ($yrMonthValArr[0] * 12) );
                                                    if($getShopOwnPeriodMonths!=0){
                                                        $shopOwnPeriod = "".$getShopOwnPeriodYrs." years ".$getShopOwnPeriodMonths." months";  
                                                    }else{
                                                        $shopOwnPeriod = "".$getShopOwnPeriodYrs." years ";
                                                    }
                                                    
                                                }

                                            ?>
                                            <div class="font-xs">
                                                <ul class="mr-50 float-start">
                                                    <li class="mb-5">UID : <span class="text-brand"> <?php echo $shopDetail["Shop_UID"]; ?></span></li>
                                                    <li class="mb-5">Pocket : <span class="text-brand"> <?php echo $shopDetail["PocketName"]; ?> </span></li>
                                                    <li class="mb-5">Executive : <span class="text-brand"> <?php echo $shopDetail["SurveyExecutive"]; ?></span></li>
                                                    <li class="mb-5">Own Status : <span class="text-brand"> <?php echo $shopDetail["ShopOwnStatus"]." since ".$shopOwnPeriod; ?> </span></li>
                                                </ul>
                                                <ul class="float-start">
                                                    <li class="mb-5">Dimension : <a href="#" class="inactiveLink"> <?php echo $shopDetail["ShopDimension"]." sq. ft."; ?></a></li>
                                                    <li class="mb-5">Ward : <a href="#" class="inactiveLink"> <?php echo $shopDetail["Ward_No"]; ?></a></li>
                                                    <li class="mb-5">Survey : <a href="#" class="inactiveLink"> <?php echo $shopDetail["SurveyDate"]; ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
                                </div>
                                <div class="product-info mt-20">
                                    <div class="tab-style3">
                                        <ul class="nav nav-tabs text-uppercase">
                                            <!-- <li class="nav-item">
                                                <a class="nav-link active" id="shop-detail-info-tab" data-bs-toggle="tab" href="#shop-detail-info">Shop Detail</a>
                                            </li> -->
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="shop-document-info-tab" data-bs-toggle="tab" href="#shop-document-info">Shop Documents</a>
                                            </li> -->
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="shop-tracking-info-tab" data-bs-toggle="tab" href="#shop-tracking-info">Shop Tracking</a>
                                            </li> -->
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="shop-license-info-tab" data-bs-toggle="tab" href="#shop-license-info">Shop License</a>
                                            </li> -->
                                        </ul>
                                        <div class="tab-content shop_info_tab entry-main-content">
                                            <div class="tab-pane fade" id="shop-detail-info">
                                                <!-- <h4 class="mb-15">Edit </h4> -->
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Business Category</label>
                                                                            <select class="form-control" name="businessCateogry">
                                                                                <option>All</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Shop Area Category</label>
                                                                            <select class="form-control" name="shopAreaName">
                                                                                <option>All</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Shop Category</label>
                                                                            <select class="form-control" name="shopCateogry">
                                                                                <option>All</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Shop Name in English</label>
                                                                            <input class="form-control" name="shopName" type="text" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Shop Name in Marathi</label>
                                                                            <input class="form-control" name="shopNameMar" type="text"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Shopkeeper / Contact Person Full Name</label>
                                                                            <input class="form-control" name="shopKeeperName" type="text"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Shopkeeper / Contact Person Primary Mobile No</label>
                                                                            <input class="form-control" name="shopKeeperMobile" type="text" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Contact No 1</label>
                                                                            <input class="form-control" name="ShopContactNo1" type="text"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Contact No 2</label>
                                                                            <input class="form-control" name="ShopContactNo2" type="text"  />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Shop Address 1</label>
                                                                            <textarea class="form-control w-100" name="Address1" cols="30" rows="9" ></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Shop Address 2</label>
                                                                            <textarea class="form-control w-100" name="Address2" cols="30" rows="9" ></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Parwana Type</label>
                                                                            <select class="form-control" name="parwanaDetail">
                                                                                <option>All</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Consumer No</label>
                                                                            <input class="form-control" name="ConsumerNo" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>GST No</label>
                                                                            <input class="form-control" name="GSTNo" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Own Status</label>
                                                                            <input class="form-control" name="ShopOwnStatus" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Period (Yrs)</label>
                                                                            <input class="form-control" name="PeriodInYrs" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Period (Months)</label>
                                                                            <input class="form-control" name="PeriodInMonths" type="text" />
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Dimension (L)</label>
                                                                            <input class="form-control" name="shopDimensionLength" type="text"  />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Dimension (W)</label>
                                                                            <input class="form-control" name="shopDimensionWidth" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Shop Area (sq. ft.)</label>
                                                                            <input class="form-control" name="shopDimension" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Male Employee</label>
                                                                            <input class="form-control" name="maleEmp" type="number"  />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Female Employee</label>
                                                                            <input class="form-control" name="femaleEmp" type="number" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-2">
                                                                        <div class="form-group">
                                                                            <label>Other Employee</label>
                                                                            <input class="form-control" name="otherEmp" type="number" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Shop Owner Name</label>
                                                                            <input class="form-control" name="ownerName" type="text"  />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Shop Owner Mobile</label>
                                                                            <input class="form-control" name="ownerMobile" type="text" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Shop Owner Contact</label>
                                                                            <input class="form-control" name="ownerContact" type="text"  />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Shop Owner Email</label>
                                                                            <input class="form-control" name="ownerEmail" type="text" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-9">
                                                                        <div class="form-group">
                                                                            <label>Owner Address </label>
                                                                            <textarea class="form-control w-100" name="ownerAddress" cols="30" rows="9" ></textarea>
                                                                        </div>
                                                                    </div>

                                                                     <!-- <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group mt-50" style="float: right;">
                                                                            <button type="button" class="button button-contactForm">Edit</button>
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                                
                                                        </div>
                                                    </div>
                                            </div>
                                            <!-- <div class="tab-pane fade" id="shop-document-info">
                                                
                                            </div> -->
                                            <div class="tab-pane fade show active" id="shop-tracking-info">

                            <?php if(sizeof($TracData) > 0){?>
                            <!-- Product sidebar Widget -->
                            <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                                <h5 class="section-title style-1 mb-30">Shop Tracking Details</h5>

                                <?php $srNo == 0;
                                foreach($TracData as $key => $val) { 
                                    $srNo++; ?>

                                <div class="single-post clearfix">
                                    <div class="image">

                                    <?php if($srNo % 2 == 0){
                                    $align = 'left';
                                     
                                    } else 
                                    { 
                                        $align = 'left';
                                    }
                                    ?>

                                    <?php if(trim($val['Calling_Category']) == 'Premise Visit') {?>
                                        <img src="assets/imgs/theme/icons/PremiseVisit.png" alt="#" style="align: <?php echo $align;?>;"/>
                                        <?php } else if(trim($val['Calling_Category']) == 'Survey Verification Call') {?>
                                        <img src="assets/imgs/theme/icons/SurveyVerificationCall.png" alt="#" style="align: <?php echo $align;?>;"/>
                                        <?php } else if(trim($val['Calling_Category']) == 'Document Collection Visit') {?>
                                        <img src="assets/imgs/theme/icons/DocumentsCollectionVisit.svg" alt="#" style="align: <?php echo $align;?>;"/>
                                        <?php } else if(trim($val['Calling_Category']) == 'Document Collection Call') {?>
                                        <img src="assets/imgs/theme/icons/DocumentCollectionCall.png" alt="#" style="align: <?php echo $align;?>;"/>
                                         <?php } else {?>
                                        <img src="assets/imgs/theme/icons/tracking.png" alt="#" style="align: <?php echo $align;?>;"/>
                                        <?php } ?>
                                    </div>
                                    <div class="content pt-10" style="text-align: <?php echo $align;?>;">
                                        <h6><a href="shop-product-detail.html" style="font-weight:bold;font-size:18px;font-text:bold;"><?php echo $val['Calling_Category'];?></a></h6>
                                        <p><b style="font-weight:bold;font-size:17px;"><?php echo $val['Calling_Type']."</b>    </br> <b style='font-weight:bold;font-size:17px;'>Executive Name : ".$val['ScheduleExeName'];?></b></p>
                                        <p><b style="font-weight:bold;font-size:17px;"><?php echo 'Schedule Date : '. $val['Schedule_Date']."</b>    </br> <b style='font-weight:bold;font-size:17px;'>Schedule Reason : ".$val['ScheduleReason'];?></b></p>
                                        <div>
                                            <!-- <div class="product-rating" style="width: 90%"></div> -->
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>
                                
                            </div>
                            </div>
                            <?php } ?>

                                            <div class="tab-pane fade" id="shop-license-info">
                                                
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php //include 'getShopBusinessCategoryWidget.php'; ?>
                    </div>
                </div>
            </div>
        </div>

<?php
    }else{
        header('Location:index.php');  
    }
?>
<?php } ?>
        
</main>