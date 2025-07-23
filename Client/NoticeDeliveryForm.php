<?php  
include '../api/includes/DbOperation.php'; 
session_start(); 

$userName = $_SESSION['SAL_UserName'];
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

$shopCd = '';
$existNoticeData = [];
$isEdit = false;

// Check if it's an edit operation (Notice_Id provided)
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['Notice_Id']) && !empty($_POST['Notice_Id'])) {
        $Notice_Id = $_POST['Notice_Id'];
        $isEdit = true;

        $Noticequery = "SELECT 
            COALESCE(Notice_Id, 0) AS Notice_Id,
            COALESCE(Calling_Category_Cd, '') AS Calling_Category_Cd,
            COALESCE(Shop_Cd, '') AS Shop_Cd,
            ISNULL(CONVERT(VARCHAR, Notice_Date, 23), '') AS Notice_Date,
            COALESCE(Notice_Type, '') AS Notice_Type,
            COALESCE(Subject, '') AS Subject,
            COALESCE(Description, '') AS Description,
            COALESCE(NoticeFileURL, '') AS NoticeFileURL,
            COALESCE(Remark, '') AS Remark,
            COALESCE(Response_Received, '') AS Response_Received,
            COALESCE(Status, '') AS Status,
            COALESCE(IsActive, 0) AS IsActive,
            ISNULL(CONVERT(VARCHAR,Acknowledged_Date, 23), '') AS Acknowledged_Date,
            COALESCE(DeliveredBy, '') AS DeliveredBy
        FROM ShopNoticeDetails 
        WHERE Notice_Id = $Notice_Id";

        $db = new DbOperation();
        $existNoticeData = $db->ExecutveQueryMultipleRowSALData($Noticequery, $electionName, $developmentMode);
        
        if (!empty($existNoticeData)) {
            $shopCd = $existNoticeData[0]['Shop_Cd'];
        }
    } elseif (isset($_POST['Shop_Cd']) && !empty($_POST['Shop_Cd'])) {
        // New notice creation
        $shopCd = $_POST['Shop_Cd'];
    }
}

// Get dropdown data
$Categorysql = "SELECT Calling_Category_Cd,Calling_Category FROM CallingCategoryMaster";
$db = new DbOperation();
$callingCategoryDropdown = $db->ExecutveQueryMultipleRowSALData($Categorysql, $electionName, $developmentMode);

$Typesql = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'Notice_Type'";
$NoticeTypeDropdown = $db->ExecutveQueryMultipleRowSALData($Typesql, $electionName, $developmentMode);

$Subjectsql = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'Notice_Subject'";
$subjectOptions = $db->ExecutveQueryMultipleRowSALData($Subjectsql, $electionName, $developmentMode);

$Responsesql = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'Notice_Response'";
$responseOptions = $db->ExecutveQueryMultipleRowSALData($Responsesql, $electionName, $developmentMode);

$Statussql = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'Notice_Status'";
$statusOptions = $db->ExecutveQueryMultipleRowSALData($Statussql, $electionName, $developmentMode);

$Deliveredsql = "SELECT um.User_Id,um.ExecutiveName FROM LoginMaster lm
                INNER JOIN Survey_Entry_Data..User_Master um ON um.User_Id = lm.User_Cd AND um.AppName = 'ShopAndLicence' 
                WHERE lm.IsActive = 1";
$deliveredByOptions = $db->ExecutveQueryMultipleRowSALData($Deliveredsql, $electionName, $developmentMode);


$noticeData = !empty($existNoticeData) ? $existNoticeData[0] : [];
?>

<style>
    .form-group input, .form-group select {
        border: #F01954 1px solid;
    }

    .filename-container {
        display: inline-block;      
        max-width: 100%;            
        white-space: nowrap;         
        overflow: hidden;           
        text-overflow: ellipsis;    
        padding: 5px 10px;           
        border: 1px solid #ddd;      
        border-radius: 4px;          
        background-color: #f8f9fa;  
        margin-top: 5px;
    }
   @media (max-width: 576px) {
        #actionButtons .flex-grow-1 {
            flex: 0 0 70%;
        }
    }


</style>

