<head>

    <title> Shop License Reciept</title>

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
    </style>

    <link rel="shortcut icon" href="../assets/imgs/theme/favicon.ico">
    <link rel="icon" href="../assets/imgs/theme/favicon.ico" type="image/x-icon">
</head>


<?php

session_start();

include '../api/includes/DbOperation.php';
include 'amount_words.php';
$db = new DbOperation();

$Transaction_Cd = $_GET['Transaction_Cd'];
// $type = $_GET['type'];

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
            COALESCE(bm.BusinessCatNameMar, '') AS BusinessCatNameMar
        FROM Aurangabad_ShopAndLicense..TransactionDetails td
        LEFT JOIN 
            Aurangabad_ShopAndLicense..ShopBilling sb ON td.Billing_Cd = sb.Billing_Cd
        LEFT JOIN 
            Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
        LEFT JOIN 
            Aurangabad_ShopAndLicense..BusinessCategoryMaster bm ON sm.BusinessCat_Cd = bm.BusinessCat_Cd
        WHERE td.Transaction_Cd = $Transaction_Cd ";

$BillingData = $db->ExecutveQuerySingleRowSALData($PaymentQuery, $electionName, $developmentMode);
// print_r($BillingData);
// exit;

$Transaction_Cd = $BillingData['Transaction_Cd'];
$txnAmount = $BillingData['txnAmount'];
$TransNumber = $BillingData['TransNumber'];
$TranDateTime = $BillingData['TranDateTime'];
$paymentStatus = $BillingData['paymentStatus'];
$paymentMode = $BillingData['paymentMode'];

$BillNo = $BillingData['BillNo'];
$FinYear = $BillingData['FinYear'];

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




list($startYear, $shortYear) = explode('-', $FinYear);
$nextYear = (int) $startYear + 1;
$BillDate = "01-April-{$startYear} to 31-March-{$nextYear}";


?>
<button style="float:right;margin-right:20px;margin-top:10px;" onclick="window.open('','_self').close();">Back</button>
<button style="float:right;margin-right:20px;margin-top:10px;" onclick="acknowledgementPrinting()">Print</button>

