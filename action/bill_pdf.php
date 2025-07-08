<head>
    <title> Shop License Invoice</title>
    <link rel="shortcut icon" href="../assets/imgs/theme/favicon.ico">
    <link rel="icon" href="../assets/imgs/theme/favicon.ico" type="image/x-icon">
</head>
<?php
session_start();
// print_r($_SESSION);
include '../api/includes/DbOperation.php';
$db = new DbOperation();

$billing_Id = $_GET['billing_id'];

$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];


$BillingQuery = "SELECT 
            COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
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
            COALESCE(bm.BusinessCatNameMar, '') AS BusinessCatNameMar
        FROM Aurangabad_ShopAndLicense..ShopBilling sb 
        LEFT JOIN 
            Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
        LEFT JOIN 
            Aurangabad_ShopAndLicense..BusinessCategoryMaster bm ON sm.BusinessCat_Cd = bm.BusinessCat_Cd
        WHERE sb.Billing_Cd = $billing_Id AND sb.IsActive = 1";

$BillingData = $db->ExecutveQuerySingleRowSALData($BillingQuery, $electionName, $developmentMode);

// echo "<pre>"; print_r($BillingData);exit;

$BillNo = $BillingData['BillNo'];
$FinYear = $BillingData['FinYear'];
$LicenseStartDate = $BillingData['LicenseStartDate'];
$LicenseEndDate = $BillingData['LicenseEndDate'];
$ShopCategory = $BillingData['ShopCategory'];
$Shop_UID = $BillingData['Shop_UID'];
$BusinessCatNameMar = $BillingData['BusinessCatNameMar'];
$BusinessCatName = $BillingData['BusinessCatName'];
$length = isset($BillingData['ShopLength']) ? floatval($BillingData['ShopLength']) : 0;
$width = isset($BillingData['ShopWidth']) ? floatval($BillingData['ShopWidth']) : 0;
$Area_SqFt = round($length * $width, 2);
$Area_SqM = round($length * $width * 0.092903, 2);
$Ward_No = $BillingData['Ward_No'];
$ShopOwnerNameMar = $BillingData['ShopOwnerNameMar'];
$ShopOwnerName = $BillingData['ShopOwnerName'];
$ShopKeeperName = $BillingData['ShopKeeperName'];
$ShopKeeperNameMar = $BillingData['ShopKeeperNameMar'];
$BillingDate = $BillingData['BillingDate'];

$LicenseFees = $BillingData['LicenseFees'];
$BillAmount = $BillingData['BillAmount'];
$TaxAmount = $BillingData['TaxAmount'];
$TaxRate = $BillingData['TaxRate'];

// $Total =  $Total_Pay  - $past_dues;
list($startYear, $shortYear) = explode('-', $FinYear);
$nextYear = (int) $startYear + 1;
$BillDate = "01-April-{$startYear} to 31-March-{$nextYear}";

?>

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
</style>

