   
<?php
    // print_r($surveyTotalData);

    if(sizeof($surveyTotalData)>0){
?>

    <div class="container mt-20 mb-20">
        <div class="row">
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated" onclick="setShopBusinessCategoriesWardFilter(1)">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-1.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Shop Verified</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["SurveyVerified"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; } ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-2.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Certificate Issued</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["CertificateIssued"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; } ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-3.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">New License Issued</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["NewCertificateIssued"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; } ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-4.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Shop Approved</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["ShopApproved"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; } ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-5.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Survey Denied</h3>
                        <p><?php echo IND_money_format($surveyTotalData["SurveyDenied"]); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                <div class="shop-badges bg-warning banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-6.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Shops Listed</h3>
                        <p><?php echo IND_money_format($surveyTotalData["ShopListed"]); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    }
?>