<center>
    <div class="col-md-12 d-flex justify-content-center" id="RecepitID" style="padding-left:20%; padding-right:20%">
        <div class="card" style="width:60%;padding-top:12%;padding-left:12%;">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
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
                                                            <center style="position: relative; font-family: serif;">
                                                                <div class="logo d-none d-flex"
                                                                    style="position: absolute; top: 10px; left: 32px; display: flex">
                                                                    <!-- <img src="../assets/imgs/theme/logo.png" alt="logo"
                                                                        style="height: 55px;" /> -->
                                                                        <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" alt="logo"
                                                                        style="height: 55px;" />
                                                                    <!-- <p
                                                                        style="color: #C90D41; margin-top: 15px; font-size: 16px; font-weight: 700; display: block; line-height: 1;">
                                                                        Bazaar<br>Trace</p> -->
                                                                </div>

                                                                <h4
                                                                    style="display: flex; justify-content: center; margin: 0; padding: 7px 0;font-size: 10px;">
                                                                    <b style=""> दुकान परवाना बिल - दुकान परवाना फी जमा पावती
                                                                    </b>
                                                                </h4>

                                                                <h2 style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 13px;">
                                                                    <b>छत्रपती संभाजीनगर महानगरपालिका</b>
                                                                </h2>
                                                            

                                                                <h2
                                                                    style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 10px;">
                                                                    <!-- <b>छत्रपती संभाजी नगर - 431001</b> -->
                                                                    <b> ( पोस्ट बॉक्स क्रमांक - 125, टाऊन हॉल, छ. संभाजीनगर - 431009 ) </b>
                                                                </h2>
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
                                                                <div class="heading" style="font-size: 13px">Receipt</div>
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="9">
                                                                    <!-- <div class="info"> Bill No. : < ?= $BillNo ?></div> -->
                                                                    <div class="info" style="font-size: 10px"> बिल क्रमांक :
                                                                        <?= $BillNo ?>
                                                                    </div>
                                                                </td>
                                                                <td colspan="3">
                                                                    <!-- <div class="info"> Payment Date : < ?= $PaymentDate ?> </div>-->
                                                                    <div class="info" style="font-size: 10px">दिनांक :
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
                                                                <div class="sub-heading" style="font-size: 13px">Property
                                                                    Details </div>
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="12">
                                                                    <!-- <div class="info"> Owner Name : < ?= $OwnerName ?></div> -->
                                                                    <div class="info" style="font-size: 10px"> दुकानदारचे
                                                                        नाव : <?= $ShopOwnerName ?></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="12">
                                                                    <!-- <div class="info"> Owner Name : < ?= $OwnerName ?></div> -->
                                                                    <div class="info" style="font-size: 10px"> दुकानाचे नाव
                                                                        : <?= $ShopName ?></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <?php if (!empty($Shop_UID)) { ?>
                                                                <td colspan="9">
                                                                    <div class="info" style="font-size: 10px">दुकान क्रमांक
                                                                        : <?= $Shop_UID ?>
                                                                    </div>
                                                                </td>

                                                                <?php } ?>

                                                                <td colspan="3">
                                                                    <!-- <div class="info"> Property Type : < ?= $Property_type ?> -->
                                                                    <div class="info" style="font-size: 10px">दुकानाचे
                                                                        प्रकार : <?= $ShopCategory ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                    <table class="table table-responsive-sm"
                                                        style="border-collapse: collapse;width:100%; margin-top: 10px; "
                                                        border="1">
                                                        <thead>
                                                            <th colspan="12">
                                                                <!-- <div class="sub-heading">Payments Details ( देयक तपशील )</div> -->
                                                                <div class="sub-heading" style="font-size: 13px">Payments
                                                                    Details</div>
                                                            </th>
                                                        </thead>
                                                        <tbody>
                                                            <?php if ($TransNumber != '') { ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Transaction Id :</div> -->
                                                                    <div class="info" style="font-size: 10px"> पावती क्रमांक :</div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        <?= $TransNumber ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Payer Name :</div> -->
                                                                    <div class="info" style="font-size: 10px"> देयकाचे नाव :
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        <?= $ShopOwnerName ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info"> Mobile No. : </div> -->
                                                                    <div class="info" style="font-size: 10px"> मोबाईल
                                                                        क्रमांक : </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        <?= $ShopOwnerMobile ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info "> Payment Mode :</div> -->
                                                                    <div class="info" style="font-size: 10px"> देय प्रकार
                                                                        : </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        <?= $paymentMode ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="info "> Payment Mode :</div> -->
                                                                    <div class="info" style="font-size: 10px"> मागील शिल्लक मागणी : </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        <?= $PastDues ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <div class="info amt-words" style="font-size: 10px">
                                                                    अक्षरी रुपये : <br>
                                                                        <b><?= convertAmountToWords($txnAmount); ?></b>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="info info-data" style="font-size: 10px">
                                                                        Amount : <br> <b> &#8377;
                                                                            <!-- <div class="info info-data"> एकूण रक्कम : <br> <b> &#8377; -->
                                                                            <?= $txnAmount ?>
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
    a.document.write('<html><head><title>ShopLicenseReceipt</title>');
    a.document.write(
        '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">'
    );
    a.document.write('<style>');
    a.document.write('@media print {');
    a.document.write('  header { display: none; }');
    a.document.write(
        '  body { padding-left: 10; padding-right: 10; font-family: "Laila", serif !important;font-weight: 300;font-style: normal;}'
    );
    a.document.write('  .logo { margin-left: 10px !important;}');
    a.document.write('  @page { margin: 10;}');
    a.document.write('}');
    a.document.write('</style>');

    a.document.write('</head><body onload="window.print()"><center>' + c + '</center></body></html>');
    a.document.close();
}

</script>