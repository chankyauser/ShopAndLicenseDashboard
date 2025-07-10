<?php 

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

<style>
.loginBg {
    background: url('<?php echo 'Client/assets/imgs/logo/' . trim($_SESSION["SAL_ElectionName"]) . '_bg.jpeg'; ?>');
    height: 70vh;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: bottom;
}

button.eyeBtn:hover,
button.eyeBtn:focus,
button.eyeBtn:active {
    background-color: transparent !important;
}
</style>

<div class="page-content pt-50 pb-50 loginBg">
    <div class="container-fluid h-100">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row d-flex align-items-center justify-content-end">
                        <div class="col-lg-6 col-md-8">
                            <div class="card p-4"
                                style="background: #ffffff3d; border-radius: 50px; box-shadow: 0px 0px 12px 4px #00000085; backdrop-filter: blur(10px);">
                                <div class="card-body">
                                    <div class="login_wrap widget-taber-content">
                                        <div class="padding_eight_all">
                                            <div class="heading_s1" style="margin-bottom: 5px;">
                                                <h4 class="mb-5"
                                                    style="color: #fff; font-size: 32px; text-align: center;">Login</h4>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="text-white">Mobile <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="mobile" placeholder="Enter Mobile No"
                                                    class="bg-white" maxlength="10" required
                                                    onkeypress="return (event.charCode >= 48 && event.charCode <= 57) " />
                                            </div>
                                            <div class="form-group" style="margin-bottom: 30px; position: relative;">
                                                <label for="" class="text-white">Password <span
                                                        class="text-danger">*</span></label>

                                                <input type="password" name="password" placeholder="Enter Password"
                                                    class="bg-white" id="user-password" required
                                                    onkeydown="if (event.keyCode == 13) document.getElementById('submitLoginBtnId').click()" />

                                                <!-- Eye toggle button -->
                                                <button class = "eyeBtn" type="button" onclick="togglePassword()"
                                                    style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); border: none; background: transparent; cursor: pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-group d-flex justify-content-center">
                                                <input type="hidden" name="loginType" value="<?php echo $loginType; ?>">
                                                <input type="hidden" name="loginMode" value="<?php echo $loginMode; ?>">
                                                <input type="hidden" name="latitude" value="<?php echo $latitude; ?>">
                                                <input type="hidden" name="longitude" value="<?php echo $longitude; ?>">
                                                <input type="hidden" name="mobileModel"
                                                    value="<?php echo $mobileModel; ?>">
                                                <input type="hidden" name="mobileVersion"
                                                    value="<?php echo $mobileVersion; ?>">
                                                <input type="hidden" name="deviceId" value="<?php echo $deviceId; ?>">
                                                <input type="hidden" name="appVersion"
                                                    value="<?php echo $appVersion; ?>">
                                                <input type="hidden" name="firebaseId"
                                                    value="<?php echo $firebaseId; ?>">
                                                <input type="hidden" name="IPAddress" value="<?php echo $IPAddress; ?>">
                                                <input type="hidden" name="appName" value="<?php echo $appName; ?>">
                                                <input type="hidden" name="developmentMode"
                                                    value="<?php echo $developmentMode; ?>">
                                                <input type="hidden" name="appSignatureKey"
                                                    value="<?php echo $appSignatureKey; ?>">
                                                <button id="submitLoginBtnId" type="button" class="btn btn-brand"
                                                    name="login" onclick="loginAuthentication()"
                                                    style="border: 1px solid #fff;border-radius: 13px; width: 80%;">Log
                                                    in</button>
                                            </div>
                                            <div class="form-group">
                                                <div id="submitmsg" style="display: none;">
                                                    <img height="50" width="50" src="assets/imgs/loader/loading.gif" />
                                                </div>
                                                <div id="submitmsgsuccess" class="controls alert alert-success"
                                                    role="alert" style="display: none; padding: 4px 10px;">adfa</div>
                                                <div id="submitmsgfailed" class="controls alert alert-danger"
                                                    role="alert" style="display: none;  padding: 4px 10px;">sdrf</div>
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

<script>
function togglePassword() {
    const pwdInput = document.getElementById('user-password');
    pwdInput.type = pwdInput.type === 'password' ? 'text' : 'password';
}
</script>
