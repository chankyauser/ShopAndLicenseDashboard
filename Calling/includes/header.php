<?php 
    include 'checksession.php';
    include '../api/includes/DbOperation.php';

    $containmentZoneMapAndListDetail = array();
    $dataPocketMapAndListSummary = array();
    $pocketShopsSurveyMapAndListDetail = array();
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
           <?php if(isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?>  Shop & License | Defaulters List <?php }else{ ?>  Shop & License | Calling | Dashboard <?php }   ?>    
    </title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <?php
        //if(isset($_GET['p']) && $_GET['p'] == 'home-dashboard' ){ ?> 
            <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/apexcharts.css">
    <?php //}?>
     <!-- <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css"> -->
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
    <!-- <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/charts/chart-apex.css"> -->
    <!-- maps -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- End Data List View -->
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/style.css">
    <!-- END: Custom CSS-->

    <script src="includes/ajaxscript.js"></script>

    <style type="text/css">
        body.vertical-layout.vertical-menu-modern.menu-collapsed .header-navbar.floating-nav {
            width: calc(100vw - (100vw - 100%) - 4.4rem - 0px);
        }
    </style> 
   
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
 <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  pace-done menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <!-- <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                        </ul> -->
                        <ul class="nav navbar-nav bookmark-icons">
                            <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                            <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                            <!--     i.ficon.feather.icon-menu-->
                            <li class="nav-item dropdown dropdown-electionname">
                                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <h2 class="brand-text mb-0 "> 
                                        <?php echo $_SESSION['SAL_ElectionName']; ?> Shop License 
                                    </h2>
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
                        </ul>
                       
                    </div>
             

                   
                    <ul class="nav navbar-nav float-right">
                        <!-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
                        </li> -->
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
                        

                        
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
    
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <!-- <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="home.php">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">ShopLicense</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"> -->
              <!--   <li class=" nav-item"><a href="home.php"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                    <ul class="menu-content"> -->
                        <!-- <li <?php// if(!isset($_GET['p']) || ( isset($_GET['p']) && $_GET['p'] == 'home') ){ ?>   class="active"  <?php //} ?>  ><a href="home.php"><i class="feather icon-home"></i><span class="menu-item" data-i18n="Analytics">Home Dashboard</span></a> -->
                        </li>
                        
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'contact-tracing-dashboard' ){ ?>   class="active"  <?php //} ?> ><a href="home.php?p=contact-tracing-dashboard"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Contact Tracing">Contact Tracing </span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'hotspot-testing-dashboard' ){ ?>   class="active"  <?php //} ?> ><a href="home.php?p=hotspot-testing-dashboard"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Hotspot Testing">Hotspot Testing </span></a>
                        </li> -->
                      <!--   <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="eCommerce">Contact Tracing Dashboard</span></a>
                        </li> -->
                  <!--   </ul>
                </li> -->


                <!-- <li class=" nav-item"><a href="#"><i class="feather icon-smartphone"></i><span class="menu-title" data-i18n="Call Assign">Survey Assigning</span></a>
                    <ul class="menu-content"> -->
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'pocket-assign' ){ ?>   class="active"  <?php// } ?> >
                            <a href="home.php?p=pocket-assign"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pocket Assign">Pocket Assign</span></a>
                        </li>
                        <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'survey-assign' ){ ?>   class="active"  <?php //} ?> ><a href="home.php?p=survey-assign"><i class="feather icon-smartphone"></i><span class="menu-item" data-i18n="Survey Assign">Survey Assign </span></a>
                        </li> -->
                        <!--  <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shoplist-edit' ){ ?>   class="active"  <?php// } ?> ><a href="home.php?p=shoplist-edit"><i class="feather icon-edit"></i><span class="menu-item" data-i18n="Shoplist Calling Edit">Shop Details Edit </span></a>
                        </li>
                        <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'shoplist-view' ){ ?>   class="active"  <?php// } ?> ><a href="home.php?p=shoplist-view"><i class="feather icon-eye"></i><span class="menu-item" data-i18n="Shoplist Calling View">Shop Details View </span></a>
                        </li> -->
                   <!--  </ul>
                </li> -->
                

          <!--       <li class=" nav-item"><a href="#"><i class="feather icon-phone"></i><span class="menu-title" data-i18n="Call Assign">Call Assigning</span></a>
                    <ul class="menu-content"> -->
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'call-assign' ){ ?>   class="active"  <?php //} ?> ><a href="home.php?p=call-assign"><i class="feather icon-phone"></i><span class="menu-item" data-i18n="Call Assign">Call Assign </span></a>
                        </li> -->
                    <!-- </ul>
                </li> 
                -->

          <!--       <li  class=" nav-item"><a href="#"><i class="feather icon-map-pin"></i><span class="menu-item" data-i18n="Survey Summary">Survey Summary</span></a>
                    <ul class="menu-content"> -->
                         <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-summary' ){ ?>   class="active"  <?php// } ?>  ><a href="home.php?p=pocket-wise-survey-summary"><i class="feather icon-map-pin"></i><span class="menu-item" data-i18n="Survey Summary">Survey Summary</span></a>
                         </li> 
                         <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-detail' ){ ?>   class="active"  <?php// } ?>  ><a href="home.php?p=pocket-wise-survey-detail"><i class="feather icon-map"></i><span class="menu-item" data-i18n="Survey Detail">Survey Detail</span></a>
                         </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'executive-wise-survey-detail' ){ ?>   class="active"  <?php// } ?>  ><a href="home.php?p=executive-wise-survey-detail"><i class="feather icon-user"></i><span class="menu-item" data-i18n="Survey Executive List"> Executive Survey</span></a>
                         </li>  -->
                    <!-- </ul>
                </li> -->

            
                <?php //if(isset($_SESSION['SAL_Designation']) && ( $_SESSION['SAL_Designation']=='Calling' || $_SESSION['SAL_Designation']=='Admin' ) ){?> 
                    <!-- <li class=" nav-item"><a href="#"><i class="feather icon-smartphone"></i><span class="menu-title" data-i18n="Call Assign">Calling Summary</span></a>
                    <ul class="menu-content"> -->
                        <?php //if( $_SESSION['SAL_Designation']=='Admin' ){?> 
                            <!-- <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'calling-summary' ){ ?>   class="active"  <?php //} ?> ><a href="home.php?p=calling-summary"><i class="feather icon-phone-outgoing"></i><span class="menu-item" data-i18n="Calling Summary">Calling Summary</span></a>
                            </li> -->
                        <?php //} ?>
                        
                        <?php //if( $_SESSION['SAL_Designation']=='Admin' ){ ?> 
                            <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'calling-detail' ){ ?>   class="active"  <?php// } ?> ><a href="home.php?p=calling-detail"><i class="feather icon-list"></i><span class="menu-item" data-i18n="Calling Detail">Calling Detail </span></a>
                            </li> -->
                        <?php //} ?>

                        <?php //if( $_SESSION['SAL_Designation']=='Calling'  || $_SESSION['SAL_Designation']=='Admin' ){ ?> 
                            <!-- <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'executive-calling-list' ){ ?>   class="active"  <?php// } ?> ><a href="home.php?p=executive-calling-list"><i class="feather icon-phone-call"></i><span class="menu-item" data-i18n="Executive Call Summary">Executive Calls </span></a>
                            </li> -->
                        <?php //} ?>
                    <!-- </ul> -->


                    <!-- </li> -->
                <?php //} ?>
                 
                

                
              <!--   <li  class=" nav-item"><a href="#"><i class="feather icon-user-check"></i><span class="menu-item" data-i18n="Survey Supervisor">Survey Supervisor</span></a>
                    <ul class="menu-content">
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'executive-attendance' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=executive-attendance"><i class="feather icon-list"></i><span class="menu-item" data-i18n="Executive Attendance">Executive Attendance</span></a>
                         </li> 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'executive-performance' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=executive-performance"><i class="feather icon-bar-chart-2"></i><span class="menu-item" data-i18n="Executive Performance">Executive Performance</span></a>
                         </li> 
                    </ul>
                </li>

                 <li  class=" nav-item"><a href="#"><i class="feather icon-check"></i><span class="menu-item" data-i18n="Quality Check">Quality Check</span></a>
                    <ul class="menu-content">
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'survey-qc-detail' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=survey-qc-detail"><i class="feather icon-check-square"></i><span class="menu-item" data-i18n="Survey QC">Survey QC</span></a>
                         </li> 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'calling-qc-detail' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=calling-qc-detail"><i class="feather icon-check-square"></i><span class="menu-item" data-i18n="Calling QC">Calling QC</span></a>
                         </li> 
                    </ul>
                </li> -->
                
          <!--       <li class=" navigation-header"><span>Shop License</span>  </li>
                
                <li  class=" nav-item"><a href="#"><i class="feather icon-shopping-bag"></i><span class="menu-item" data-i18n="Shop License">Shop License</span></a>
                    <ul class="menu-content"> -->
                         <!-- <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'shop-license-tracking' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-tracking"><i class="feather icon-truck"></i><span class="menu-item" data-i18n="Shop License">License Tracking</span></a>
                         </li> 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-renewal' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-renewal"><i class="feather icon-pocket"></i><span class="menu-item" data-i18n="License Renewal">License Renewal</span></a>
                         </li> 
                         <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-receipt' ){ ?>   class="active"  <?php// } ?>  ><a href="home.php?p=shop-license-receipt"><i class="feather icon-file-text"></i><span class="menu-item" data-i18n="Payment Receipt">Payment Receipt</span></a>
                         </li>  -->
                         <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-helpline' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-helpline"><i class="feather icon-file"></i><span class="menu-item" data-i18n="License Helpline">License Helpline</span></a>
                         </li>  -->
                   <!--  </ul>
                </li> -->

                <!-- <li class=" navigation-header"><span>Revenue Summary</span>  </li> -->

                <!-- <li  class=" nav-item"><a href="#"><i class="feather icon-dollar-sign"></i><span class="menu-item" data-i18n="Fund Manager">Revenue Summary</span></a>
                    <ul class="menu-content"> -->
                         <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-revenue-summary' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-revenue-summary"><i class="feather icon-pie-chart"></i><span class="menu-item" data-i18n="Revenue Summary">Revenue Summary</span></a>
                         </li>  -->
                       <!--   <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-revenue-business-category' ){ ?>   class="active"  <?php //} ?>  ><a href="home.php?p=shop-license-revenue-business-category"><i class="feather icon-pocket"></i><span class="menu-item" data-i18n="Business Category">Business Category</span></a>
                         </li>  -->
                         <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?>   class="active"  <?php// } ?>  ><a href="home.php?p=shop-license-defaulters-detail"><i class="feather icon-user-x"></i><span class="menu-item" data-i18n="Defaulters Detail">Defaulters Detail</span></a>
                         </li>  -->

                    <!-- </ul>
                </li> -->


                <!-- <li class=" navigation-header"><span>Masters</span>  </li> -->
                
                <!-- <li class=" nav-item"><a href="#"><i class="feather icon-check-square"></i><span class="menu-title" data-i18n="Masters">To Do Masters</span></a>
                    <ul class="menu-content"> -->
                   <!--      <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'executive-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=executive-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Executive Master">Executive Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'login-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=login-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Login Master">Login Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'license-user-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=license-user-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="License User Master">User Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'login-detail' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=login-detail"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Login Detail">Login Detail</span></a>
                        </li> -->
                        <!-- <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'node-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=node-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Node Master">Node Master</span></a>
                        </li>
                        <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'pocket-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=pocket-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pocket Master">Pocket Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'business-category-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=business-category-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Business Category Master">Business Category Master</span></a>
                        </li>
                        <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'drop-down-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=drop-down-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Drop Down Master">Drop Down Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-area-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=shop-area-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop Area Master">Shop Area Master</span></a>
                        </li>
                        <li <?php// if( isset($_GET['p']) && $_GET['p'] == 'calling-category-master' ){ ?>   class="active"  <?php// } ?> >
                            <a href="home.php?p=calling-category-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Calling Category Master">Calling Category Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'shop-document-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=shop-document-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop Document Master">Shop Document Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'board-tax-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=board-tax-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Board Tax Master">Board Tax Master</span></a>
                        </li>
                        <li <?php //if( isset($_GET['p']) && $_GET['p'] == 'faq-master' ){ ?>   class="active"  <?php //} ?> >
                            <a href="home.php?p=faq-master"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="FAQ Master">FAQ Master</span></a>
                        </li> -->
                    <!-- </ul>
                </li>
              
           
            </ul>
        </div>
    </div> -->
    <!-- END: Main Menu-->

    
    <!-- BEGIN: Content-->
    <div class="app-content content" style="width:100%;margin-left:0px;">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            
            <style type="text/css">
                html body .content .content-wrapper .content-header-title{
                    margin: 0.3rem 1rem;
                }
                .breadcrumb {
                    font-size: 1.10rem;
                    border-left: 1px solid #D6DCE1;
                    margin-left:  -1rem !important;
                }
            </style>

            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h3 class="content-header-title float-left mb-0">Calling Dashboard</h3>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">

                                        <?php if(!isset($_GET['p']) || ( isset($_GET['p']) && $_GET['p'] == 'home') ){ ?>  
                                                    Calls Assigned List
                                        <?php } elseif(isset($_GET['p']) && $_GET['p'] == 'shoplist-edit' ){ ?> 
                                                    Edit Shop Details
                                        <?php } elseif(isset($_GET['p']) && $_GET['p'] == 'shoplist-view' ){ ?> 
                                                    View Shop Details
                                        <?php } elseif(isset($_GET['p']) && $_GET['p'] == 'shoplist-track' ){ ?> 
                                                    Application Tracking Status
                                        <?php }   ?> 
                                        

                                        
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-menu"></i>
                            </button>
                            <!-- <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Chat</a>
                                <a class="dropdown-item" href="#">Email</a>
                                <a class="dropdown-item" href="#">Calendar</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
                        
                            