<?php
set_time_limit(500);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);


include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ShopCd = isset($_POST['Shop_Cd']) ? trim($_POST['Shop_Cd']) : '';
    $operation = isset($_POST['operation']) ? trim($_POST['operation']) : '';

    $ImgURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/ShopAndLicenseDashboard/assets/imgs/'. trim($_SESSION['SAL_ElectionName']) . '_Logo.jpeg';


    if(!empty($ShopCd) && !empty($operation)){
        if($operation === 'shopApplication'){
            $query = "SELECT ISNULL(Shop_Cd , '') AS Shop_Cd,
                        ISNULL(CASE
                                    WHEN ShopKeeperName = '.....' OR NULLIF(ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                    ELSE ShopKeeperName
                                END,'') AS ShopKeeperName,
                        ISNULL(NULLIF(ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                        ISNULL(NULLIF(ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                        ISNULL(CONCAT(ShopAddress_1, 
                                            CASE 
                                                WHEN ShopAddress_2 IS NOT NULL AND ShopAddress_2 != '' 
                                                    THEN CONCAT(', ', ShopAddress_2)
                                            ELSE ''END), '') AS ShopAddress,
                        ISNULL(ShopName, '') AS ShopName,
                        ISNULL(CONVERT(VARCHAR,AddedDate,23),'') as AddedDate
                FROM ShopMaster 
                WHERE Shop_Cd = '$ShopCd'";

            $db2 = new DbOperation();
            $shopDetail = $db2->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);

            if ($shopDetail) {
                $ShopCd           = $shopDetail['Shop_Cd'];
                $ShopKeeperName   = $shopDetail['ShopKeeperName'];
                $ShopKeeperMobile = $shopDetail['ShopKeeperMobile'];
                $ShopEmailAddress = $shopDetail['ShopEmailAddress'];
                $ShopName         = $shopDetail['ShopName'];
                $ShopAddress      = $shopDetail['ShopAddress'];
                $AddedDate        = date('d-M-Y', strtotime($shopDetail['AddedDate']));

                $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                $Subject = 'Confirmation of Shop Application Submission';

                $Message = "<html>
                                <body>
                                    <p>Dear Mr./Ms. $ShopKeeperName,</p>
                                    <p>Greetings from Chhatrapati Sambhajinagar Municipal Corporation.</p>

                                    <p>This is to inform you that we have successfully received your application for the registration of your shop, submitted on <strong>$AddedDate</strong>, under the name <strong>$ShopName</strong> located at <strong>$ShopAddress</strong>.</p>

                                    <p>Your application reference number is <strong>$ShopCd</strong>. Please keep this number for future correspondence.</p>

                                    <p>Our team will now begin the verification and review process. Should we require any additional information or documents, we will reach out to you via this email address or your registered phone number. Thank you for your application.</p>

                                    <p>We appreciate your cooperation and adherence to municipal regulations.</p>

                                    <br>
                                    <p>
                                        Warm regards,<br>
                                        <strong>Licensing Department</strong><br>
                                        Assistant Commissioner Trade Licenses<br>
                                        Chhatrapati Sambhajinagar Municipal Corporation<br>
                                        <img src=" . $ImgURL . " alt='Election Log' style='width:100px; height:100px'> 
                                    </p>
                                </body>
                            </html>";

            }
        } 
        try {
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                     
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'ornetyash@gmail.com';    
                $mail->Password   = 'cqnr mnvs cugz pfgp'; // App Password from Gmail   
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
                $mail->Port       = 465;

                $mail->setFrom('ornetyash@gmail.com', $SetFrom);
                $mail->addAddress('karuna.gaikwad@ornet.co.in', 'Karuna Gaikwad');
                $mail->isHTML(true);
                $mail->Subject = $Subject;  
                $mail->Body = $Message;
                $mail->send();

                echo json_encode([
                    'StatusCode' => 200,
                    'Message' => 'Mail has been sent successfully!'
                ]);

            } catch (Exception $e) {
                    echo json_encode([
                        'StatusCode' => 500,
                        'Message' => 'Message could not be sent.',
                        'ErrorInfo' => $mail->ErrorInfo
                    ]);
            }
    }
    

}






?>