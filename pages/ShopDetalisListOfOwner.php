<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<?php
// echo "<pre>"; print_r($_SERVER);exit;
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$ShopMobileNo = $_SESSION['SAL_ShopKeeperMobile'];
$currentDate = new DateTime();
$startYear = (int)$currentDate->format("Y");
$endDate = $currentDate->modify('+1 year');
$endYear = (int)$endDate->format("Y");
$FinYear = $startYear . '-' . substr($endYear, -2);
$queryShopOwnerShopList = "SELECT  
                                ISNULL(sm.Shop_Cd , '') AS Shop_Cd,
                                ISNULL(sm.ShopOwnerAadharNo, '') AS ShopOwnerAadharNo,
                                ISNULL(sm.ShopOwnerPinCode, '') AS ShopOwnerPinCode,
                                ISNULL(bcm.BusinessCatName, '') AS BusinessCatName,
                                ISNULL(CASE
                                    WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                    ELSE ShopKeeperName
                                END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(sm.ShopOwnerAddress, '') AS ShopOwnerAddress,
                                ISNULL(sm.FirstName, '') AS FirstName,
                                ISNULL(sm.MiddleName, '') AS MiddleName,
                                ISNULL(sm.LastName, '') AS LastName,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(pm.Parwana_Name_Eng, '') AS BusinessDetails,
                                ISNULL(pd.Amount,'') as Amount,
                                ISNULL(sm.ShopLength,0) as ShopLength,
                                ISNULL(sm.ShopWidth,0) as ShopWidth,
                                ISNULL(sm.ShopHeight,0) as ShopHeight,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                            CASE 
                                                WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                    THEN CONCAT(', ', ShopAddress_2)
                                            ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopCategory, '') AS ShopCategory,
                                ISNULL(sm.IsCertificateIssued, '') AS IsCertificateIssued,
                                ISNULL(CONVERT(VARCHAR,sm.BusinessStartDate,23),'') as BusinessStartDate,
                                ISNULL(CONVERT(VARCHAR,sm.RenewalDate,23),'') as RenewalDate,
                                ISNULL(sm.ShopOutsideImage1, '') AS ShopOutsideImage1,
                                ISNULL(sm.ShopOwnStatus, '') AS ShopOwnStatus,
                                ISNULL(sm.BusinessCat_Cd, '') AS BusinessCat_Cd,
                                ISNULL(sm.ShopNameMar, '') AS ShopNameMar,
                                ISNULL(sb.Billing_Cd, 0) AS Billing_Cd
                            FROM ShopMaster sm
                            LEFT JOIN ParwanaDetails AS pd ON (pd.ParwanaDetCd = sm.ParwanaDetCd)
                            LEFT JOIN ParwanaMaster AS pm ON (pm.Parwana_Cd = pd.Parwana_Cd)
                            LEFT JOIN BusinessCategoryMaster AS bcm ON (bcm.BusinessCat_Cd=sm.BusinessCat_Cd)
                            LEFT JOIN ShopBilling AS sb ON (sb.Shop_Cd = sm.Shop_Cd) AND sb.FinYear = '$FinYear' AND sb.IsActive  = 1
                            WHERE (sm.ShopKeeperMobile='$ShopMobileNo' OR sm.ShopOwnerMobile = '$ShopMobileNo') AND sm.IsActive = 1
                            ORDER BY sm.Shop_Cd DESC";

$db2 = new DbOperation();
$shopDetailList = $db2->ExecutveQueryMultipleRowSALData($queryShopOwnerShopList, $electionName, $developmentMode);
?>
<style>
.custom-product-image {
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-width: 100%;
    height: auto;
}

.custom-product-image:hover {
    transform: scale(1.1);

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

}

.custom-product-image {
    border: 2px solid #f0f0f0;

    padding: 5px;

}

