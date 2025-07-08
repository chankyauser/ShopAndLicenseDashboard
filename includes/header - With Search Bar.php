<?php 
    ob_start();
    session_start();

    require_once 'PHP-Cache/cache.class.php';
    $cache = new Cache();
    ini_set('max_execution_time', '1000'); // 5 min

    $pageLanguageArray = array('English','Marathi');
    if(!isset($_SESSION['Page_Language'])){
        $_SESSION['Page_Language'] = 'English';
    }
    $_SESSION['SAL_AppName'] = "ShopAndLicence";
    $_SESSION['SAL_DevelopmentMode'] = "Live";

    date_default_timezone_set('Asia/Kolkata');

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    $startTime = "00:00:00";
    $endTime = "23:59:59";
    $_SESSION['StartTime']=$startTime;
    $_SESSION['EndTime']=$endTime;

    if(!isset($_SESSION['SAL_ElectionName'])){
        $_SESSION['SAL_ElectionName']='CSMC';
    }

    // include 'includes/checksession.php';
    include 'api/includes/DbOperation.php';

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    
    if(!isset($_SESSION['SAL_BusinessCat_Cd'])){
        $_SESSION['SAL_BusinessCat_Cd'] = "All";
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
    }else{
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
    }

?>


<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bazaar Trace | <?php echo $_SESSION['SAL_ElectionName'];  ?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" /> -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="assets/css/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/extensions/dataTables.checkboxes.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- <link rel="stylesheet" href="assets/css/plugins/apexcharts.css" /> -->
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="assets/css/main.css?v=5.3" />

     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="includes/ajaxscript.js"></script>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
             var windowHeight = $(window).height();
             
             $("#categories-dropdown").height(windowHeight-200);
        });

    </script>

