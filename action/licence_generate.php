<?php
    session_start();
    include '../api/includes/DbOperation.php';
    include 'amount_words.php';
    $db = new DbOperation();

    $billing_Id = $_GET['billing_id'];

    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

   
    $BillingQuery = "SELECT 
            COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
            COALESCE(sm.Shop_Cd , '') AS Shop_Cd ,
            COALESCE(sb.BillNo, '') AS BillNo, 
            COALESCE(sb.FinYear, '') AS FinYear, 
            COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
            COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate, 
            COALESCE(CONVERT(VARCHAR, sb.BillingDate, 105), '') AS BillingDate, 
            COALESCE(sb.BillAmount, 0) AS BillAmount, 
            COALESCE(sb.LicenseFees, 0) AS LicenseFees, 
            COALESCE(sb.TaxRate, 0) AS TaxRate, 
            COALESCE(sb.TaxAmount, 0) AS TaxAmount, 
            COALESCE(sm.Shop_UID, '') AS Shop_UID, 
            COALESCE(sm.ShopName, '') AS ShopName, 
            COALESCE(sm.ShopNameMar, '') AS ShopNameMar,
            COALESCE(sm.ShopOwnerName, '') AS ShopOwnerName,
            COALESCE(sm.ShopOwnerNameMar, '') AS ShopOwnerNameMar,
            COALESCE(sm.ShopOwnerMobile, '') AS ShopOwnerMobile,
            COALESCE(sm.ShopKeeperName, '') AS ShopKeeperName, 
            COALESCE(sm.ShopKeeperNameMar, '') AS ShopKeeperNameMar, 
            COALESCE(sm.ShopAddress_1, '') AS ShopAddress_1, 
            COALESCE(sm.ShopAddress_1Mar, '') AS ShopAddress_1Mar,
            COALESCE(sm.ShopKeeperMobile, '') AS ShopKeeperMobile, 
            COALESCE(sm.ShopLength, 0) AS ShopLength, 
            COALESCE(sm.ShopWidth, 0) AS ShopWidth, 
            COALESCE(sm.ShopHeight, 0) AS ShopHeight, 
            COALESCE(sm.Ward_No, 0) AS Ward_No, 
            COALESCE(sm.ShopCategory, '') AS ShopCategory,
            COALESCE(sm.ShopLength, 0) * COALESCE(sm.ShopWidth, 0) AS Area_SqFt,
            COALESCE(sm.ShopLength, 0) * COALESCE(sm.ShopWidth, 0) * 0.092903 AS Area_SqM,
            COALESCE(bm.BusinessCatName, '') AS BusinessCatName, 
            COALESCE(td.TransNumber, '') AS TransNumber, 
            COALESCE(bm.BusinessCatNameMar, '') AS BusinessCatNameMar,
            COALESCE(sb.LicenseNumber, '') AS LicenseNumber,
			COALESCE(sm.Ward_No,0) AS Ward_No,
			CONCAT(COALESCE(sm.ShopAddress_1,''),' ',COALESCE(sm.ShopAddress_2,'')) AS ShopAddress,
			COALESCE(nm.NodeName,'') AS ZoneName,
            COALESCE(sb.QRCode_URL, '') AS QRCode_URL
        FROM ShopBilling sb 
        LEFT JOIN ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
        LEFT JOIN BusinessCategoryMaster bm ON sm.BusinessCat_Cd = bm.BusinessCat_Cd
        LEFT JOIN TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd
		LEFT JOIN NodeMaster nm ON (sm.Ward_No = nm.Ward_No)
        WHERE sb.Billing_Cd = $billing_Id AND sb.IsActive = 1";

    $BillingData = $db->ExecutveQuerySingleRowSALData($BillingQuery, $electionName, $developmentMode);

    $BillNo = $BillingData['BillNo'];
    $FinYear = $BillingData['FinYear'];
    $LicenseStartDate = $BillingData['LicenseStartDate'];
    $LicenseEndDate = $BillingData['LicenseEndDate'];
    $ShopCategory = $BillingData['ShopCategory'];
    $Shop_UID = $BillingData['Shop_UID'];
    $BusinessCatNameMar = $BillingData['BusinessCatNameMar'];
    $BusinessCatName = $BillingData['BusinessCatName'];
    $Area_SqFt = $BillingData['Area_SqFt'];
    $Area_SqM = $BillingData['Area_SqM'];
    $Ward_No = $BillingData['Ward_No'];

    $ShopOwnerNameMar  = $BillingData['ShopOwnerNameMar'];
    $ShopOwnerName  = $BillingData['ShopOwnerName'];
    $ShopKeeperName  = $BillingData['ShopKeeperName'];
    $ShopKeeperNameMar  = $BillingData['ShopKeeperNameMar'];
    $ShopName  = $BillingData['ShopName'];
    $BillingDate = $BillingData['BillingDate'];
    
    $LicenseFees = $BillingData['LicenseFees'];
    $BillAmount = $BillingData['BillAmount'];
    $TaxAmount = $BillingData['TaxAmount'];
    $TaxRate = $BillingData['TaxRate'];
    $TransNumber = $BillingData['TransNumber'];
    $Shop_Cd = $BillingData['Shop_Cd'];
    $LicenseNumber = $BillingData['LicenseNumber'];
    $ZoneName = $BillingData['ZoneName'];
    $Ward_No = $BillingData['Ward_No'];
    $ShopAddress = $BillingData['ShopAddress'];
    $QRCode_URL = $BillingData['QRCode_URL'];

    // $Total =  $Total_Pay  - $past_dues;
    list($startYear, $shortYear) = explode('-', $FinYear);
    $nextYear = (int)$startYear + 1;
    $BillDate = "01-April-{$startYear} to 31-March-{$nextYear}";


    // Signature 

    $cerFile = '../Signature/CSMC_Shop_License_Signatures.cer';  

    if (file_exists($cerFile)) {

        $cerContent = file_get_contents($cerFile);
        $certData = openssl_x509_parse($cerContent);

        if ($certData !== false) {
            $signerName = $certData['subject']['CN'] ?? 'Unknown';
            $corporation  = $certData['subject']['O'] ?? 'Unknown';
            $timestamp = date('d-m-Y H:i:s');  
            $location = 'Mumbai';  
            $reason = 'Verification';

            $width = 300;   
            $height = 130; 

            $image = imagecreatetruecolor($width, $height);

            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $green = imagecolorallocate($image, 0, 200, 0);
            $imagebg = imagecolorallocate($image, 234,218,193);
            imagesavealpha($image, true);
            $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);

            imagefill($image, 0, 0, $transparent);

           
            $fontRegular = '../Signature/roboto.ttf';  
            $fontWithTick = '../Signature/dejavu-sans.ttf';  

            if (!file_exists($fontRegular) || !file_exists($fontWithTick)) {
                echo "Font files not found!";
                exit;
            }

            $x = 20;
            $y = 30;

            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Signature Valid");

            $checkmarkFontSize = 90;
            $bbox = imagettfbbox($checkmarkFontSize, 0, $fontWithTick, "✓");
            $tickWidth = $bbox[2] - $bbox[0];
            $tickHeight = abs($bbox[5] - $bbox[1]);

            $tickX = (($width - $tickWidth) / 2) - 75;
            $tickY = ($y + $tickHeight) + 15; 
            imagettftext($image, $checkmarkFontSize, 0, $tickX, $tickY, $green, $fontWithTick, "✓");

             $y += 20;
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Digitally Signed by");

            $y += 25;  
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "$signerName");
          
            $y += 25;  
            imagettftext($image, 8, 0, $x, $y, $black, $fontRegular, "($corporation)");

            $y += 25;  
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Date: $timestamp");

            $outputPath = '../Signature/CSMC_Signature.png';
            imagepng($image, $outputPath);

            imagedestroy($image);
        }
    }
        
