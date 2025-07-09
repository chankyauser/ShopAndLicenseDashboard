<?php 
    include 'checksession.php';
    include '../api/includes/DbOperation.php';
  
    $qcTypeArray = array(array('QC_Title' => 'Shop Listing', 'QC_Type' =>'ShopList', 'QC_Flag' =>1), array('QC_Title' => 'Shop Survey', 'QC_Type' =>'ShopSurvey', 'QC_Flag' =>2), array('QC_Title' => 'Shop Board', 'QC_Type' =>'ShopBoard', 'QC_Flag' =>5), array('QC_Title' => 'Shop Document', 'QC_Type' =>'ShopDocument', 'QC_Flag' =>3), array('QC_Title' => 'Shop Calling', 'QC_Type' =>'ShopCalling', 'QC_Flag' =>4));
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
           <?php if(isset($_GET['p']) && $_GET['p'] == 'shop-license-defaulters-detail' ){ ?>  Shop & License | Defaulters List <?php }else{ ?>  Shop & License | QC Dashboard <?php }   ?>    
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
                        <ul class="nav navbar-nav">
                            <li class="dropdown dropdown-user nav-item">
                                
                                <a class="nav-link nav-menu-main dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="ficon feather icon-menu"></i></a>
                            
                             <div class="dropdown-menu dropdown-menu-left">
                                <a class="dropdown-item" href="home.php">Home</a>
                                <?php if(isset($_SESSION['SAL_UserName']) && isset($_SESSION['SAL_AppName']) && isset($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType'] == 'Admin'  ){ ?>
                                    <a class="dropdown-item" href="../admin/home.php">Admin Dashboard</a>
                                    <a class="dropdown-item" href="../Client/index.php">Client Dashboard</a>
									<a class="dropdown-item" href="../index.php?p=home-dashboard">Ward Officer Dashboard</a>
                                <?php } ?>
                                <a class="dropdown-item" href="home.php?p=shop-qc-list">QC Shops</a>
                                <a class="dropdown-item" href="home.php?p=shop-data-validation">Data Validation</a>
                                <!-- <a class="dropdown-item" href="home.php?p=shop-qc-summary">QC Summary</a> -->
                                
                            </div> 
                            
                        </li>

                        </ul>
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
								
								<?php 
									if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Admin' ) {
								?>
											<a class="dropdown-item" href="../qc/index.php" ><i class="feather icon-home"></i> Home</a>
											<a class="dropdown-item" href="../admin/index.php" ><i class="feather icon-user"></i> Admin Dashboard</a>
											<a class="dropdown-item" href="../Client/index.php" ><i class="feather icon-bar-chart-2"></i> Client Dashboard</a>
											<a class="dropdown-item" href="../index.php?p=home-dashboard" ><i class="feather icon-pie-chart"></i> Ward Officer Dashboard</a>
										
								<?php    
									}
								?>
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


    
    <!-- BEGIN: Content-->
    <div class="app-content content" style="width:100%;margin-left:0px;">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            
            <!-- <style type="text/css">
                html body .content .content-wrapper .content-header-title{
                    margin: 0.3rem 1rem;
                }
                .breadcrumb {
                    font-size: 1.10rem;
                    border-left: 1px solid #D6DCE1;
                    margin-left:  -1rem !important;
                }
                .card-body {
                    padding: 1rem;
                }
                label{
                    font-weight: 900;
                    color:#C90D41;
                }
            </style>

            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h3 class="content-header-title float-left mb-0">QC Dashboard</h3>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">

                                        <?php //if(!isset($_GET['p']) || ( isset($_GET['p']) && $_GET['p'] == 'home') ){ ?>  
                                                    QC Dashboard
                                        <?php //} elseif(isset($_GET['p']) && $_GET['p'] == 'shop-qc-list' ){ ?> 
                                                    QC Shops List
                                        <?php //} elseif(isset($_GET['p']) && $_GET['p'] == 'shop-qc-summary' ){ ?> 
                                                    QC Summary
                                        <?php //} elseif(isset($_GET['p']) && $_GET['p'] == 'shoplist-track' ){ ?> 
                                                    Application Tracking Status
                                        <?php //}   ?> 
                                        

                                        
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div> -->
                        
                            