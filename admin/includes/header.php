<?php 
    include 'checksession.php';
    include '../api/includes/DbOperation.php';

    $containmentZoneMapAndListDetail = array();
    $dataPocketMapAndListSummary = array();
    $pocketShopsSurveyMapAndListDetail = array();
    $qcTypeArray = array(array('QC_Title' => 'Shop Listing', 'SH_Action' => 'Shop Listed', 'QC_Type' =>'ShopList', 'QC_Flag' =>1, 'QC_Color' =>'dark'), array('QC_Title' => 'Shop Survey', 'SH_Action' => 'Shop Surveyed', 'QC_Type' =>'ShopSurvey', 'QC_Flag' =>2, 'QC_Color' =>'primary'), array('QC_Title' => 'Shop Board', 'SH_Action' => 'Shop Board Details', 'QC_Type' =>'ShopBoard', 'QC_Flag' =>5, 'QC_Color' =>'info'), array('QC_Title' => 'Shop Document', 'SH_Action' => 'Shop Document Collected', 'QC_Type' =>'ShopDocument', 'QC_Flag' =>3, 'QC_Color' =>'danger'), array('QC_Title' => 'Shop Calling', 'SH_Action' => 'Shop Called', 'QC_Type' =>'ShopCalling', 'QC_Flag' =>4, 'QC_Color' =>'warning'));
   
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <!-- <title>Shop & License - Dashboard</title> -->
    <title> 
           <?php if(isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?>  Bazaar Trace | Defaulters List <?php }else{ ?>  Bazaar Trace | Dashboard <?php }   ?>    
    </title>
    <!-- <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico"> -->
    <link rel="apple-touch-icon" href="<?php echo '../assets/imgs/' . ($_SESSION["SAL_ElectionName"]) . '_Logo.jpeg'; ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo '../assets/imgs/' . ($_SESSION["SAL_ElectionName"]) . '_Logo.jpeg'; ?>">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <?php
        //if(isset($_GET['p']) && $_GET['p'] == 'home-dashboard' ){ ?> 
            <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/apexcharts.css">
    <?php //}?>
     <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/tether-theme-arrows.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/tether.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/shepherd-theme-default.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    
    <!-- Data List View -->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
    <!-- End Data List View -->
    
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <!-- <link rel="stylesheet" type="text/css" href="app-assets/css/pages/dashboard-analytics.css"> -->
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/card-analytics.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/tour/tour.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-todo.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-user.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-ecommerce-details.css">

    <!-- Data List View -->
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/file-uploaders/dropzone.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/data-list-view.css">

    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/pickadate/pickadate.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/charts/chart-apex.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <!-- maps -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- End Data List View -->
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/style.css">
    <!-- END: Custom CSS-->

    <script src="includes/ajaxscript.js"></script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<!-- !isset($_GET['p']) || -->
  <?php //if(    ( isset($_GET['p']) && ( $_GET['p'] == 'executive-calling-list' || $_GET['p'] == 'calling-detail' ) )     ){ ?>  
 
 <!-- <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  pace-done menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns"> -->

