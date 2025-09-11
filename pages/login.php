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
                 
              $latitude= $ipdat->geoplugin_latitude ?? '';
              // echo "<br>";
              $longitude= $ipdat->geoplugin_longitude ?? '';
               // "<br>";
              $city= $ipdat->geoplugin_city ?? '';
              // echo "<br>";
              $region= $ipdat->geoplugin_region ?? '';
              // echo "<br>";
              $country= $ipdat->geoplugin_countryName ?? '';
              // echo "<br>";
              $locAddress = $city.", ".$region.", ".$country ?? '';
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
                                                    id="mobile" class="bg-white" maxlength="10" required
                                                    onkeypress="return (event.charCode >= 48 && event.charCode <= 57) " />
                                            </div>
                                            <div class="form-group" style="margin-bottom: 30px; position: relative;">
                                                <label for="" class="text-white">Password <span
                                                        class="text-danger">*</span></label>

                                                <input type="password" name="password" placeholder="Enter Password"
                                                    class="bg-white" id="user-password" required
                                                    onkeydown="if (event.keyCode == 13) document.getElementById('submitLoginBtnId').click()" />

                                                <!-- Eye toggle button -->
                                                <button class="eyeBtn" type="button"
                                                    onclick="togglePassword('user-password', 'eyebtn_icon')"
                                                    style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); border: none; background: transparent; cursor: pointer;">
                                                    <i class="fa fa-eye" id="eyebtn_icon"></i>
                                                </button>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-white">
                                                    <a class="text-white" href="#" id="forgot_password">Forgot your
                                                        password?</a>
                                                </label>
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
                                                    role="alert" style="display: none; padding: 4px 10px;"></div>
                                                <div id="submitmsgfailed" class="controls alert alert-danger"
                                                    role="alert" style="display: none;  padding: 4px 10px;"></div>
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

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2 m-2">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm">
                    <div class="form-group">
                        <label for="forgot_mobile">Mobile</label>
                        <input type="text" class="form-control" id="forgot_mobile"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required>
                        <span id="forgot_mobile_error" style="color:red"></span>
                    </div>

                    <!-- OTP Section -->
                    <div class="form-group mb-4" id="otpFieldForgot" style="display: none;">
                        <label for="">Enter OTP <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <input type="text" class="otp-input form-control" id="otp_id_1" maxlength="1" />
                            <input type="text" class="otp-input form-control" id="otp_id_2" maxlength="1" />
                            <input type="text" class="otp-input form-control" id="otp_id_3" maxlength="1" />
                            <input type="text" class="otp-input form-control" id="otp_id_4" maxlength="1" />
                        </div>
                        <input type="hidden" name="otp" id="forgot_otp" required />
                        <span id="otpFieldForgot_error" style="color:red"></span>
                        <p id="otpTimerForgot" style="color: red; font-size: 12px;">OTP expires in <span
                                id="countdown">05:00</span></p>
                    </div>

                    <!-- Password Section -->
                    <div class="form-group password-field"
                        style="display: none; margin-bottom: 30px; position: relative;">
                        <label for="new-password">New Password</label>
                        <!-- <div class="input-group"> -->
                        <input type="password" name="new_password" placeholder="Enter New Password" class="form-control"
                            id="new-password" required />
                        <button class="eyeBtn" type="button"
                            onclick="togglePassword('new-password', 'eyeIconNewPassword')"
                            style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); border: none; background: transparent; cursor: pointer;">
                            <i class="fa fa-eye" id="eyeIconNewPassword"></i>
                        </button>
                        <!-- </div> -->
                        <span id="new_password_error" style="color:red"></span>
                    </div>
                    <div class="form-group password-field"
                        style="display: none; margin-bottom: 30px; position: relative;">
                        <label for="retype-password">Retype New Password</label>
                        <!-- <div class="input-group"> -->
                        <input type="password" name="retype_password" placeholder="Retype New Password"
                            class="form-control" id="retype-password" required />
                        <button class="eyeBtn" type="button"
                            onclick="togglePassword('retype-password', 'eyeIconRetypePassword')"
                            style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); border: none; background: transparent; cursor: pointer;">
                            <i class="fa fa-eye" id="eyeIconRetypePassword"></i>
                        </button>
                        <!-- </div> -->
                        <span id="retype_password_error" style="color:red"></span>
                    </div>

                    <!-- Resend OTP -->
                    <div class="form-group">
                        <a class="text-danger" style="display: none;" href="#" id="resend-otp">Resend OTP</a>
                        <button type="button" class="btn btn-primary" id="send_otp_forgot">Send OTP</button>
                    </div>

                    <button type="button" class="btn btn-success" id="resetPasswordBtn" style="display: none;">Update
                        Password</button>

                    <div id="forgotmsgsuccess" class="controls alert alert-success" role="alert"
                        style="display: none; padding: 4px 10px;"></div>
                    <div id="forgotmsgfailed" class="controls alert alert-danger" role="alert"
                        style="display: none; padding: 4px 10px;"></div>

                    <input type="hidden" id="appname" value="<?php echo $appName; ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let otpExpirationTime = 300;
