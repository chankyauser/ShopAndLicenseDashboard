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
        transform-origin: 30% 30%;
    }

    embed.docimg:hover{
        z-index: 999999;
        transform: scale(8.2);
    }
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
    $billingCd = 0;

    if(isset($_SESSION['SAL_Shop_Cd']) && !empty($_SESSION['SAL_Shop_Cd'])){
       $shopCd = $_SESSION['SAL_Shop_Cd'];
    }

    if(isset($_SESSION['SAL_Billing_Cd']) && !empty($_SESSION['SAL_Billing_Cd'])){
       $billingCd = $_SESSION['SAL_Billing_Cd'];
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
            ISNULL(CONVERT(VARCHAR, ShopMaster.BillGeneratedDate, 100), '') as BillGeneratedDate,
            ISNULL(( SELECT
                    TOP 1 sb.Billing_Cd
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,0) as Billing_Cd,
            ISNULL(( SELECT
                    TOP 1 sb.IsLicenseRenewal
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as IsLicenseRenewal,
            ISNULL(( SELECT
                    TOP 1 CONVERT(VARCHAR, sb.BillingDate, 100)
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as BillingDate,
            ISNULL(( SELECT
                    TOP 1 CONVERT(VARCHAR, sb.ExpiryDate, 100)
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as ExpiryDate,
            ISNULL(( SELECT
                    TOP 1 sb.BillAmount
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as BillAmount,
            ISNULL(( SELECT
                    TOP 1 sb.DiscountAmount
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as DiscountAmount,
            ISNULL(( SELECT
                    TOP 1 sb.TotalBillAmount
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd)
            ,'') as TotalBillAmount,
            ISNULL(( SELECT
                    TOP 1 tsd.TransType
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd 
                ORDER BY tsd.TranDateTime DESC)
            ,'') as TransType,
            ISNULL(( SELECT
                    TOP 1 tsd.TransStatus
                FROM ShopBilling sb 
                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sb.Shop_Cd = ShopMaster.Shop_Cd 
                    AND sb.IsLicenseRenewal = pd.IsRenewal )
                INNER JOIN ScheduleDetails sd on sd.ScheduleCall_Cd = sb.ScheduleCall_Cd
                LEFT JOIN ShopTracking st on sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                LEFT JOIN TransactionDetails tsd on tsd.Billing_Cd = sb.Billing_Cd
                WHERE sb.Transaction_Cd is not null AND tsd.Shop_Cd = ShopMaster.Shop_Cd 
                ORDER BY tsd.TranDateTime DESC)
            ,'') as TransStatus
            
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


?>

                <div class="row">
                    <div class="col-lg-8">
                        <h5><?php echo $shopDetail["ShopName"]; ?> </h5>    
                    </div>
                    <div class="col-lg-4">
                            <?php if(!empty($shopDetail["TotalBillAmount"])){ ?>
                                <h5 style="float:right;"> 
                                    Sub Total : <i class="fa-solid fa-indian-rupee-sign"></i> <?php echo IND_money_format($shopDetail["TotalBillAmount"])."/-"; ?> 
                                    <input type="hidden" name="paymentAmount" value="<?php echo $shopDetail["TotalBillAmount"]; ?>">
                                </h5> 
                            <?php } ?>
                    </div>
                    <div class="col-lg-12">     
                            <div class="row">
                               <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <table class="table table-bordered table-10">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Sr. No.</th>
                                                        <th style="text-align: left;">License Detail</th>
                                                        
                                                        <th style="text-align: center;">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: center;">1</td>
                                                        <td style="text-align: left;">
                                                            <h5>Shop Act License - <?php if(!empty($shopDetail["IsLicenseRenewal"]) && $shopDetail["IsLicenseRenewal"] == 0){ ?> NEW <?php }else if(!empty($shopDetail["IsLicenseRenewal"]) && $shopDetail["IsLicenseRenewal"] == 1){ ?> Renewal <?php }else{ ?> New <?php } ?></h5>
                                                            
                                                            <h6>&nbsp;&nbsp;<?php echo $shopDetail["PDetNameEng"]; ?></h6>

                                                            <br/><br/><br/>
                                                            <span>
                                                                <?php 
                                                                    $diff = abs(strtotime($shopDetail["RenewalDate"]) - strtotime($shopDetail["BillingDate"]));

                                                                    $years = floor($diff / (365*60*60*24)); 
                                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                                                ?>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For <?php if($years < 1 ){ echo $months." Months"; }else{ echo $years." Year"; } ?>
                                                            </span>
                                                        </td>
                                                        <th style="text-align: right;"><?php echo IND_money_format($shopDetail["BillAmount"])."/-"; ?> </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                     <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="payment ml-10">
                                                            <h5 class="mb-0">Payment</h5>
                                                            <div class="paymentMode">
                                                                <div class="custome-radio">
                                                                    <input class="form-check-input"  type="radio" name="paymentMode" id="paymentModeCASH" checked value="CASH">
                                                                    <label class="form-check-label" for="paymentModeCASH" data-bs-toggle="collapse" data-target="#paymentModeCASH" aria-controls="paymentModeCASH">Cash Payment</label>
                                                                </div>
                                                                <div class="custome-radio">
                                                                    <input class="form-check-input" type="radio" name="paymentMode" id="paymentModePOS" value="POS">
                                                                    <label class="form-check-label" for="paymentModePOS" data-bs-toggle="collapse" data-target="#paymentModePOS" aria-controls="paymentModePOS">POS Machine</label>
                                                                </div>
                                                                <div class="custome-radio">
                                                                    <input class="form-check-input" required="" type="radio" name="paymentMode" id="paymentModeOnline" value="Online" >
                                                                    <label class="form-check-label" for="paymentModeOnline" data-bs-toggle="collapse" data-target="#paymentModeOnline" aria-controls="paymentModeOnline">Online Gateway</label>
                                                                </div>
                                                            </div>
                                                            <div class="payment-logo d-flex">
                                                                <img class="mr-15" src="assets/imgs/theme/icons/payment-paypal.svg" alt="">
                                                                <img class="mr-15" src="assets/imgs/theme/icons/payment-visa.svg" alt="">
                                                                <img class="mr-15" src="assets/imgs/theme/icons/payment-master.svg" alt="">
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="payment ml-10">
                                                            <h5 class="mb-0">Location</h5>
                                                            <div class="locationMode">
                                                                <div class="custome-radio">
                                                                    <input class="form-check-input"  type="radio" name="locationMode" id="locationModeRadioOffice" value="Office" checked>
                                                                    <label class="form-check-label" for="locationModeRadioOffice" data-bs-toggle="collapse" data-target="#locationModeRadioOffice" aria-controls="locationModeRadioOffice">Office</label>
                                                                </div>
                                                                <div class="custome-radio">
                                                                    <input class="form-check-input"  type="radio" name="locationMode" id="locationModeRadioSite" value="OnSite" >
                                                                    <label class="form-check-label" for="locationModeRadioSite" data-bs-toggle="collapse" data-target="#locationModeRadioSite" aria-controls="locationModeRadioSite">On Site</label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            
                                            <div class="col-sm-12 col-md-12" style="margin-top: 15px;">
                                                <div class="form-group">
                                                    <!-- <label>Remark</label> -->
                                                    <input class="form-control" name="paymentRemark" type="text" value="" placeholder="Remark if any" />
                                                </div>
                                            </div>

                                    </div>

                                </div>

                                <div class="col-md-12 col-sm-12" style="margin-top:10px;">
                                    <input class="form-control" name="pageName" type="hidden"  value="<?php echo $_SESSION['SAL_Page_Name']; ?>" />
                                    <input class="form-control" name="pageNo" type="hidden"  value="<?php echo $_SESSION['SAL_Pagination_PageNo']; ?>" />
                                    <input class="form-control" name="viewType" type="hidden"  value="<?php echo $_SESSION['SAL_View_Type']; ?>" />
                                    <input class="form-control" name="licenseType" type="hidden"  value="<?php if(!empty($shopDetail["IsLicenseRenewal"]) && $shopDetail["IsLicenseRenewal"] == 0){ echo "NEW"; }else if(!empty($shopDetail["IsLicenseRenewal"]) && $shopDetail["IsLicenseRenewal"] == 1){ echo "Renewal"; }else{ echo "NEW"; } ?>" />
                                    <input class="form-control" name="wardOfficerUserId" type="hidden"  value="<?php echo $wrdOfficerUserId; ?>" />
                                    <input class="form-control" name="shopId" type="hidden"  value="<?php echo $shopCd; ?>" />
                                    <input class="form-control" name="billingId" type="hidden"  value="<?php echo $billingCd; ?>" />
                                    <input class="form-control" name="qcType" type="hidden"  value="LicensePayment" />
                                    <input class="form-control" name="qcFlag" type="hidden"  value="8" />

                                    <div id="submitloading" style="display: none;">
                                        <img height="48" width="48" src="assets/imgs/loader/loading.gif"/>
                                    </div>
                                    <div id="submitmsgsuccessSHBillPay" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailedSHBillPay"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>


                            </div>
                    
                    </div>
                </div>

            



<?php
    }else{
        header('Location:index.php');  
    }
?>
