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

    if(isset($_SESSION['SAL_Shop_Cd']) && !empty($_SESSION['SAL_Shop_Cd'])){
       $shopCd = $_SESSION['SAL_Shop_Cd'];
    }


    $userId = $_SESSION['SAL_UserId'];
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
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <h5> <?php echo $shopDetail["ShopName"]; ?> </h5>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            
                        </div>

                        
                       
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            
                        </div>
                 
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                 <style>
                                    #invoice_wrappe{
                                        border: 4px solid rgb(5, 49, 107);
                                            border-collapse: collapse;
                                            padding-left:20px;
                                            padding-right:20px;
                                            padding-top: 5px;
                                            line-height: 2.0;
                                            outline: 2px solid rgb(209, 102, 26);
                                            outline-offset: -13px;
                                    }
                                    p{
                                        color: rgb(37, 42, 92);
                                        font-size: 17px;
                                    }
                                    .grid-container {
                                        display: grid;
                                        grid-template-columns: auto auto auto auto auto auto auto auto auto auto;
                                        grid-gap: 0px;
                                    }
                                    .box{
                                        border: 1px solid rgb(209, 102, 26);
                                        background-color: white;
                                        width: 25px;
                                        height: 25px;
                                        padding: 0px;
                                        
                                    }
                                    .invoice-5 .invoice-info {
                                    border-radius: 0;
                                    padding: 70px;
                                }
                                        
                                  
                                </style>
                                <div class="invoice invoice-content invoice-5">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="invoice-inner">
                                                    <div class="invoice-info"  id="PrintLicenseID">
                                                       
                                                        <center>
                                                            <p><b> नमुना"ख"</b> </br> </br>  <b>(नियम १०(१)पहा) </b></p>
                                                            <h2 style="color:rgb(209, 102, 26);    padding: 20px;">औरंगाबाद महानगरपालिका औरंगाबाद</h2>
                                                            <h2> <span style="display: table; padding: 15px;margin: 0px auto 0px auto; background-color: rgb(209, 103, 27); color: rgb(226, 192, 100); border-radius: 10px;">&nbsp;स्थानिक संस्था नोंदणी प्रमाणपत्र&nbsp;</span></h2>
                                                        </center>
                                                        <p style="font-size: 17px;  margin-top: 50px; color: #000;"><b >नोंदणी क्रमांक : <?php echo $shopDetail["Shop_UID"]; ?></b></p>
                                                        
                                                            
                                                         


                                                        <p style="text-align:justify;margin-top: 50px;margin-bottom: 50px; line-height: 2.0rem;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;प्रमाणित करण्यात येते की,श्री./सर्वश्री <span style="color: black;font-weight: 800;font-size: 22px;"><u><?php echo $shopDetail["ShopKeeperName"]; ?></u></span> 
                                                             यांचे शहरातील <span style="color: black;font-weight: 800;font-size: 22px;"><u><?php echo $shopDetail["ShopName"]; ?>, <?php echo $shopDetail["ShopAddress_1"]; ?></u></span> 
                                                             हे एकमेव / मुख्य व्यवसायाचे ठिकाण असून तेथे आपला. <span style="color: black;font-weight: 800;font-size: 22px;"><u><?php echo $shopDetail["BusinessCatName"]; ?></u></span> व्यवसाय करीतअसून त्यांची दिनांक <span style="color: black;"><b>1/7/2011</b></span> पासून मुंबई प्रांतिक महानगरपालिका 
                                                             (स्थानिक संस्था कर) नियम २०१० च्या नियम ९ अन्वये नोंदणीकृत व्यापारी म्हणून नोंदणी करण्यात आली आहे.</p>

                                                       <!--  <p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;या व्यापाऱ्याचा सदर व्यवसाय पूर्णत:/प्रामुख्याने/अंशत: <span style="color: black;"><b>फेरविक्रेता - .औषधी</b></span> (सामान्य वर्णन) या वर्गवारीतील मालांसंबंधित आहे.</p>

                                                        <p>या व्यापाऱ्याची खाली विनिर्दिष्ट केलेल्या पात्यांवर व्यवसायाची अतिरिक्त ठिकाणे आहेत:</p>
                                                        <p>क) वखारी व्यतिरिक्त ------------------------------------------------------------------------------------------ <br>
                                                           ख) वखार -------------------------------------------------------------------------------------------------------</p>
                                                        <p>हा व्यापारी खाली नमूद केलेल्या सोपीव कामाच्या तत्वावर संस्करणाची कामे पार पाडत आहे :- 
                                                            <br>------------------------------------------------------------------------------------------------------------------- 
                                                            <br>-------------------------------------------------------------------------------------------------------------------
                                                            <br>-------------------------------------------------------------------------------------------------------------------
                                                         </p> -->

                                                         <b style="font-size: 17px;color: black;">ठिकाण :- <span style="color:rgb(209, 102, 26)"> औरंगाबाद</span></b>
                                                         <br>
                                                        <b style="font-size: 17px;color: black;line-height: 1.60rem;">दिनांक :- 18/10/2022</b>
                                                        <p style="float: right;"><span style="color:rgb(209, 102, 26); line-height: 1.60rem;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> उपायुक्त</b></span> <br> महानगरपालिका औरंगाबाद</p>  
                                                       
                                                        
                                                       
                                                    </div>
                                                    <div class="invoice-btn-section clearfix d-print-none">
                                                        <a onclick="licensePrinting()" class="btn btn-lg btn-custom btn-print hover-up"> <img src="assets/imgs/theme/icons/icon-print.svg" alt="" /> Print </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