.custom-product-image:focus {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.product-img-zoom {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    height: auto;
}

.product-img-inner {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 15rem !important;
}

.nav-tabs {
    border-bottom: none !important;
    background-color: transparent !important;
}

.nav-tabs .nav-link {
    background-color: white;
    color: #C90D41;
    border: 1px solid #C90D41;
    transition: none;
    /* disable transitions if you want */
}

.nav-tabs .nav-link:hover {
    background-color: white !important;
    /* force white on hover */
    color: #C90D41 !important;
    /* force text color on hover */
}

.nav-tabs .nav-link.active {
    background-color: #C90D41;
    color: white;
    border-color: #C90D41;
}

.nav-item {
    border-bottom: none !important;
}

.nav-tabs .nav-link:hover {
    color: #C90D41;
    text-decoration: none;
}

.custom-tab {
    min-width: 100px;
    text-align: center;
    height: 40px;
    margin-left: 10px;
}

.btntoggle {
    background-color: transparent !important;
    border: none;
    padding: 0;
    cursor: pointer;
}

.btntoggle .fa-solid {
    color: black;
    font-size: 1rem;
}


tbody td {
    padding-left: 10px;
}


tbody tr:nth-child(n+5):nth-child(-n+6) td {
    padding-left: 40px;
}

.table td {
    padding-left: 20px;
}

.btn.btntoggle .icon-down,
.btn.btntoggle .icon-up {
    color: red;
}


a[data-tooltip] {
    position: relative;
    cursor: pointer;
}


a[data-tooltip]::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 13px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

a[data-tooltip]::before {
    content: "";
    position: absolute;
    bottom: 115%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

a[data-tooltip]:hover::after,
a[data-tooltip]:hover::before {
    opacity: 1;
    pointer-events: auto;
}
</style>
<div class="container mb-0 mt-0">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="row">
                <?php if (sizeof($shopDetailList) > 0) {
                    foreach ($shopDetailList as $shopData) { ?>
                <div class="col-lg-3-6 mt-0 mb-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Shop Image -->
                                <div class="col-12 col-xl-2">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap" style="cursor: pointer;">
                                            <div class="product-img product-img-zoom">
                                                <div class="product-img-inner">
                                                    <!-- Display the Shop Image if available -->
                                                    <?php
                                                            if (!empty($shopData['ShopOutsideImage1'])) {
                                                                // $shopImageUrl = "$shopData['ShopOutsideImage1'];
                                                                ?>
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=" . $shopData['ShopOutsideImage1']; ?>"
                                                        alt="Shop Image" class="img-fluid custom-product-image">
                                                    <?php } else { ?>
                                                    <img src="./assets/imgs/shopImage.png" alt="Default Image"
                                                        class="img-fluid custom-product-image">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Details -->
                                <div class="col-12 col-xl-5">
                                    <span class="badge badge-pill badge-primary">Primary</span>
                                    <div class="product-content-wrap">
                                        <h5 class="card-title">
                                            <?= $shopData['ShopName']; ?>
                                        </h5>
                                        <p class="card-text">Address : <?= $shopData['ShopAddress']; ?> -
                                            <?= $shopData['ShopOwnerPinCode'] ?>
                                        </p>
                                        <p class="card-text">Shopkeeper / ShopOwner:
                                            <?php echo $shopData['ShopKeeperName']; ?>
                                        </p>
                                        <p class="card-text">Mobile : <?php echo $shopData['ShopKeeperMobile']; ?>
                                        </p>
                                        <p class="card-text">Email : <?php echo $shopData['ShopEmailAddress']; ?></p>
                                        <p class="card-text">Shop Area (Length, Height, Width)(in meters):
                                            <?php if ($shopData['ShopLength'] != 0 && $shopData['ShopWidth'] != 0 && $shopData['ShopHeight'] != 0) {
                                                        echo $shopData['ShopLength'] . ',' . $shopData['ShopHeight'] . ',' . $shopData['ShopWidth'];
                                                    }
                                                    ?>
                                        </p>

                                    </div>
                                </div>

                                <!-- Shop Ownership Status -->
                                <div class="col-12 col-xl-3">
                                    <div class="product-cart-wrap">
                                        <div class="product-content-wrap" style=" margin-top: 30px;">
                                            <p>Shop Category : <?php echo $shopData['ShopCategory']; ?></p>
                                            <p>Business Category : <?php echo $shopData['BusinessCatName']; ?></p>
                                            <p>Business Details : <?php echo $shopData['BusinessDetails']; ?></p>
                                            <p>Fees Applicable :
                                                <?= isset($shopData['Amount']) && !empty($shopData['Amount']) ? '₹ ' . $shopData['Amount'] : '₹ 0'; ?>
                                            </p>
                                            <!-- <p>Business Name: <? // echo $shopData['ShopName']; ?></p> -->
                                            <p>Shop Own Status : <?php echo $shopData['ShopOwnStatus']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-2">
                                    <div class="product-action-1" style="margin-top: 35px;">
                                        <button type="button" id="edit-btn"
                                            class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2"
                                            onclick="redirectToEditPage(<?php echo $shopData['Shop_Cd']; ?>)">Edit
                                            Info</button>
                                    </div>
                                    <button type="button" id="license-btn"
                                        class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2 <?php echo ($shopData['Billing_Cd'] != 0 && $shopData['Billing_Cd'] != '') ? 'd-none' : ''; ?>"
                                        onclick="applyforlicense(<?php echo $shopData['Shop_Cd']; ?>, '')">
                                        Generate License </button>

                                    <?php
                                        $currentDate = strtotime(date('Y-m-d'));
                                        $renewalDate = strtotime(date('Y-m-d', strtotime($shopData['RenewalDate'])));
                                        $plus30Date = strtotime('+30 days', $currentDate);

                                        if ($renewalDate >= $currentDate && $renewalDate <= $plus30Date) {
                                        ?>
                                    <button type="button" id="renew-btn"
                                        class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2"
                                        onclick="applyforlicense(<?php echo $shopData['Shop_Cd']; ?>, '<?php echo $shopData['RenewalDate'] ?>')">
                                        Renew License
                                    </button>
                                    <?php
                                        }
                                        ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 mt-2">
                                    <div class="total-amt" id="total-amt-<?= $shopData['Shop_Cd']; ?>"></div>
                                    <div class="billing-content" id="billing-content-<?= $shopData['Shop_Cd']; ?>">
                                        <div>
                                            <table class="table table-bordered" id="BillingDetails">
                                                <thead></thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                } else { ?>
                <p>No shops found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => {
        new bootstrap.Tooltip(el);
    });
    getBillDetails();
    $(document).on("click", ".toggle-details", function() {
        const index = $(this).data("index");
        const shopCd = $(this).data("shop");
        const detailsRow = $("#bill-details-" + shopCd + "-" + index);
        const button = $(this);
        const buttonText = button.siblings(".button-text");
        const iconDown = button.find(".icon-down");
        const iconUp = button.find(".icon-up");

        detailsRow.toggleClass("d-none");

        if (detailsRow.hasClass("d-none")) {
            buttonText.text("View More");
            iconDown.show();
            iconUp.hide();
        } else {
            buttonText.text("View Less");
            iconDown.hide();
            iconUp.show();
        }
    });
});


function getBillDetails() {

    $("[id^=billing-content-]").each(function() {
        var paidAmt = 0;
        var unpaidAmt = 0;
        var totalAmt = 0;
        const billingContent = $(this);
        const shopCd = this.id.replace("billing-content-", "");
        billingContent.html('<div>Loading billing details...</div>');


        $.ajax({
            url: 'action/get-billing-details.php',
            method: 'POST',
            data: {
                Shop_Cd: shopCd
            },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    let hasSuccessPayment = data.some(item => item.PaymentStatus?.toLowerCase() ===
                        "success");
                    let tableHtml = `<table class="table table-bordered">
                                <thead style="background-color:#FFEBEB;text-align:center">
                                    <tr>
                                        <th> Sr. No. </th> 
                                        <th> Download </th>
                                        <th> Bill Number </th>
                                        <th> License Period </th>
                                        <th> Amount </th>
                                        <th> Status </th>`;
                    if (hasSuccessPayment) {
                        tableHtml += `<th>Transaction Number </th>
                                            <th> Payment Mode </th>
                                            <th>Transaction Date </th>`;
                    }

                    tableHtml += `<th class="text-center">Action</th> </tr>
                                </thead>
                                <tbody>`;
                    $.each(data, function(index, item) {
                        let statusText = '';
                        totalAmt += parseFloat(item.BillAmount) || 0;
                        const startDate = formatDate(item.LicenseStartDate);
                        const endDate = formatDate(item.LicenseEndDate);
                        const BillingDate = formatDate(item.BillingDate);
                        if (item.PaymentStatus.toLowerCase() === "success") {
                            statusText =
                                '<span class="badge bg-success">Paid</span>';
                        } else if (item.PaymentStatus.toLowerCase() === "failed") {
                            statusText =
                                '<span class="badge bg-danger">Failed</span>';
                        } else {
                            unpaidAmt = unpaidAmt + parseFloat(item.BillAmount);
                            statusText =
                                '<span class="badge bg-info">Pending</span>';
                        }

                        let actionBtn = '';
                        if (item.PaymentStatus.toLowerCase() === "success") {
                            actionBtn = '';
                        } else {
                            actionBtn =
                                `<button class="btn btn-sm btn-success" onclick="paymentGateway(${item.Billing_Cd}, ${item.BillAmount}, ${shopCd})">Pay Now</button>`;
                        }

                        tableHtml += `<tr class="bill-row text-center" data-index="${index}">
                                                    <td> ${index + 1} </td>
                                                    <td> 
                                                        <div style="display: flex; align-items: center;">
                                                            <a href="./action/licence_generate.php?billing_id=${item.Billing_Cd}"   data-tooltip="Download the License Invoice" style="margin-right: 12px;" target="_blank">
                                                               <span class ="badge bg-warning" style="font-size: 14px;"> License </span>
                                                            </a>`;
                        if (item.PaymentStatus.toLowerCase() === "success") {
                            tableHtml += ` <a href="./action/reciept.php?Transaction_Cd=${item.Transaction_Cd}" data-bs-toggle="tooltip" data-tooltip="Download the Payment Receipt" style="margin-right: 12px;" target="_blank">
                                                                <span class ="badge bg-info" style="font-size: 14px;"> Receipt </span>
                                                            </a>`;
                        }
                        tableHtml += `              </div>
                                                    </td>
                                                    <td>${item.BillNo}</td>
                                                    <td>${startDate} to ${endDate}</td>
                                                    <td style="color: #C90D41; font-weight:700" >₹ ${item.BillAmount}</td>
                                                    <td>${statusText}</td>
                                                    `;
                        if (hasSuccessPayment) {
                            var TransDateTime = formatDateWithTimeIST(item.TranDateTime);
                            paidAmt += parseFloat(item.BillAmount) || 0;
                            tableHtml += `<td>${item.TransNumber}</td> `;
                            tableHtml += `<td>${item.paymentMode}</td> `;
                            tableHtml += `<td>${TransDateTime}</td> `;
                        }

                        tableHtml += `<td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                                            <div class="d-flex align-items-center">
                                                                ${actionBtn}
                                                            </div>
                                                            <div class="toggle-details d-flex align-items-center gap-2" data-index="${index}" data-shop="${shopCd}">
                                                                <span class="button-text" style="color:red;">View More</span>
                                                                <button class="btn btntoggle p-0 m-0" style="background-color: transparent; border: none; cursor: pointer;">
                                                                    <i class="fa-solid fa-angle-down icon-down" style="color: #C90D41;"></i>
                                                                    <i class="fa-solid fa-angle-up icon-up" style="display: none; color: #C90D41;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>`;

                        tableHtml += `<tr class="details-row d-none" id="bill-details-${shopCd}-${index}">
                            <td colspan="10">
                                <div class="card shadow-sm mt-2">
                                    <div class="card-body p-2">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tbody>
                                                <tr><td><strong>Bill Number</strong></td><td>${item.BillNo}</td></tr>
                                                <tr><td><strong>License Period </strong></td><td> ${startDate} to ${endDate}</td></tr>
                                                <tr><td><strong>Bill Generation Date</strong></td><td>${BillingDate}</td></tr>
                                                <tr><td><strong>Bill Amount</strong></td><td>₹ ${item.BillAmount}</td></tr>
                                                <tr><td><strong>Net Amount</strong></td><td>₹ ${item.BillAmount}</td></tr>
                                                <tr><td><strong style="color:#C90D41;">Final Amount</strong></td><td style="color:#C90D41;">₹ ${item.BillAmount}</td></tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    billingContent.html(tableHtml);
                } else {
                    // billingContent.html('<div>No billing records found.</div>');
                    billingContent.html('');
                }

                var amtHtml = `<div class="d-flex justify-content-end gap-2 m-2">`;
                if (totalAmt) {
                    amtHtml +=
                        `<span class="badge bg-info text-center" style ="font-size: 14px;">Total Amount: ₹ ${totalAmt}</span>`;
                }

                if (paidAmt) {
                    amtHtml +=
                        ` <span class="badge bg-success text-center" style ="font-size: 14px;">Paid Amount: ₹ ${paidAmt}</span>`;
                }

                if (unpaidAmt) {
                    amtHtml +=
                        `<span class="badge bg-danger text-center" style ="font-size: 14px;">Unpaid Amount: ₹ ${unpaidAmt}</span>`;
                }



                amtHtml += ` </div>`;

                $(`#total-amt-${shopCd}`).html(amtHtml);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                billingContent.html('<div>Failed to load billing data.</div>');
            }
        });
    });
}

function applyforlicense(shopCd, renewDate) {
    var currentDate = new Date();
    var renewFlag = 0;
    var options = {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    };
    var StartDate = currentDate.toLocaleDateString('en-GB', options);

    var nextYearDate = new Date(currentDate);
    nextYearDate.setFullYear(nextYearDate.getFullYear() + 1);
    nextYearDate.setDate(nextYearDate.getDate() - 1);
    var EndDate = nextYearDate.toLocaleDateString('en-GB', options);

    if (renewDate) {
        renewFlag = 1;
        var dateObj = new Date(renewDate);
        StartDate = dateObj.toLocaleDateString('en-GB', options);
        var nextYearDate = new Date(StartDate);
        nextYearDate.setFullYear(nextYearDate.getFullYear() + 1);
        nextYearDate.setDate(nextYearDate.getDate() - 1);
        EndDate = nextYearDate.toLocaleDateString('en-GB', options);
    }

    Swal.fire({
        html: `Once the payment is completed, your license will be valid from <strong>${StartDate}</strong> to <strong>${EndDate}</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm'

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: 'action/License_bill_generation.php',
                data: {
                    shopCd: shopCd,
                    renewflag: renewFlag
                },
                success: function(response) {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status == 'success') {
                        paymentGateway(data.Billing_Id, data.Amount, data.ShopCd);

                    }
                },
                error: function() {
                    alert('Error occurred during License Bill Generation.');
                }
            });
        }
    });
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function formatDateWithTimeIST(dateStr) {
    const date = new Date(dateStr);
    const options = {
        timeZone: 'Asia/Kolkata',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    };

    return date.toLocaleString('en-IN', options).replace(',', '');
}


function paymentGateway(Billing_id, Amount, shopCd) {
    // alert(Billing_id+'--'+Amount+'--'+shopCd);
    $.ajax({
        type: "POST",
        url: 'action/generateTransaction.php',
        data: {
            billing_id: Billing_id,
            amount: Amount,
            shopCd: shopCd
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Payment processing',
                text: 'Opening payment window...',
                icon: 'info',
                showConfirmButton: false,
            });
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.statusCode === 200) {
                // window.location.href = data.data; 
                window.open(data.data);
                // window.open(data.data, '_blank');
            } else if (data.statusCode === 204) {
                Swal.fire({
                    title: 'Payment Already Made',
                    text: `${data.message}`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            } else if (data.statusCode === 500) {
                Swal.fire({
                    title: 'Opps, Something went wrong!',
                    text: `${data.message}`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function() {
            alert('Error occurred during License Bill Generation.');
        }
    });
}
</script>