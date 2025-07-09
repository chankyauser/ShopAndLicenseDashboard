<style>
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #666 !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
    padding: 0;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    color: #333 !important;
    border: 1px solid transparent;
    border-radius: 2px;
    padding: 0;
}

#billingModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}
</style>
<div class="container mt-10 mb-2">
    <div class="card">
        <div class="card-body">
            <!-- <form class="form-horizontal" novalidate> -->

            <div class="row align-items-end">
                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Zone</label>
                        <select class="form-control" name="nodeName" id="nodeName"
                            onchange="setNodeAndWardList(this.value)">
                            <option value="All">All Zone</option>
                            <?php 
                                foreach ($dataNodeName as $key => $valueNodeName) {
                                    $selected = ($nodeName == $valueNodeName["NodeName"]) ? "selected" : "";
                                    echo '<option ' . $selected . ' value="' . $valueNodeName["NodeName"] . '">' . $valueNodeName["NodeName"] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Ward</label>
                        <select class="form-control" name="nodeCd" id="setNodeAndWardDetailId"
                            onchange="setNodeAndWardId(this.value)">
                            <option value="All">All Ward</option>
                            <?php 
                                foreach ($dataNode as $key => $valueNode) {
                                    $selected = ($nodeCd == $valueNode["Node_Cd"]) ? "selected" : "";
                                    echo '<option ' . $selected . ' value="' . $valueNode["Node_Cd"] . '">' . $valueNode["Ward_No"] . ' - ' . $valueNode["Area"] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Owner Name</label>
                        <input type="text" class="form-control" name="OwnerName" id="OwnerName"
                            placeholder="Search Owner Name..." style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Owner Mobile No</label>
                        <input type="text" class="form-control" name="OwnerMobile" id="OwnerMobile"
                            placeholder="Search Owner Mobile No..." maxlength="10"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) "
                            style="border: 1px solid #F01954;">
                    </div>
                </div>

                <!-- Clear Button -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <button class="btn btn-sm btn-danger" id="clearFilter">Clear</button>
                    </div>
                </div>
            </div>

            <!-- </form> -->
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <h4 class="ps-2">Collection Report - <span id="GetTotalRecods"></span> </h4>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="shopTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">SR NO</th>
                                    <th class="text-left">Node Name</th>
                                    <th class="text-left">Ward Name</th>
                                    <th class="text-left">Shop Owner </th>
                                    <th class="text-left">Shop Details</th>
                                    <th class="text-right">Bill Count</th>
                                    <th class="text-right">Collection</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Billing Details Modal -->
<div class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2 m-2">
                <h5 class="modal-title" id="billingModalLabel">Billing Details</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="billingModalBody">
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    var shopTable = $('#shopTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: "./action/setOwnerCollectionReport.php",
            data: function(d) {
                d.documentStatus = $('#documentStatus').val();
                d.ward = $('#setNodeAndWardDetailId').val();
                d.nodeName = $('#nodeName').val();
                d.OwnerMobile = $('#OwnerMobile').val();
                d.OwnerName = $('#OwnerName').val();
            }
        },
        columns: [{
                data: null,
                render: function(data, type, row, meta) {
                    return `
                        ${meta.row + meta.settings._iDisplayStart + 1} 
                        `;
                },
                orderable: false,
                className: 'text-center'
            },
            {
                data: null,
                render: function(data) {
                    return `${data.NodeName}`;
                },
                orderable: false,
                className: 'text-left'
            },
            {
                data: null,
                render: function(data) {
                    return `${data.Area}`;
                },
                orderable: false,
                className: 'text-left'

            },
            {
                data: null,
                render: function(data) {
                    return `<strong>${data.ShopOwnerName}</strong><br><small>${data.ShopOwnerMobile}</small>`;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data) {
                    return `Shop Name: <strong>${data.ShopName}</strong><br>Shop No: <small>${data.Shop_UID}</small>`;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data) {
                    return `${data.BillCount}
                    &nbsp;&nbsp;
                    <i class="fas fa-eye text-primary view-bills-icon text-danger" data-bill='${data.BillDetailsArray || "[]"}' data-shopname='${data.ShopName || ''}'style="cursor: pointer;" title="View Bill Details"> </i>`;
                },
                orderable: false,
                className: 'text-right'
            },
            {
                data: null,
                render: function(data) {
                    var totalAmount = `₹ ${data.TotalAmount}`;
                    var renewalAmount = "";
                    if (data.RenewalAmount > 0) {
                        var originalamt = data.TotalAmount - data.RenewalAmount;
                        renewalAmount =
                            `<br><span class="text-danger"> Renewed : ₹ ${data.RenewalAmount}</span>`;
                    }
                    return `${totalAmount} ${renewalAmount}`;
                },
                orderable: false,
                className: 'text-right'
            }
        ],
        drawCallback: function(settings) {
            const totalRecords = settings.json ? settings.json.recordsTotal : 0;
            if (totalRecords == 1 || totalRecords == 0) {
                $('#GetTotalRecods').text(totalRecords + ' Shop');
            } else {
                $('#GetTotalRecods').text(totalRecords + ' Shops');
            }
        }
    });

    $('#shopTable tbody').on('click', '.view-bills-icon', function() {
        const billData = $(this).attr('data-bill');
        const shopName = $(this).attr('data-shopname');
        let billDetailsArray = [];

        try {
            billDetailsArray = JSON.parse(billData || '[]');
        } catch (e) {
            console.error("Invalid billing data", e);
        }

        const billingTable = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Bill No</th>
                        <th>Bill Date</th>
                        <th>Amount</th>
                        <th>License Period</th>
                    </tr>
                </thead>
                <tbody>
                    ${billDetailsArray.map((bill, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${bill.BillNo || ''}</td>
                            <td>${bill.BillingDate || ''}</td>
                            <td>₹${parseFloat(bill.Amount || 0).toFixed(2)}</td>
                            <td>${bill.LicenseStartDate || ''} to ${bill.LicenseEndDate || ''}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

        $('#billingModalBody').html(billingTable);
        $('#billingModalLabel').text(`Billing Details for ${shopName}`);

        const modal = new bootstrap.Modal(document.getElementById('billingModal'));
        modal.show();
    });


    $('#setNodeAndWardDetailId').on('change', function() {
        shopTable.ajax.reload();
    });

    $('#nodeName').on('change', function() {
        shopTable.ajax.reload();
    });

    $('#OwnerName').on('input', function() {
        setTimeout(() => {
            shopTable.ajax.reload();
        }, 500);
    });

    $('#OwnerMobile').on('input', function() {
        setTimeout(() => {
            shopTable.ajax.reload();
        }, 500)
    });
});

$('#clearFilter').click(function() {
    $('#nodeName').val('All');
    $('#setNodeAndWardDetailId').val('All');
    $('#OwnerName').val('');
    $('#OwnerMobile').val('');
    $('#shopTable').DataTable().ajax.reload();

});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>