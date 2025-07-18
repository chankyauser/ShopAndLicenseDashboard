<?php   
$db = new DbOperation();

$userName = $_SESSION['SAL_UserName'];
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

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
LEFT JOIN ShopMaster AS sm ON sm.Shop_Cd=sd.Shop_Cd";

$NoticeData = $db->ExecutveQueryMultipleRowSALData($Noticequery, $electionName, $developmentMode);
?>

<style>
.notice-container {
    margin-bottom: 30px;
    border: 1px solid #ccc;
    /* border-radius: 10px; */
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
.notice-image{
   padding:10px;
}
.notice-details {
    padding: 10px 0px 10px 40px;
}
.delivery-details{
    padding: 10px 0px 10px 40px;
}
.notice-details p{
    margin-top:10px
}
.delivery-details p{
     margin-top:10px
}
.notice-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: -10px
}

.notice-table th, .notice-table td {
    width: 50%; 
    padding: 10px;
    vertical-align: top;
    border-bottom: 1px solid #eee;
    word-wrap: break-word; 
}

.notice-subheading {
    background-color: #f9f9f9;
    text-align:center;
    font-size:15px;
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
/* Modal default hidden */
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
  background-color: transperent;
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

</style>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <h4 class="ps-2">Notice Distribution Details</h4>
            </div>

            <?php foreach ($NoticeData as $notice): ?>
                <div class="notice-container">
                    <div class="notice-header" style="font-style:Font Awesome 6 Brands;">Shop Name  :  <?php echo $notice['ShopName']; ?></div>

                    <table class="notice-table">
                        <tr class="notice-subheading">
                            <th >Notice Details</th>
                            <th >Delivery Details</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <div class="notice-image">
                                        <?php if (!empty($notice['NoticeFileURL'])): ?>
                                            <img src="<?php echo htmlspecialchars($notice['NoticeFileURL']); ?>" alt="Notice Image"  class="clickable-image" style="width:350px;height:200px">
                                        <?php else: ?>
                                            <img src="./assets/imgs/shopImage.png" alt="Default Image"
                                                        class="img-fluid custom-product-image">
                                        <?php endif; ?>
                                    </div>
                                   
                                    <div class="notice-details">
                                        <p style="color: black;"><strong>Date:</strong> <?php echo date('d-m-Y', strtotime($notice['Notice_Date'])); ?></p>
                                        <p style="color: black;"><strong>Subject:</strong> <?php echo $notice['Subject']; ?></p>
                                        <p style="color: black;"><strong>Description:</strong> <?php echo $notice['Description']; ?></p>
                                        <p style="color: black;"><strong>Response Received:</strong> <?php echo $notice['Response_Received']; ?></p>
                                </div>
                                
                            </td>
                            <td>
                                <div class="delivery-details">
                                    <p style="color: black;"><strong>Type:</strong> <?php echo $notice['Notice_Type']; ?></p>
                                    <p style="color: black;"><strong>Status:</strong> <?php echo $notice['Status']; ?></p>
                                    <p style="color: black;"><strong>Remark:</strong> <?php echo $notice['Remark']; ?></p>
                                    <p style="color: black;"><strong>Acknowledged Date:</strong> <?php echo date('d-m-Y', strtotime($notice['Acknowledged_Date'])); ?></p>
                                    <p style="color: black;"><strong>Delivered By:</strong> <?php echo $notice['DeliveredBy']; ?></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>

        </div>
         <div id="imageModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modalImg">
         </div>
    </div>
</div>
<script>
  // Modal elements
  var modal = document.getElementById("imageModal");
  var modalImg = document.getElementById("modalImg");
  var closeBtn = document.querySelector(".close");

  // Get all images with the class
  var images = document.querySelectorAll(".clickable-image");

  images.forEach(function(img) {
    img.addEventListener("click", function() {
      modal.style.display = "block";
      modalImg.src = this.src;
    });
  });

  closeBtn.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
</script>
