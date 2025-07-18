<?php 
 if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['QRKey'])) {
    include "../api/includes/DbOperation.php";

    session_start();

    $appName=$_SESSION['SAL_AppName'] ?? 'ShopAndLicence';
    $electionName=$_SESSION['SAL_ElectionName'] ?? 'CSMC';
    $developmentMode=$_SESSION['SAL_DevelopmentMode'] ?? 'Live';
    
    $QRKey = $_GET['QRKey'];
    //UAT -----------------
    $key = base64_decode('JoYPd+qso9s7T+Ebj8pi4Wl8i+AHLv+5UNJxA3JkDgY=');
    $iv = base64_decode('hlnuyA9b4YxDq6oJSZFl8g==');

    // LIVE -----------------
    // $key = base64_decode('tPjvm0W0iIO4lpX/Ry9VQcGGcx0gAB1D1salkTrtpP4=');
    // $iv = base64_decode('FRaquqRsN0nrEStG0ukNOA==');

    $QRKey_raw = hex2bin($QRKey);  
    $options = OPENSSL_RAW_DATA;    
    $decrypted_data = openssl_decrypt($QRKey_raw, "AES-256-CBC", $key, $options, $iv);

    $data = json_decode($decrypted_data, true); 

    $billingId = $data['billingId'];
    $licenseStartDate = $data['licenseStartDate']['date'];
    $licenseEndDate = $data['licenseEndDate']['date'];
    $licenseNumber = $data['licenseNumber'];
    $transNumber = $data['transNumber'];

    $startDateTime = new DateTime($licenseStartDate);
    $endDateTime = new DateTime($licenseEndDate);

    $StartDate = $startDateTime->format('d-m-Y');
    $EndDate = $endDateTime->format('d-m-Y');

    $currentDate = new DateTime();

    if ($currentDate >= $startDateTime && $currentDate <= $endDateTime) {
        $status = "Active";
        $remainingDays = $currentDate->diff($endDateTime)->days;
    } else {
        $status = "Expired";
        $remainingDays = 0;
    }

    //  $status = "Expired";

    $Query = "SELECT ISNULL(CONCAT(sm.ShopAddress_1, 
                        CASE 
                            WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                THEN CONCAT(', ', ShopAddress_2)
                     ELSE ''END), '') AS ShopAddress,
                    ISNULL(sm.ShopName, '') AS ShopName,
                    ISNULL(nm.NodeName, '') AS Node,
                    ISNULL(nm.Area, '') AS ward,
                    ISNULL(sm.Shop_Cd, '') AS Shop_Cd

              FROM ShopBilling sb 
              INNER JOIN ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd AND sm.IsActive = 1
              INNER JOIN NodeMaster nm ON nm.Ward_No = sm.Ward_No AND nm.IsActive = 1
              WHERE sb.Billing_Cd = $billingId";
    $DB = new DBOperation();
    $result = $DB->ExecutveQuerySingleRowSALData($Query, $electionName, $developmentMode);
    $Shop_Cd = $result['Shop_Cd'];
    $ShopName = $result['ShopName'];
    $ShopAddress = $result['ShopAddress'];
    $Node = $result['Node'];
    $Ward = $result['ward'];
 } else {
     http_response_code(400);
     echo "Invalid request.";

 }
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body {
    margin: 0;
    height: 100vh;
    background-color: #f0f2f5;
}

.card-custom {
    max-width: 600px;
    width: 100%;
    background-image: url('../assets/imgs/license_bg.jpeg');
    background-repeat: no-repeat;
    background-size: 100% 100%;
    background-position: center;
    padding: 30px 30px 80px 30px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    color: #000;
    position: relative;
    min-height: 600px;
    background-color: transparent !important;
}

.card-custom table {
    background-color: transparent !important;
}

.card-custom td {
    background-color: rgba(255, 255, 255, 0.6) !important;
}

.name {
    font-size: 1.2rem;
    font-weight: bold;
}

.description {
    font-weight: bold;
    padding-top: 3rem;
    font-size: 1rem;
    color: #F01954 !important;
}

.social {
    font-size: 1rem;
    margin-top: 20px;
}

.text-primary {
    font-weight: bold;
    color: #F01954 !important;
}

.text-danger{
    font-weight: bold;
}

.text-success{
    font-weight: bold;
}

</style>

<div class="d-flex justify-content-center pt-4 px-2">
    <div class="card-custom text-center">
        <!-- <img src="../assets/imgs/CSMC_Logo.jpeg" alt="logo" style="height: 80px;" />
      <h3 class="name mt-3">
        छत्रपती संभाजीनगर महानगरपालिका <br />
        Chhatrapati Sambhajinagar Municipal Corporation
      </h3> -->
        <p class="description mt-3">आस्थापनांना व्यवसाय करणेकरिता परवाना</p>

        <div class="m-4 text-start">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>परवाना क्र.</td>
                        <td><?= $transNumber ?></td>
                    </tr>
                    <tr>
                        <td>दुकान क्रमांक</td>
                        <td><?= $Shop_Cd ?></td>
                    </tr>
                    <tr>
                        <td>दुकानाचे नाव</td>
                        <td><?= $ShopName ?></td>
                    </tr>
                    <tr>
                        <td>दुकानाचा पत्ता</td>
                        <td><?= $ShopAddress ?></td>
                    </tr>
                    <tr>
                        <td>झोन</td>
                        <td><?= $Node ?></td>
                    </tr>
                    <tr>
                        <td>वॉर्ड</td>
                        <td><?= $Ward ?></td>
                    </tr>
                    <tr>
                        <td>तारखेपासून</td>
                        <td><?= $StartDate ?></td>
                    </tr>
                    <tr>
                        <td>तारखेपर्यंत</td>
                        <td><?= $EndDate ?></td>
                    </tr>
                    <tr>
                        <td>स्टेट्स</td>
                        <td class = <?php if($status === 'Active') { echo "text-success fw-bold";}else{ echo "text-danger fw-bold"; }?>><?= $status ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        
        <div class="social m-4">
            <?php if($status === 'Active') { ?>
                आजच्या दिनांकानुसार परवाना संपुष्टात येण्यासाठी आणखी <span class="text-primary fw-bold"> <?= $remainingDays ?> दिवस</span> शिल्लक आहेत.
            <?php } else { ?>
                    <span class='text-danger fw-bold'> परवान्याची वैधता संपली आहे. कृपया लवकरात लवकर नूतनीकरण करा. </span>
            <?php } ?>
        </div>
    </div>
</div>