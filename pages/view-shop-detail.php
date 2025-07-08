<?php 
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

?>
    
<?php 
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


    if(sizeof($shopDetail)>0){
?>

 <?php 


        $Shop_Cd = $shopDetail["Shop_Cd"];


        $getShopName = $shopDetail["ShopName"];
        $getShopNameMar = $shopDetail["ShopNameMar"];

        $getShopArea_Cd = $shopDetail["ShopArea_Cd"];
        $getShopAreaName = $shopDetail["ShopAreaName"];
        $getShopCategory = $shopDetail["ShopCategory"];

        $getPocketName = $shopDetail["PocketName"];
        $getNodeName = $shopDetail["NodeName"];
        $getWardNo = $shopDetail["Ward_No"];
        $getWardArea = $shopDetail["WardArea"];

        $getShopAddress_1 = $shopDetail["ShopAddress_1"];
        $getShopAddress_2 = $shopDetail["ShopAddress_2"];

        $getShopKeeperName = $shopDetail["ShopKeeperName"];
        $getShopKeeperMobile = $shopDetail["ShopKeeperMobile"];


        $getAddedDate = $shopDetail["AddedDate"];
        $getSurveyDate = $shopDetail["SurveyDate"];



        $getQC_Flag = $shopDetail["QC_Flag"];
        $getQC_UpdatedDate = $shopDetail["QC_UpdatedDate"];



        $getLetterGiven = $shopDetail["LetterGiven"];
        $getIsCertificateIssued = $shopDetail["IsCertificateIssued"];
        $getRenewalDate = $shopDetail["RenewalDate"];
        $getParwanaDetCd = $shopDetail["ParwanaDetCd"];



        $getConsumerNumber = $shopDetail["ConsumerNumber"];

        $getShopOwnStatus = $shopDetail["ShopOwnStatus"];
        $getShopOwnPeriod = $shopDetail["ShopOwnPeriod"];

        if($getShopOwnPeriod == 0){
        $getShopOwnPeriodYrs = 0;
        $getShopOwnPeriodMonths = 0;
        }else if($getShopOwnPeriod < 12){
        $getShopOwnPeriodYrs = 0;
        $getShopOwnPeriodMonths = $getShopOwnPeriod;
        }else if($getShopOwnPeriod == 12){
        $getShopOwnPeriodYrs = 1;
        $getShopOwnPeriodMonths = 0;
        }else if($getShopOwnPeriod > 12){
        $yrMonthVal = $getShopOwnPeriod / 12;
        $yrMonthValArr = explode(".", $yrMonthVal);
        $getShopOwnPeriodYrs = $yrMonthValArr[0];
        $getShopOwnPeriodMonths = ( $getShopOwnPeriod - ($yrMonthValArr[0] * 12) );
        }


        $getShopOwnerName = $shopDetail["ShopOwnerName"];
        $getShopOwnerMobile = $shopDetail["ShopOwnerMobile"];
        $getShopContactNo_1 = $shopDetail["ShopContactNo_1"];
        $getShopContactNo_2 = $shopDetail["ShopContactNo_2"];
        $getShopEmailAddress = $shopDetail["ShopEmailAddress"];
        $getShopOwnerAddress = $shopDetail["ShopOwnerAddress"];

        $getMaleEmp = $shopDetail["MaleEmp"];
        $getFemaleEmp = $shopDetail["FemaleEmp"];
        $getOtherEmp = $shopDetail["OtherEmp"];
        $getContactNo3 = $shopDetail["ContactNo3"];
        $getGSTNno = $shopDetail["GSTNno"];

        $getShopOutsideImage1 = $shopDetail["ShopOutsideImage1"];
        $getShopOutsideImage2 = $shopDetail["ShopOutsideImage2"];
        $getShopInsideImage1 = $shopDetail["ShopInsideImage1"];
        $getShopInsideImage2 = $shopDetail["ShopInsideImage2"];


        $getShopDimension = $shopDetail["ShopDimension"];


        $getShopStatus = $shopDetail["ShopStatus"];
        $getShopStatusTextColor = $shopDetail["ShopStatusTextColor"];
        $getShopStatusFaIcon = $shopDetail["ShopStatusFaIcon"];
        $getShopStatusIconUrl = $shopDetail["ShopStatusIconUrl"];
        $getShopStatusDate = $shopDetail["ShopStatusDate"];
        $getShopStatusRemark = $shopDetail["ShopStatusRemark"];


        $getBusinessCat_Cd = $shopDetail["BusinessCat_Cd"];
        $getNature_of_Business = $shopDetail["BusinessCatName"];

       



$query2 = "SELECT BusinessCat_Cd, BusinessCatName, BusinessCatNameMar 
        FROM BusinessCategoryMaster WHERE IsActive = 1;";

$NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

$query7 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
        WHERE DTitle = 'Category' AND IsActive = 1 
        ORDER BY SerialNo;";

$EstablishmentCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query7, $electionName, $developmentMode);

