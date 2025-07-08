<head>
    <title> Shop License </title>
    <link rel="shortcut icon" href="../assets/imgs/theme/favicon.ico">
    <link rel="icon" href="../assets/imgs/theme/favicon.ico" type="image/x-icon">
</head>
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
            COALESCE(bm.BusinessCatNameMar, '') AS BusinessCatNameMar
        FROM Aurangabad_ShopAndLicense..ShopBilling sb 
        LEFT JOIN 
            Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
        LEFT JOIN 
            Aurangabad_ShopAndLicense..BusinessCategoryMaster bm ON sm.BusinessCat_Cd = bm.BusinessCat_Cd
        LEFT JOIN 
            Aurangabad_ShopAndLicense..TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd
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

    // $Total =  $Total_Pay  - $past_dues;
    list($startYear, $shortYear) = explode('-', $FinYear);
    $nextYear = (int)$startYear + 1;
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
                                        <div id="PrintApplicationTableID">
                                            
                                            <div class="row" style="position: relative; font-family: serif;">
                                                <div class="logo d-none d-flex" style="position: absolute; top: -7px; left: 2px; display: flex">
                                                        <!-- <img src="../assets/imgs/theme/logo.png" alt="logo" style="height: 39px;"/> -->
                                                         <img src="../assets/imgs/<?=trim($_SESSION['SAL_ElectionName'])?>_Logo.jpeg" alt="logo"
                                                                    style="height: 55px;" />
                                                        <!-- <p style="color: #C90D41; margin-top: 10px; font-size: 10px; font-weight: 700; display: block; line-height: 1;">Bazaar<br>Trace</p> -->
                                                </div>
    
                                                
                                                <h2 style="display: flex; justify-content: center; margin: 0; padding-bottom: 10px; font-size: 17px;">
                                                    <b>	छत्रपती संभाजीनगर महानगरपालिका</b>
                                                </h2>
                                                <h4 style="display: flex; justify-content: center; margin: 0; padding: 7px 0;font-size: 10px;">
                                                    <b style=""> post box number - 125, Town Hall, Chha. Sambhajinagar – 431009
                                                        <?= $FinYear ?>
                                                    </b>
                                                </h4>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12" style="display: flex;justify-content: center;">
                                                    <p style="font-size: 12px;">व्यावसायिक अस्थापना दुकान परवाना </p>
                                                </div>
                                                <div class="col-12" style="display: flex; ">
                                                    <div class="col-6" style="width: 50%">
                                                        <p style="font-size: 10px;">पावती क्र. <span><?= $TransNumber ?> </span> </p>
                                                    </div>
                                                    <div class="col-6"  style="width: 50%">
                                                        <p style="font-size: 10px;">दिनांक: <span><?= $BillingDate ?> </span> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <p style="font-size: 11px;"> 
                                                        छत्रपती संभाजीनगर महानगरपालिका हद्दीतील दुकान क्र. (<span><?= $Shop_Cd ?></span>) यावर देय्य असलेली सन <?= $FinYear ?> या आर्थिक वर्षात पुढील प्रमाणे कराची रक्कम अदा केली असून त्यांना सदरहू परवाना अदा केला जात आहे. 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <table class="table table-responsive-sm" border="1"
                                                    style="border-collapse: collapse;width:100%; font-family: serif;">
                                                    <thead>
                                                       <tr>
                                                            <th style="width: 11%; font-size: 10px;"> क्र. </th>
                                                            <th style="font-size: 10px;"> दुकानाचे नाव  </th>
                                                            <th style="font-size: 10px;"> दुकानदाराचे नाव  </th>
                                                            <th style="font-size: 10px;"> रक्कम </th>
                                                            <th style="font-size: 10px;"> रक्कम  अक्षरी  </th>
                                                        </tr>
                                                        <tr>
                                                            <!-- <th style="font-size: 9px;">< ?= $Shop_UID ?></th> -->
                                                            <th style="font-size: 10px;">1</th>
                                                            <th style="font-size: 10px;"><?= $ShopName?></th>
                                                            <th style="font-size: 10px;"><?= $ShopOwnerName ?></th>
                                                            <th style="font-size: 10px;"><?= $BillAmount?></th>
                                                            <th style="font-size: 10px;"><?= convertAmountToWords($BillAmount); ?></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <p style="font-size: 11px;">उपरोक्त व्यावसायिक अस्थापना परवाना फी आकारणी केली असून पुढील एकवर्षा करिता मर्यादित असेल. एक वर्षानंतर सदर परवाना नुतानिकरण करणे अपेक्षित आहे. </p>
                                            </div>
                                            <div class="row" style="display: flex ; justify-content: flex-end;">
                                                <div style="display: flex ; flex-direction: column; align-content: center; align-items: center;">
                                                    <p style="font-size: 10px;">उपायुक्त </p>
                                                    <p style="font-size: 10px;">छ. संभाजीनगर महानगरपलिका </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <p style="font-size: 10px;">टीप :- १. हे माणप िसटीम जनरेटेड आहे आिण यासाठी वा रीची आवयकता नाही.
                                                        <br> २. सदरील माणप  मालम9 मालक9 पुरावा नाही.
                                                </p>
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
    a.document.write('  .logo { margin-left: 10px !important;}');
    a.document.write('  @page { margin: 10;}');
    a.document.write('}');
    a.document.write('</style>');

    a.document.write('</head><body onload="window.print()">' + c + '</body></html>');
    a.document.close();
}
</script>