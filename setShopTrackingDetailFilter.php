<?php

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
        session_start();
        include 'api/includes/DbOperation.php'; 
      
      if(isset($_GET['pageNo']) && !empty($_GET['pageNo']) ){

        try  
            {  
                
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $_SESSION['SAL_Node_Cd'] = $_GET['nodeCd'];
                $_SESSION['SAL_Node_Name'] = $_GET['nodeName'];
                $_SESSION['SAL_Shop_Name'] = $_GET['shopName'];
                if(empty($_SESSION['SAL_Shop_Name'])){
                    if(isset($_GET['shopId'])){
                        $shopCd = $_GET['shopId'];
                        $_SESSION['SAL_ST_Shop_Cd'] = $shopCd ;
                    }else{
                        $shopCd = "";
                    }
                }else{
                    if(isset($_GET['shopId'])){
                        $shopCd = $_GET['shopId'];
                        $_SESSION['SAL_ST_Shop_Cd'] = $shopCd ;
                    }else{
                        $shopCd = "";
                    }
                }


                if( !isset($_SESSION['SAL_UserName']) ){
                

                    $appName = $_SESSION['SAL_AppName'];
                    $developmentMode = $_SESSION['SAL_DevelopmentMode'];
                    $appSignatureKey = "Shop And License Web Application";
                    $loginType = "Admin";
                    $latitude = "";
                    $longitude = "";
                    $loginMode = "WebAdmin";
                    $mobileModel = "";
                    $mobileVersion= "";
                    $deviceId= "";
                    $appVersion = "1.0"; 
                    $firebaseId = "";
                    $IPAddress = "";
                    $ip = '';
                         if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                                    $ip = $_SERVER['HTTP_CLIENT_IP'];  
                            }  
                        //whether ip is from the proxy  
                        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
                         }  
                    //whether ip is from the remote address  
                        else{  
                                 $ip = $_SERVER['REMOTE_ADDR'];  
                         }  

                               $IPAddress=$ip;
                            

                     
                    // Using get_browser() with return_array set to TRUE
                    // $browser = get_browser(null, true);
                    // print_r($browser);
                    // $mobileModel = $browser["browser"];
                    // echo "<br>";
                    // $mobileVersion = $browser["version"];
                    // echo "<br>";
                    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $IPAddress)); 
                     
                          // echo 'City Name: ' . $ipdat->geoplugin_city . "\n"; 
                          // echo 'Region Name: ' . $ipdat->geoplugin_region . "\n"; 
                          // echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n"; 
                          // echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n"; 
                          // echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n"; 
                          // echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n"; 
                          // echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n"; 
                          // echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n"; 
                          // echo 'Timezone: ' . $ipdat->geoplugin_timezone. "\n"; 
                             
                          $latitude= $ipdat->geoplugin_latitude;
                          // echo "<br>";
                          $longitude= $ipdat->geoplugin_longitude;
                           // "<br>";
                          $city= $ipdat->geoplugin_city;
                          // echo "<br>";
                          $region= $ipdat->geoplugin_region;
                          // echo "<br>";
                          $country= $ipdat->geoplugin_countryName;
                          // echo "<br>";
                          $locAddress = $city.", ".$region.", ".$country;
                          // echo "<br>";

            ?>
                    <!-- <div class="page-header breadcrumb-wrap">
                        <div class="container">
                            <div class="breadcrumb">
                                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> Pages <span></span> My Account
                            </div>
                        </div>
                    </div> -->
                    <div class="page-content pt-50 pb-50">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                                    <div class="row">
                                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                                            <img class="border-radius-15" src="assets/imgs/theme/login.png" alt="" height="350" />
                                        </div>
                                        <div class="col-lg-6 col-md-8">
                                            <div class="login_wrap widget-taber-content background-white">
                                                <div class="padding_eight_all bg-white">
                                                    <div class="heading_s1">
                                                        <h1 class="mb-5">Login</h1>
                                                        <br><br>
                                                    </div>
                                                        <div class="form-group">
                                                            <input type="text" name="mobile" placeholder="Mobile *" maxlength="10" required  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) " />
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="password" placeholder="Password *" id="user-password" required  onkeydown = "if (event.keyCode == 13) document.getElementById('submitLoginBtnId').click()"/>
                                                        </div>
                                                        
                                                        <div class="login_footer form-group mb-50">
                                                            <div class="chek-form">
                                                                <div class="custome-checkbox">
                                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                                                    <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="loginType" value="<?php echo $loginType; ?>">
                                                                <input type="hidden" name="loginMode" value="<?php echo $loginMode; ?>">
                                                                <input type="hidden" name="latitude" value="<?php echo $latitude; ?>">
                                                                <input type="hidden" name="longitude" value="<?php echo $longitude; ?>">
                                                                <input type="hidden" name="mobileModel" value="<?php echo $mobileModel; ?>">
                                                                <input type="hidden" name="mobileVersion" value="<?php echo $mobileVersion; ?>">
                                                                <input type="hidden" name="deviceId" value="<?php echo $deviceId; ?>">
                                                                <input type="hidden" name="appVersion" value="<?php echo $appVersion; ?>">
                                                                <input type="hidden" name="firebaseId" value="<?php echo $firebaseId; ?>">
                                                                <input type="hidden" name="IPAddress" value="<?php echo $IPAddress; ?>">
                                                                <input type="hidden" name="appName" value="<?php echo $appName; ?>">
                                                                <input type="hidden" name="developmentMode" value="<?php echo $developmentMode; ?>">
                                                                <input type="hidden" name="appSignatureKey" value="<?php echo $appSignatureKey; ?>">
                                                            <button id="submitLoginBtnId" type="button" class="btn btn-brand btn-block hover-up" name="login" onclick="loginAuthentication()" >Log in</button>
                                                        </div>
                                                        <div class="form-group">
                                                                <div id="submitmsg" style="display: none;">
                                                                    <img height="50" width="50" src="assets/imgs/loader/loading.gif"/>
                                                                </div>
                                                                <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                                                <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
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
                    include 'setShopTrackingDetailFilterData.php';
                    if(!empty($_SESSION['SAL_Shop_Name'])){
                        include 'datatbl/tblShopTrackingDetailListData.php';
                    }
                }
             
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                              

      }else{
        //echo "ddd";
      }

    }
?>

