<style type="text/css">
     img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 8% 50%;
        border-radius: 5px;
        margin-left: 10px
    }

    img.galleryimg:hover{
        z-index: 999999;
        transform: scale(2.2);
    }

     embed.docimg{
        transition: 0.4s ease;
        transform-origin: 00% 30%;

    }
    embed.docimg:hover{
        z-index: 999999;
        transform: scale(5.2); 
    }
    /*embed.docimg:active{
        z-index: 999999;
        position: absolute;
        width: 650px;
        height: 600px;
        top: 35%;
        left: 35%;
        bottom: 35%;
        right: 35%;
        -webkit-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -o-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
        transform: scale(2.0);


    }*/
    .form-group { 
        margin: 0.25rem 0.1rem;
        margin-right: 0.1rem;
        margin-left: 0.1rem;
    }
    .row>*{
        margin-top: 0.50rem;
    }
    
</style>

<?php 
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }

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
    $wrdOfficerUserId = $userId;
    if($userId != 0){
        $db=new DbOperation();
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
            ISNULL(pd.PDFullEng,'') as PDFullEng,
            ISNULL(pd.IsRenewal,'') as IsRenewal,
            ISNULL(pd.Amount,'') as ParwanaAmount,
            
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
            ISNULL(bcm.BusinessCatImage, '') as BusinessCatImage,

            ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
            ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,

            ISNULL((SELECT Remarks  FROM Survey_Entry_Data..User_Master 
                WHERE UserName = ShopMaster.AddedBy),'') as ListingExecutive,
            ISNULL((SELECT Remarks  FROM Survey_Entry_Data..User_Master 
                WHERE UserName = ShopMaster.SurveyBy),'') as SurveyExecutive,

            ISNULL(ShopMaster.AddedBy,'') as AddedBy,
            ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
            ISNULL(convert(varchar, ShopMaster.AddedDate, 100),'') as AddedDate, 
            ISNULL(convert(varchar, ShopMaster.SurveyDate, 100),'') as SurveyDate,

            ISNULL(ShopMaster.ShopApproval, '') as ShopApproval, 
            ISNULL(ShopMaster.ShopApprovalBy, '') as ShopApprovalBy, 
            ISNULL(CONVERT(VARCHAR, ShopMaster.ShopApprovalDate, 100), '') as ShopApprovalDate, 
            ISNULL(ShopMaster.ShopApprovalRemark, '') as ShopApprovalRemark,

            ISNULL(ShopMaster.IsNewCertificateIssued, 0) as IsNewCertificateIssued,  
            ISNULL(ShopMaster.BillGeneratedFlag, 0) as BillGeneratedFlag,  
            ISNULL(ShopMaster.BillGeneratedBy, '') as BillGeneratedBy,  
            ISNULL(CONVERT(VARCHAR, ShopMaster.BillGeneratedDate, 100), '') as BillGeneratedDate
            
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

        $getShopApprovalRemark = $shopDetail["ShopApprovalRemark"];



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
<!-- <style type="text/css">
    .form-group {
      margin-bottom: 0.5rem;
    }
</style> -->

 
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">

            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <h5> <?php echo $shopDetail["ShopName"]; ?> </h5>
                </div>
               <!--  <div class="col-sm-12 col-md-3 col-lg-3">
                    <span class="shop-badges bg-brand"> <?php echo $shopDetail["BusinessCatName"]; ?> </span> 
                    <span class="shop-badges bg-brand"> <?php echo $shopDetail["ShopAreaName"]; ?> </span> 
                    <span class="shop-badges bg-brand"> <?php echo $shopDetail["ShopCategory"]; ?> </span>
                </div> -->
                <div class="col-sm-12 col-md-3 col-lg-<?php if(!empty($shopDetail["ShopApproval"])){ ?>3<?php }else{ ?>6<?php } ?>">
                    <?php if(empty(!$shopDetail["ShopStatus"])){ ?> 

                            <?php if($shopDetail["ShopStatus"]=="Verified"){ ?>
                                <span class="shop-badges" style="background-color: <?php echo $shopDetail["ShopStatusTextColor"]; ?>;color: #FFFFFF;float: right;"><i class="<?php echo $shopDetail["ShopStatusFaIcon"]; ?>"></i>  <?php echo $shopDetail["ShopStatus"]; ?></span>
                                <span class="shop-badges bg-primary" style="float: right;"><i class="fa-solid fa-file"></i> <?php echo "Shop Documents"; ?> </span>
                                &nbsp;&nbsp;
                            <?php }else if($shopDetail["ShopStatus"]=="Pending"){ ?>
                                    <span class="shop-badges" style="background-color: <?php echo $shopDetail["ShopStatusTextColor"]; ?>;color: #FFFFFF;float: right;"><i class="<?php echo $shopDetail["ShopStatusFaIcon"]; ?>"></i>  <?php echo "In-Review"; ?></span>
                                    <span class="shop-badges bg-primary" style="float: right;"><i class="fa-solid fa-file"></i> <?php echo "Shop Documents "; ?> </span>
                                    &nbsp;&nbsp;
                            <?php }else{ ?>
                                <span class="shop-badges" style="background-color: <?php echo $shopDetail["ShopStatusTextColor"]; ?>;color: #FFFFFF;float: right;"><i class="<?php echo $shopDetail["ShopStatusFaIcon"]; ?>"></i>  <?php echo $shopDetail["ShopStatus"]; ?></span>
                            <?php } ?>

                    <?php }else{ ?>
                            <span class="shop-badges" style="background-color:#FF3342;color: #FFFFFF;float: left;">  <?php echo "Document Pending"; ?></span>
                    <?php } ?>
                </div>
                
                    <?php if(!empty($shopDetail["ShopApproval"])){ ?>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                           
                                <span class="shop-badges" style="background-color:<?php if($shopDetail["ShopApproval"]=="Rejected"){ ?> #E6490B <?php }else{ ?> #008000 <?php } ?>;color: #FFFFFF;float: right;"><?php if($shopDetail["ShopApproval"]=="Rejected"){ ?> <i class="fa-solid fa-circle-xmark"></i> <?php }else{ ?> <i class="fa fa-check-circle"></i>  <?php } ?> <?php echo $shopDetail["ShopApproval"]; ?></span>
                                    <span class="shop-badges bg-primary" style="float: right;"><i class="fa-solid fa-file-invoice-dollar"></i> <?php echo "Shop License"; ?> </span>

                        </div>
                    <?php } ?>
                
                <!-- <div class="col-sm-12 col-md-6 col-lg-6">
                    <h6>
                        <?php echo $shopDetail["ShopKeeperName"]; ?>
                        <?php if(!empty($shopDetail["ShopKeeperMobile"])){ ?>
                            <a title="Call Shop Keeper" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"> <?php echo $shopDetail["ShopKeeperMobile"];  ?></a>
                        <?php } ?>
                    </h6>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <h6 style="float:right;"><?php echo "Ward : ".$shopDetail["Ward_No"]." - ".$shopDetail["WardArea"];?> </h6>
                </div>
                <?php if(!trim($shopDetail["ShopAddress_1"])=="."){ ?>
                    <div class="col-sm-12 col-md-12 col-lg-12"> 
                        <h6><?php echo $shopDetail["ShopAddress_1"]; ?></h6>
                    </div>
                <?php } ?> -->
               
            </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2" style="margin-top: 25px;">
            <?php if(!empty($shopDetail["ShopOutsideImage1"])){ ?>
                    <img class="product-image-slider galleryimg" src="<?php echo $shopDetail["ShopOutsideImage1"]; ?>" alt="Shop Image" height="140" width="100%"  />
            <?php }else if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                    <img class="product-image-slider galleryimg" src="<?php echo $shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image" height="140" width="100%" />
            <?php } ?>

         <!--    <?php if(!empty($shopDetail["ShopOutsideImage2"])){ ?>
                    <img class="product-image-slider galleryimg" src="<?php echo $shopDetail["ShopOutsideImage2"]; ?>" alt="Shop Image"  height="150" width="100%" />
            <?php } ?>

            <?php if(!empty($shopDetail["ShopInsideImage1"])){ ?>
                    <img class="product-image-slider galleryimg" src="<?php echo $shopDetail["ShopInsideImage1"]; ?>" alt="Shop Image"  height="150" width="100%" />
            <?php } ?>

            <?php if(!empty($shopDetail["ShopInsideImage2"])){ ?>
                    <img class="product-image-slider galleryimg" src="<?php echo $shopDetail["ShopInsideImage2"]; ?>" alt="Shop Image" height="150" width="100%"  />
            <?php } ?> -->
        </div>
        

        <div class="col-sm-12 col-md-10 col-lg-10" >
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Shop Name in English</label>
                        <input class="form-control" name="shopName" type="text" value="<?php echo $getShopName; ?>" placeholder="Shop Name in English"/>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Shop Name in Marathi</label>
                        <input class="form-control" name="shopNameMar" type="text" value="<?php echo $getShopNameMar; ?>" placeholder="Shop Name in Marathi" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
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
                <div class="col-sm-12 col-md-2">
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
                <div class="col-sm-12 col-md-2">
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

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Shopkeeper Name</label>
                        <input class="form-control" name="shopKeeperName" type="text" value="<?php echo $getShopKeeperName; ?>" placeholder="Shop Keeper Name"  />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Shopkeeper Mobile</label>
                        <input class="form-control" name="shopKeeperMobile" type="text" value="<?php echo $getShopKeeperMobile; ?>" placeholder="Shop Keeper Mobile"  pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)" />
                    </div>
                </div>


            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <div class="row"  id="parwanaAmountId">
                    <div class="col-sm-12 col-md-10">
                        <label>Parwana Detail : <?php echo $shopDetail["PDetNameEng"]; ?> </label>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label style="float:right;"> 
                           <?php if($shopDetail["ParwanaAmount"] !=0){ ?> Demand : <i class="fa-solid fa-indian-rupee-sign"></i> <?php echo IND_money_format($shopDetail["ParwanaAmount"])."/-"; } ?> 
                        </label>
                    </div>
                </div> 
                <select class="form-control" name="parwanaDetail" onchange="setDisplayParwanaAmount(this.value)">
                    <option value="">--Select--</option>
                        <?php   
                            if (sizeof($ParwanaDetailDropDown)>0) 
                            {
                                foreach($ParwanaDetailDropDown as $key => $value)
                                {
                                    if($getParwanaDetCd == $value["ParwanaDetCd"])
                                    {
                                    ?> 
                                        <option selected="true" value="<?php echo $value['ParwanaDetCd'];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?></option>
                                        <?php }
                                        else
                                        { ?>
                                        <option value="<?php echo $value["ParwanaDetCd"];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?></option>
                                <?php }
                                }
                            } 
                        ?>
                </select>
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="row" style="margin-left: 10%;margin-right: 10%;">
                <?php 
                    foreach ($shopDocumentsList as $key => $valueDoc) {
                        if($valueDoc["DocumentType"]=="image" || $valueDoc["DocumentType"]=="pdf"){
                ?> 
                        <div class="col-lg-1-6 col-md-2 col-12 col-sm-6">
                            <embed <?php if($valueDoc["DocumentType"]=='image'){ ?> <?php }else if($valueDoc["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?> class="rounded docimg"   title="<?php echo $valueDoc["DocumentName"]; ?>" src="<?php echo $valueDoc["FileURL"]; ?>" width="100%" height="150"></embed>
                        </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>


  
    
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
        

        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Consumer No</label>
                <input class="form-control" name="ConsumerNo" type="text" value="<?php echo $getConsumerNumber; ?>" placeholder="Consumer Number" pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>GST No</label>
                <input class="form-control" name="GSTNo" type="text" value="<?php echo $getGSTNno; ?>" placeholder="Shop GST No" maxlength="15" style="text-transform: uppercase;" />
            </div>
        </div>

         <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Shop Contact No 1</label>
                <input class="form-control" name="ShopContactNo1" type="text" value="<?php echo $getShopContactNo_1; ?>" placeholder="Shop Contact No 1"  pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" />
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Shop Contact No 2</label>
                <input class="form-control" name="ShopContactNo2" type="text" value="<?php echo $getShopContactNo_2; ?>" placeholder="Shop Contact No 2"  pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Shop Address 1</label>
                <input class="form-control" name="Address1"  type="text" value="<?php echo $getShopAddress_1; ?>" placeholder="Address Line 1" /></textarea>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Shop Address 2</label>
                <input class="form-control" name="Address2"  type="text" value="<?php echo $getShopAddress_2; ?>" placeholder="Address Line 2" /></textarea>
            </div>
        </div>

    

   

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Shop Own Status</label> <label style="color:red;">*</label>
                <select class="select2 form-control" name="ShopOwnStatus">
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
                <input class="form-control" name="PeriodInYrs" type="text" value="<?php echo $getShopOwnPeriodYrs; ?>" placeholder="Shop Own Period in Yrs" pattern="[0-9]{3}" maxlength="3" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Period (Months)</label>
                <input class="form-control" name="PeriodInMonths" type="text" value="<?php echo $getShopOwnPeriodMonths; ?>" placeholder="Shop Own Period in Months" pattern="[0-9]{2}" maxlength="2" onkeypress="return isNumber(event)" />
            </div>
        </div>


        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Shop Dimension (L)</label>
                <input class="form-control" name="shopDimensionLength" type="text" placeholder="Length (ft.) " onchange="setShopDimension()" maxlength="10" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Shop Dimension (W)</label>
                <input class="form-control" name="shopDimensionWidth" type="text" placeholder="Width (ft.) " onchange="setShopDimension()" maxlength="10" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Shop Area (sq. ft.)</label>
                <input class="form-control" name="shopDimension" type="text" value="<?php echo $getShopDimension; ?>" placeholder="Shop Area (sq. ft.)" onkeypress="return isNumber(event)"/>
            </div>
        </div>


        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Shop Owner Name</label>
                <input class="form-control" name="ownerName" type="text" value="<?php echo $getShopOwnerName; ?>" placeholder="Shop Owner Name" />
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Shop Owner Mobile</label>
                <input class="form-control" id="ownerMobile" name="ownerMobile" type="text" value="<?php echo $getShopOwnerMobile; ?>" placeholder="Shop Owner Mobile No" pattern="[0-9]{10}" maxlength="10" onchange="validateOwnerMobile(event)" onkeypress="return isNumber(event)" />
            </div>
        </div>

                        
        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Owner Contact No</label>
                <input class="form-control" name="OwnerContactNo3" type="text"  value="<?php echo $getContactNo3; ?>" placeholder="Owner Contact No" pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="form-group">
                <label>Shop Owner Email</label>
                <input class="form-control" id="ownerEmail" name="ownerEmail" type="text"  value="<?php echo $getShopEmailAddress; ?>" placeholder="Shop Owner Email Id" onchange="validateOwnerEmail(event)" />
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Owner Address </label>
                <input class="form-control" name="ownerAddress" type="text"  value="<?php echo $getShopOwnerAddress; ?>" />
            </div>
        </div>


        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Male Employee</label>
                <input class="form-control" name="maleEmp" type="text" value="<?php echo $getMaleEmp; ?>" placeholder="Shop Male Employee"  pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Female Employee</label>
                <input class="form-control" name="femaleEmp" type="text" value="<?php echo $getFemaleEmp; ?>" placeholder="Shop Female Employee"  pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-6 col-md-2">
            <div class="form-group">
                <label>Other Employee</label>
                <input class="form-control" name="otherEmp" type="text"  value="<?php echo $getOtherEmp; ?>" placeholder="Shop Other Employee"  pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" />
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Shop Remark ( Verification / Rejection )</label>
                <textarea class="form-control" name="shopApprovalRemark" type="text" ><?php echo $getShopApprovalRemark; ?></textarea>
            </div>
        </div>
                              
            

        <div class="col-md-6 col-sm-12" style="margin-top:35px;">
            <input class="form-control" name="pageName" type="hidden"  value="<?php echo $_SESSION['SAL_Page_Name']; ?>" />
            <input class="form-control" name="pageNo" type="hidden"  value="<?php echo $_SESSION['SAL_Pagination_PageNo']; ?>" />
            <input class="form-control" name="viewType" type="hidden"  value="<?php echo $_SESSION['SAL_View_Type']; ?>" />
            <input class="form-control" name="wardOfficerUserId" type="hidden"  value="<?php echo $wrdOfficerUserId; ?>" />
            <input class="form-control" name="shopId" type="hidden"  value="<?php echo $shopCd; ?>" />
            <input class="form-control" name="qcType" type="hidden"  value="ShopLicense" />
            <input class="form-control" name="qcFlag" type="hidden"  value="6" />


                    <div id="submitloading" style="display: none;">
                        <img height="48" width="48" src="assets/imgs/loader/loading.gif"/>
                    </div>
                    <div id="submitmsgsuccessSHApprovalReject" class="controls alert alert-success" role="alert" style="display: none;"></div>
                    <div id="submitmsgfailedSHApprovalReject"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
        </div>

    </div>



<?php
    }else{
        header('Location:index.php');  
    }
?>
