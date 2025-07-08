   
<?php
    // print_r($surveyTotalData);

    if(sizeof($surveyTotalData)>0){
?>

    <div class="container mt-20 mb-20">


        <div class="row">
            
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0  mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-1.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title"><?php echo "Shop Verified"; ?></h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["SurveyVerified"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; }else{ echo "0%"; } ?></p>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-4.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Shop Approved</h3>
                        <p><?php echo IND_money_format($surveyTotalData["ShopApproved"]); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-6.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Shop Not Approved</h3>
                        <p><?php echo IND_money_format(0); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
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

            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-4.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Survey Status</h3>
                        <p><?php echo IND_money_format($surveyTotalData["SurveyAll"])." / ".IND_money_format($surveyTotalData["ShopListed"]); ?></p>
                    </div>
                </div>
            </div>


            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-2.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">License Issued Earlier!</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["CertificateIssued"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; }else{ echo "0%"; } ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-2.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">New License Issued</h3>
                        <p><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["NewCertificateIssued"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; }else{ echo "0%"; } ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-2.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Total Licensee</h3>
                        <p><?php echo IND_money_format(0); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-2.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">Defaulter Licensee</h3>
                        <p><?php echo IND_money_format(0); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-10">
                <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                    <div class="banner-icon">
                        <img src="assets/imgs/theme/icons/icon-3.svg" alt="" />
                    </div>
                    <div class="banner-text">
                        <h3 class="icon-box-title">License Revenue</h3>
                        <p><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo IND_money_format(0); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>


     <div class="container mb-20">

        <div class="row">
           
             <div class="col-lg-4-5 col-md-6 col-12 col-sm-12">
                <h5 class="mt-10 mb-10">Survey Status</h5>
                <div id="chartSurveyShopStatus"></div>

                <?php 
                    if(isset($_GET['refreshFlag']) && $_GET['refreshFlag']==1){
                ?>
                    <script type="text/javascript">

                        ApexCharts.exec('chartSurveyShopStatus', 'updateSeries', [{
                          data: [<?php  foreach ($surveyShopStatusData as $key => $value) {
                                      echo $value["ShopCount"].",";
                                  } ?>]
                        }], true);
                        
                    </script>
                <?php
                    }
                ?>
             </div>

        <style type="text/css">
            
            table td, table th, .table tr {
                border: 0px solid #ececec;
            }
            .count {
                display: inline-block;
                font-size: 12px;
                line-height: 1;
                border-radius: 0px 10px 0 20px;
                color: #fff;
                padding: 9px 20px 10px 20px;
                background-color: #F01954;
                cursor: pointer;
                justify-content: space-between;
            }
        </style>
            <div class="col-lg-1-5 col-md-6 col-12 col-sm-12">
                <div class="table-responsive mt-30">
                    <table class="table">
                        <!-- <thead>
                            <tr>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead> -->
                        <tbody>
                            <?php foreach ($surveyShopStatusData as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $value["ShopStatus"]; ?></td>
                                    <td style="text-align: right;"><span class="count"><?php echo $value["ShopCount"]; ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

             
        </div>
     </div>
<?php
    }
?>