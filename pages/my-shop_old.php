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



<div class="container">

    <!-- <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
        <li class="nav-item" id="shop-login-tab">
            <a class="nav-link active" id="shop-login-tab-link" data-toggle="tab" href="#shop-login-content">Shop
                Login</a>
        </li>
        <li class="nav-item" id="application-details-tab">
            <a class="nav-link" id="application-details-tab-link" data-toggle="tab"
                href="#application-details-content">Application Details</a>
        </li>
        <li class="nav-item" id="shop-details-tab">
            <a class="nav-link" id="shop-details-tab-link" data-toggle="tab" href="#shop-details-content">Shop
                Details</a>
        </li>
        <li class="nav-item" id="shop-documents-tab">
            <a class="nav-link" id="shop-documents-tab-link" data-toggle="tab" href="#shop-documents-content">Shop
                Documents</a>
        </li>
    </ul> -->
    <br>
    <!-- <div class="tab-content">
        <div class="tab-pane active" id="shop-login-content">
            <div class="page-content pt-50 pb-50"> -->
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
                                <div class="heading_s1 d-flex justify-content-between mb-5 align-items-center">
                                    <h4 class="mb-5">Shop Owner Login</h4>
                                    <div class="form-group mb-0">
                                        <button id="addnewButton" type="button"
                                            class="btn btn-brand btn-block hover-up mb-5" name="newlogin"
                                            id="newlogin">New Shop</button>
                                    </div>
                                </div>
                                <!-- <div class="form-group" id="fullNameField">
                                    <input type="text" name="fullName" id="fullName" placeholder="Enter FullName" />
                                    <span id="nameerror" style="color:red"></span>
                                </div> -->
                                <div class="form-group">
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile *" maxlength="10"
                                        required onkeypress="return (event.charCode >= 48 && event.charCode <= 57) " />
                                    <span id="mobileerror" style="color:red"></span>
                                </div>
                                <div class="form-group" id="otpField" style="display: none;">
                                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" maxlength="4"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                    <!-- <button type="button" class="btn btn-danger btn-sm ml-10"> Resend</button> -->
                                    <span id="otperror" style="color:red"></span>
                                </div>


                                <!-- Mobile Input -->
                                <!-- <div class="form-group">
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile *" maxlength="10"
                                        required onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                        class="form-control" />
                                    <span id="mobileerror" style="color:red"></span>
                                </div> -->

                                <!-- OTP Input and Resend Button (Initially hidden) -->
                                <!-- <div class="form-group d-flex justify-content-center align-items-center" id="otpField"
                                    style="display: none;">
                                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" maxlength="4"
                                        required/>
                                    <button type="button" class="btn btn-danger btn-sm ml-10 d-none" id="resend-otp">Resend</button>
                                    <span id="otperror" style="color:red"></span>
                                </div> -->

                                <div class="form-group">
                                    <button type="button" class="btn btn-danger text-end ml-5" id="resend-otp"
                                        style="display: none;">Resend OTP</button>
                                    <button id="submitLoginBtnId" type="button"
                                        class="btn btn-brand btn-block text-end hover-up" name="login">Log
                                        in</button>

                                    <!-- <button id="sendOTPBtnId" type="button"
                                                    class="btn btn-brand btn-block hover-up" name="OTPbutton"
                                                    style="display: none;">Send OTP</button> -->
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
<style>
    /* .nav-tabs {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-between;
    background-color: #f4f4f4;
    border-radius: 5px;
}

.nav-tabs li {
    flex: 1;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 2px;
}

.nav-tabs li:last-child {
    margin-right: 0;
}

.nav-tabs a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #555;
    font-weight: 600;
    font-size: 14px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.nav-tabs a:hover {
    background-color: #f1f1f1;
    color: #007bff;
}

.nav-tabs li.active a {
    background-color: #007bff;
    color: white;
    border-bottom: 2px solid #007bff;
}

.nav-tabs li:not(.active) a {
    border-bottom: none;
}

.tab-content {
    background-color: #f8f9fa;
    padding: 20px;
    border: 2px solid #ddd;
    border-radius: 0 0 10px 10px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
} */
</style>