let otpTimerInterval;

function startOtpTimer() {
    clearInterval(otpTimerInterval);
    otpExpirationTime = 300;

    otpTimerInterval = setInterval(() => {
        let minutes = Math.floor(otpExpirationTime / 60);
        let seconds = otpExpirationTime % 60;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        document.getElementById('countdown').textContent = `${minutes}:${seconds}`;

        if (otpExpirationTime <= 0) {
            clearInterval(otpTimerInterval);
            document.getElementById('countdown').textContent = '00:00';
            $('#resend-otp').show();
            $('.otp-input').prop('disabled', true);
        }
        otpExpirationTime--;
    }, 1000);
}

function togglePassword(pwdInputId, eyeIconId) {
    const pwdInput = document.getElementById(pwdInputId);
    const eyeIcon = document.getElementById(eyeIconId);
    if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        pwdInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

$(document).ready(function() {
    $('#forgot_password').on('click', function(e) {
        e.preventDefault();
        $('#forgot_mobile').val('');
        var mobile = $('#mobile').val();
        if (mobile != '') {
            $('#forgot_mobile').val(mobile);
            $('#forgot_mobile').attr('readonly', true);
        } else {
            $('#forgot_mobile').val('');
            $('#forgot_mobile').attr('readonly', false);
        }
        $('#otpFieldForgot').hide();
        $('.password-field').hide();
        $('#forgotPasswordModal').modal('show');
    });



    $('#send_otp_forgot').on('click', function(e) {
        e.preventDefault();
        var mobileNumber = $('#forgot_mobile').val().trim();
        var mobileRegex = /^[6-9]\d{9}$/;

        if (mobileNumber !== '') {
            if (!mobileRegex.test(mobileNumber)) {
                $('#forgot_mobile_error').text('Please enter a valid 10-digit mobile number.').show();
                return;
            } else {
                $('#forgot_mobile_error').text('').hide();
            }

            $('#send_otp_forgot').text('Reset Password');

            if ($('#otpFieldForgot').is(':visible')) {
                var otp = $('#forgot_otp').val().trim();
                if (otp === '') {
                    $('#otpFieldForgot_error').text("Please enter OTP").show();
                } else {
                    $('#forgot_otp').val('');
                    $('#otpTimerForgot').hide();
                    otpExpirationTime = 5 * 60;
                    startOtpTimer();
                    $('#otpFieldForgot_error').text('').hide();
                    validateForgotOtp(mobileNumber, otp);
                }
            } else if ($('.password-field').is(':visible')) {
                updatePassword();
            } else {
                checkmobileNoExists(mobileNumber);
            }
        } else {
            $('#mobileerror').text('Please enter a mobile number.').show();
        }
    });

    $('#resend-otp').on('click', function() {
        const mobileNumber = $('#forgot_mobile').val().trim();
        if (mobileNumber) {
            const newOtp = generateOtp();
            sendForgotOTPToMobile(mobileNumber, newOtp);
            $('.otp-input').val('').prop('disabled', false);
            $('#resend-otp').hide();
            $('#otpTimerForgot').show();
            startOtpTimer();
        }
    });

    $('.otp-input').on('input', function() {
        const $input = $(this);
        const value = $input.val().replace(/[^0-9]/g, '');
        $input.val(value);
        if (value && $input.next('.otp-input').length) {
            $input.next('.otp-input').focus();
        }
        updateOTP();
    });

    $('.otp-input').on('keydown', function(e) {
        const $input = $(this);
        if (e.key === 'Backspace' && !$input.val() && $input.prev('.otp-input').length) {
            $input.prev('.otp-input').focus();
        }
    });
});

function updateOTP() {
    let otp = '';
    $('.otp-input').each(function() {
        otp += $(this).val();
    });
    $('#forgot_otp').val(otp);
}

function checkmobileNoExists(mobileNumber) {
    $.ajax({
        type: "POST",
        url: 'action/adminMobileExists.php',
        data: {
            mobileNumber: mobileNumber
        },
        beforeSend: function() {
            $('#send_otp_forgot').prop("disabled", true);
        },
        success: function(dataResult) {
            dataResult = JSON.parse(dataResult);
            if (dataResult.exists === 1) {
                var otp = generateOtp();
                sendForgotOTPToMobile(mobileNumber, otp);
                $('#otpFieldForgot').show();
                $('#fullNameField').hide();
                // $("#forgotmsgsuccess").html('OTP sent to your mobile.').hide().fadeIn(800).delay(3000)
                //     .fadeOut("fast");
            } else {
                $("#forgotmsgfailed").html('Mobile number does not exist. Please check and try again.')
                    .hide().fadeIn(800).delay(3000).fadeOut("fast");
                $('#forgot_mobile').val('');
                $('#forgot_mobile').attr('readonly', false);
            }
        },
        complete: function() {
            $('#send_otp_forgot').prop("disabled", false);
        }
    });
}

function sendForgotOTPToMobile(mobileNumber, otp) {
    $.ajax({
        type: "POST",
        url: 'action/sendOTP.php',
        data: {
            mobileNumber: mobileNumber,
            otp: otp
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.statusCode === 200) {
                $('#generatedOtp').val(otp);
                $("#forgotmsgsuccess").html('OTP sent to your mobile.').hide().fadeIn(800).delay(3000)
                    .fadeOut("fast");
                $('#otpTimerForgot').show();
                startOtpTimer();
            }
        },
        error: function() {
            $("#forgotmsgfailed").html('Error occurred while sending OTP.')
                .hide().fadeIn(800).delay(3000).fadeOut("fast");
        }
    });
}