?>

<head>
    <title> Bazaar Trace | <?= trim($_SESSION['SAL_ElectionName'])?> </title>
    <link rel="shortcut icon" href="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg">
    <link rel="icon" href="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" type="image/x-icon">
</head>

<button style="float:right;margin-right:20px;margin-top:10px;" onclick="window.open('','_self').close();">Back</button>
<button style="float:right;margin-right:20px;margin-top:10px;" onclick="acknowledgementPrinting()">Print</button>

<style>
.badge {
    font-weight: 500;
    border-radius: 0.5rem;
    padding: .5rem .625rem;
    font-size: 70%;
    min-width: 25px;
    letter-spacing: 0.3px;
    vertical-align: middle;
    display: inline-block;
    text-align: center;
    text-transform: capitalize;
}

.bg-success {
    background-color: #007D88 !important;
    color: #fff !important;
}

.rounded-pill {
    border-radius: 50rem !important;
}

.watermarked-container {
    position: relative;
}

.watermarked-container::before {
    content: "";
    background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 300px 300px;
    opacity: 0.05;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    pointer-events: none;
}

#PrintApplicationTableID {
    position: relative;
    z-index: 1;
}

td .info {
    margin: 4px !important;
}

th .sub-heading {
    padding: 5px !important;
    background: #9e9e9e2b !important;
    font-size: 18px;
}

