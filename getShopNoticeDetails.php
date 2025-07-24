
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
    text-align:center
}
.notice-image{
   padding:10px;
}
.notice-details {
    padding: 5px;
}
.delivery-details{
     padding : 0px 0px 0px 20px;
}
.table td {
    padding-left:0;
}
/* Apply custom widths */
.notice-table th:nth-child(1),
.notice-table td:nth-child(1) {
    width: 60%;
}

.notice-table th:nth-child(2),
.notice-table td:nth-child(2) {
    width: 40%;
}

.notice-table th {
    text-align: center;
    vertical-align: middle;
}
.notice-details p{
    margin-top:10px
}
.delivery-details p{
    margin-top:10px
   
}
.notice-table{
     margin-bottom: -20px
}
.notice-image img {
        transition: transform 0.3s ease;
        cursor: pointer;
 }

.notice-image img:hover {
        transform: scale(1.1); 
}
</style>
<?php  
include 'api/includes/DbOperation.php'; 
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
        LEFT JOIN ShopMaster AS sm ON sm.Shop_Cd = sd.Shop_Cd
        WHERE sd.Shop_Cd = $shopCd";

        $NoticeData = $db->ExecutveQueryMultipleRowSALData($Noticequery, $electionName, $developmentMode);
    if (!empty($NoticeData)) {
        foreach ($NoticeData as $notice): ?>
            <div class="notice-container mb-4">
                <table class="table table-bordered notice-table">
                    <thead class="table-light">
                        <tr>
                            <th>Notice Details</th>
                            <th>Delivery Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="vertical-align: top;">
                                <div class="d-flex">
                                    <div class="notice-image">
                                            <?php if (!empty($notice['NoticeFileURL'])){ ?>
                                                <img src="<?php echo htmlspecialchars($notice['NoticeFileURL']); ?>" alt="Notice Image" class="img-fluid mb-2" style="max-width: 150px; height: 200px;">
                                            <?php }else{ ?>
                                            <img src="./assets/imgs/shopImage.png" alt="Default Image"
                                                        class="img-fluid custom-product-image">
                                            <?php } ?>
                                    </div>
                                <div class="notice-details">
                                        <p><strong>Date:</strong> <?php echo $notice['Notice_Date']; ?></p>
                                        <p><strong>Subject:</strong> <?php echo $notice['Subject']; ?></p>
                                        <p><strong>Description:</strong> <?php echo $notice['Description']; ?></p>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                 <div class="delivery-details">
                                    <p><strong>Type:</strong> <?php echo $notice['Notice_Type']; ?></p>
                                    <p><strong>Status:</strong> <?php echo $notice['Status']; ?></p>
                                    <p><strong>Remark:</strong> <?php echo $notice['Remark']; ?></p>
                                    <p><strong>Acknowledged Date:</strong> <?php echo $notice['Acknowledged_Date']; ?></p>
                                    <p><strong>Delivered By:</strong> <?php echo $notice['DeliveredBy']; ?></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endforeach;
    } else { ?>
        <div class="notice-container mb-4">
            <div class="notice-header">No Notice Details Found</div>
        </div>
        <?php 
    }
}
}
?>
