<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include 'api/includes/DbOperation.php';

    $db2=new DbOperation();

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    // if(!isset($_SESSION['SAL_View_Type'])){
        $_SESSION['SAL_View_Type'] = 'ListView';
    // }

        if($_SESSION['SAL_UserType'] == 'Ward Officer'){
            
        }else{
            header('Location:index.php');
        }
?>

 <section class="featured section-padding">

    <div class="page-header mt-30 mb-50">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Snack</h1>
                        <div class="breadcrumb">
                            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Shop <span></span> Snack
                        </div>
                    </div>
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        <ul class="tags-list">
                            <li class="hover-up">
                                <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Cabbage</a>
                            </li>
                            <li class="hover-up active">
                                <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Broccoli</a>
                            </li>
                            <li class="hover-up">
                                <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Artichoke</a>
                            </li>
                            <li class="hover-up">
                                <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Celery</a>
                            </li>
                            <li class="hover-up mr-0">
                                <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Spinach</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

        <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
            <h5 class="section-title style-1 mb-30">New products</h5>
            <div class="single-post clearfix">
                <div class="image">
                    <img src="assets/imgs/shop/thumbnail-3.jpg" alt="#" />
                </div>
                <div class="content pt-10">
                    <h5><a href="shop-product-detail.html">Chen Cardigan</a></h5>
                    <p class="price mb-0 mt-5">$99.50</p>
                    <div class="product-rate">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                </div>
            </div>
            <div class="single-post clearfix">
                <div class="image">
                    <img src="assets/imgs/shop/thumbnail-4.jpg" alt="#" />
                </div>
                <div class="content pt-10">
                    <h6><a href="shop-product-detail.html">Chen Sweater</a></h6>
                    <p class="price mb-0 mt-5">$89.50</p>
                    <div class="product-rate">
                        <div class="product-rating" style="width: 80%"></div>
                    </div>
                </div>
            </div>
            <div class="single-post clearfix">
                <div class="image">
                    <img src="assets/imgs/shop/thumbnail-5.jpg" alt="#" />
                </div>
                <div class="content pt-10">
                    <h6><a href="shop-product-detail.html">Colorful Jacket</a></h6>
                    <p class="price mb-0 mt-5">$25</p>
                    <div class="product-rate">
                        <div class="product-rating" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>