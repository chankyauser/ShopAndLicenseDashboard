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
</style>
<div class="container mt-10 mb-2">
    <div class="card">
        <div class="card-body">
            <!-- <form class="form-horizontal" novalidate> -->

            <div class="row" style="margin-top:-10px">


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
                    <h4 class="ps-2">Pending Report - <span id="GetTotalRecods"></span></h4>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="shopTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SR NO</th>
                                        <th>Shop Owner</th>
                                        <th>Shop Details</th>
                                        <th>Billing Details</th>
                                        <th>Licence Details</th>
                                        <th>Pending</th>
                                    </tr>
                                </thead>
                                <tbody></tbody> <!-- Needed for data -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // $('#showPageDetails').addClass('d-none');
        var shopTable = $('#shopTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: "POST",
                url: "action/setOwnerPendingReport.php",
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
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                {
                    data: null,
                    render: function(data) {
                        let name = data.ShopOwnerName !== '' ? data.ShopOwnerName : data
                            .ShopKeeperName;
                        let mobile = data.ShopOwnerMobile !== '' ? data.ShopOwnerMobile : data
                            .ShopKeeperMobile;

                        return `<strong>${name}</strong><br><small>${mobile}</small>`;
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
                        var BillDate = "";
                        if (data.BillingDate != "") {
                            BillDate = `Date: <small>${data.BillingDate}</small>`;
                        }
                        var BillNo = "";
                        if (data.BillNo != "") {
                            BillNo = `Bill No: <strong>${data.BillNo}</strong><br>`;
                        }
                        return `${BillDate} ${BillNo}`;
                    },
                    orderable: false
                },
                {
                    data: null,
                    render: function(data) {
                        var condtition = "";
                        if (data.LicenseStartDate != "") {
                            condtition =
                                `Expired : <strong>${data.LicenseStartDate}</strong> to <strong>${data.LicenseEndDate}</strong>`;
                        }
                        return `${condtition}`;
                    },
                    orderable: false
                },
                {
                    data: null,
                    render: function(data) {
                        return `<strong>${data.Amount}</strong>`;
                    },
                    orderable: false
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