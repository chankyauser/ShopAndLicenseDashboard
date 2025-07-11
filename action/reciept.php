<?php

session_start();

include '../api/includes/DbOperation.php';
include 'amount_words.php';
$db = new DbOperation();

$Transaction_Cd = $_GET['Transaction_Cd'];

$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

$PaymentQuery = "SELECT 
            COALESCE(td.Transaction_Cd, 0) AS Transaction_Cd, 
            COALESCE(td.txnAmount, 0) AS txnAmount, 
            COALESCE(td.TransNumber, 0) AS TransNumber, 
            COALESCE(td.paymentMode, '') AS paymentMode, 
            COALESCE(CONVERT(VARCHAR, td.TranDateTime, 105), '') AS TranDateTime,
            COALESCE(td.paymentStatus, '') AS paymentStatus, 
            COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
            COALESCE(sb.BillNo, '') AS BillNo, 
            COALESCE(sb.FinYear, '') AS FinYear, 
            COALESCE(CONVERT(VARCHAR, sb.BillingDate, 105), '') AS BillingDate,
            COALESCE(sm.Shop_Cd, '') AS Shop_Cd, 
            COALESCE(sm.Shop_UID, '') AS Shop_UID, 
            COALESCE(sm.ShopName, '') AS ShopName, 
            COALESCE(sm.ShopNameMar, '') AS ShopNameMar,
            COALESCE(sm.ShopOwnerName, '') AS ShopOwnerName,
            COALESCE(sm.ShopOwnerNameMar, '') AS ShopOwnerNameMar,
            COALESCE(sm.ShopOwnerMobile, '') AS ShopOwnerMobile,
            COALESCE(sm.ShopAddress_1, '') AS ShopAddress_1, 
            COALESCE(sm.ShopAddress_1Mar, '') AS ShopAddress_1Mar,
            COALESCE(sm.Ward_No, 0) AS Ward_No, 
            COALESCE(sm.ShopCategory, '') AS ShopCategory,
            COALESCE(sb.PastDues, '') AS PastDues,
            COALESCE(bm.BusinessCatName, '') AS BusinessCatName, 
            COALESCE(bm.BusinessCatNameMar, '') AS BusinessCatNameMar,
			COALESCE(sm.Ward_No,0) AS Ward_No,
			CONCAT(COALESCE(sm.ShopAddress_1,''),' ',COALESCE(sm.ShopAddress_2,'')) AS ShopAddress,
			COALESCE(nm.NodeName,'') AS ZoneName,
            COALESCE(nm.Area,'') AS Area
        FROM TransactionDetails td
        LEFT JOIN ShopBilling sb ON td.Billing_Cd = sb.Billing_Cd
        LEFT JOIN ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
        LEFT JOIN BusinessCategoryMaster bm ON sm.BusinessCat_Cd = bm.BusinessCat_Cd
		LEFT JOIN NodeMaster nm ON (sm.Ward_No = nm.Ward_No)
        WHERE td.Transaction_Cd = $Transaction_Cd ";

$BillingData = $db->ExecutveQuerySingleRowSALData($PaymentQuery, $electionName, $developmentMode);

$Transaction_Cd = $BillingData['Transaction_Cd'];
$txnAmount = $BillingData['txnAmount'];
$TransNumber = $BillingData['TransNumber'];
$TranDateTime = $BillingData['TranDateTime'];
$paymentStatus = $BillingData['paymentStatus'];
$paymentMode = $BillingData['paymentMode'];

$BillNo = $BillingData['BillNo'];
$FinYear = $BillingData['FinYear'];

$Shop_Cd = $BillingData['Shop_Cd'];
$Shop_UID = $BillingData['Shop_UID'];
$ShopName = $BillingData['ShopName'];
$ShopCategory = $BillingData['ShopCategory'];
$ShopOwnerName = $BillingData['ShopOwnerName'];
$ShopOwnerNameMar = $BillingData['ShopOwnerNameMar'];
$ShopOwnerMobile = $BillingData['ShopOwnerMobile'];

$BusinessCatNameMar = $BillingData['BusinessCatNameMar'];
$BusinessCatName = $BillingData['BusinessCatName'];
$BillingDate = $BillingData['BillingDate'];
$PastDues = $BillingData['PastDues'];
$ZoneName = $BillingData['ZoneName'];
$Ward_No = $BillingData['Ward_No'];
$ShopAddress = $BillingData['ShopAddress'];
$WardName = $BillingData['Area'];


