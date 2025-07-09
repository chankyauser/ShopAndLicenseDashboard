<?php

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

// include 'api/includes/DbOperation.php';

// $db2 = new DbOperation();
$ShopOwner_Shop_Cd = 0;
if (isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])) {
    $userName = $_SESSION['SAL_UserName'];
}
// $ShopOwner_Shop_Cd = 1;
if (isset($_SESSION['ShopOwner_Shop_Cd']) && !empty($_SESSION['ShopOwner_Shop_Cd'])) {
    $ShopOwner_Shop_Cd = $_SESSION['ShopOwner_Shop_Cd'];
}
// print_r($_SESSION);
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

// if(!isset($_SESSION['SAL_View_Type'])){
$_SESSION['SAL_View_Type'] = 'ListView';
// }


?>

<style>
.loginBg {
    background: url('<?php echo 'Client/assets/imgs/logo/' . trim($_SESSION["SAL_ElectionName"]) . '_bg.jpeg'; ?>');
    height: 70vh;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: bottom;
}
</style>



<div class="container-fluid loginBg">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                <div class="row d-flex align-items-center justify-content-end">
                    <!-- <div class="col-lg-6 pr-30 d-none d-lg-block">
                        <img class="border-radius-15" src="assets/imgs/theme/login.png" alt="" height="350" />
                    </div> -->
                    <div class="col-lg-6 col-md-8">
                        <div class="card p-5"
                            style="background: #ffffff3d; border-radius: 50px; box-shadow: 0px 0px 12px 4px #00000085; backdrop-filter: blur(10px);">
                            <div class="card-body">

                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="form-group mb-0" style="text-align: right;">
                                        <button id="addnewButton" type="button" class="btn btn-brand hover-up mb-5"
                                            name="newlogin">
                                            New Shop
                                        </button>
                                    </div>
                                    <div class="padding_eight_all">
                                        <div class="heading_s6 d-flex justify-content-center mb-5 align-items-left">
                                            <h6 class="mb-5" style="color: #fff; font-size: 40px; text-align: left;">
                                                Shop Owner Login</h6>

                                        </div>

                                        <div class="form-group">
                                            <label for="" class="text-white">Mobile <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="mobile" id="mobile" placeholder="Enter Mobile No"
                                                maxlength="10" required
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) "
                                                class="bg-white" />
                                            <span id="mobileerror" style="color:red"></span>
                                        </div>
                                        <div class="form-group mb-4" id="otpField" style="display: block;">
                                            <label class="text-white" for="">Enter OTP <span
                                                    class="text-danger">*</span></label>
                                            <div style="display: flex; gap: 10px;">
                                                <input type="text" class="otp-input bg-white" id="otp_id_1"
                                                    style="padding-left: 30px;" maxlength="1" />
                                                <input type="text" class="otp-input bg-white" id="otp_id_2"
                                                    style="padding-left: 30px;" maxlength="1" />
                                                <input type="text" class="otp-input bg-white" id="otp_id_3"
                                                    style="padding-left: 30px;" maxlength="1" />
                                                <input type="text" class="otp-input bg-white" id="otp_id_4"
                                                    style="padding-left: 30px;" maxlength="1" />
                                            </div>
                                            <input type="hidden" name="otp" id="otp" required />
                                            <span id="otperror" style="color:red"></span>
                                        </div>

                                        <!-- <div class="form-group" id="otpField">
                                                <input type="text" name="otp" id="otp" placeholder="Enter OTP" maxlength="4"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                                <span id="otperror" style="color:red"></span>
                                            </div> -->

                                        <div class="form-group d-flex justify-content-center">
                                            <button id="submitLoginBtnId" type="button"
                                                class="btn btn-brand btn-block hover-up mb-2" name="login"
                                                style="border: 1px solid #fff;border-radius: 13px; width: 80%;">Get
                                                OTP</button>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="mb-2 text-white" style="cursor: pointer;" id="resend-otp">Resend
                                                OTP </p>
                                        </div>
                                        <div id="submitmsgsuccess" class="controls alert alert-success" role="alert"
                                            style="display: none;"></div>
                                        <div id="submitmsgfailed" class="controls alert alert-danger" role="alert"
                                            style="display: none;"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div>
        </div> -->

    <!-- Application Details Content -->
    <?php
    // include 'ShopOwnerApplicationDetails.php';
    ?>
    <!-- </div> -->
</div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {

    $('#mobile,#otp_id_4').on('keypress', function(e) {
        if (e.which === 13) { // 13 is the Enter key
            $('#submitLoginBtnId').click(); // Trigger button click
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

        // Handle backspace
        if (e.key === 'Backspace' && !$input.val() && $input.prev('.otp-input').length) {
            $input.prev('.otp-input').focus();
        }
    });

    function updateOTP() {
        let otp = '';
        $('.otp-input').each(function() {
            otp += $(this).val();
        });
        $('#otp').val(otp); // Set hidden field
    }

    $('#resend-otp').on('click', function() {
        var mobileNumber = $('#mobile').val();
        if (mobileNumber.length === 10) {
            var otp = generateOtp();
            // alert(otp)
            sendOTPToMobile(mobileNumber, otp);
            $('#otp').val('');
            $('#otpField').show();
            $('#resend-otp').hide();
        } else {
            $('#mobileerror').text('Please enter a valid mobile number.');
        }
    });
    $('#resend-otp').hide();

    $('#mobile').on('input', function() {
        $('#mobileerror').hide();
    });
    $('#otp').on('input', function() {
        $('#otperror').hide();
    });
    $('#otpField').hide();

    $('#submitLoginBtnId').on('click', function() {
        $('#submitLoginBtnId').text('Login');
        if ($('#otpField').is(':visible')) {
            var mobileNumber = $('#mobile').val();
            var otp = $('#otp').val();
            if (otp == '') {
                $('#otperror').text("Please Enter OTP").show();
            } else {
                validateOtp(mobileNumber, otp);
            }
        } else {
            shopLogin();
        }
    });

    $('#addnewButton').on('click', function() {
        // alert('hello');
        $('#ShopModal').find('form').each(function() {
            this.reset();
        });

        $('#ShopModal').find('select').each(function() {
            $(this).val(null).trigger('change');
        });
        $('#shopkeeper_mobile').prop('readonly', false);
        $('#verifyOtpBtn').hide();
        $('#ShopModal').modal('show');

        setTimeout(function() {
            if ($('.nav-item').has('active')) {
                $('.nav-item').removeClass('active');
            }
            $('#application-details-tab').addClass('active');
            $('#application-details-tab-link').tab('show');
            updateNavLinks();
        }, 200);
    })
});