<script>
    $(document).ready(function () {
        $('#resend-otp').on('click', function () {
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

        $('#mobile').on('input', function () {
            $('#mobileerror').hide();
        });
        $('#otp').on('input', function () {
            $('#otperror').hide();
        });
        $('#otpField').hide();
        
        $('#submitLoginBtnId').on('click', function () {
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

        $('#addnewButton').on('click', function () {
            // alert('hello');
            $('#ShopModal').find('form').each(function () {
                this.reset();
            });

            $('#ShopModal').find('select').each(function () {
                $(this).val(null).trigger('change');
            });
            $('#shopkeeper_mobile').prop('readonly', false);
            $('#verifyOtpBtn').hide();
            $('#ShopModal').modal('show');

            setTimeout(function () {
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
        var mobileNumber = $('#mobile').val();
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
        $.ajax({
            type: "POST",
            url: 'action/checkMobileExists.php',
            data: {
                mobileNumber: mobileNumber,

            },
            beforeSend: function () {
                $('#submitLoginBtnId').prop("disabled", true);
                $('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function (dataResult) {
                dataResult = JSON.parse(dataResult);
                if (dataResult.exists === 1 && dataResult.message === 'Mobile number exists') {
                    var otp = generateOtp();
                    sendOTPToMobile(mobileNumber, otp);
                    $('#otpField').show();
                    $('#fullNameField').hide();
                    $('input[name="mobile"]').show();
                    $("#submitmsgsuccess").html('OTP sent to your mobile.')
                        .hide().fadeIn(800, function () {
                            $("submitmsgsuccess").append("");

                        }).delay(3000).fadeOut("fast");
                } else {
                    $("#submitmsgfailed").html('Mobile number does not exist. Please check and try again.')
                        .hide().fadeIn(800, function () {
                            $("submitmsgfailed").append("");

                        }).delay(3000).fadeOut("fast");
                    $('#ShopModal').find('form').each(function () {
                        this.reset();
                    });

                    $('#ShopModal').find('select').each(function () {
                        $(this).val(null).trigger('change');
                    });
                    $('#shopkeeper_mobile').prop('readonly', false);
                    $('#verifyOtpBtn').hide();
                    $('#ShopModal').modal('show');
                    setTimeout(function () {
                        if ($('.nav-item').has('active')) {
                            $('.nav-item').removeClass('active');
                        }
                        $('#application-details-tab').addClass('active');
                        $('#application-details-tab-link').tab('show');
                        updateNavLinks();
                    }, 200);
                }
            },
            complete: function () {
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
            success: function (response) {
                if (response.success) {
                    $("#submitmsgsuccess").html('OTP has been sent to your mobile number!')
                        .hide().fadeIn(800, function () {
                            $("submitmsgsuccess").append("");

                        }).delay(3000).fadeOut("fast");
                    $('#generatedOtp').val(otp);
                }
            },
            error: function () {
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
            success: function (response) {
                var responseData = JSON.parse(response);
                if (responseData.statusCode === 200) {
                    $("#submitmsgsuccess").html(responseData.msg)
                        .hide().fadeIn(800, function () {
                            $("submitmsgsuccess").append("");

                        }).delay(3000).fadeOut("fast");
                    ShopOwnerLogin(mobileNumber);
                } else {
                    $("#submitmsgfailed").html(responseData.msg || 'OTP verification failed.')
                        .hide().fadeIn(800, function () {
                            $("submitmsgfailed").append("");

                        }).delay(3000).fadeOut("fast");
                    $('#otp').val('');
                    $('#resend-otp').show();
                }
            },
            error: function () {
                alert('Error occurred during OTP verification.');
            }
        });

    }

    function ShopOwnerLogin(mobileNumber) {
        $("#submitmsgsuccess").html('Shop owner logged in successfully.')
            .hide().fadeIn(800, function () {
                $("submitmsgsuccess").append("");

            }).delay(3000).fadeOut("fast");
        $('#otp').val('');
        $('#fullName').val('');
        // alert(mobileNumber);
        // $.ajax({
        //     type: "POST",
        //     url: 'action/License_bill_generation.php',
        //     data: {
        //         mobileNumber: mobileNumber
        //     },
        //     success: function (response) {
        //         console.log(response);
        //         // window.location.href = 'index.php?p=ShopDetalisListOfOwner';
        //     },
        //     error: function () {
        //         alert('Error occurred during License Bill Generation.');
        //     }

        // });
        window.location.href = 'index.php?p=ShopDetalisListOfOwner';

    }
</script>