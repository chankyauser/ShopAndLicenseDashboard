<?php  
include '../api/includes/DbOperation.php';
session_start();  
$db = new DbOperation();

$userName = $_SESSION['SAL_UserName'];
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['shopCd']) && !empty($_POST['shopCd'])) {

        $shopCd = $_POST['shopCd'];
        $Noticequery = "SELECT 
                            COALESCE(sd.Notice_Id, 0) AS Notice_Id,
                            COALESCE(sd.Calling_Category_Cd, '') AS Calling_Category_Cd,
                            COALESCE(sd.Shop_Cd, '') AS Shop_Cd,
                            ISNULL(CONVERT(VARCHAR, sd.Notice_Date, 23), '') AS Notice_Date,
                            COALESCE(sd.Notice_Type, '') AS Notice_Type,
                            COALESCE(sd.Subject, '') AS Subject,
                            COALESCE(sd.Description, '') AS Description,
                            COALESCE(sd.NoticeFileURL, '') AS NoticeFileURL,
                            COALESCE(sd.Remark, '') AS Remark,
                            COALESCE(sd.Response_Received, '') AS Response_Received,
                            COALESCE(sd.Status, '') AS Status,
                            COALESCE(sd.IsActive, 0) AS IsActive,
                            COALESCE(sm.ShopName, '') AS ShopName,
                            ISNULL(CONVERT(VARCHAR, sd.Acknowledged_Date, 23), '') AS Acknowledged_Date,
                            COALESCE(sd.DeliveredBy, '') AS DeliveredBy
                        FROM ShopNoticeDetails sd
                        LEFT JOIN ShopMaster AS sm ON sm.Shop_Cd=sd.Shop_Cd
                        WHERE sd.Shop_Cd = $shopCd AND sd.IsActive = 1
                        ORDER BY sd.Notice_Date DESC";

        $NoticeData = $db->ExecutveQueryMultipleRowSALData($Noticequery, $electionName, $developmentMode);
        // print_r($NoticeData);

?>


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
           <div class="col-12">
             <?php if (!empty($NoticeData)) { ?>
                <?php foreach ($NoticeData as $notice): ?>
                    <div class="notice-container">
                        <table class="notice-table">
                            <tr class="notice-subheading">
                                <th>Notice Details</th>
                                <th>Delivery Details</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="notice-image">
                                          <?php 
                                              $fileUrl = $notice['NoticeFileURL']; 
                                              $fileExt = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION)); 
                                          ?>
                                            <?php if (!empty($fileUrl)) { ?>
                                              <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) { ?>
                                                  <img src="<?php echo htmlspecialchars($fileUrl); ?>" 
                                                      alt="Notice Image" class="clickable-image" style="width:200px;height:200px"
                                                      onclick="openModal('<?php echo htmlspecialchars($fileUrl); ?>', 'image')">
                                              
                                              <?php } elseif ($fileExt === 'pdf') { ?>
                                               <i class="fas fa-file-pdf clickable-image"
                                                  style="font-size: 100px; color: red; width: 150px; height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                                  onclick="window.open('<?php echo htmlspecialchars($fileUrl); ?>', '_blank')"></i>
                                              <?php } else { ?>
                                                  <img src="./assets/imgs/noticeImg.png" alt="Default Image" class="img-fluid custom-product-image" style="width:150px;height:200px">
                                              <?php } ?>

                                          <?php } else { ?>
                                              <img src="./assets/imgs/noticeImg.png" alt="Default Image" class="img-fluid custom-product-image" style="width:150px;height:200px">
                                          <?php } ?>
                                        </div>
                                       
                                        <div class="notice-details">
                                            <p style="color: black;"><strong>Date:</strong> <?php echo !empty($notice['Notice_Date']) ? date('d-m-Y', strtotime($notice['Notice_Date'])) : 'N/A'; ?></p>
                                            <p style="color: black;"><strong>Subject:</strong> <?php echo htmlspecialchars($notice['Subject']); ?></p>
                                            <p style="color: black;"><strong>Description:</strong> <?php echo htmlspecialchars($notice['Description']); ?></p>
                                            <p style="color: black;"><strong>Response Received:</strong> <?php echo htmlspecialchars($notice['Response_Received']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="delivery-details">
                                        <p style="color: black;"><strong>Type:</strong> <?php echo htmlspecialchars($notice['Notice_Type']); ?></p>
                                        <p style="color: black;"><strong>Status:</strong> <?php echo htmlspecialchars($notice['Status']); ?></p>
                                        <p style="color: black;"><strong>Remark:</strong> <?php echo htmlspecialchars($notice['Remark']); ?></p>
                                        <p style="color: black;"><strong>Acknowledged Date:</strong> <?php echo !empty($notice['Acknowledged_Date']) ? date('d-m-Y', strtotime($notice['Acknowledged_Date'])) : 'N/A'; ?></p>
                                        <p style="color: black;"><strong>Delivered By:</strong> <?php echo htmlspecialchars($notice['DeliveredBy']); ?></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-end mt-3 mb-3">
                          <button class="btn btn-primary btn-sm" onclick="editNotice('<?php echo $notice['Notice_Id']; ?>')" style="margin-right: 10px;">Edit</button>
                      </div>
                    </div>
                <?php endforeach; ?>
                <div id="fileModal" class="modal">
                  <span class="close" onclick="closeModal()">&times;</span>
                  <div id="fileContent" class="modal-content-container" style="text-align:center">
                     
                  </div>
              </div>
            <?php } else { ?>
                <div class="alert alert-info">
                    <h5>No Notice Found</h5>
                    <p>No notices have been recorded for this shop yet.</p>
                </div>
            <?php } ?>
           </div>
        </div>
    </div>