<?php //}else{  ?>
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php //} ?>


    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                         <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                        </ul> 
                        <ul class="nav navbar-nav bookmark-icons">
                            <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                            <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                            <!--     i.ficon.feather.icon-menu-->
                            <li class="nav-item dropdown dropdown-electionname">
                                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <h3 class="brand-text mb-0 "  >
                                        <?php if(isset($_SESSION['SAL_ElectionName'])){ ?>
                                            <input type="hidden" name="electionName" value="<?php echo $_SESSION['SAL_ElectionName']; ?>">
                                        <?php echo $_SESSION['SAL_ElectionName']; } ?>

                                        <?php if(!isset($_GET['p']) || ( isset($_GET['p']) && $_GET['p'] == 'home') ){ ?>  
                                            Shop License
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'listing-survey-filter' ){ ?> 
                                                Shop Listing & Survey
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-survey-detail' ){ ?> 
                                                Shop Survey Detail
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'pocket-assign' ){ ?> 
                                                Pocket Assigning
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'pocket-wise-shops-list' ){ ?> 
                                                Shops Listing
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shops-assign' ){ ?> 
                                                Shops Assigning
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shops-assign-list' ){ ?> 
                                                Shops Assign Summary
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-summary' ){ ?> 
                                                Survey Summary
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-detail' ){ ?> 
                                                Survey Detail
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'calling-summary' ){ ?> 
                                                Calling Summary
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'calling-detail' ){ ?> 
                                                Calling Detail
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'executive-calling-list' ){ ?> 
                                                Executive Calling
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-qc-summary' ){ ?> 
                                                QC Summary 
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-qc-log-detail' ){ ?> 
                                                QC Log Detail 
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'listing-average-report' ){ ?> 
                                                Listing Average Report 
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'survey-average-report' ){ ?> 
                                                Survey Average Report 
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'all-report' ){ ?> 
                                                Report
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'qc-report' ){ ?> 
                                                QC Report
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'document-pending-report' ){ ?> 
                                                Document Pending Report
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-first-and-last-entry' ){ ?> 
                                                Executive Attendance
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-loss-of-hours-details' ){ ?> 
                                                Executives Loss of Hours Details 
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-license-tracking' ){ ?> 
                                                Shop Tracking
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-license-renewal' ){ ?> 
                                                Shop License Renewal
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-license-receipt' ){ ?> 
                                                Shop License Receipt
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-license-revenue-summary' ){ ?> 
                                                Shop License Revenue Summary
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?> 
                                                Shop License Defaulters
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'login-master' ){ ?> 
                                                Login Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'pocket-master' ){ ?> 
                                                Pocket Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'node-master' ){ ?> 
                                                Node Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'business-category-master' ){ ?> 
                                                Business Category Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'drop-down-master' ){ ?> 
                                                Drop Down Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-area-master' ){ ?> 
                                                Shop Area Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'calling-category-master' ){ ?> 
                                                Calling Category Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'shop-document-master' ){ ?> 
                                                Shop Document Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'board-tax-master' ){ ?> 
                                                Board Tax Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'faq-master' ){ ?> 
                                                FAQ Master
                                        <?php }elseif(isset($_GET['p']) && $_GET['p'] == 'assign-ward-officer' ){ ?> 
                                                Assign Ward Master
                                        <?php }   ?> 
                                    </h3>
                                </a>
                                <?php
                                      $db=new DbOperation();
                                      $userName=$_SESSION['SAL_UserName'];
                                      $appName=$_SESSION['SAL_AppName'];
                                      $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                                      $dataElectionName = $db->getSALCorporationElectionData($appName, $developmentMode);
                                ?>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                                     <?php 
                                            foreach ($dataElectionName as $key => $value) {
                                        ?> 
                                             <a class="dropdown-item" href="javascript:void(0);" style="font-size: 1.1rem;font-weight: 900;" onclick="setElectionHeaderNameInSession('<?php echo $value["ElectionName"]; ?>')"  > <?php echo $value["ElectionName"]; ?></a>
                                        <?php
                                            }
                                        ?>
                                </div>
                            </li>
                           <!--  <li class="nav-item d-lg-block">
                                <a class="nav-link" href="home.php" data-toggle="tooltip" data-placement="top" >
                                <i class="ficon feather icon-check-square"></i>

                                    <h2 class="brand-text mb-0 "> 
                                       
                                    </h2>
                                </a>
                            </li> -->
                          <!--   <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon feather icon-message-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon feather icon-mail"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon feather icon-calendar"></i></a></li>  -->
                        </ul>
                        <!-- <ul class="nav navbar-nav">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon feather icon-star warning"></i></a>
                                <div class="bookmark-input search-input">
                                    <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                    <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="0" data-search="template-list">
                                    <ul class="search-list search-list-bookmark"></ul>
                                </div>
                            </li>
                        </ul> -->
                    </div>
             

                    <!-- <ul class="nav navbar-nav align-items-center ml-auto"> -->
                       
                       <!--  <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="selected-language"><?php //if(isset($_SESSION['Form_Language'])){ echo $_SESSION['Form_Language']; } ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                                 <?php 
                                      //  foreach ($formLanguageArray as $key => $value) {
                                    ?> 
                                         <a class="dropdown-item" href="javascript:void(0);"  onclick="setFormLanguageInSession('<?php //echo $value; ?>')"  > <?php //echo $value; ?></a>
                                    <?php
                                        //}
                                    ?>
                            </div>
                        </li> -->
                    <!-- </ul> -->
                    <ul class="nav navbar-nav float-right">
                        <!-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
                        </li> -->
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
                        <!-- <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon feather icon-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="feather icon-search primary"></i></div>
                                <input class="input" type="text" placeholder="Explore Vuexy..." tabindex="-1" data-search="template-list">
                                <div class="search-input-close"><i class="feather icon-x"></i></div>
                                <ul class="search-list search-list-main"></ul>
                            </div>
                        </li> -->
                        <!-- <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-shopping-cart"></i><span class="badge badge-pill badge-primary badge-up cart-item-count">6</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-cart dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white"><span class="cart-item-count">6</span><span class="mx-50">Items</span></h3><span class="notification-title">In Your Cart</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list"><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img src="app-assets/images/pages/eCommerce/4.png" width="75" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Apple - Apple Watch Series 1 42mm Space Gray Aluminum Case Black Sport Band - Space Gray Aluminum</span><span class="item-desc font-small-2 text-truncate d-block"> Durable, lightweight aluminum cases in silver, space gray,gold, and rose gold. Sport Band in a variety of colors. All the features of the original Apple Watch, plus a new dual-core processor for faster performance. All models run watchOS 3. Requires an iPhone 5 or later to run this device.</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $299</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img class="mt-1 pl-50" src="app-assets/images/pages/eCommerce/dell-inspirion.jpg" width="100" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Apple - Macbook® (Latest Model) - 12" Display - Intel Core M5 - 8GB Memory - 512GB Flash Storage - Space Gray</span><span class="item-desc font-small-2 text-truncate d-block"> MacBook delivers a full-size experience in the lightest and most compact Mac notebook ever. With a full-size keyboard, force-sensing trackpad, 12-inch Retina display,1 sixth-generation Intel Core M processor, multifunctional USB-C port, and now up to 10 hours of battery life,2 MacBook features big thinking in an impossibly compact form.</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $1599.99</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img src="app-assets/images/pages/eCommerce/7.png" width="88" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Sony - PlayStation 4 Pro Console</span><span class="item-desc font-small-2 text-truncate d-block"> PS4 Pro Dynamic 4K Gaming & 4K Entertainment* PS4 Pro gets you closer to your game. Heighten your experiences. Enrich your adventures. Let the super-charged PS4 Pro lead the way.** GREATNESS AWAITS</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $399.99</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img src="app-assets/images/pages/eCommerce/10.png" width="75" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Beats by Dr. Dre - Geek Squad Certified Refurbished Beats Studio Wireless On-Ear Headphones - Red</span><span class="item-desc font-small-2 text-truncate d-block"> Rock out to your favorite songs with these Beats by Dr. Dre Beats Studio Wireless GS-MH8K2AM/A headphones that feature a Beats Acoustic Engine and DSP software for enhanced clarity. ANC (Adaptive Noise Cancellation) allows you to focus on your tunes.</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $379.99</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img class="mt-1 pl-50" src="app-assets/images/pages/eCommerce/sony-75class-tv.jpg" width="100" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Sony - 75" Class (74.5" diag) - LED - 2160p - Smart - 3D - 4K Ultra HD TV with High Dynamic Range - Black</span><span class="item-desc font-small-2 text-truncate d-block"> This Sony 4K HDR TV boasts 4K technology for vibrant hues. Its X940D series features a bold 75-inch screen and slim design. Wires remain hidden, and the unit is easily wall mounted. This television has a 4K Processor X1 and 4K X-Reality PRO for crisp video. This Sony 4K HDR TV is easy to control via voice commands.</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $4499.99</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a><a class="cart-item" href="app-ecommerce-details.html">
                                        <div class="media">
                                            <div class="media-left d-flex justify-content-center align-items-center"><img class="mt-1 pl-50" src="app-assets/images/pages/eCommerce/canon-camera.jpg" width="70" alt="Cart Item"></div>
                                            <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Nikon - D810 DSLR Camera with AF-S NIKKOR 24-120mm f/4G ED VR Zoom Lens - Black</span><span class="item-desc font-small-2 text-truncate d-block"> Shoot arresting photos and 1080p high-definition videos with this Nikon D810 DSLR camera, which features a 36.3-megapixel CMOS sensor and a powerful EXPEED 4 processor for clear, detailed images. The AF-S NIKKOR 24-120mm lens offers shooting versatility. Memory card sold separately.</span>
                                                <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $4099.99</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center text-primary" href="app-ecommerce-checkout.html"><i class="feather icon-shopping-cart align-middle"></i><span class="align-middle text-bold-600">Checkout</span></a></li>
                                <li class="empty-cart d-none p-2">Your Cart Is Empty.</li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white">5 New</h3><span class="notification-title">App Notifications</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                                            <div class="media-body">
                                                <h6 class="primary media-heading">You have new order!</h6><small class="notification-text"> Are your going to meet me tonight?</small>
                                            </div><small>
                                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">9 hours ago</time></small>
                                        </div>
                                    </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
                                            <div class="media-body">
                                                <h6 class="success media-heading red darken-1">99% Server load</h6><small class="notification-text">You got new order of goods.</small>
                                            </div><small>
                                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">5 hour ago</time></small>
                                        </div>
                                    </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left"><i class="feather icon-alert-triangle font-medium-5 danger"></i></div>
                                            <div class="media-body">
                                                <h6 class="danger media-heading yellow darken-3">Warning notifixation</h6><small class="notification-text">Server have 99% CPU usage.</small>
                                            </div><small>
                                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                        </div>
                                    </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left"><i class="feather icon-check-circle font-medium-5 info"></i></div>
                                            <div class="media-body">
                                                <h6 class="info media-heading">Complete the task</h6><small class="notification-text">Cake sesame snaps cupcake</small>
                                            </div><small>
                                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                        </div>
                                    </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left"><i class="feather icon-file font-medium-5 warning"></i></div>
                                            <div class="media-body">
                                                <h6 class="warning media-heading">Generate monthly report</h6><small class="notification-text">Chocolate cake oat cake tiramisu marzipan</small>
                                            </div><small>
                                                <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">View all notifications</a></li>
                            </ul>
                        </li> -->
                        

                        
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600"></span><span class="user-status"><?php echo $_SESSION['SAL_FullName']; ?></span>
                                </div>
                                  <!--<span>
                                    <img class="round" src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span> -->
                                      <?php  
                                  $fulNameInitial = "";
                                  $fulNameArray = explode(" ", $_SESSION['SAL_FullName']);
                                  if(sizeof($fulNameArray)>1){
                                    $nameInitial1 = $fulNameArray[0]; 
                                    $nameInitial2 = $fulNameArray[1]; 
                                    $fulNameInitial = strtoupper(substr($nameInitial1, 0, 1)."".substr($nameInitial2, 0, 1));
                                  }else{
                                    $nameInitial1 = $fulNameArray[0]; 
                                    $fulNameInitial = strtoupper(substr($nameInitial1, 0, 1));
                                  }
                                ?>
                                 <span class="d-none d-sm-inline-block ml-1" data-letters="<?php echo $fulNameInitial; ?>"></span>
              
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- <a class="dropdown-item" href="page-user-profile.html"><i class="feather icon-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="app-email.html"><i class="feather icon-mail"></i> My Inbox</a>
                                <a class="dropdown-item" href="app-todo.html"><i class="feather icon-check-square"></i> Task</a>
                                <a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> Chats</a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="logout.php"><i class="feather icon-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="app-assets/images/icons/xls.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="app-assets/images/icons/doc.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                    </div>
                </div>
            </a></li>
    </ul> -->
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="home.php"  style="margin:unset">
                        <div class="brand-logo" style="background: url('<?php echo '../assets/imgs/' . ($_SESSION["SAL_ElectionName"]) . '_Logo.jpeg'; ?>') no-repeat center center; background-size: contain; width: 60px; height: 60px;"></div>
                        <h2 class="brand-text mb-2 mt-2" style="font-size: 16px !important"> <?= trim($_SESSION["SAL_ElectionName"]) ?> <br> Bazaar Trace</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
              <!--   <li class=" nav-item"><a href="home.php"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                    <ul class="menu-content"> -->
                        <!--<li ><a href="../index.php"><i class="feather icon-home"></i><span class="menu-item" data-i18n="Home">Home Page</span></a></li>-->
                        <li <?php if(!isset($_GET['p']) || ( isset($_GET['p']) && $_GET['p'] == 'home') ){ ?>   class="active"  <?php } ?>  ><a href="home.php" onclick="getLoaderUntilRefresh('home.php')"><i class="feather icon-home"></i><span class="menu-item" data-i18n="Dashboard">Admin Dashboard</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-data-validation' ){ ?>   class="active"  <?php } ?>  ><a href="../QC/home.php" onclick="getLoaderUntilRefresh('../QC/home.php')" ><i class="feather icon-check-circle"></i><span class="menu-item" data-i18n="QC Dashboard">QC Dashboard</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-data-validation' ){ ?>   class="active"  <?php } ?>  ><a href="../Client/home.php" onclick="getLoaderUntilRefresh('../Client/home.php')"><i class="feather icon-bar-chart"></i><span class="menu-item" data-i18n="Client Dashboard">Client Dashboard</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-data-validation' ){ ?>   class="active"  <?php } ?>  ><a href="../index.php?p=home-dashboard" onclick="getLoaderUntilRefresh('../index.php?p=home-dashboard')"><i class="feather icon-pie-chart"></i><span class="menu-item" data-i18n="Client Dashboard">Ward Officer Dashboard</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'listing-survey-filter' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=listing-survey-filter" onclick="getLoaderUntilRefresh('home.php?p=listing-survey-filter')" ><i class="feather icon-map"></i><span class="menu-item" data-i18n="Listing Survey Filter">Listing & Survey</span></a>
                        </li>

                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-first-and-last-entry' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=shop-first-and-last-entry" onclick="getLoaderUntilRefresh('home.php?p=shop-first-and-last-entry')"><i class="feather icon-user"></i><span class="menu-item" data-i18n="User Attendance">User Attendance</span></a>
                        </li>

                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'pocket-assign' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=pocket-assign" onclick="getLoaderUntilRefresh('home.php?p=pocket-assign')"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pocket Assign">Pocket Assigning</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'pocket-wise-shops-list' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=pocket-wise-shops-list" onclick="getLoaderUntilRefresh('home.php?p=pocket-wise-shops-list')"><i class="feather icon-map-pin"></i><span class="menu-item" data-i18n="Shops Listing ">Shops Listing </span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && ( $_GET['p'] == 'shops-assign' || $_GET['p'] == 'shops-assign-list' ) ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=shops-assign" onclick="getLoaderUntilRefresh('home.php?p=shops-assign')"><i class="feather icon-smartphone"></i><span class="menu-item" data-i18n="Shops Assign">Shops Assigning </span></a>
                        </li>

                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-summary' ){ ?>   class="active"  <?php } ?>  ><a href="home.php?p=pocket-wise-survey-summary" onclick="getLoaderUntilRefresh('home.php?p=pocket-wise-survey-summary')"><i class="feather icon-map-pin"></i><span class="menu-item" data-i18n="Survey Summary">Survey Summary</span></a>
                         </li> 
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-detail' ){ ?>   class="active"  <?php } ?>  ><a href="home.php?p=pocket-wise-survey-detail" onclick="getLoaderUntilRefresh('home.php?p=pocket-wise-survey-detail')"><i class="feather icon-map"></i><span class="menu-item" data-i18n="Survey Detail">Survey Detail</span></a>
                         </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'calling-summary' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=calling-summary" onclick="getLoaderUntilRefresh('home.php?p=calling-summary')"><i class="feather icon-phone-outgoing"></i><span class="menu-item" data-i18n="Calling Summary">Calling Summary</span></a>
                        </li>
             
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'executive-calling-list' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=executive-calling-list" onclick="getLoaderUntilRefresh('home.php?p=executive-calling-list')"><i class="feather icon-phone-call"></i><span class="menu-item" data-i18n="Executive Call Summary">Executive Calls </span></a>
                        </li>
              
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'calling-detail' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=calling-detail"><i class="feather icon-list"></i><span class="menu-item" data-i18n="Calling Detail">Calling Detail </span></a>
                        </li>
                         <!--   <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'executive-performance' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=executive-performance"><i class="feather icon-bar-chart-2"></i><span class="menu-item" data-i18n="Executive Performance">Executive Performance</span></a>
                         </li> -->
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-qc-summary' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=shop-qc-summary" ><i class="feather icon-check-square"></i><span class="menu-item" data-i18n="QC Summary">QC Summary</span></a>
                        </li>
                         <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-qc-log-detail' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=shop-qc-log-detail"><i class="feather icon-book"></i><span class="menu-item" data-i18n="QC Log Detail">QC Log Detail</span></a>
                        </li>
                        
                        <!-- <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-license-tracking' ){ ?>   class="active"  <?php } ?>  ><a href="home.php?p=shop-license-tracking"><i class="feather icon-truck"></i><span class="menu-item" data-i18n="Shop Tracking">Shop Tracking</span></a>
                        </li> -->

                        <li  class=" nav-item"><a href="#"><i class="feather icon-clipboard"></i><span class="menu-item" data-i18n="Shop License">Report</span></a>
                        <ul class="menu-content"> 
                            <li <?php if( isset($_GET['p']) && $_GET['p'] == 'listing-average-report' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=listing-average-report"><i class="feather icon-book"></i><span class="menu-item" data-i18n="Listing Average Report">Listing Average Report</span></a>
                            </li>
                            <li <?php if( isset($_GET['p']) && $_GET['p'] == 'survey-average-report' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=survey-average-report"><i class="feather icon-book"></i><span class="menu-item" data-i18n="Survey Average Report">Survey Average Report</span></a>
                            </li>
                            <li <?php if( isset($_GET['p']) && $_GET['p'] == 'all-report' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=all-report"><i class="feather icon-book"></i><span class="menu-item" data-i18n="Survey Average Report">All Report</span></a>
                            </li>
                            <li <?php if( isset($_GET['p']) && $_GET['p'] == 'qc-report' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=qc-report"><i class="feather icon-book"></i><span class="menu-item" data-i18n="QC Report">QC Report</span></a>
                            </li>
                            <li <?php if( isset($_GET['p']) && $_GET['p'] == 'document-pending-report' ){ ?>   class="active"  <?php } ?> ><a href="home.php?p=document-pending-report"><i class="feather icon-book"></i><span class="menu-item" data-i18n="Document Pending Report">Document Pending Report</span></a>
                            </li>
                        </ul>
                        </li>

          <!--       <li class=" navigation-header"><span>Shop License</span>  </li>
                
                <li  class=" nav-item"><a href="#"><i class="feather icon-shopping-bag"></i><span class="menu-item" data-i18n="Shop License">Shop License</span></a>
                    <ul class="menu-content"> -->
                         
                         <!-- 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-renewal' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-renewal"><i class="feather icon-pocket"></i><span class="menu-item" data-i18n="License Renewal">License Renewal</span></a>
                         </li> 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-receipt' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-receipt"><i class="feather icon-file-text"></i><span class="menu-item" data-i18n="Payment Receipt">Payment Receipt</span></a>
                         </li>  -->
                         <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-helpline' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-helpline"><i class="feather icon-file"></i><span class="menu-item" data-i18n="License Helpline">License Helpline</span></a>
                         </li>  -->
                   <!--  </ul>
                </li> -->

                <!-- <li class=" navigation-header"><span>Revenue Summary</span>  </li> -->

                <!-- <li  class=" nav-item"><a href="#"><i class="feather icon-dollar-sign"></i><span class="menu-item" data-i18n="Fund Manager">Revenue Summary</span></a>
                    <ul class="menu-content"> -->
                       <!--   <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-revenue-summary' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-revenue-summary"><i class="feather icon-pie-chart"></i><span class="menu-item" data-i18n="Revenue Summary">Revenue Summary</span></a>
                         </li>  -->
                       <!--   <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-revenue-business-category' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-revenue-business-category"><i class="feather icon-pocket"></i><span class="menu-item" data-i18n="Business Category">Business Category</span></a>
                         </li>  -->
                        <!--  <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-defaulters-detail"><i class="feather icon-user-x"></i><span class="menu-item" data-i18n="Defaulters Detail">Defaulters Detail</span></a>
                         </li>  -->
                    <!-- </ul>
                </li> -->


                <li class=" navigation-header"><span>Masters</span>  </li>
                
                <li class=" nav-item"><a href="#"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Masters">To Do Masters</span></a>
                    <ul class="menu-content">
                        
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'login-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=login-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Login Master">Login Master</span></a>
                        </li>
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'login-detail' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=login-detail"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Login Detail">Login Detail</span></a>
                        </li>  -->
                        <!--  
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'license-user-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=license-user-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="License User Master">User Master</span></a>
                        </li>
                        -->
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'node-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=node-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Node Master">Node Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'pocket-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=pocket-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pocket Master">Pocket Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'business-category-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=business-category-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Business Category Master">Business Category Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'drop-down-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=drop-down-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Drop Down Master">Drop Down Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-area-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=shop-area-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop Area Master">Shop Area Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'calling-category-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=calling-category-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Calling Category Master">Calling Category Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'shop-document-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=shop-document-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop Document Master">Shop Document Master</span></a>
                        </li>
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'board-tax-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=board-tax-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Board Tax Master">Board Tax Master</span></a>
                        </li> -->
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'faq-master' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=faq-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="FAQ Master">FAQ Master</span></a>
                        </li>
                        <li <?php if( isset($_GET['p']) && $_GET['p'] == 'assign-ward-officer' ){ ?>   class="active"  <?php } ?> >
                            <a href="home.php?p=assign-ward-officer"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Assign Ward Officer">Assign Ward Officer</span></a>
                        </li>
                    </ul>
                </li>
              
           
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">

            <div id='spinnerLoader1' style="display:none;text-align:center;align:center;" width="1000" height="1000">
        <section id="dashboard-analytics">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-12 text-center" id="spindiv">
                  
                    <img id="spinnerImage" style="display:none;" src='app-assets/images/loader/load.gif' width="100" height="100"/>
                                
                </div>
            </div>
        </section>
        </div>
        <div id="bodyId">
                