</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="assets/imgs/theme/load.gif" alt=""  height="100" width="100" />
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-labelledby="onloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal" style="background-image: url('assets/imgs/banner/popup-1.png')">
                        <div class="deal-top">
                            <h6 class="mb-10 text-brand-2">Deal of the Day</h6>
                        </div>
                        <div class="deal-content detail-info">
                            <h4 class="product-title"><a href="shop-product-right.html" class="text-heading">Organic fruit for your family's health</a></h4>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand">$38</span>
                                    <span>
                                        <span class="save-price font-md color3 ml-15">26% Off</span>
                                        <span class="old-price font-md ml-15">$52</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="deal-bottom">
                            <p class="mb-20">Hurry Up! Offer End In:</p>
                            <div class="deals-countdown pl-5" data-countdown="2025/03/25 00:00:00">
                                <span class="countdown-section"><span class="countdown-amount hover-up">03</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">02</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">29</span><span class="countdown-period"> sec </span></span>
                            </div>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 rates)</span>
                                </div>
                            </div>
                            <a href="#" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Quick View Shop Detail -->
    <div class="modal fade custom-modal" id="quickViewShopDetailModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row" id="showQuickShopDetails">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="header-area header-style-1 header-height-2">
       <!--  <div class="mobile-promotion">
            <span><strong>Shop License - View & Pay Online</strong></span>
        </div> -->
   <!--      <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="header-info">
                            <ul>
                                <li><a href="#">My Shop</a></li>
                                <li><a href="#">Shop Tracking</a></li>
                                <li><a href="#">Guideline</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6">
                        <div class="header-info header-info-right">
                            <ul>   -->  
                                <?php


                                    $db=new DbOperation();
                                    $dataElectionName = $db->getSALCorporationElectionData($appName, $developmentMode);
                                ?>
                                    <!-- <li> -->
                                        <!-- <a class="language-dropdown-active" href="#"><?php echo $electionName; ?>  -->
                                        <!-- <i class="fi-rs-angle-small-down"></i> -->
                                        <!-- </a> -->
                                        <input type="hidden" name="electionName" value="<?php echo $electionName; ?>">
                                            <!-- <ul class="language-dropdown">
                                                <?php 
                                                    foreach ($dataElectionName as $key => $valueEle) {
                                                ?>
                                                    <li>
                                                        <a onclick="setElectionHeaderNameInSession('<?php echo $valueEle["ElectionName"]; ?>')"><?php echo $valueEle["ElectionName"]; ?></a>
                                                    </li>
                                                <?php
                                                    }
                                                ?>    
                                            </ul> -->
                                    <!-- </li> -->
                                    <!-- <li>
                                        <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>
                                            <ul class="language-dropdown">
                                              <li>
                                                  <a href="#">English</a>
                                              </li>
                                              <li>
                                                  <a href="#">Marathi</a>
                                              </li>
                                              <li>
                                                  <a href="#">Hindi</a>
                                              </li>
                                            </ul>
                                    </li> -->
                                    <!-- <li>Need help? Call Us : &nbsp;<strong class="text-brand"> 1900 - 888 - 878 </strong></li> -->
                                    <!-- <li><a href="admin/login.php">Admin</a></li> -->
                                    <!-- <li>
                                        <div class="mobile-social-icon">
                                            <a href="#"><img src="assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                                            <a href="#"><img src="assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                                            <a href="#"><img src="assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                                            <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                                            <a href="#"><img src="assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
                                        </div>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="index.php">
                              <div class="logo d-none d-lg-flex">
                                    <img src="assets/imgs/theme/logo.png" height="50" alt="logo" />
                                    <p>Bazaar Trace</p>
                              </div>
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                                        <?php 
                                            $queryNode = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
                                                ISNULL(NodeMaster.Node_Cd,0) as Node_Cd,
                                                ISNULL(NodeMaster.NodeName,'') as NodeName,
                                                ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar,
                                                ISNULL(NodeMaster.Ac_No,0) as Ac_No,
                                                ISNULL(NodeMaster.Ward_No,0) as Ward_No,
                                                ISNULL(NodeMaster.Address,'') as Address,
                                                ISNULL(NodeMaster.Area,'') as Area
                                                FROM NodeMaster 
                                                INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
                                                INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
                                                WHERE NodeMaster.IsActive = 1 
                                                GROUP BY NodeMaster.Node_Cd, NodeMaster.NodeName,
                                                NodeMaster.NodeNameMar, NodeMaster.Ac_No,
                                                NodeMaster.Ward_No, NodeMaster.Address, NodeMaster.Area
                                                ORDER BY NodeMaster.Area";
                                            $db=new DbOperation();
                                            $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
                                            // print_r($dataNode);
                                        ?>

                                    <select class="select-active" name="nodeCd"

                                        <?php
                                           if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName']) && !isset($_GET['p'])) {
                                        ?>
                                               
                                        <?php
                                           }else{   
                                        ?>
                                                onchange="setShopBusinessCategoriesWardFilter(1)"
                                        <?php
                                           }
                                        ?>

                                    >
 <!-- onchange="setShopSurveyAnalysisTopFilter(1)" -->

                                        <option value="All">All Ward </option>
                                        <?php 
                                            foreach ($dataNode as $key => $valueNode) {
                                                if($nodeCd==$valueNode["Node_Cd"]){
                                        ?>
                                                    <option selected value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                                        <?php
                                                }else{
                                         ?>
                                                    <option value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                                        <?php            
                                                }
                                            }
                                        ?>    
                                    </select>
                                    <?php 
                                            $queryBusinessCat = "SELECT
                                                ISNULL(BusinessCat_Cd,0) as BusinessCat_Cd,
                                                ISNULL(BusinessCatName,'') as BusinessCatName,
                                                ISNULL(BusinessCatNameMar,'') as BusinessCatNameMar,
                                                ISNULL(BusinessCatImage,'') as BusinessCatImage
                                                FROM BusinessCategoryMaster 
                                                WHERE IsActive = 1 ";
                                            $db=new DbOperation();
                                            $dataBusinessCategory = $db->ExecutveQueryMultipleRowSALData($queryBusinessCat, $electionName, $developmentMode);
                                            // print_r($dataBusinessCategory);
                                        ?>
                                    <select class="select-active" id="business_cat_id"  name="businessCatCd" 

                                        <?php
                                           if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName']) && !isset($_GET['p'])) {
                                        ?>
                                                
                                        <?php
                                           }else{   
                                        ?>
                                                onchange="setShopBusinessCategoriesWardFilter(1)"
                                        <?php
                                           }
                                        ?>

                                    >

                                    <!-- onchange="setShopSurveyAnalysisTopFilter(1)" -->
                                          <option id="businessCategoryTextId" value="All">All Categories</option>
                                        <?php 
                                            foreach ($dataBusinessCategory as $key => $valueBusinessCat) {
                                                if($businessCatCd==$valueBusinessCat["BusinessCat_Cd"]){
                                        ?>
                                                    <option selected value="<?php echo $valueBusinessCat["BusinessCat_Cd"]; ?>"><?php echo $valueBusinessCat["BusinessCatName"]; ?></option>
                                        <?php
                                                }else{
                                        ?>
                                                    <option value="<?php echo $valueBusinessCat["BusinessCat_Cd"]; ?>"><?php echo $valueBusinessCat["BusinessCatName"]; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                <input type="text" name="shopName" placeholder="Search by Shop Name / Shop UID"  onkeydown = "if (event.keyCode == 13) document.getElementById('submitSearchShopHeaderBtnId').click()"/>

                                <input id="submitSearchShopHeaderBtnId" type="hidden" class="btn btn-brand" onclick="searchShopHeaderFilter(1)" >
                        </div>
                        <div class="header-action-right">
                              <div class="header-action-2">
                                
                                
                                    <div class="header-action-icon-2">
                                          <div class="hotline d-none d-lg-flex">
                                            <?php 
                                                if (!isset($_SESSION['SAL_FullName'])) {
                                            ?>
                                                
                                                    <img src="assets/imgs/theme/icons/icon-user.svg" alt="hotline" />
                                                        <a href="index.php?p=login">
                                                            <p>Sign In
                                                                <span>Role</span>
                                                            </p>
                                                        </a>
                                            <?php        
                                                }else{
                                            ?>
                                                <img src="assets/imgs/theme/icons/icon-user.svg" alt="hotline" />
                                                <p> 
                                                    <?php echo $_SESSION['SAL_FullName']; ?>
                                                    <span><?php echo $_SESSION['SAL_UserType']; ?> </span>
                                                    
                                                </p>
                                            <?php
                                                }
                                            ?>
                                          </div>
                                        <?php 
                                            // if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName'])) {
                                        ?>
                                            <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                              <ul>
                                                    <?php 
                                                            if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Admin' ) {
                                                    ?>
                                                                <li>
                                                                    <a href="admin/index.php"><i class="fi fi-rs-home mr-10"></i> Admin</a>
                                                                </li>
                                                    <?php    
                                                            }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'QC' ) {
                                                    ?>
                                                                <li>
                                                                    <a href="qc/index.php"><i class="fi fi-rs-home mr-10"></i> Dashboard</a>
                                                                </li>
                                                    <?php    
                                                            }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ) { 
                                                    ?>
                                                                <li>
                                                                    <a href="client/index.php"><i class="fa-solid fa-chart-column"></i>  Dashboard</a>
                                                                </li>
                                                    <?php
                                                            }else{
                                                    ?>
                                                               
                                                    <?php
                                                            }
                                                        
                                                    ?>
                                                  <li>
                                                        <?php 
                                                            if (!isset($_SESSION['SAL_FullName'])) {
                                                        ?>
                                                            <a href="index.php?p=login"><i class="fi fi-rs-user mr-10"></i>Sign In</a>

                                                        <?php    
                                                            }else{
                                                        ?>
                                                            <a href="index.php?p=my-account"><i class="fi fi-rs-user mr-10"></i>My Account</a>

                                                        <?php
                                                            }
                                                        ?>
                                                  </li>
                                                    <li>
                                                          <a href="index.php?p=my-shop"><i class="fi fi-rs-label mr-10"></i>My Shop</a>
                                                    </li>   
                                                  <li>
                                                      <a href="index.php?p=shop-tracking"><i class="fi fi-rs-location-alt mr-10"></i>Shop Tracking</a>
                                                  </li>
                                                  <li>
                                                      <a href="index.php?p=settings"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                                  </li>
                                                  <li>
                                                      <a href="logout.php"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                  </li>
                                              </ul>
                                          </div>
                                        <?php   
                                            // }
                                        ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="index.php"><img src="assets/imgs/theme/logo.png" height="48" width="48" alt="logo" /></a>
                        <!-- <p>Shop License</p> -->
                    </div>

                    <div class="header-nav d-none d-lg-flex">

                    
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active">
                                <span class="fi-rs-apps"></span> <span class="et"></span> All Categories
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <script type="text/javascript">
                                var height = $(window).height();
                                $("#map-container").height(height);
                            </script>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading" id="categories-dropdown" style="overflow-y: scroll;">
                                <div class="d-flex categori-dropdown-inner" >
                                    <ul>
                                    <?php 
                                        $queryBusinessCatSummary = "SELECT
                                            ISNULL(bcm.BusinessCat_Cd,0) as BusinessCat_Cd,
                                            ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
                                            ISNULL(bcm.BusinessCatNameMar,'') as BusinessCatNameMar,
                                            ISNULL(bcm.BusinessCatImage,'') as BusinessCatImage,
                                            ISNULL(COUNT(DISTINCT(sm.Shop_Cd)),0) as ShopCount
                                            FROM BusinessCategoryMaster bcm 
                                            INNER JOIN ShopMaster sm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                                            WHERE bcm.IsActive = 1 AND sm.IsActive = 1
                                            GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, 
                                            bcm.BusinessCatNameMar, bcm.BusinessCatImage";
                                        $db=new DbOperation();
                                        $dataBusinessCategorySummary = $db->ExecutveQueryMultipleRowSALData($queryBusinessCatSummary, $electionName, $developmentMode);
                                        // print_r($dataBusinessCategorySummary);

                                        $srNo = 0;
                                        $catTotal = sizeof($dataBusinessCategorySummary);
                                        $totalDivideIntoSubRecords = "SELECT CEILING( CAST ($catTotal as float) / 2 ) as RecordEachSide";
                                        $db1=new DbOperation();
                                        $TotalCountData = $db1->ExecutveQuerySingleRowSALData($totalDivideIntoSubRecords, $electionName, $developmentMode); 
                                        $totalOneSide = $TotalCountData["RecordEachSide"];
                                        foreach ($dataBusinessCategorySummary as $key => $valueBusinessCat) {
                                            $srNo = $srNo+1;

                                            if($srNo <=$totalOneSide){
                                    ?>            
                                            <li  onclick="setShopBusinessCategoriesFilter(1,'<?php echo $valueBusinessCat["BusinessCat_Cd"]; ?>')"  >
                                                <a > <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueBusinessCat["BusinessCatImage"]; ?>" alt="<?php echo $valueBusinessCat["BusinessCatName"]; ?>" /><?php echo $valueBusinessCat["BusinessCatName"]; ?></a> <!-- <span class="count"><?php //echo $valueBusinessCat["ShopCount"]; ?></span> -->
                                            </li>
                                    <?php
                                            }
                                        }
                                    ?>
                                    </ul>
                                    <ul class="end">
                                        <?php 
                                            $srNo = 0;
                                            foreach ($dataBusinessCategorySummary as $key => $valueBusinessCat) {
                                                $srNo = $srNo+1;

                                                if($srNo >$totalOneSide && $srNo <=$catTotal){
                                        ?>            
                                                <li onclick="setShopBusinessCategoriesFilter(1,'<?php echo $valueBusinessCat["BusinessCat_Cd"]; ?>')" >
                                                    <a > <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueBusinessCat["BusinessCatImage"]; ?>" alt="<?php echo $valueBusinessCat["BusinessCatName"]; ?>" /><?php echo $valueBusinessCat["BusinessCatName"]; ?></a> <!-- <span class="count"><?php //echo $valueBusinessCat["ShopCount"]; ?></span> -->
                                                </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                       
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    
                                    <li>
                                        <a <?php if(!isset($_GET['p'])){ ?> class="active" <?php }  ?> href="index.php"><i class="fa-solid fa-house"></i> Home</a>
                                    </li>
                                        <?php 
                                            if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName'])) {
                                                if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Admin' ) {
                                        ?>
                                                    <li>
                                                        <a href="admin/index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                                                    </li>
                                        <?php    
                                                }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'QC' ) {
                                        ?>
                                                    <li>
                                                        <a href="qc/index.php"><i class="fa-solid fa-square-check"></i> Dashboard</a>
                                                    </li>
                                        <?php    
                                                }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Client' ) ) { 
                                        ?>
                                                    <li>
                                                        <a href="client/index.php"><i class="fa-solid fa-chart-column"></i> Dashboard</a>
                                                    </li>
                                        <?php
                                                }
                                     
                                        ?>
                                            <li>
                                                <a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-map' || $_GET['p']== 'survey-shops' || $_GET['p']== 'survey-list') ){ ?> class="active" <?php }  ?>  href="client/index.php?p=survey-map"><i class="fa-solid fa-check-to-slot"></i> Shops Survey
                                                  <!-- <i class="fi-rs-angle-down"></i> -->
                                                </a>
                                              <!--   <ul class="sub-menu">
                                                    <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-map') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-map">Survey Map</a></li>
                                                    <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-shops') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-shops">Survey Shops</a></li>
                                                </ul> -->
                                            </li>
                                        
                                             <li>
                                                  <a href="client/index.php?p=shop-license"><i class="fa-solid fa-id-card"></i> Shop License
                                                  </a>
                                            </li>
                                            <li>
                                                  <a href="client/index.php?p=shop-tracking"><i class="fa-solid fa-clock"></i> Shop Tracking
                                                  </a>
                                            </li>
                                         <!--    <li>
                                                  <a href="#"><i class="fa-solid fa-shop-slash"></i> Defaulters
                                                  </a>
                                                  
                                            </li> -->
                                           
                                         <!--    <li>
                                                  <a href=""><i class="fa-solid fa-indian-rupee-sign"></i> Revenue
                                                      
                                                  </a>
                                            </li> -->
                                           
                                            <li>
                                                  <a href="https://datastudio.google.com/reporting/42f90ce4-bcee-46a4-8029-39720d624736/page/39C5C"><i class="fa-solid fa-download"></i> Reports
                                                        <!-- <i class="fi-rs-angle-down"></i> -->
                                                  </a>
                                                  <!-- <ul class="sub-menu">
                                                    <li><a href="page-about.html">About Us</a></li>
                                                    <li><a href="page-404.html">404 Page</a></li>
                                                </ul> -->
                                            </li>
                                    <?php
                                        }else{
                                    ?>  
                                            <!-- <li>
                                                  <a href="index.php?p=my-shop"><i class="fa-solid fa-sitemap"></i> About Us </a>
                                            </li>
 -->
                                            <li>
                                                  <a href="index.php?p=my-shop"><i class="fa-solid fa-store"></i> My Shop
                                                        <!-- <i class="fi-rs-angle-down"></i> -->
                                                  </a>
                                                  <!-- <ul class="sub-menu">
                                                    <li><a href="page-about.html">About Us</a></li>
                                                    <li><a href="page-404.html">404 Page</a></li>
                                                </ul> -->
                                            </li>

                                            <li>
                                                  <a href="index.php?p=license-guideline"><i class="fa-solid fa-file"></i> Guideline </a>
                                            </li>

                                            <li>
                                                  <a href="index.php?p=license-objection"><i class="fa-solid fa-file-pen"></i> Objections
                                                        <!-- <i class="fi-rs-angle-down"></i> -->
                                                  </a>
                                                  <!-- <ul class="sub-menu">
                                                    <li><a href="page-about.html">About Us</a></li>
                                                    <li><a href="page-404.html">404 Page</a></li>
                                                </ul> -->
                                            </li>

                                            <li>
                                                  <a href="index.php?p=contact-us"><i class="fa-solid fa-location-dot"></i> Contact Us </a>
                                            </li>
                                    <?php
                                        }
                                    ?>
                               
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-flex">
                        <!-- <img src="assets/imgs/theme/icons/icon-headphone.svg" alt="hotline" />
                        <p>1900 - 888 - 878<span>24/7 Support Center</span></p> -->
                    </div>
                
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            
                              <div class="header-action-icon-2">
                                    <div class="mini-cart-icon">
                                          <img alt="MyAccount" src="assets/imgs/theme/icons/icon-user.svg" alt="hotline" />
                                    </div>
                                    <!-- <a class="mini-cart-icon" href="shop-cart.html">
                                          <img alt="MyAccount" src="assets/imgs/theme/icons/icon-user.svg" />
                                          <span class="pro-count white">2</span>
                                    </a> -->
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                          <ul>
                                                <li>
                                                      <a href="index.php?p=my-account"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <?php 
                                                    if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName'])) {
                                                        if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Admin' ) {
                                                ?>
                                                    <li>
                                                        <a href="admin/index.php"><i class="fi fi-rs-home mr-10"></i><?php echo $_SESSION['SAL_UserType']; ?> Dashboard</a>
                                                    </li>
                                                <?php    
                                                        }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'QC' ) {
                                                ?>
                                                    <li>
                                                        <a href="qc/index.php"><i class="fi fi-rs-home mr-10"></i><?php echo $_SESSION['SAL_UserType']; ?> Dashboard</a>
                                                    </li>
                                                <?php    
                                                        }else if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Client' ) {
                                                ?>
                                                    <li>
                                                        <a href="client/index.php"><i class="fi fi-rs-home mr-10"></i><?php echo $_SESSION['SAL_UserType']; ?> Dashboard</a>
                                                    </li>
                                                <?php    
                                                        }else{
                                                ?>
                                                    <li>
                                                          <a href="#"><i class="fi fi-rs-label mr-10"></i>My Shop</a>
                                                    </li>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                
                                                
                                                <li>
                                                      <a href="#"><i class="fi fi-rs-location-alt mr-10"></i>Shop Tracking</a>
                                                </li>
                                                <li>
                                                      <a href="#"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                                </li>
                                                <li>
                                                      <a href="#"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                </li>
                                          </ul>
                                    </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                        <a href="index.php">
                              <img src="assets/imgs/theme/logo.png" height="50" alt="logo" />
                        </a>
                        <!-- <p>Shop License</p> -->
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="menu-item-has-children">
                                <a href="index.php">Home</a>
                                <!-- <ul class="dropdown">
                                    <li><a href="index.html">Home 1</a></li>
                                    <li><a href="index-2.html">Home 2</a></li>
                                    <li><a href="index-3.html">Home 3</a></li>
                                    <li><a href="index-4.html">Home 4</a></li>
                                    <li><a href="index-5.html">Home 5</a></li>
                                    <li><a href="index-6.html">Home 6</a></li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Shop</a>
                                <!-- <ul class="dropdown">
                                    <li><a href="#">Shop Grid – Right Sidebar</a></li>
                                    <li><a href="shop-grid-left.html">Shop Grid – Left Sidebar</a></li>
                                    <li><a href="shop-list-right.html">Shop List – Right Sidebar</a></li>
                                    <li><a href="shop-list-left.html">Shop List – Left Sidebar</a></li>
                                    <li><a href="shop-fullwidth.html">Shop - Wide</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Product – Right Sidebar</a></li>
                                            <li><a href="shop-product-left.html">Product – Left Sidebar</a></li>
                                            <li><a href="shop-product-full.html">Product – No sidebar</a></li>
                                            <li><a href="shop-product-vendor.html">Product – Vendor Infor</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop-filter.html">Shop – Filter</a></li>
                                    <li><a href="shop-wishlist.html">Shop – Wishlist</a></li>
                                    <li><a href="shop-cart.html">Shop – Cart</a></li>
                                    <li><a href="shop-checkout.html">Shop – Checkout</a></li>
                                    <li><a href="shop-compare.html">Shop – Compare</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Shop Invoice</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-invoice-1.html">Shop Invoice 1</a></li>
                                            <li><a href="shop-invoice-2.html">Shop Invoice 2</a></li>
                                            <li><a href="shop-invoice-3.html">Shop Invoice 3</a></li>
                                            <li><a href="shop-invoice-4.html">Shop Invoice 4</a></li>
                                            <li><a href="shop-invoice-5.html">Shop Invoice 5</a></li>
                                            <li><a href="shop-invoice-6.html">Shop Invoice 6</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">License</a>
                                <!-- <ul class="dropdown">
                                    <li><a href="vendors-grid.html">Vendors Grid</a></li>
                                    <li><a href="vendors-list.html">Vendors List</a></li>
                                    <li><a href="vendor-details-1.html">Vendor Details 01</a></li>
                                    <li><a href="vendor-details-2.html">Vendor Details 02</a></li>
                                    <li><a href="vendor-dashboard.html">Vendor Dashboard</a></li>
                                    <li><a href="vendor-guide.html">Vendor Guide</a></li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Survey</a>
                                <!-- <ul class="dropdown">
                                    <li class="menu-item-has-children">
                                        <a href="#">Women's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Dresses</a></li>
                                            <li><a href="shop-product-right.html">Blouses & Shirts</a></li>
                                            <li><a href="shop-product-right.html">Hoodies & Sweatshirts</a></li>
                                            <li><a href="shop-product-right.html">Women's Sets</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Men's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Jackets</a></li>
                                            <li><a href="shop-product-right.html">Casual Faux Leather</a></li>
                                            <li><a href="shop-product-right.html">Genuine Leather</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Technology</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Gaming Laptops</a></li>
                                            <li><a href="shop-product-right.html">Ultraslim Laptops</a></li>
                                            <li><a href="shop-product-right.html">Tablets</a></li>
                                            <li><a href="shop-product-right.html">Laptop Accessories</a></li>
                                            <li><a href="shop-product-right.html">Tablet Accessories</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Defaulters</a>
                                <!-- <ul class="dropdown">
                                    <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                    <li><a href="blog-category-list.html">Blog Category List</a></li>
                                    <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                    <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product Layout</a>
                                        <ul class="dropdown">
                                            <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                            <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                            <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Revenue</a>
                                <!-- <ul class="dropdown">
                                    <li><a href="page-about.html">About Us</a></li>
                                    <li><a href="page-contact.html">Contact</a></li>
                                    <li><a href="page-account.html">My Account</a></li>
                                    <li><a href="page-login.html">Login</a></li>
                                    <li><a href="page-register.html">Register</a></li>
                                    <li><a href="page-forgot-password.html">Forgot password</a></li>
                                    <li><a href="page-reset-password.html">Reset password</a></li>
                                    <li><a href="page-purchase-guide.html">Purchase Guide</a></li>
                                    <li><a href="page-privacy-policy.html">Privacy Policy</a></li>
                                    <li><a href="page-terms.html">Terms of Service</a></li>
                                    <li><a href="page-404.html">404 Page</a></li>
                                </ul> -->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">English</a>
                                <ul class="dropdown">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Marathi</a></li>
                                    <li><a href="#">Hindi</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap">
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-marker"></i> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="index.php?p=login"><i class="fi-rs-user"></i>Log In </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-headphones"></i>+91 022 27833972 </a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <!-- <h6 class="mb-15">Follow Us</h6> -->
                    <a href="#"><img src="assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                    <a href="#"><img src="assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
                </div>
                <div class="site-copyright">Copyright <?php echo date('Y'); ?> © <?php echo 'Corporation'; ?>. All rights reserved | <a href="https://www.ornettech.com/" target="_blank"> ORNET Technologies Pvt. Ltd.</a></div>
            </div>
        </div>
    </div>
    <!--End header-->

        <main class="main" id="showPageDetails">