function validateForgotOtp(mobileNumber, otpEntered) {
    $.ajax({
        type: "POST",
        url: 'action/sendOTP.php',
        data: {
            verifyMobileNumber: mobileNumber,
            verifyOtp: otpEntered
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.statusCode === 200) {
                $("#forgotmsgsuccess").html(responseData.msg).hide().fadeIn(800).delay(3000).fadeOut(
                    "fast");
                $('#otpFieldForgot').hide();
                $('.password-field').show();

            } else {
                $("#forgotmsgfailed").html(responseData.msg || 'OTP verification failed.').hide().fadeIn(
                    800).delay(3000).fadeOut("fast");
                $('#otp').val('');
                $('#resend-otp').show();
            }
        },
        error: function() {
            alert('Error occurred during OTP verification.');
        }
    });
}

function updatePassword() {
    var newPassword = $('#new-password').val().trim();
    var retypePassword = $('#retype-password').val().trim();

    if (newPassword === '') {
        $('#new_password_error').text('Please enter a new password.').show();
        return;
    } else {
        $('#new_password_error').text('').hide();
    }

    if (retypePassword === '') {
        $('#retype_password_error').text('Please retype the new password.').show();
        return;
    } else {
        $('#retype_password_error').text('').hide();
    }

    if (newPassword !== retypePassword) {
        $('#retype_password_error').text('Passwords do not match.').show();
        return;
    } else {
        $('#retype_password_error').text('').hide();
    }

    $.ajax({
        type: "POST",
        url: 'action/updatePassword.php',
        data: {
            mobileNumber: $('#forgot_mobile').val().trim(),
            newPassword: newPassword,
            appname: '<?= $appName ?>',
            developmentMode: '<?= $developmentMode ?>'
        },
        success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.error === false) {
                $("#forgotmsgsuccess").html(responseData.message).hide().fadeIn(800).delay(3000).fadeOut(
                    "fast",
                    function() {
                        $('#forgotPasswordModal').modal(
                            'hide');
                    });
            } else {
                $("#forgotmsgfailed").html(responseData.message || 'Failed to update password.').hide()
                    .fadeIn(800).delay(3000).fadeOut("fast");
            }
        },
        error: function() {
            alert('Error occurred while updating password.');
        }
    });
}

function generateOtp() {
    return Math.floor(1000 + Math.random() * 9000).toString();
}
</script>