<div class="col-md-12" id="PrintApplicationID" style="padding-left:20%; padding-right:20%;min-height:50%;">
    <div class="card" style="width:60%;padding-top:12%;padding-left:12%;">
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
                                        <table id="PrintApplicationTableID" border="1"
                                            style="border-collapse: collapse;width:100%;">
                                            <tr>
                                                <td>
                                                    <center style="position: relative; font-family: serif;">
                                                        <div class="logo d-none d-flex"
                                                            style="position: absolute; top: 13px; left: 7px; display: flex">
                                                            <!-- <img src="../assets/imgs/theme/logo.png" alt="logo"
                                                                style="height: 50px;" /> -->
                                                                <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" alt="logo"
                                                                    style="height: 55px;" />
                                                            <p
                                                                style="color: #C90D41; margin-top: 10px; font-size: 16px; font-weight: 700; display: block; line-height: 1;">
                                                                Bazaar<br>Trace</p>
                                                        </div>

                                                        <h4
                                                            style="display: flex; justify-content: center; margin: 0; padding: 7px 0;font-size: 13px;">
                                                            <b style=""> दुकान परवाना बिल - सन
                                                                <?= $FinYear ?>
                                                            </b>
                                                        </h4>

                                                        <h2
                                                            style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 17px;">
                                                            <b>छत्रपती संभाजी नगर - 431001</b>
                                                        </h2>
                                                    </center>
                                                </td>
                                            </tr>

                                            <table class="table table-responsive-sm" border="1"
                                                style="border-collapse: collapse;width:100%; font-family: serif;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 11%; font-size: 10px;"> दिनांक </th>
                                                        <th style="font-size: 10px;"> बिल क्रमांक </th>
                                                        <th style="font-size: 10px;"> प्रभाग क्रमांक </th>
                                                        <th style="font-size: 10px;"> दुकान प्रकार </th>
                                                        <?php if (!empty($Shop_UID)) { ?>
                                                        <th style="font-size: 10px;"> दुकान क्रमांक </th>
                                                        <?php } ?>
                                                        <?php if (!empty($BusinessCatNameMar)) { ?>
                                                        <th style="font-size: 10px;"> दुकान वर्णन </th>
                                                        <?php } ?>
                                                        <th style="font-size: 10px;"> क्षेत्र चौ.मी </th>
                                                        <th style="font-size: 10px;"> क्षेत्र चौ. फूट</th>
                                                        <th style="width: 11%; font-size: 10px;"> कर दात्यांची नावे
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-size: 9px;"><?= $BillingDate ?></th>
                                                        <th style="font-size: 10px;"><?= $BillNo ?></th>
                                                        <th style="font-size: 10px;"><?= $Ward_No ?></th>
                                                        <th style="font-size: 10px;"><?= $ShopCategory ?></th>
                                                        <?php if (!empty($Shop_UID)) { ?>
                                                        <th style="font-size: 10px;">
                                                            <?= $Shop_UID ?>
                                                        </th>
                                                        <?php } ?>
                                                        <?php if (!empty($BusinessCatNameMar)) { ?>
                                                        <th style="font-size: 10px;">
                                                            <?= $BusinessCatNameMar ?>
                                                        </th>
                                                        <?php } ?>
                                                        <th style="font-size: 10px;"><?= $Area_SqM ?></th>
                                                        <th style="font-size: 10px;"><?= $Area_SqFt ?></th>
                                                        <th style="font-size: 10px;"><?= $ShopOwnerName ?></td>
                                                    </tr>
                                                </thead>
                                            </table>


                                            <table border="1"
                                                style="border-collapse: collapse;width:100%; font-family: serif;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="text-align:left;padding-left:20px;padding-top:10px;padding-bottom:10px;font-size:13px;">
                                                            दिनांका पासून पर्यंत </th>
                                                        <th colspan="4"
                                                            style="text-align:left;padding-left:20px;padding-top:10px;padding-bottom:10px;font-size:13px;">
                                                            <?= $LicenseStartDate ?> to
                                                            <?= $LicenseEndDate ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="text-align:left;padding-left:20px;padding-top:10px;">
                                                            <h4 style="font-size: 12px;"> दुकानाचे करपात्र मूल्य
                                                            </h4>
                                                        </th>
                                                        <th colspan="4"
                                                            style="text-align:left;padding-left:20px;padding-top:10px;">
                                                            <h4 style="font-size: 12px;"><?= $BillAmount ?></h4>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="text-align:left;padding-left:20px;padding-top:5px;padding-bottom:5px;font-size:10px; ">
                                                            देयकाचा तपशील
                                                        </th>
                                                        <th colspan="4"
                                                            style="text-align:left;padding-top:5px;padding-left:20px;padding-bottom:5px;font-size:10px;">
                                                            दुकान कर
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2"
                                                            style="text-align:left;padding-top:5px;padding-left:20px;padding-bottom:5px; font-size: 10px;">
                                                            बिलाची रक्कम
                                                        </td>
                                                        <td colspan="4"
                                                            style="text-align:left;padding-top:5px;padding-left:20px;padding-right:20px;padding-bottom:5px; font-size: 10px;">
                                                            <?= $LicenseFees ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="text-align:left;padding-left:20px;font-size:13px">
                                                            एकूण रक्कम
                                                        </th>
                                                        <th colspan="4"
                                                            style="text-align:left;padding-right:20px;padding-left:20px;padding-top:10px;padding-bottom:10px; font-size: 13px;">
                                                            &#8377;<?= (float) $BillAmount ?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
<script>
function acknowledgementPrinting() {
    var c = document.getElementById("PrintApplicationID").innerHTML;
    var a = window.open("", "print_content", "width=800,height=1000,resizable=1,scrollbars=1");
    a.document.open();
    a.document.write('<html><head><title>ShopLicenseInvoice</title>');
    a.document.write(
        '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">'
    );
    a.document.write('<style>');
    a.document.write('@media print {');
    a.document.write('  header { display: none; }');
    a.document.write(
        '  body { padding-left: 10; padding-right: 10; font-family: "Laila", serif !important;font-weight: 300;font-style: normal;}'
    );
    a.document.write('  .logo { margin-left: 5px !important;}');
    a.document.write('  .logo img{height : 45px !important; }');
    a.document.write('  .logo p {font-size : 14px !important; }');
    a.document.write('  @page { margin: 10;}');
    a.document.write('}');
    a.document.write('</style>');

    a.document.write('</head><body onload="window.print()">' + c + '</body></html>');
    a.document.close();
}
</script>