td .info-data {
    width: 300px;
}

td:first-child .info::before {
    content: "• ";
    margin-right: 5px;
    color: black;
}

.template_bg {
    background-image: url(../assets/imgs/license_bg.jpeg);
    background-repeat: no-repeat;
    background-size: 100% 100%;
    background-position: unset;
    position: relative;
}


/* .qrImg {
    width: 10% !important;
    max-width: unset !important;
} */


@media print {
    .watermarked-container::before {
        content: "";
        background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 300px 300px;
        opacity: 0.05;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    body,
    html {
        height: auto !important;
        overflow: visible !important;
        -webkit-print-color-adjust: exact !important;
        /* Chrome/Safari */
        print-color-adjust: exact !important;
    }

    .template_bg {
        background-image: url('../assets/imgs/license_bg.jpeg') !important;
        background-repeat: no-repeat !important;
        background-size: 100% 100% !important;
        background-position: center center !important;
        min-height: 100vh !important;
        height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
    }
}
</style>

<div class="col-md-12" id="PrintApplicationID" style="padding-left:20%; padding-right:20%">
    <div class="card">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <br>
                                        <br>
                                        <div id="PrintApplicationTableID" class="watermarked-container" <?php 
                                                if(trim($_SESSION['SAL_ElectionName']) != 'AMC' && trim($_SESSION['SAL_ElectionName']) != 'CSMC') {
                                                    echo "style='border: 1px solid #000'";
                                                }
                                            ?>>
                                            <div
                                                class="content_div <?php if(trim($_SESSION['SAL_ElectionName']) === 'AMC' || trim($_SESSION['SAL_ElectionName']) == 'CSMC'){ echo "template_bg"; }?>">
                                                <?php if($_SESSION['SAL_ElectionName'] !== 'AMC' && $_SESSION['SAL_ElectionName'] !== 'CSMC'){ ?>
                                                <div class="row" style="position: relative; font-family: serif;">
                                                    <div style="width:20%">
                                                        <div class="logo d-none d-flex"
                                                            style="position: absolute; top: 0px; left: 0px; display: flex">
                                                            <!-- <img src="../assets/imgs/< ?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" alt="logo" style="height: 50px; border-radius: 50px;"/> -->
                                                            <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg"
                                                                alt="logo" style="height: 80px;" />
                                                        </div>
                                                    </div>
                                                    <div style="width: 100%;text-align: center;">
                                                        <h2
                                                            style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 17px;">
                                                            <b style="margin-top:15px;">छत्रपती संभाजीनगर महानगरपालिका
                                                                <br>Chhatrapati Sambhajinagar Municipal Corporation</b>
                                                        </h2>
                                                    </div>

                                                    <!-- <h4 style="display: flex; justify-content: center; margin: 0; padding: 7px 0;font-size: 15px;">
                                                                <b style=""> post box number - 125, Town Hall, Chha. Sambhajinagar – 431009
                                                                </b>
                                                            </h4> -->

                                                </div>
                                                <hr style="margin-top:20px;">
                                                <?php } ?>

                                                <div class="row"
                                                    style="<?php if($_SESSION['SAL_ElectionName'] === 'AMC'  || $_SESSION['SAL_ElectionName'] === 'CSMC'){ echo "padding: 120px 63px;"; } else { echo "padding: 10px 40px; margin-bottom: 40px;";} ?> ">
                                                    <div class="row">
                                                        <div class="col-12"
                                                            style="display: flex;justify-content: center;">
                                                            <p style="font-size: 16px; font-weight: 600;"> आस्थापनांना
                                                                व्यवसाय करणेकरिता परवाना</p>
                                                        </div>
                                                        <div class="col-12" style="display: flex; ">
                                                            <div class="col-6" style="width: 80%">
                                                                <p style="font-size: 14px;">परवाना क्र.
                                                                    <span><?= $LicenseNumber ?> </span>
                                                                </p>
                                                            </div>
                                                            <div class="col-6" style="width: 20%">
                                                                <p style="font-size: 14px;">दिनांक:
                                                                    <span><?= $BillingDate ?> </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-bottom: 50px;">
                                                        <div class="col-12">
                                                            <p style="font-size: 14px;">
                                                                <!-- छत्रपती संभाजीनगर महानगरपालिका हद्दीतील दुकान क्र. (<span>< ?= $Shop_Cd ?></span>) यावर देय्य असलेली सन < ?= $FinYear ?> या आर्थिक वर्षात पुढील प्रमाणे कराची रक्कम अदा केली असून त्यांना सदरहू परवाना अदा केला जात आहे. -->

                                                                <!-- महाराष्ट्र महानगरपालिका अधिनियम 1949 चे कलम 376, 383, 386
                                                                अन्वये छत्रपती संभाजीनगर महानगरपालिका कार्यक्षेत्रातील
                                                                दुकाने, कारखाने इ. व्यापारी आस्थापनांनी आपले व्यवसाय
                                                                करणेकरीता महानगरपालिकेचा परवाना दुकान क्र.
                                                                <b><span>< ?= $Shop_Cd ?></span></b> साठी
                                                                <b>< ?= $LicenseStartDate ?></b></b> ते
                                                                <b>< ?= $LicenseEndDate ?></b> या कालावधी करिता अदा करण्यात
                                                                येत आहे. -->

                                                            <p> महाराष्ट्र महानगरपालिका अधिनियम, १९४९ अंतर्गत कलम ३७६,
                                                                ३८३ व
                                                                ३८६ अन्वये, छत्रपती संभाजीनगर महानगरपालिका
                                                                कार्यक्षेत्रातील
                                                                दुकाने, कारखाने इत्यादी व्यापारी आस्थापनांनी आपल्या
                                                                व्यवसाय
                                                                करण्याकरिता महानगरपालिकेचा परवाना प्राप्त करणे आवश्यक
                                                                आहे.
                                                            <p>

                                                            <p> या अनुषंगाने, दुकान क्रमांक
                                                                <b><span><?= $Shop_Cd ?></span></b> नाव
                                                                <b><span><?= $ShopName ?></span></b> साठी दिनांक
                                                                <b><span><?= $LicenseStartDate ?></span></b> पासून
                                                                दिनांक <b><span><?= $LicenseEndDate ?></span></b>
                                                                पर्यंतच्या कालावधीसाठी परवाना शुल्क अदा करण्यात आले असून
                                                                सदर आस्थापनेस परवाना अदा करण्यात येत आहे.
                                                            <p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-bottom: 50px;">
                                                        <div style="width:50%">

                                                        </div>
                                                        <div style="width:50%">

                                                        </div>

                                                        <table class="table table-responsive-sm"
                                                            style="border-collapse: collapse; font-family: serif;">
                                                            <tbody>
                                                                <tr>

                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px">
                                                                            दुकानाचे
                                                                            नाव </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= $ShopName ?></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px">
                                                                            दुकानदाराचे नाव </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= $ShopOwnerName ?></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px">
                                                                            दुकानाचा
                                                                            पत्ता </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= $ShopAddress ?></div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px"> झोन
                                                                        </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= $ZoneName ?></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px"> वॉर्ड
                                                                        </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= $Ward_No ?></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px">
                                                                            परवाना फी
                                                                        </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : &#8377;<?= $BillAmount ?></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info" style="font-size: 14px">
                                                                            परवाना फी
                                                                            अक्षरी </div>
                                                                    </td>
                                                                    <td style="font-size: 13px;">
                                                                        <div class="info info-data"
                                                                            style="font-size: 14px">
                                                                            : <?= convertAmountToWords($BillAmount) ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row" style="margin-bottom: 10px;">
                                                        <p style="font-size: 14px;">उपरोक्त व्यावसायिक अस्थापना परवाना
                                                            पुढील
                                                            एकवर्षा करिता मर्यादित असेल. एक वर्षानंतर सदर परवाना
                                                            नुतनिकरण
                                                            करणे अपेक्षित आहे. </p>
                                                    </div>
                                                    <!-- <div class="row"
                                                        style="display: flex; justify-content: flex-end; margin-bottom: 5px; margin-right: 10px;">
                                                        <img class="qrImg" src=" < ?= $QRCode_URL ?>" id="qrCode" />
                                                        <div
                                                            style="display: flex; flex-direction: column; align-content: center; align-items: center;">
                                                            <p style="font-size: 14px; margin-bottom: 0;">उपायुक्त</p>
                                                            <p style="font-size: 14px; margin-top: 5px;">छत्रपती
                                                                संभाजीनगर महानगरपलिका
                                                            </p>
                                                        </div>
                                                    </div> -->
                                                    <div class="row"
                                                        style="display: flex; justify-content: space-between;  margin-right: 10px;">
                                                        <img class="qrImg" src="<?= $QRCode_URL ?>" id="qrCode"
                                                            style="width: 10vw; height: 10vw;" />
                                                        <div
                                                            style="display: flex; flex-direction: column;">
                                                            <img src='<?= $outputPath ?>'
                                                                alt='Verified Digital Signature' style='width: 300px;'>
                                                            <br>
                                                            <!-- <p style="font-size: 14px; margin-bottom: 0; margin-right: 45px">उपायुक्त</p>
                                                            <p style="font-size: 14px; margin-top: 5px; margin-right: 45px">छत्रपती
                                                                संभाजीनगर महानगरपलिका
                                                            </p> -->
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row" style="display: flex; gap: 10px;">
                                                        <p style="font-size: 14px;">टीप :-
                                                        </p>
                                                        <p style="font-size: 14px;">
                                                            १. हा परवाना सिस्टीम जनरेटेड आहे आणि त्यासाठी स्वाक्षरीची
                                                            आवश्यकता नाही.<br>
                                                            २. सदरील परवाना मालमत्ता मालकीचा पुरावा नाही.
                                                        </p>
                                                    </div> -->
                                                    <div class="row"
                                                        style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                                                        <div style="flex: 1;">
                                                            <p style="font-size: 14px; margin-bottom: 0px;">टीप :-
                                                            </p>
                                                            <p style="font-size: 14px; margin: 0px;">
                                                                १. हा परवाना सिस्टीम जनरेटेड आहे आणि त्यासाठी
                                                                स्वाक्षरीची
                                                                आवश्यकता नाही.<br>
                                                                २. सदरील परवाना मालमत्ता मालकीचा पुरावा नाही.
                                                            </p>
                                                        </div>
                                                        <!-- <div style="width: 100px; margin-right: 10px;">
                                                           <img src="< ?= htmlspecialchars($QRUrl) ?>" height="80"
                                                            style="float:right;margin-right:30px;margin-bottom:10px;">
                                                        </div> -->
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
            </section>
        </div>
    </div>
</div>

<script>
// function acknowledgementPrinting() {
//     var c = document.getElementById("PrintApplicationID").innerHTML;
//     var a = window.open("", "print_content", "width=800,height=1000,resizable=1,scrollbars=1");
//     a.document.open();
//     a.document.write('<html><head><title>ShopLicenseInvoice</title>');
//     a.document.write(
//         '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">'
//     );
//     a.document.write('<style>');
//     a.document.write(`
//         body {
//             font-family: "Laila", serif !important;
//             font-weight: 300;
//             font-style: normal;
//         }

//         .watermarked-container {
//             position: relative;
//         }

//         .watermarked-container::before {
//             content: "";
//             background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg'); /* Adjust path if needed */
//             background-repeat: no-repeat;
//             background-position: center;
//             background-size: 300px 300px;
//             opacity: 0.05;
//             position: absolute;
//             top: 0;
//             left: 0;
//             width: 100%;
//             height: 100%;
//             z-index: 0;
//             pointer-events: none;
//         }


//         #PrintApplicationTableID {
//             position: relative;
//             z-index: 1;
//         }

//         @page {
//             margin: 5mm;
//         }


//         @media print {
//             header { display: none; }
//             .logo { margin-left: 10px !important; }

//             .watermarked-container::before {
//                 content: "";
//                 background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg');
//                 background-repeat: no-repeat;
//                 background-position: center;
//                 background-size: 300px 300px;
//                 opacity: 0.05;
//                 position: absolute;
//                 top: 0;
//                 left: 0;
//                 width: 100%;
//                 height: 100%;
//                 z-index: 0;
//             }

//             .template_bg {
//                 background-image: url(../assets/imgs/license_bg.jpeg);
//                 background-repeat: no-repeat;
//                 background-size: 100% 100%;
//                 background-position: unset;
//                 position: relative;
//                 border : none !important;
//             }

//             body {
//                 -webkit-print-color-adjust: exact !important;
//                 print-color-adjust: exact !important;
//             }
//         }

//         td:first-child .info::before {
//             content: "• ";
//             margin-right: 5px;
//             color: black;
//         }
//     `);
//     a.document.write('@media print {');
//     a.document.write('  header { display: none; }');
//     a.document.write(
//         '  body { padding-left: 10; padding-right: 10; font-family: "Laila", serif !important;font-weight: 300;font-style: normal;}'
//     );
//     a.document.write('  .logo { margin-left: 10px !important; margin-top : 2px;}');
//     // a.document.write('  @page { margin: 2;}');
//     a.document.write('}');
//     a.document.write('</style>');

//     a.document.write('</head><body onload="window.print()">' + c + '</body></html>');
//     a.document.close();
// }

function acknowledgementPrinting() {
    var c = document.getElementById("PrintApplicationID").innerHTML;
    var a = window.open("", "print_content", "width=800,height=1000,resizable=1,scrollbars=1");
    a.document.open();
    a.document.write(`
    <html>
    <head>
        <title>ShopLicenseInvoice</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: "Laila", serif !important;
                font-weight: 300;
                margin: 0;
                padding: 0;
            }

            .watermarked-container {
                position: relative;
            }

            .watermarked-container::before {
                content: "";
                background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg');
                background-repeat: no-repeat;
                background-position: center;
                background-size: 300px 300px;
                opacity: 0.05;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                pointer-events: none;
            }

            #PrintApplicationTableID {
                position: relative;
                z-index: 1;
            }

            @media print {
                @page {
                    size: A4;
                    margin: 5mm;
                }

                body {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    zoom: 0.9; 
                }

                header {
                    display: none;
                }

                .template_bg {
                    background-image: url('../assets/imgs/license_bg.jpeg');
                    background-repeat: no-repeat;
                    background-size: 100% 100%;
                    background-position: unset;
                    position: relative;
                    border: none !important;
                }

                .watermarked-container::before {
                    background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg');
                }

                .logo {
                    margin-left: 10px !important;
                    margin-top: 2px;
                }
            }

            td:first-child .info::before {
                content: "• ";
                margin-right: 5px;
                color: black;
            }
        </style>
    </head>
    <body onload="window.print()">${c}</body>
    </html>
    `);
    a.document.close();
}
</script>