$query10 = "SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1 ORDER BY ShopAreaName;";

$EstablishmentAreaCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);


$query12 = "SELECT pd.ParwanaDetCd, pd.Parwana_Cd, pd.IsRenewal, pm.Parwana_Name_Eng, pm.Parwana_Name_Mar, pd.PDetNameEng, pd.PDetNameMar, pd.Amount from ParwanaDetails pd  INNER JOIN ParwanaMaster pm on pm.Parwana_Cd = pd.Parwana_Cd
WHERE pd.IsRenewal = $getIsCertificateIssued AND pd.IsActive = 1;";

$ParwanaDetailDropDown = $db->ExecutveQueryMultipleRowSALData($query12, $electionName, $developmentMode);

$query13 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
        WHERE DTitle = 'CertificateIssued' AND IsActive = 1 ORDER BY SerialNo;";

$IsCertificateIssuedDropDown = $db->ExecutveQueryMultipleRowSALData($query13, $electionName, $developmentMode);


$query4 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
        WHERE DTitle = 'LetterGiven' AND IsActive = 1 ORDER BY SerialNo;";

$LetterGivenDropDown = $db->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

$query110 = "SELECT Status_Cd as DropDown_Cd, ApplicationStatus as DValue FROM StatusMaster
        WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1;";

$ShopStatusDropDown = $db->ExecutveQueryMultipleRowSALData($query110, $electionName, $developmentMode);


$query111 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
        WHERE DTitle = 'PropertyStatus' AND IsActive = 1
        ORDER BY SerialNo;";

$OwnedORRentedDropDown = $db->ExecutveQueryMultipleRowSALData($query111, $electionName, $developmentMode);

$getReason = '';

$query113 = "SELECT Calling_Category_Cd
        ,Calling_Category
        ,Calling_Type
        FROM CallingCategoryMaster WHERE IsActive = 1;";

$ReasonDropDown = $db->ExecutveQueryMultipleRowSALData($query113, $electionName, $developmentMode);


$query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
    ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
    ISNULL(sd.Document_Cd,0) as Document_Cd,
    ISNULL(sd.FileURL,'') as FileURL,
    ISNULL(sd.IsVerified,0) as IsVerified,
    ISNULL(sd.QC_Flag,0) as QC_Flag,
    ISNULL(sd.IsActive,0) as IsActive,
    ISNULL(CONVERT(VARCHAR,sd.UpdatedDate,100),'') as UpdatedDate,
    ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
    ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
    ISNULL(sdm.DocumentName,'') as DocumentName,
    ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
    ISNULL(sdm.DocumentType,'') as DocumentType,
    ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
FROM ShopDocuments sd
INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
WHERE sd.Shop_Cd = $shopCd ORDER BY sd.UpdatedDate DESC;";

$DocumentsListForQC = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

?>
<style type="text/css">
    .form-group {
      margin-bottom: 0.5rem;
    }
