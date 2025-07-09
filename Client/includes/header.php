<?php 
    ob_start();
    session_start();
    date_default_timezone_set('Asia/Kolkata');

    ini_set('max_execution_time', '1000'); // 5 min
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    $pageLanguageArray = array('English','Marathi');

    if(!isset($_SESSION['Page_Language'])){
        $_SESSION['Page_Language'] = 'English';
    }
    $_SESSION['SAL_AppName'] = "ShopAndLicence";
    $_SESSION['SAL_DevelopmentMode'] = "Live";



    $startTime = "00:00:00";
    $endTime = "23:59:59";
    $_SESSION['StartTime']=$startTime;
    $_SESSION['EndTime']=$endTime;

    if(!isset($_SESSION['SAL_ElectionName'])){
        $_SESSION['SAL_ElectionName']='CSMC';
    }

    include '../api/includes/DbOperation.php';

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }else{
        header('Location:../index.php');
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $electionName = 'CSMC';

    $db=new DbOperation();
    $currentDate = date('Y-m-d');
    $fromDate = $currentDate." ".$_SESSION['StartTime'];
    $toDate =$currentDate." ".$_SESSION['EndTime']; 

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
     $dataNodeName = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
        ISNULL(NodeMaster.NodeName,'') as NodeName,
        ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar
        FROM NodeMaster 
        INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
        INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
        WHERE NodeMaster.IsActive = 1 
        GROUP BY NodeMaster.NodeName, NodeMaster.NodeNameMar
        ORDER BY NodeMaster.NodeName";
    $db=new DbOperation();
    $dataNodeName = $db->ExecutveQueryMultipleRowSALData($dataNodeName, $electionName, $developmentMode);
    // print_r($dataNodeName);

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $_SESSION['SAL_ElectionName'];  ?> Bazaar Trace | Dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/logo/logo.png" /> -->
      <link rel="shortcut icon" type="image/x-icon" href="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" />
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="assets/css/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tables/datatable/extensions/dataTables.checkboxes.css">

    <link rel="stylesheet" type="text/css" href="assets/css/forms/select/select2.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" href="assets/css/main.css?v=5.3" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="includes/ajaxscript.js"></script>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>

</head>

<body>
    
    
    <input type="hidden" name="electionName" value="<?php echo $electionName; ?>">
    <div class="search-style-2" style="display: none;">
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
                ORDER BY NodeMaster.Ward_No";
            $db=new DbOperation();
            $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
            // print_r($dataNode);
             $dataNodeName = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
                ISNULL(NodeMaster.NodeName,'') as NodeName,
                ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar
                FROM NodeMaster 
                INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
                INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
                WHERE NodeMaster.IsActive = 1 
                GROUP BY NodeMaster.NodeName, NodeMaster.NodeNameMar
                ORDER BY NodeMaster.NodeName";
            $db=new DbOperation();
            $dataNodeName = $db->ExecutveQueryMultipleRowSALData($dataNodeName, $electionName, $developmentMode);
            // print_r($dataNodeName);
        ?>
<!-- onchange="setShopBusinessCategoriesWardFilter(1)" -->
        <select class="select-active" id="node_id"  name="nodeCd"

            <?php
               //if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName']) && !isset($_GET['p'])) {
            ?>
                   
            <?php
               // }else

                if (isset($_SESSION['SAL_FullName']) && !empty($_SESSION['SAL_FullName']) && isset($_GET['p'])  && ($_GET['p']=='survey-shops' || $_GET['p']=='shop-license' || $_GET['p']=='shop-tracking') ) {
            ?>
                   
            <?php
               }else{   
            ?>
                    
            <?php
               }
            ?>

        >
    
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
    </div>
    <input type="hidden" id="business_cat_id" name="businessCatCd" value="<?php echo $businessCatCd; ?>">

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="assets/imgs/theme/load.gif" alt="" height="100" width="100"/>
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
    <!-- View Shop Detail -->
    <div class="modal fade custom-modal" id="quickViewShopDetailModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalCloseId" style="display: none;"></button>
                <div class="modal-header" id="modalHeaderId">
                    <h4 class="modal-title">Shop Details And Documents</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="showQuickShopDetails">
                        
                    </div>
                </div>
                <div class="modal-footer" id="modalFooterId">
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12">
                            <button type="button" class="btn-sm btn-success" id="verifyShopDetailId" <?php if($_SESSION['SAL_ElectionName']=='PCMC' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> onclick="setVerifyAndApproveShopDetail()" <?php } ?>  style="display: none;" >Verify</button>
                            <button type="button" class="btn-sm btn-danger" id="verifyShopDetailId" <?php if($_SESSION['SAL_ElectionName']=='PCMC' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> onclick="setRejectShopDetail()" <?php } ?> style="display: none;"  >Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="payShopLicenseFeeModal" tabindex="-1" aria-labelledby="payShopLicenseFeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalPaymentCloseId" style="display: none;"></button>
                <div class="modal-header" id="modalPaymentHeaderId">
                    <h4 class="modal-title">License Fee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="showShopLicenseFeeDetails">
                        
                    </div>
                </div>
                <div class="modal-footer" id="modalPaymentFooterId">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="payShopLicenseFeeBtnId" <?php if($_SESSION['SAL_ElectionName']=='PCMC' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> onclick="setPayShopLicenseFeeDetail()" <?php } ?> style="display: none;">Pay Now</button>
                </div>
            </div>
        </div>
    </div>
    <header class="header-area header-style-1 header-height-2">
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1">
                        <a href="index.php">
                              <div class="logo d-none d-lg-flex" style="width: max-content">
                                    <!-- <img src="assets/imgs/theme/logo.png" height="50" alt="logo" /> -->
                                    <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" height="50" alt="logo" />
                                    <p> <?= trim($_SESSION["SAL_ElectionName"]) ?><br> Bazaar Trace</p>
                              </div>
                        </a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="../"><i class="fa-solid fa-house"></i> Home </a>
                                    </li>
                                    <li>
                                        <a <?php if  ((!isset($_GET['p'])) || $_GET['p'] == 'home-dashboard') { ?> class="active" <?php } ?> href="home.php"><i class="fa-solid fa-chart-line"></i> Dashboard </a>
                                    </li>
                                    <li>
                                        <a <?php if
                                        (
                                            (isset($_GET['p']) && $_GET['p'] == 'survey-map') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'survey-grid') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'survey-list') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'shop-survey-summary') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'survey-shops')

                                        ){ ?>   class="active"  <?php } ?> href="#"><i class="fa-solid fa-check-to-slot"></i> Shop Survey </a>
                                        <ul class="sub-menu">
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'shop-survey-summary') ){ ?> class="active" <?php }  ?> href="index.php?p=shop-survey-summary"> <i class="fa-solid fa-chart-pie"></i> &nbsp; Summary</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-map') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-map"><i class="fa-solid fa-location-dot"></i> &nbsp; GIS Map</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-shops') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-shops"> <i class="fa-solid fa-file-circle-check"></i> &nbsp; Survey Details</a></li>
                                            <!-- <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-grid') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-grid">Survey Grid</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'survey-list') ){ ?> class="active" <?php }  ?> href="index.php?p=survey-list">Survey List</a></li> -->
                                        </ul>
                                    </li>
                                   

                                    <!-- <li>
                                        <a <?php if
                                        (
                                            (isset($_GET['p']) && $_GET['p'] == 'calling-map') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'calling-grid') ||
                                            (isset($_GET['p']) && $_GET['p'] == 'calling-list')

                                        ){ ?>   class="active"  <?php } ?> href="index.php">Follow-Up<i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                        <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'calling-map') ){ ?> class="active" <?php }  ?> href="index.php?p=calling-map">Comming Soon</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'calling-grid') ){ ?> class="active" <?php }  ?> href="index.php?p=calling-grid">Comming Soon</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'calling-list') ){ ?> class="active" <?php }  ?> href="index.php?p=calling-list">Comming Soon</a></li>
                                        </ul>
                                    </li> -->
                                    <li>
                                        <a <?php if (isset($_GET['p']) && ( $_GET['p'] == 'shop-license' || $_GET['p']== 'shop-license-summary') ) { ?>   class="active"  <?php } ?>
                                        href="#"><i class="fa-solid fa-id-card"></i> Shop License 
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'shop-license-summary') ){ ?> class="active" <?php }  ?> href="index.php?p=shop-license-summary"> <i class="fa-solid fa-chart-pie"></i> &nbsp; Summary</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'shop-license') ){ ?> class="active" <?php }  ?> href="index.php?p=shop-license"> <i class="fa-solid fa-id-card"></i> &nbsp; License Details</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a <?php if (isset($_GET['p']) && $_GET['p'] == 'shop-tracking') { ?> class="active" <?php } ?>
                                        href="index.php?p=shop-tracking"> <i class="fa-solid fa-clock"></i> Shop Tracking </a>
                                    </li>

                                  <li>
                                        <a <?php if (isset($_GET['p']) && ( $_GET['p'] == 'Billing-reports' || $_GET['p']== 'collection-report' || $_GET['p'] == 'pending-report') ){ ?> class="active" <?php } ?>
                                        href="index.php?p=Billing-reports"><img src="./assets/imgs/logo/rupee.png" style="width:20px; height:20px; object-fit:contain"> Revenue Dashboard</a>
                                        <ul class="sub-menu">
                                        <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'collection-report') ){ ?> class="active" <?php }  ?> href="index.php?p=collection-report"> <i class="fa-solid fa-chart-pie"></i> &nbsp; Collection Report</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'pending-report') ){ ?> class="active" <?php }  ?> href="index.php?p=pending-report"> <i class="fa-solid fa-filter-circle-dollar"></i> &nbsp; Pending Report</a></li>
                                            
                                        </ul>
                                    </li>
                                    <li>
                                        <a <?php if (isset($_GET['p']) && ( $_GET['p'] == 'shop-revenue-summary' || $_GET['p']== 'shop-license-defaulters' ) ){ ?> class="active" <?php } ?>
                                        href="#"><i class="fa-solid fa-indian-rupee-sign"></i> Revenue Statistics </a>
                                        <ul class="sub-menu">
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'shop-revenue-summary') ){ ?> class="active" <?php }  ?> href="index.php?p=shop-revenue-summary"> <i class="fa-solid fa-chart-pie"></i> &nbsp; Summary</a></li>
                                            <li><a <?php if(isset($_GET['p']) && ( $_GET['p']== 'shop-license-defaulters') ){ ?> class="active" <?php }  ?> href="index.php?p=shop-license-defaulters"> <i class="fa-solid fa-filter-circle-dollar"></i> &nbsp; License Defaulters</a></li>
                                            
                                        </ul>
                                    </li>
                                    <!-- <li>
                                        <a <?php if (isset($_GET['p']) && $_GET['p'] == 'all-report') { ?> class="active" <?php } ?>
                                        href="index.php?p=all-report"><i class="fa-solid fa-file-pdf"></i> Reports  -->
                                        

                                        <!-- <a href="https://datastudio.google.com/reporting/42f90ce4-bcee-46a4-8029-39720d624736/page/39C5C" target="_blank"><i class="fa-solid fa-file-pdf"></i> Reports -->

                                         <!-- <a href="index.php?p=all-report" target="_blank">Reports<i class="fi-rs-angle-down"></i></a> -->
                                        <!-- <ul class="sub-menu">
                                            <li><a href="https://datastudio.google.com/embed/reporting/a68c38a2-8234-4e57-a7c9-00e3271c4c4b/page/yQ64C" target="_blank">Survey Report</a></li>
                                            <li><a href="https://datastudio.google.com/embed/reporting/2c8793f8-483e-4ffc-a9a6-a3c24963c02b/page/RB84C" target="_blank">Revenue Report</a></li>
                                        </ul> -->

                                    <!-- </li> -->
                                </ul>
                            </nav>
                        </div>
                    </div>

                            <div class="header-action-right">
                                <div class="header-action-2">
                                    <div class="header-action-icon-2">
                                          <div class="hotline d-none d-lg-flex">
                                                <img src="assets/imgs/theme/icons/icon-user.svg" alt="hotline" />
                                                <p style="font-size:18px;">
                                                    <?php 
                                                        if (!isset($_SESSION['SAL_FullName'])) {
                                                    ?>
                                                        Log In
                                                    <span>User </span>
                                                    <?php        
                                                        }else{
                                                    ?>
                                                    <?php echo $_SESSION['SAL_FullName']; ?>
                                                    <span><?php echo $_SESSION['SAL_UserType']; ?></span>
                                                    <?php
                                                        }
                                                    ?>
                                                </p>
                                          </div>
                                          <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                              <ul>
												<?php 
													if (isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && $_SESSION['SAL_UserType']== 'Admin' ) {
												?>
														<li>
															<a href="../admin/index.php" ><i class="fi fi-rs-home mr-10"></i> Admin Dashboard</a>
														</li>
														<li>
															<a href="../qc/index.php" ><i class="fi fi-rs-home mr-10"></i> QC Dashboard</a>
														</li>
														<li>
															<a href="../index.php?p=home-dashboard" ><i class="fi fi-rs-home mr-10"></i> Ward Officer Dashboard</a>
														</li>
												<?php    
													}
												?>
                                                  <li>
                                                      <a href="logout.php"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                  </li>
                                              </ul>
                                          </div>
                                    </div>
                                </div>
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
                                <a href="shop-wishlist.html">
                                    <img alt="Nest" src="assets/imgs/theme/icons/icon-heart.svg" />
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="Nest" src="assets/imgs/theme/icons/icon-cart.svg" />
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="assets/imgs/shop/thumbnail-3.jpg" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="assets/imgs/shop/thumbnail-4.jpg" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main" id="showPageDetails">