list($startYear, $shortYear) = explode('-', $FinYear);
$nextYear = (int) $startYear + 1;
$BillDate = "01-April-{$startYear} to 31-March-{$nextYear}";

function titleCaseWithHyphen($text) {
    $text = ucwords(strtolower($text));
    $text = preg_replace_callback('/\b(\w+)-(\w+)\b/', function ($matches) {
        return ucfirst($matches[1]) . '-' . ucfirst($matches[2]);
    }, $text);

    return $text;
}


function convertAmount($amount){
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);

    $rupees = floor($amount);
    $paise = round(($amount - $rupees) * 100);

    $words = $formatter->format($rupees) . " Rupees";

    if ($paise > 0) {
        $words .= " and " . $formatter->format($paise) . " Paise";
    }

    $words .= " Only";

    $words = titleCaseWithHyphen($words);

    return $words;
}
?>

<head>
    <style>
    .title {
        font-weight: bold;
    }

    th .heading {
        padding: 10px !important;
        background: #9e9e9e2b !important;
        font-size: 23px;
        text-transform: uppercase;
        font-weight: bold;
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

    .amt-words {
        text-transform: capitalize;
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
        /* adjust size as needed */
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

    /* ✅ Ensure watermark shows when printing */
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
    }
    </style>

    <title> Bazaar Trace | <?= trim($_SESSION['SAL_ElectionName'])?> </title>
    <link rel="shortcut icon" href="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg">
    <link rel="icon" href="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" type="image/x-icon">
</head>



<button style="float:right;margin-right:20px;margin-top:10px;" onclick="window.open('','_self').close();">Back</button>
<button style="float:right;margin-right:20px;margin-top:10px;" onclick="acknowledgementPrinting()">Print</button>

<center>
    <div class="col-md-12 d-flex justify-content-center" id="RecepitID" style="padding-left:20%; padding-right:20%">
        <div class="card">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card watermarked-container">
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="RecepitTableID" border="1"
                                                style="border-collapse: collapse;width:100%;">
                                                <br>
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td colspan="12">
                                                            <center
                                                                style="position: relative; font-family: serif;padding: 13px;">
                                                                <div class="logo d-flex align-items-center"
                                                                    style="position: absolute; top: 20px; left: 12px; display: flex; align-items: center;">

                                                                    <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg"
                                                                        alt="logo"
                                                                        style="height: 80px;margin-top: -15px;" />

                                                                    <!-- <div
                                                                        style="display: flex; flex-direction: column; justify-content: center; text-align: left; color: #C90D41; font-size: 16px; font-weight: 700; line-height: 1.2;">
                                                                       <?=trim($_SESSION['SAL_ElectionName'])?> <br>
                                                                        Bazaar Trace
                                                                    </div> -->
                                                                </div>


                                                                <h4
                                                                    style="display: flex; justify-content: center; margin: 0; padding: 7px 0;font-size: 13px;">
                                                                    <b style="">आस्थापनांना व्यवसाय करणेकरिता परवाना फी
                                                                        जमा पावती</b>
                                                                </h4>

                                                                <h2
                                                                    style="display: flex; justify-content: center; margin: 0; padding-bottom: 4px; font-size: 20px;">
                                                                    <b>छत्रपती संभाजीनगर महानगरपालिका</b>
                                                                </h2>


                                                                <!-- <h2
                                                                    style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 14px;">
                                                                    <b> पोस्ट बॉक्स क्रमांक - 125, टाऊन हॉल, छ.
                                                                        संभाजीनगर - 431009 </b>
                                                                </h2> -->
                                                            </center>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <table class="table "
                                                        style="border-collapse: collapse;width:100%; margin-top: 10px; font-family: serif;"
                                                        border="1">
                                                        <thead>
                                                            <th colspan="12">
                                                                <div class="heading" style="font-size: 16px">RECEIPT
                                                                </div>
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="9">
                                                                    <!-- <div class="info"> Bill No. : < ?= $BillNo ?></div> -->
                                                                    <!-- <div class="info" style="font-size: 14px"> पावती
                                                                        क्रमांक :
                                                                        < ?= $TransNumber ?>
                                                                    </div> -->
                                                                    <div class="info" style="font-size: 14px"> Receipt
                                                                        No :
                                                                        <?= $TransNumber ?>
                                                                    </div>
                                                                </td>
                                                                <td colspan="3">
                                                                    <!-- <div class="info"> Payment Date : < ?= $PaymentDate ?> </div>-->
                                                                    <div class="info" style="font-size: 14px"> Date :
                                                                        <?= $TranDateTime ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                    <table class="table table-responsive-sm"
                                                        style="border-collapse: collapse;width:100%; margin-top: 10px;font-family: serif;"
                                                        border="1">
                                                        <thead>
                                                            <th colspan="12">
                                                                <!-- <div class="sub-heading">Property Details ( मालमत्तेची
                                                                    माहिती )</div> -->
                                                                <div class="sub-heading" style="font-size: 16px">
                                                                    SHOP DETAILS
                                                                </div>
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                   
                                                                    <div class="info" style="font-size: 14px">
                                                                        Shop No </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $Shop_Cd ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px">
                                                                        Shop Owner Name </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ShopOwnerName ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php if (!empty($Shop_UID)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Shop No
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $Shop_UID ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Shop Name
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ShopName ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Shop Type
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ShopCategory ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Shop
                                                                        Address </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ShopAddress ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Zone
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ZoneName ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Ward
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $WardName ?>
                                                                    </div>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 14px"> Mobile No
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $ShopOwnerMobile ?>
                                                                    </div>
                                                                </td>
                                                            </tr>



                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info "> Payment Mode :</div> -->
                                                                    <div class="info" style="font-size: 14px"> Payment
                                                                        Mode
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $paymentMode ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info "> Payment Mode :</div> -->
                                                                    <div class="info" style="font-size: 14px"> Past Dues
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <?= $PastDues ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <div class="info amt-words" style="font-size: 14px">
                                                                        Amount <br>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 14px">
                                                                        <b>
                                                                            &#8377; <?= $txnAmount ?>/- &nbsp;
                                                                            <!-- < ?= convertAmountToWords($txnAmount); ?> -->
                                                                            <?= convertAmount($txnAmount); ?>
                                                                        </b>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </tbody>
                                            </table>
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
</center>

<script>
// function acknowledgementPrinting() {
//     var c = document.getElementById("RecepitID").innerHTML;
//     var a = window.open("", "print_content", "width=800,height=1000,resizable=1,scrollbars=1");
//     a.document.open();
//     a.document.write('<html><head><title>Shop License Payment Receipt</title>');
//     a.document.write('<style>');
//     a.document.write('@media print {');
//     a.document.write('  body { font-family: serif; padding: 20px; margin: 0; }');
//     a.document.write('  .card, .card-body, .card-content { box-shadow: none !important; border: none; }');
//     a.document.write('  .logo { text-align: left; margin-bottom: 10px; display: block !important; left: 10px !important }');
//     a.document.write('  .logo img { height: 55px !important; margin: 0 auto; display: block; }');
//     a.document.write('  .info, .info-data { font-size: 10px; }');
//     a.document.write('  table { width: 100%; border-collapse: collapse; }');
//     a.document.write('  th, td { border: 1px solid #000; padding: 4px; }');
//     a.document.write('  @page { margin: 20px; }');
//     a.document.write('}');
//     a.document.write('</style>');

//     a.document.write('</head><body onload="window.print()">' + c + '</body></html>');
//     a.document.close();
// }

function acknowledgementPrinting() {
    var c = document.getElementById("RecepitID").innerHTML;
    var a = window.open("", "print_content", "width=800,height=1000,resizable=1,scrollbars=1");
    a.document.open();
    a.document.write('<html><head><title>ShopLicenseInvoice</title>');
    a.document.write(
        '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">'
    );
    a.document.write('<style>');
    a.document.write(`
        body {
            font-family: "Laila", serif !important;
            font-weight: 300;
            font-style: normal;
        }

        .watermarked-container {
            position: relative;
        }

        .watermarked-container::before {
            content: "";
            background-image: url('../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg'); /* Adjust path if needed */
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

        @page {
            margin: 10mm;
        }

        @media print {
            header { display: none; }
            .logo { margin-left: 10px !important; }

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

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    `);
    a.document.write('@media print {');
    a.document.write('  header { display: none; }');
    a.document.write(
        '  body { padding-left: 10; padding-right: 10; font-family: "Laila", serif !important;font-weight: 300;font-style: normal;}'
    );
    a.document.write('  .logo { margin-left: 10px !important;}');
    a.document.write('  @page { margin: 10;}');
    a.document.write('}');
    a.document.write('</style>');

    a.document.write('</head><body onload="window.print()">' + c + '</body></html>');
    a.document.close();
}
</script>