</style>

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

        <div class="container mt-10 mb-30">
            <div class="row">
                <div class="col-xl-11 col-lg-12 m-auto">
                    <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="detail-info pr-0 pl-0">
                                <h2 class="title-detail mb-5"><?php echo $shopDetail["ShopName"]; ?></h2>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="product-detail accordion-detail">
                                <div class="row mb-5 mt-20">
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
                                                    <div><img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueDoc["FileURL"]; ?>" alt="Shop Documents" width="100"  height="100" /></div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-0 pl-0">
                                            <!-- <h2 class="title-detail mb-5"><?php echo $shopDetail["ShopName"]; ?></h2> -->
                                          <!--   <span class="stock-status out-stock"> <?php echo $shopDetail["BusinessCatName"]; ?> </span>
                                            <span class="stock-status out-stock"> <?php echo $shopDetail["ShopAreaName"]; ?> </span>
                                            <h5 class="title-detail mt-5"><?php echo $shopDetail["ShopKeeperName"]." - ".$shopDetail["ShopKeeperMobile"]; ?></h5>
                                            <h6 class="title-detail"><?php echo $shopDetail["ShopAddress_1"]; ?></h6> -->
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
                                           <!--  <div class="font-xs">
                                                <ul class="mr-50 float-start">
                                                    <li class="mb-5">UID : <span class="text-brand"> <?php echo $shopDetail["Shop_UID"]; ?></span></li>
                                                    <li class="mb-5">Ward : <span class="text-brand"> <?php echo $shopDetail["Ward_No"]; ?> </span></li>
                                                </ul>
                                                <ul class="float-start">
                                                    <li class="mb-5">Dimension : <a href="#" class="inactiveLink"> <?php echo $shopDetail["ShopDimension"]." sq. ft."; ?></a></li>
                                                    <li class="mb-5">Own Status : <a href="#" class="inactiveLink"><?php echo $shopDetail["ShopOwnStatus"]." since ".$shopOwnPeriod; ?>  </a></li>
                                                </ul>
                                            </div> -->

                                           <!--  <div class="row">
                                                <?php 
                                                    foreach ($DocumentsListForQC as $key => $value) {
                                                ?>
                                                        <div class="col-12 col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <div class="controls">  
                                                                    <embed <?php if($value["DocumentType"]=='image'){ ?> <?php }else if($value["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?>  src="<?php echo $value["FileURL"]; ?>" width="100%" height="180"></EMBED>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php 
                                                    }
                                                ?>
                                            </div>  -->




                                                <!-- <h4 class="mb-15">Edit </h4> -->
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label>Business Category</label>
                                                                    <select class="form-control" name="businessCateogry">
                                                                        <option value="">--Select--</option>
                                                                            <?php   
                                                                                if (sizeof($NatureOfBusinesDropDown)>0) 
                                                                                {
                                                                                    foreach($NatureOfBusinesDropDown as $key => $value)
                                                                                    {
                                                                                        if($getNature_of_Business == $value["BusinessCatName"])
                                                                                        {
                                                                                        ?> 
                                                                                            <option selected="true" value="<?php echo $value['BusinessCat_Cd'];?>"><?php echo $value['BusinessCatName'];?></option>
                                                                                            <?php }
                                                                                            else
                                                                                            { ?>
                                                                                            <option value="<?php echo $value["BusinessCat_Cd"];?>"><?php echo $value["BusinessCatName"];?></option>
                                                                                    <?php }
                                                                                    }
                                                                                } 
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label>Shop Area Category</label>
                                                                    <select class="form-control" name="shopAreaName">
                                                                        <option  value="">--Select--</option>   
                                                                            <?php if (sizeof($EstablishmentAreaCategoryDropDown)>0) 
                                                                                {
                                                                                    foreach($EstablishmentAreaCategoryDropDown as $key => $value)
                                                                                    {
                                                                                        if($getShopAreaName == $value["ShopAreaName"])
                                                                                        {
                                                                                        ?> 
                                                                                            <option selected="true" value="<?php echo $value['ShopArea_Cd'];?>"><?php echo $value['ShopAreaName'];?></option>
                                                                                        <?php }
                                                                                        else
                                                                                        { ?>
                                                                                            <option value="<?php echo $value["ShopArea_Cd"];?>"><?php echo $value["ShopAreaName"];?></option>
                                                                                    <?php }
                                                                                    }
                                                                                } 
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label>Shop Category</label>
                                                                    <select class="form-control" name="shopCateogry">
                                                                        <?php if (sizeof($EstablishmentCategoryDropDown)>0) 
                                                                            {
                                                                                foreach($EstablishmentCategoryDropDown as $key => $value)
                                                                                {
                                                                                    if($getShopCategory == $value["DValue"])
                                                                                    {
                                                                            ?> 
                                                                                        <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                            <?php } else { ?>
                                                                                        <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                                }
                                                                            } 
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Shop Name in English</label>
                                                                    <input class="form-control" name="shopName" type="text" value="<?php echo $getShopName; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Shop Name in Marathi</label>
                                                                    <input class="form-control" name="shopNameMar" type="text" value="<?php echo $getShopNameMar; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label>Shopkeeper / Contact Person Full Name</label>
                                                                    <input class="form-control" name="shopKeeperName" type="text" value="<?php echo $getShopKeeperName; ?>"  />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <div class="form-group">
                                                                    <label>Shopkeeper / Contact Person Primary Mobile No</label>
                                                                    <input class="form-control" name="shopKeeperMobile" type="text" value="<?php echo $getShopKeeperMobile; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Shop Contact No 1</label>
                                                                    <input class="form-control" name="ShopContactNo1" type="text" value="<?php echo $getShopContactNo_1; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Shop Contact No 2</label>
                                                                    <input class="form-control" name="ShopContactNo2" type="text" value="<?php echo $getShopContactNo_2; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Shop Address 1</label>
                                                                    <textarea class="form-control w-100" name="Address1" cols="30" rows="9" ><?php echo $getShopAddress_1; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Shop Address 2</label>
                                                                    <textarea class="form-control w-100" name="Address2" cols="30" rows="9" ><?php echo $getShopAddress_2; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Parwana Type</label>
                                                                    <select class="form-control" name="parwanaDetail">
                                                                        <option value="">--Select--</option>
                                                                            <?php   
                                                                                if (sizeof($ParwanaDetailDropDown)>0) 
                                                                                {
                                                                                    foreach($ParwanaDetailDropDown as $key => $value)
                                                                                    {
                                                                                        if($getParwanaDetCd == $value["ParwanaDetCd"])
                                                                                        {
                                                                                        ?> 
                                                                                            <option selected="true" value="<?php echo $value['ParwanaDetCd'];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['Amount'];?></option>
                                                                                            <?php }
                                                                                            else
                                                                                            { ?>
                                                                                            <option value="<?php echo $value["ParwanaDetCd"];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['Amount'];?></option>
                                                                                    <?php }
                                                                                    }
                                                                                } 
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Consumer No</label>
                                                                    <input class="form-control" name="ConsumerNo" type="text" value="<?php echo $getConsumerNumber; ?>"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>GST No</label>
                                                                    <input class="form-control" name="GSTNo" type="text" value="<?php echo $getGSTNno; ?>"  />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Shop Own Status</label>
                                                                    <select class="select2 form-control" name="ShopOwnStatus" required>
                                                                        <option  value="">--Select--</option>   
                                                                            <?php if (sizeof($OwnedORRentedDropDown)>0) 
                                                                                {
                                                                                    foreach($OwnedORRentedDropDown as $key => $value)
                                                                                    {
                                                                                        if($getShopOwnStatus == $value["DValue"])
                                                                                        {
                                                                                        ?> 
                                                                                            <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                        <?php }
                                                                                        else
                                                                                        { ?>
                                                                                            <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                                    <?php }
                                                                                    }
                                                                                } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Period (Yrs)</label>
                                                                    <input class="form-control" name="PeriodInYrs" type="text" value="<?php echo $getShopOwnPeriodYrs; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Period (Months)</label>
                                                                    <input class="form-control" name="PeriodInMonths" type="text" value="<?php echo $getShopOwnPeriodMonths; ?>" />
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
                                                                    <input class="form-control" name="shopDimension" type="text" value="<?php echo $getShopDimension; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Male Employee</label>
                                                                    <input class="form-control" name="maleEmp" type="number" value="<?php echo $getMaleEmp; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Female Employee</label>
                                                                    <input class="form-control" name="femaleEmp" type="number" value="<?php echo $getFemaleEmp; ?>"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-2">
                                                                <div class="form-group">
                                                                    <label>Other Employee</label>
                                                                    <input class="form-control" name="otherEmp" type="number"  value="<?php echo $getOtherEmp; ?>"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Shop Owner Name</label>
                                                                    <input class="form-control" name="ownerName" type="text" value="<?php echo $getShopOwnerName; ?>"  />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Shop Owner Mobile</label>
                                                                    <input class="form-control" name="ownerMobile" type="text" value="<?php echo $getShopOwnerMobile; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Shop Owner Contact</label>
                                                                    <input class="form-control" name="ownerContact" type="text"  value="<?php echo $getContactNo3; ?>"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Shop Owner Email</label>
                                                                    <input class="form-control" name="ownerEmail" type="text"  value="<?php echo $getShopEmailAddress; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-9">
                                                                <div class="form-group">
                                                                    <label>Owner Address </label>
                                                                    <textarea class="form-control w-100" name="ownerAddress" cols="30" rows="9" ><?php echo $getShopOwnerAddress; ?></textarea>
                                                                </div>
                                                            </div>

                                                             <div class="col-sm-12 col-md-3">
                                                                <div class="form-group mt-50" style="float: right;">
                                                                    <button type="button" class="button button-contactForm">Verify</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>




                                        </div>

                                  





                                        </div>


                                    </div>
                                </div>
                                <div class="product-info mt-20">

                                    
                                 
                                </div>
                                
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

<?php
    }else{
        header('Location:index.php');  
    }
?>
