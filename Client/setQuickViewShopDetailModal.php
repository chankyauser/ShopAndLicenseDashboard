<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include '../api/includes/DbOperation.php';

$shopDetail = array();

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
    if(isset($_GET['shopId']) && !empty($_GET['shopId']) ){

        try  
            {  
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $shopId = $_GET['shopId'];
                

                $db2=new DbOperation();
                if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
                    $userName=$_SESSION['SAL_UserName'];
                }
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                $query1 = "SELECT 
                        ISNULL(ShopMaster.Shop_Cd, 0) as Shop_Cd, 
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
                WHERE ShopMaster.IsActive = 1 AND ShopMaster.Shop_Cd = $shopId
                ORDER BY ShopMaster.SurveyDate ASC;";
                // echo $query1;
                $shopDetail = $db2->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
             
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                              

      }else{

    }
}


    if(sizeof($shopDetail)>0){

?>


    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="detail-gallery">
                <?php 
                    if(!empty($shopDetail["ShopOutsideImage1"])){
                ?>
                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage1"]; ?>" alt="Shop Image" height="180" width="100%" />
                <?php
                    }else if(!empty($shopDetail["ShopOutsideImage2"])){
                ?>
                        <img class="product-image-slider" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image" height="180" width="100%" />
                <?php
                    }
                ?>
        </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="detail-info pr-10">
            <h3 style="margin-bottom: 8px;"><a onclick="setShopDetailData(<?php echo $shopDetail["Shop_Cd"];  ?>)" class="text-heading"><?php echo $shopDetail["ShopName"];  ?></a></h3>
            <span class="stock-status out-stock"> <?php echo $shopDetail["BusinessCatName"]; ?> </span> <span class="stock-status out-stock"> <?php echo $shopDetail["ShopAreaName"]; ?> </span>  
                
            
            <h5 class="title-detail"><a aria-label="Shop Keeper Detail" class="action-btn" href="tel:<?php echo $shopDetail["ShopKeeperMobile"];  ?>"><i class="fi-rs-smartphone"></i></a> <?php echo $shopDetail["ShopKeeperName"];  ?> - <?php echo $shopDetail["ShopKeeperMobile"];  ?></h5>
            <!-- <h6 class="title-detail"><a class="inactiveLink" href="#"><i class="fi-rs-location-alt"></i></a> <?php //echo "Ward : ".$shopDetail["Ward_No"]." ".$shopDetail["WardArea"];  ?></h6> -->
            <h6 class="title-detail"><a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopDetail['Latitude'].','.$shopDetail['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a> <?php echo $shopDetail["ShopAddress_1"];  ?></h6>
        </div>
    </div>



<?php

    }

?>
