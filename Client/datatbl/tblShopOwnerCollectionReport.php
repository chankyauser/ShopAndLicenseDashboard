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

.badge-warning {
    background-color: #f39c12;
}

.badge-success {
    background-color: #27ae60;
}

.badge-danger {
    background-color: #e74c3c;
}

.view-bills-icon {
    color: #C90D41 !important;
    text-decoration: underline;
    font-weight: 700;
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
                                    echo '<option ' . $selected . ' value="' . $valueNode["Ward_No"] . '">' . $valueNode["Ward_No"] . ' - ' . $valueNode["Area"] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label> Owner Name / Mobile </label>
                        <input type="text" class="form-control" name="OwnerSearch" id="OwnerSearch"
                            placeholder="Search Owner Name & Owner Mobile ..." style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Shop No / Shop Name</label>
                        <input type="text" class="form-control" name="ShopSearch" id="ShopSearch"
                            placeholder="Search Shop No & Shop Name..." style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                    <div class="form-group mb-2">
                        <label>Status</label>
                        <select class="form-control" name="confirmationStatus" id="confirmationStatus"
                            onchange="setNodeAndWardId(this.value)">
                            <option value="Pending">Pending</option>
                            <option value="Confirm">Confirm</option>
                            <option value="Hold">Hold</option>
                        </select>
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
            <div class="row mb-4 align-items-center justify-content-between">
                <div class="col-md-auto">
                    <h4 class="ps-2 m-0">
                        Collection Report - <span id="GetTotalRecods"></span>
                    </h4>
                </div>

                <div class="col-md-auto status-filter d-flex align-items-end d-none">
                    <div class="form-group me-2">
                        <label for="Status" class="mb-1">Status</label>
                        <select class="form-control" id="Status"
                            style="height: 45px; min-width: 200px; font-size: 1rem;">
                            <option value="">Select Status</option>
                            <option value="Confirm">Confirm</option>
                            <option value="Hold">Hold</option>
                        </select>
                    </div>

                    <div class="form-group hold-reason d-none">
                        <label class="d-block invisible mb-1">Reason</label>
                        <input type="text" class="form-control" id="HoldReasonInput" name="HoldReasonInput"
                            placeholder="Enter Hold Reason" style="height: 45px;">
                    </div>
                    <div class="form-group">
                        <label class="d-block invisible mb-1">Update</label>
                        <button type="button" class="btn btn-primary btn-sm" id="UpdateStatus">Update</button>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="shopTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">SR NO</th>
                                    <th class="text-left">Node / Ward</th>
                                    <th class="text-left">Shop Owner </th>
                                    <th class="text-left">Shop Details</th>
                                    <th class="text-left">Lincense Details</th>
                                    <th class="text-left"> Status </th>
                                    <th class="text-end">Pending </th>
                                    <th class="text-end">Collection</th>
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
    <div class="modal-dialog modal-dialog-scrollable" style="width: auto; max-width: 75%; min-width: 120px;">
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
        autoWidth: false, 
        scrollX: true,
        ajax: {
            type: "POST",
            url: "./action/setOwnerCollectionReport.php",
            data: function(d) {
                d.documentStatus = $('#documentStatus').val();
                d.ward = $('#setNodeAndWardDetailId').val();
                d.nodeName = $('#nodeName').val();
                d.OwnerSearch = $('#OwnerSearch').val();
                d.ShopSearch = $('#ShopSearch').val();
                d.confirmationStatus = $('#confirmationStatus').val();
            }
        },
        columns: [{
                data: null,
                render: function(data, type, row, meta) {
                    const index = meta.row + meta.settings._iDisplayStart + 1;
                    const bills = JSON.parse(row.BillDetailsArray || '[]');
                    let status = '';
                    let transactionCd = '';

                    if (bills.length > 0) {
                        const latestBill = bills[bills.length - 1];
                        status = latestBill.ConfirmationStatus || '';
                        transactionCd = latestBill.Transaction_Cd || '';
                    }

                    if (status.toLowerCase() !== 'confirm') {
                        return `<span style="display: inline-flex; align-items: center;">
                                    ${index}
                                    <input type="checkbox" 
                                        class="select-pending" 
                                        data-transcd="${transactionCd}" 
                                        style="transform: scale(1.5); margin-left: 16px; vertical-align: middle;">
                                </span>`;
                    }

                    return `${index}`;
                },
                orderable: false,
                className: 'text-center'
            },
            {
                data: null,
                render: function(data) {
                    return `Node : <strong>${data.NodeName}</strong> <br> Ward : <strong>${data.Area}</strong>`;
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
                    const shopName = data.ShopName || '';
                    const shopUID = data.Shop_UID;
                    const Shop_Cd = data.Shop_Cd || '';

                    let output =
                        `Shop No : <strong>${Shop_Cd}</strong> <br> Shop Name: <strong>${shopName}</strong>`;

                    if (shopUID) {
                        output += `<br>Shop UID: <strong>${shopUID}</strong>`;
                    }

                    return output;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data) {
                    const bills = JSON.parse(data.BillDetailsArray || '[]');
                    const safeBillDataAttr = JSON.stringify(bills).replace(/"/g, '&quot;');

                    if (data.BillCount === 1 && bills.length === 1) {
                        const safeBillDataAttr = JSON.stringify(bills).replace(/"/g, '&quot;');
                        return `Transaction Number: <strong>${bills[0].TransNumber || ''}</strong><br>
                                Transaction Date: <strong>${bills[0].TranDateTime || ''}</strong><br>
                                License Period: <strong>${bills[0].LicenseStartDate || ''} to ${bills[0].LicenseEndDate || ''}</strong><br>
                                Amount: <strong>₹${parseFloat(bills[0].Amount || 0).toFixed(2)}</strong><br>
                                <a class="text-primary view-bills-icon" 
                                data-bill="${safeBillDataAttr}" 
                                data-shopname="${data.ShopName || ''}" 
                                style="cursor: pointer;" 
                                title="View Bill Details"> View More </a>`;


                    } else if (data.BillCount > 1 && bills.length > 1) {
                        const latestBill = bills[bills.length - 1];
                        const safeBillDataAttr = JSON.stringify(bills).replace(/"/g, '&quot;');
                        return `Transaction Number: <strong>${latestBill.TransNumber || ''}</strong><br>
                                Transaction Date: <strong>${latestBill.TranDateTime || ''}</strong><br>
                                License Period: <strong>${latestBill.LicenseStartDate || ''} to ${latestBill.LicenseEndDate || ''}</strong><br>
                                Amount: <strong>₹${parseFloat(latestBill.Amount || 0).toFixed(2)}</strong><br>
                                <a class="text-primary view-bills-icon" 
                                data-bill="${safeBillDataAttr}" 
                                data-shopname="${data.ShopName || ''}" 
                                style="cursor: pointer;" 
                                title="View Bill Details"> View More </a>`;
                    }

                    return '';
                },
                orderable: false,
                className: 'text-left'
            },
            {
                data: null,
                render: function(data) {
                    const bills = JSON.parse(data.BillDetailsArray || '[]');

                    let status = '';
                    let statusBy = '';
                    let statusDate = '';
                    let holdReason = '';

                    if (data.BillCount === 1 && bills.length === 1) {
                        const bill = bills[0];
                        status = bill.ConfirmationStatus || '';
                        statusBy = bill.ConfirmationUpdatedBy || '';
                        statusDate = bill.ConfirmationUpdatedDate || '';
                        if (status.toLowerCase() === 'hold') {
                            holdReason =
                                `<br>Hold Reason: <strong>${bill.HoldReason || 'Not Provided'}</strong>`;
                        }
                    } else if (data.BillCount > 1 && bills.length > 1) {
                        const latestBill = bills[bills.length - 1];
                        status = latestBill.ConfirmationStatus || '';
                        statusBy = latestBill.ConfirmationUpdatedBy || '';
                        statusDate = latestBill.ConfirmationUpdatedDate || '';
                        if (status.toLowerCase() === 'hold') {
                            holdReason =
                                `<br>Hold Reason: <strong>${latestBill.HoldReason || 'Not Provided'}</strong>`;
                        }
                    }

                    if (status != 'Pending' && status != '') {
                        let badgeClass = '';
                        let reasonText = '';
                        switch (status) {
                            case 'Hold':
                                badgeClass = 'badge-danger';
                                if (holdReason) {
                                    reasonText =
                                        `<br>Hold Reason: <strong>${holdReason}</strong>`;
                                }
                                break;
                            case 'Success':
                                badgeClass = 'badge-success';
                                break;
                            default:
                                badgeClass = 'badge-success';
                        }
                        return `<span class="badge badge-pil ${badgeClass}">${status}</span><br>
                                Status By: <strong>${statusBy}</strong><br>
                                Status Date: <strong>${statusDate}</strong>${reasonText}`;
                    }

                    return '<span class="badge badge-pil badge-warning">Pending</span>';
                },
                orderable: false,
                className: 'text-left'
            },
            {
                data: null,
                render: function(data) {
                    const bills = JSON.parse(data.BillDetailsArray || '[]');

                    let status = '';
                    let statusBy = '';
                    let statusDate = '';
                    let holdReason = '';
                    let totalPendingAmount = 0;

                    if (data.BillCount === 1 && bills.length === 1) {
                        const bill = bills[0];
                        status = bill.ConfirmationStatus || '';

                    } else if (data.BillCount > 1 && bills.length > 1) {
                        const latestBill = bills[bills.length - 1];
                        status = latestBill.ConfirmationStatus || '';
                    }

                    if (!status || status.toLowerCase() !== 'confirm') {
                        totalPendingAmount = bills.reduce((sum, bill) => {
                            return sum + parseFloat(bill.Amount || 0);
                        }, 0);

                        return `<span style="font-weight: 700">₹${totalPendingAmount.toFixed(2)} </span>`;
                    }

                    return `<span style="font-weight: 700"> ₹0.00 </span>`;
                },
                orderable: false,
                className: 'text-end'
            },
            {
                data: null,
                render: function(data) {
                    const bills = JSON.parse(data.BillDetailsArray || '[]');

                    let status = '';
                    let statusBy = '';
                    let statusDate = '';
                    let holdReason = '';
                    let totalPendingAmount = 0;

                    if (data.BillCount === 1 && bills.length === 1) {
                        const bill = bills[0];
                        status = bill.ConfirmationStatus || '';

                    } else if (data.BillCount > 1 && bills.length > 1) {
                        const latestBill = bills[bills.length - 1];
                        status = latestBill.ConfirmationStatus || '';
                    }

                    if (status.toLowerCase() === 'confirm') {
                        totalPendingAmount = bills.reduce((sum, bill) => {
                            return sum + parseFloat(bill.Amount || 0);
                        }, 0);

                        return `<span style="font-weight: 700"> ₹${totalPendingAmount.toFixed(2)} </span>`;
                    }

                    return `<span style="font-weight: 700"> ₹0.00 </span>`;
                },
                orderable: false,
                className: 'text-end'
            }
        ],
        drawCallback: function(settings) {
            const totalRecords = settings.json ? settings.json.recordsTotal : 0;
            if (totalRecords == 1 || totalRecords == 0) {
                $('#GetTotalRecods').text(totalRecords + ' Shop');
            } else {
                $('#GetTotalRecods').text(totalRecords + ' Shops');
            }
            $('.dataTables_processing').hide();
            
        }
    });
    
    shopTable.columns.adjust().draw();


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
           <table class="table table-bordered" style="width: 100%; table-layout: auto;">
    <thead>
        <tr>
            <th class="text-center" style="width : 8%">Sr.No</th> 
            <th class="text-left" style="width : 10%">Transaction No</th> 
            <th class="text-left" style="width : 12%">Transaction Date</th> 
            <th class="text-center" style="width : 10%">Payment Mode</th> 
            <th class="text-end" style="width : 10%">Amount</th> 
            <th class="text-left" style="width : 18%">License Period</th> 
            <th class="text-left" style="width : 25%">Status</th> 
        </tr>
    </thead>
    <tbody>
        ${billDetailsArray.map((bill, index) => {
            const isPending = !bill.ConfirmationStatus || bill.ConfirmationStatus === 'Pending';
            return `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-left">${bill.TransNumber || ''}</td>
                    <td class="text-left">${bill.TranDateTime || ''}</td>
                    <td class="text-center">${bill.paymentMode || ''}</td>
                    <td class="text-end"><span style="font-weight: 700"> ₹${parseFloat(bill.Amount || 0).toFixed(2)} </span></td>
                    <td class="text-left">${bill.LicenseStartDate || ''} to ${bill.LicenseEndDate || ''}</td>
                    <td class="text-left">
                        <span class="badge 
                            ${bill.ConfirmationStatus === 'Hold' ? 'badge-danger' : 
                            bill.ConfirmationStatus === 'Confirm' ? 'badge-success' : 
                            'badge-warning'}">
                            ${bill.ConfirmationStatus  || 'Pending'}
                        </span>
                        ${!isPending && bill.ConfirmationUpdatedBy && bill.ConfirmationUpdatedBy != '' && bill.ConfirmationUpdatedBy != null ? `<br> Status By: ${bill.ConfirmationUpdatedBy}` : ''}
                        ${!isPending && bill.ConfirmationUpdatedDate  && bill.ConfirmationUpdatedDate != '' && bill.ConfirmationUpdatedDate != null ? `<br> Status Date: ${bill.ConfirmationUpdatedDate}` : ''}
                    </td>
                </tr>
            `;
        }).join('')}
    </tbody>
</table>
        `;

        $('#billingModalBody').html(billingTable);
        $('#billingModalLabel').text(`License Details for ${shopName}`);

        const modal = new bootstrap.Modal(document.getElementById('billingModal'));
        modal.show();
    });


    $('#setNodeAndWardDetailId').on('change', function() {
        shopTable.ajax.reload();
    });

    $('#nodeName').on('change', function() {
        shopTable.ajax.reload();
    });

    $('#OwnerSearch').on('input', function() {
        setTimeout(() => {
            shopTable.ajax.reload();
        }, 500);
    });

    $('#confirmationStatus').on('change', function() {
        shopTable.ajax.reload();
    });

    $('#ShopSearch').on('input', function() {
        setTimeout(() => {
            shopTable.ajax.reload();
        }, 500)
    });

    $(document).on('change', '.select-pending', function() {
        const anyChecked = $('.select-pending:checked').length > 0;

        if (anyChecked) {
            $('.status-filter').removeClass('d-none');
        } else {
            $('.status-filter').addClass('d-none');
        }
    });

    $('#UpdateStatus').on('click', function() {
        const selectedTranscds = [];
        $('.select-pending:checked').each(function() {
            const transCd = $(this).data('transcd');
            console.log('Selected transaction ID:', transCd);
            if (transCd && !isNaN(transCd)) {
                selectedTranscds.push(Number(transCd));
            }
        });

        if (selectedTranscds.length === 0) {
            alert('Please select at least one record.');
            return;
        }

        const selectedStatus = $('#Status').val();

        if (!selectedStatus) {
            alert('Please select a status.');
            return;
        }

        let holdReason = '';

        if (selectedStatus === 'Hold') {
            holdReason = $('#HoldReasonInput').val().trim();
            if (!holdReason) {
                alert('Please provide a reason for holding the status.');
                return;
            }
        }

        $.ajax({
            url: './action/updateConfirmation.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                transactionIds: selectedTranscds,
                status: selectedStatus,
                holdReason: holdReason || ''
            }),
            success: function(response) {
                var data = response;
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: true,
                    }).then(() => {
                        $('#shopTable').DataTable().ajax.reload(null, false);
                        $('#Status').val('');
                        $('#HoldReasonInput').val('');
                        $('.status-filter').addClass('d-none');
                        $('.hold-reason').addClass('d-none');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        showConfirmButton: true,
                    }).then(() => {
                        $('#shopTable').DataTable().ajax.reload(null, false);
                        $('#Status').val('');
                        $('#HoldReasonInput').val('');
                        $('.status-filter').addClass('d-none');
                        $('.hold-reason').addClass('d-none');
                    });
                }
                // alert('Status updated successfully.');
                // $('#shopTable').DataTable().ajax.reload(null, false);
                // $('#Status').val('');
                // $('#HoldReasonInput').val('')
                // $('.status-filter').addClass('d-none');
                // $('.hold-reason').addClass('d-none');
            },
            error: function() {
                alert('Error updating status.');
            }
        });
    });

    $('#Status').on('change', function() {
        const selectedStatus = $(this).val();
        if (selectedStatus === 'Hold') {
            $('.hold-reason').removeClass('d-none');
        } else {
            $('.hold-reason').addClass('d-none');
        }
    });
});

$('#clearFilter').click(function() {
    $('#nodeName').val('All');
    $('#setNodeAndWardDetailId').val('All');
    $('#OwnerSearch').val('');
    $('#ShopSearch').val('');
    $('#confirmationStatus').val('Pending');
    $('#shopTable').DataTable().ajax.reload();

});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>