var generatedOtp;

function shopLogin() {
    // var fullName = $('#fullName').val();
    var mobileNumber = $('#mobile').val();
    // alert(mobileNumber);

    if (mobileNumber.length === 10) {
        checkMobileExistence(mobileNumber);
    } else {
        if (!fullName) {
            $('#nameerror').text("Enter Full Name").show();
        } else {
            $('#nameerror').hide();
        }

        if (mobileNumber.length !== 10) {
            $('#mobileerror').text("Enter Mobile Number").show();
        } else {
            $('#mobileerror').hide();
        }
    }
}

function checkMobileExistence(mobileNumber) {
    // AJAX request to check if mobile number exists
    $.ajax({
        type: "POST",
        url: 'action/checkMobileExists.php',
        data: {
            mobileNumber: mobileNumber,

        },
        beforeSend: function() {
            $('#submitLoginBtnId').prop("disabled", true);
            $('#submitmsg').show();
            $('html').addClass("ajaxLoading");
        },
        success: function(dataResult) {
            dataResult = JSON.parse(dataResult);
            if (dataResult.exists === 1 && dataResult.message === 'Mobile number exists') {
                var otp = generateOtp();
                sendOTPToMobile(mobileNumber, otp);
                $('#otpField').show();
                $('#fullNameField').hide();
                $('input[name="mobile"]').show();
                $("#submitmsgsuccess").html('OTP sent to your mobile.')
                    .hide().fadeIn(800, function() {
                        $("submitmsgsuccess").append("");

                    }).delay(3000).fadeOut("fast");
            } else {
                $("#submitmsgfailed").html('Mobile number does not exist. Please check and try again.')
                    .hide().fadeIn(800, function() {
                        $("submitmsgfailed").append("");

                    }).delay(3000).fadeOut("fast");
                $('#ShopModal').find('form').each(function() {
                    this.reset();
                });

                $('#ShopModal').find('select').each(function() {
                    $(this).val(null).trigger('change');
                });
                $('#shopkeeper_mobile').prop('readonly', false);
                $('#verifyOtpBtn').hide();
                $('#ShopModal').modal('show');
                setTimeout(function() {
                    if ($('.nav-item').has('active')) {
                        $('.nav-item').removeClass('active');
                    }
                    $('#application-details-tab').addClass('active');
                    $('#application-details-tab-link').tab('show');
                    updateNavLinks();
                }, 200);
            }
        },
        complete: function() {
            $('#submitLoginBtnId').prop("disabled", false);
            $('#submitmsg').hide();
            $('html').removeClass("ajaxLoading");
        }
    });
}

function sendOTPToMobile(mobileNumber, otp) {
    $.ajax({
        type: "POST",
        url: 'action/sendOTP.php',
        data: {
            mobileNumber: mobileNumber,
            otp: otp
        },
        success: function(response) {
            if (response.success) {
                $("#submitmsgsuccess").html('OTP has been sent to your mobile number!')
                    .hide().fadeIn(800, function() {
                        $("submitmsgsuccess").append("");

                    }).delay(3000).fadeOut("fast");
                $('#generatedOtp').val(otp);
            }
        },
        error: function() {
            alert('Error occurred while sending OTP.');
        }
    });
}

function generateOtp() {
    var otp = Math.floor(1000 + Math.random() * 9000);
    generatedOtp = otp
    return otp;
}

function validateOtp(mobileNumber, otpEntered) {

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
                $("#submitmsgsuccess").html(responseData.msg)
                    .hide().fadeIn(800, function() {
                        $("submitmsgsuccess").append("");

                    }).delay(3000).fadeOut("fast");
                // alert(responseData.msg);
                ShopOwnerLogin();
            } else {
                $("#submitmsgfailed").html(responseData.msg || 'OTP verification failed.')
                    .hide().fadeIn(800, function() {
                        $("submitmsgfailed").append("");

                    }).delay(3000).fadeOut("fast");
                $('#otp').val('');
                $('#resend-otp').show();
            }
        },
        error: function() {
            alert('Error occurred during OTP verification.');
        }
    });

}

function ShopOwnerLogin() {
    $("#submitmsgsuccess").html('Shop owner logged in successfully.')
        .hide().fadeIn(800, function() {
            $("submitmsgsuccess").append("");

        }).delay(3000).fadeOut("fast");
    $('#otp').val('');
    $('#fullName').val('');
    // $('#application-details-tab-link').tab('show');
    window.location.href = 'index.php?p=ShopDetalisListOfOwner';

}
</script>