</div>




<?php
    } else {
        echo '<div class="alert alert-warning">No shop code provided.</div>';
    }
}
?>
<script>
$(document).ready(function() {
    $('#NoticeDetailModal').data('shop-cd', '<?php echo $shopCd; ?>');
});

function openModal(fileUrl, type) {
    const modal = document.getElementById("fileModal");
    const contentDiv = document.getElementById("fileContent");

    contentDiv.innerHTML = ''; // Clear previous content

    if (type === 'image') {
        const img = document.createElement('img');
        img.src = fileUrl;
        img.className = 'modal-content';
        img.alt = "Notice Image";
        contentDiv.appendChild(img);
    } else if (type === 'pdf') {
        const iframe = document.createElement('iframe');
        iframe.src = fileUrl;
        iframe.style.width = '100%';
        iframe.style.height = '80vh';
        iframe.frameBorder = 0;
        contentDiv.appendChild(iframe);
    }

    modal.style.display = "block";
}

function closeModal() {
    const modal = document.getElementById("fileModal");
    modal.style.display = "none";
}
</script>

<style>
.notice-container {
    margin-bottom: 30px;
    border: 1px solid #ccc;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.notice-header {
    background-color: #f1f1f1;
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    border-bottom: 1px solid #ddd;
}

.notice-image {
   padding: 10px;
}

.notice-details {
    padding: 5px 0px 10px 10px;
   
}

.delivery-details {
    padding: 0px 0px 10px 5px;
    margin-top: -4rem;
}

.notice-details p {
    margin-top: 10px;
}

.delivery-details p {
    margin-top: 10px;
}

.notice-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 10px;
}

/* .notice-table th, .notice-table td {
    width: 50%; 
    padding: 10px;
    vertical-align: top;
    border-bottom: 1px solid #eee;
    word-wrap: break-word; 
} */

.notice-subheading {
    background-color: #f9f9f9;
    text-align: center;
    font-size: 15px;
    font-weight: bold;
    padding: 10px;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    color: #555;
}

@media screen and (max-width: 768px) {
    .notice-table td {
        display: block;
        width: 100%;
    }
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 50%;
    max-height: 80%;
}

.close {
    position: absolute;
    top: 30px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.clickable-image {
    cursor: pointer;
    transition: transform 0.2s ease;
}

.clickable-image:hover {
    transform: scale(1.05);
}

/* Fix modal z-index issues */
#NoticeDeliveryStatusModal {
    z-index: 1060 !important;
}

#NoticeDeliveryStatusModal .modal-backdrop {
    z-index: 1055 !important;
}

.notice-table {
    width: 100%;
    table-layout: fixed; 
}

.notice-container {
    width: 100%;
}

/* .notice-details, .delivery-details {
    padding-left: 20px;
    width: 100%;
} */

.notice-image {
    min-width: 150px;
    margin-right: 10px;
}
/* .notice-table th:nth-child(1), 
.notice-table td:nth-child(1) {
    width: 65%;
}

.notice-table th:nth-child(2), 
.notice-table td:nth-child(2) {
    width: 35%;
} */
</style>