<div class="container-fluid mt-5 mb-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Calling Category -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Calling_Category_Cd">Calling Category<span class="text-danger">*</span></label>
                        <select name="Calling_Category_Cd" id="Calling_Category_Cd" class="form-control">
                            <option value="">Select Calling Category</option>
                            <?php foreach ($callingCategoryDropdown as $category) { ?>
                                <option value="<?= $category['Calling_Category_Cd'] ?>" 
                                    <?= (isset($noticeData['Calling_Category_Cd']) && $noticeData['Calling_Category_Cd'] == $category['Calling_Category_Cd']) ? 'selected' : '' ?>>
                                    <?= $category['Calling_Category'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Notice Type -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Notice_Type">Notice Type<span class="text-danger">*</span></label>
                        <select name="Notice_Type" id="Notice_Type" class="form-control">
                            <option value="">Select Notice Type</option>
                            <?php foreach ($NoticeTypeDropdown as $type) { ?>
                                <option value="<?= $type['DValue'] ?>" 
                                    <?= (isset($noticeData['Notice_Type']) && $noticeData['Notice_Type'] == $type['DValue']) ? 'selected' : '' ?>>
                                    <?= $type['DValue'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Notice Date -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Notice_date">Notice Date<span class="text-danger">*</span></label>
                        <input type="date" name="Notice_date" id="Notice_date" class="form-control" 
                            value="<?= isset($noticeData['Notice_Date']) ? $noticeData['Notice_Date'] : '' ?>">
                        <small class="error-message text-danger"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Subject -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Subject">Subject<span class="text-danger">*</span></label>
                        <select name="Subject" id="Subject" class="form-control">
                            <option value="">Select Subject</option>
                            <?php foreach ($subjectOptions as $subject) { ?>
                                <option value="<?= $subject['DValue'] ?>" 
                                    <?= (isset($noticeData['Subject']) && $noticeData['Subject'] == $subject['DValue']) ? 'selected' : '' ?>>
                                    <?= $subject['DValue'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Description">Description<span class="text-danger">*</span></label>
                        <input type="text" name="Description" id="Description" class="form-control" 
                            value="<?= isset($noticeData['Description']) ? htmlspecialchars($noticeData['Description']) : '' ?>">
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Upload Notice (Camera and File Upload) -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Upload Notice</label><br>
                        <button type="button" class="btn btn-sm btn-primary" id="openCameraBtn">📷 Picture</button>
                        <button type="button" class="btn btn-sm btn-secondary" id="uploadFileBtn">📁 Upload File</button>
                        <input type="file" name="NoticeFileURL" accept="image/*,.pdf" class="form-control mt-2" id="NoticeFileURL" style="display: none;">
                        
                        <input type="file" accept="image/*" capture="environment" id="cameraInput" style="display: none;">
                        <img id="capturedPreviewImg" style="max-width: 100%; display: none; margin-top: 10px;">
                        <input type="hidden" id="capturedImageData" name="capturedImageData">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Remark -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Remark">Remark</label>
                        <input type="text" name="Remark" id="Remark" maxlength="255" class="form-control" 
                            value="<?= isset($noticeData['Remark']) ? htmlspecialchars($noticeData['Remark']) : '' ?>">
                    </div>
                </div>

                <!-- Response Received -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Response_Received">Response Received<span class="text-danger">*</span></label>
                        <select name="Response_Received" id="Response_Received" class="form-control">
                            <option value="">Select Response</option>
                            <?php foreach ($responseOptions as $response) { ?>
                                <option value="<?= $response['DValue'] ?>" 
                                    <?= (isset($noticeData['Response_Received']) && $noticeData['Response_Received'] == $response['DValue']) ? 'selected' : '' ?>>
                                    <?= $response['DValue'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Status">Status<span class="text-danger">*</span></label>
                        <select name="Status" id="Status" class="form-control">
                            <option value="">Select Status</option>
                            <?php foreach ($statusOptions as $status) { ?>
                                <option value="<?= $status['DValue'] ?>" 
                                    <?= (isset($noticeData['Status']) && $noticeData['Status'] == $status['DValue']) ? 'selected' : '' ?>>
                                    <?= $status['DValue'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Acknowledged Date -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="Acknowledged_Date">Acknowledged Date<span class="text-danger">*</span></label>
                        <input type="date" name="Acknowledged_Date" id="Acknowledged_Date" class="form-control" 
                            value="<?= isset($noticeData['Acknowledged_Date']) ? $noticeData['Acknowledged_Date'] : '' ?>">
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Delivered By -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="DeliveredBy">Delivered By<span class="text-danger">*</span></label>
                        <select name="DeliveredBy" id="DeliveredBy" class="form-control">
                            <option value="">Select Delivered By</option>
                            <?php foreach ($deliveredByOptions as $user) { ?>
                                <option value="<?= $user['User_Id'] ?>" 
                                    <?= (isset($noticeData['DeliveredBy']) && $noticeData['DeliveredBy'] == $user['User_Id']) ? 'selected' : '' ?>>
                                    <?= $user['ExecutiveName'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="error-message text-danger"></small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end mt-3">
                    <input type="hidden" name="Shop_Cd" value="<?= $shopCd ?>" />
                    <input type="hidden" name="Notice_Id" value="<?= isset($noticeData['Notice_Id']) ? $noticeData['Notice_Id'] : '' ?>" />
                    <input type="hidden" name="operation_type" value="<?= $isEdit ? 'update' : 'insert' ?>" />
                    <button type="button" id="SubmitBtn" class="btn btn-danger">
                        <?= $isEdit ? 'Update' : 'Submit' ?>
                    </button>
                </div>
            </div>

            <!-- Success/Failure Messages -->
            <div class="alert alert-success" role="alert" id="successMsg" style="display: none"></div>
            <div class="alert alert-danger" role="alert" id="failedMsg" style="display: none"></div>
        </div>
    </div>
</div>


<!-- <script>
$(document).ready(function () {
 
    let video = document.getElementById('videoPreview');
    let canvas = document.getElementById('canvas');
    let capturedImage = document.getElementById('capturedImageData');
    let captureBtn = document.getElementById('capturePhoto');
    let capturedPreview = document.getElementById('capturedPreviewImg');
    let fileInput = document.getElementById('NoticeFileURL');

   
    $('#startCamera').on('click', function () {
        fileInput.value = ''; 
        $('#NoticeFileURL').hide(); 

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.style.display = 'block';
                    $('#capturePhoto').show();
                })
                .catch(function (err) {
                    alert("Camera access denied: " + err);
                });
        } else {
            alert("Your browser does not support camera access or this page is not served over HTTPS.");
        }
    });

   
    $('#uploadFileBtn').on('click', function () {
     
        if (video.srcObject) {
            let tracks = video.srcObject.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }

      
        $('#startCamera').hide();
        $('#uploadFileBtn').hide();

      
        $('#NoticeFileURL').show();
        $('#cancelIcon').show();
      
        $('#videoPreview').hide();
        $('#capturePhoto').hide();
        $('#canvas').hide();
        $('#capturedPreviewImg').hide();
        $('#capturedImageData').val('');
    });

    $('#cancelIcon').on('click', function () {
       $('#startCamera').show();
        $('#uploadFileBtn').show();

      
        $('#NoticeFileURL').hide();
        $('#cancelIcon').hide();
    }); 
 
    $('#capturePhoto').on('click', function () {
        let context = canvas.getContext('2d');
        canvas.style.display = 'block';
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        let imageData = canvas.toDataURL('image/jpeg');
        $('#capturedImageData').val(imageData);

        $('#capturedPreviewImg').attr('src', imageData).show();
    });



    function clearErrors() {
        $('.error-message').text('');
    }

    function setError(fieldSelector, message) {
        $(fieldSelector).siblings('.error-message').text(message);
    }

    $('input, select').on('input change', function () {
        if ($(this).val().trim() !== '') {
            $(this).siblings('.error-message').text('');
        }
    });

    $('#SubmitBtn').on('click', function () {
        clearErrors();
        let isValid = true;

        let callingCategory = $('#Calling_Category_Cd').val().trim();
        let noticeType = $('#Notice_Type').val().trim();
        let noticeDate = $('#Notice_date').val().trim();
        let subject = $('#Subject').val().trim();
        let description = $('#Description').val().trim();
        let acknowledgedDate = $('#Acknowledged_Date').val().trim();
        let deliveredBy = $('#DeliveredBy').val().trim();
        let Response_Received = $('#Response_Received').val().trim();
        let status = $('#Status').val().trim();

        if (!callingCategory) {
            setError('#Calling_Category_Cd', 'Please select Calling Category.');
            isValid = false;
        }

        if (!noticeType) {
            setError('#Notice_Type', 'Please select Notice Type.');
            isValid = false;
        }

        if (!noticeDate) {
            setError('#Notice_date', 'Please enter Notice Date.');
            isValid = false;
        } else if (isNaN(Date.parse(noticeDate))) {
            setError('#Notice_date', 'Notice Date is invalid.');
            isValid = false;
        }

        if (!subject) {
            setError('#Subject', 'Please select Subject.');
            isValid = false;
        }

        if (!description) {
            setError('#Description', 'Please enter Description.');
            isValid = false;
        }

        if (acknowledgedDate) {
            if (isNaN(Date.parse(acknowledgedDate))) {
                setError('#Acknowledged_Date', 'Acknowledged Date is invalid.');
                isValid = false;
            } else if (new Date(acknowledgedDate) < new Date(noticeDate)) {
                setError('#Acknowledged_Date', 'Acknowledged Date cannot be before Notice Date.');
                isValid = false;
            }
        }else{
            setError('#Acknowledged_Date', 'Please enter Acknowledged Date.');
            isValid = false;
        }

        if (!deliveredBy) {
            setError('#DeliveredBy', 'Please select Delivered By.');
            isValid = false;
        }

        if (!status) {
            setError('#Status', 'Please select Status.');
            isValid = false;
        }

        if (!Response_Received) {
            setError('#Response_Received', 'Please select Response.');
            isValid = false;
        }

        // File validation
        let fileInput = $('#NoticeFileURL')[0];
        let file = fileInput.files[0];
        if (file) {
            let allowedTypes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
            let maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                setError('#NoticeFileURL', 'Invalid file type (PDF, PNG, JPG, JPEG only).');
                isValid = false;
            }
            if (file.size > maxSize) {
                setError('#NoticeFileURL', 'File size exceeds 5MB.');
                isValid = false;
            }
        }

        if (!isValid) return;

      
        var formData = new FormData();
        var operationType = $('[name="operation_type"]').val();
        var noticeId = $('[name="Notice_Id"]').val();

        formData.append("action", operationType === 'update' ? 'updateNotice' : 'insertNotice');
        formData.append("Calling_Category_Cd", callingCategory);
        formData.append("Notice_Type", noticeType);
        formData.append("Notice_date", noticeDate);
        formData.append("Subject", subject);
        formData.append("Description", description);
        formData.append("NoticeFileURL", file || '');
        formData.append("capturedImageData", $('#capturedImageData').val());
        formData.append("Remark", $('[name="Remark"]').val());
        formData.append("Response_Received", Response_Received);
        formData.append("Status", status);
        formData.append("Acknowledged_Date", acknowledgedDate);
        formData.append("DeliveredBy", deliveredBy);
        formData.append("Shop_Cd", $('[name="Shop_Cd"]').val());

        if (operationType === 'update' && noticeId) {
            formData.append("Notice_Id", noticeId);
        }

        $.ajax({
            url: 'action/ShopNoticeDeliveryOperation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.status === 'success') {
                    $('#successMsg')
                        .text(operationType === 'update' ? 'Notice updated successfully.' : 'Notice submitted successfully.')
                        .show();
                    $('#failedMsg').hide();

                   
                   $('#successMsg')
                        .text(operationType === 'update' ? 'Notice updated successfully.' : 'Notice submitted successfully.')
                        .fadeIn(300) 
                        .delay(1000) 
                        .fadeOut(300, function () {
                            $('#NoticeDeliveryStatusModal').modal('hide');

                            if (typeof refreshNoticeDetails === 'function') {
                                refreshNoticeDetails();
                            }
                        });
                } else {
                    $('#successMsg').hide();

                    $('#failedMsg')
                        .text("Failed to " + (operationType === 'update' ? 'update' : 'submit') + " notice.")
                        .fadeIn(300)
                        .delay(1000)
                        .fadeOut(300);
                }
            },
            error: function () {
                $('#failedMsg').text("AJAX error occurred.").show();
                $('#successMsg').hide();
                setTimeout(function () {
                    $('#failedMsg').fadeOut();
                }, 800);
            }
        });
    });
});

</script> -->

<script>
    function setError(fieldSelector, message) {
        $(fieldSelector).siblings('.error-message').text(message);
    }

    $('input, select').on('input change', function () {
        if ($(this).val().trim() !== '') {
            $(this).siblings('.error-message').text('');
        }
    });
    document.getElementById('openCameraBtn').addEventListener('click', function () {
    document.getElementById('cameraInput').click();
});

document.getElementById('cameraInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const base64Image = e.target.result;
            const preview = document.getElementById('capturedPreviewImg');
            preview.src = base64Image;
            preview.style.display = 'block';
            document.getElementById('capturedImageData').value = base64Image;
        };
        reader.readAsDataURL(file);
    }    
});

 function clearErrors() {
        $('.error-message').text('');
    }

 $('#SubmitBtn').on('click', function () {
        clearErrors();
        let isValid = true;

        let callingCategory = $('#Calling_Category_Cd').val().trim();
        let noticeType = $('#Notice_Type').val().trim();
        let noticeDate = $('#Notice_date').val().trim();
        let subject = $('#Subject').val().trim();
        let description = $('#Description').val().trim();
        let acknowledgedDate = $('#Acknowledged_Date').val().trim();
        let deliveredBy = $('#DeliveredBy').val().trim();
        let Response_Received = $('#Response_Received').val().trim();
        let status = $('#Status').val().trim();

        if (!callingCategory) {
            setError('#Calling_Category_Cd', 'Please select Calling Category.');
            isValid = false;
        }

        if (!noticeType) {
            setError('#Notice_Type', 'Please select Notice Type.');
            isValid = false;
        }

        if (!noticeDate) {
            setError('#Notice_date', 'Please enter Notice Date.');
            isValid = false;
        } else if (isNaN(Date.parse(noticeDate))) {
            setError('#Notice_date', 'Notice Date is invalid.');
            isValid = false;
        }

        if (!subject) {
            setError('#Subject', 'Please select Subject.');
            isValid = false;
        }

        if (!description) {
            setError('#Description', 'Please enter Description.');
            isValid = false;
        }

        if (acknowledgedDate) {
            if (isNaN(Date.parse(acknowledgedDate))) {
                setError('#Acknowledged_Date', 'Acknowledged Date is invalid.');
                isValid = false;
            } else if (new Date(acknowledgedDate) < new Date(noticeDate)) {
                setError('#Acknowledged_Date', 'Acknowledged Date cannot be before Notice Date.');
                isValid = false;
            }
        }else{
            setError('#Acknowledged_Date', 'Please enter Acknowledged Date.');
            isValid = false;
        }

        if (!deliveredBy) {
            setError('#DeliveredBy', 'Please select Delivered By.');
            isValid = false;
        }

        if (!status) {
            setError('#Status', 'Please select Status.');
            isValid = false;
        }

        if (!Response_Received) {
            setError('#Response_Received', 'Please select Response.');
            isValid = false;
        }

        // File validation
        let fileInput = $('#NoticeFileURL')[0];
        let file = fileInput.files[0];
        if (file) {
            let allowedTypes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
            let maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                setError('#NoticeFileURL', 'Invalid file type (PDF, PNG, JPG, JPEG only).');
                isValid = false;
            }
            if (file.size > maxSize) {
                setError('#NoticeFileURL', 'File size exceeds 5MB.');
                isValid = false;
            }
        }

        if (!isValid) return;

      
        var formData = new FormData();
        var operationType = $('[name="operation_type"]').val();
        var noticeId = $('[name="Notice_Id"]').val();

        formData.append("action", operationType === 'update' ? 'updateNotice' : 'insertNotice');
        formData.append("Calling_Category_Cd", callingCategory);
        formData.append("Notice_Type", noticeType);
        formData.append("Notice_date", noticeDate);
        formData.append("Subject", subject);
        formData.append("Description", description);
        formData.append("NoticeFileURL", file || '');
        formData.append("capturedImageData", $('#capturedImageData').val());
        formData.append("Remark", $('[name="Remark"]').val());
        formData.append("Response_Received", Response_Received);
        formData.append("Status", status);
        formData.append("Acknowledged_Date", acknowledgedDate);
        formData.append("DeliveredBy", deliveredBy);
        formData.append("Shop_Cd", $('[name="Shop_Cd"]').val());

        if (operationType === 'update' && noticeId) {
            formData.append("Notice_Id", noticeId);
        }

        $.ajax({
            url: 'action/ShopNoticeDeliveryOperation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.status === 'success') {
                    $('#successMsg')
                        .text(operationType === 'update' ? 'Notice updated successfully.' : 'Notice submitted successfully.')
                        .show();
                    $('#failedMsg').hide();

                    $('#NoticeDeliveryStatusModal').modal('hide');
                    if (typeof refreshNoticeDetails === 'function') {
                        refreshNoticeDetails();
                    }

                    setTimeout(function () {
                        $('#successMsg').fadeOut();
                    }, 5000);
                } else {
                    $('#failedMsg')
                        .text("Failed to " + (operationType === 'update' ? 'update' : 'submit') + " notice.")
                        .show();
                    $('#successMsg').hide();

                    setTimeout(function () {
                        $('#failedMsg').fadeOut();
                    }, 5000);
                }
            },
            error: function () {
                $('#failedMsg').text("AJAX error occurred.").show();
                $('#successMsg').hide();
                setTimeout(function () {
                    $('#failedMsg').fadeOut();
                }, 5000);
            }
        });
    });
</script>

