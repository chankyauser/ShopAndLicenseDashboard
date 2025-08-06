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
    
    $operation = isset($_POST['operation']) ? trim($_POST['operation']) : '';
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];

    $ImgURL = $protocol . '://' . $host  . '/ShopAndLicenseDashboard/assets/imgs/'. trim($_SESSION['SAL_ElectionName']) . '_Logo.jpeg';

    $Message = '';
    if(!empty($operation)){
        if($operation === 'shopRegister'){
            $Shop_Cd = isset($_POST['Shop_Cd']) ? trim($_POST['Shop_Cd']) : '';
            if(!empty($Shop_Cd)){
                $ShopCd = isset($_POST['Shop_Cd']) ? trim($_POST['Shop_Cd']) : '';
                $query = "SELECT ISNULL(Shop_Cd , '') AS Shop_Cd,
                                ISNULL(CASE
                                            WHEN ShopKeeperName = '.....' OR NULLIF(ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                            ELSE ShopKeeperName
                                        END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN ShopKeeperMobile IS NOT NULL AND ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(ShopAddress_1, 
                                                    CASE 
                                                        WHEN ShopAddress_2 IS NOT NULL AND ShopAddress_2 != '' 
                                                            THEN CONCAT(', ', ShopAddress_2)
                                                    ELSE ''END), '') AS ShopAddress,
                                ISNULL(ShopName, '') AS ShopName,
                                ISNULL(CONVERT(VARCHAR,AddedDate,23),'') as AddedDate
                          FROM ShopMaster WHERE Shop_Cd = '$ShopCd'";

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
                    $ContactType = $shopDetail['ContactType'];

                    $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                    $Subject = 'Confirmation of Shop Application Submission';

                    $Message = "<html>
                                    <body>
                                        <p>Dear Mr./Ms. $ShopKeeperName,</p>
                                        <p>Greetings from Chhatrapati Sambhajinagar Municipal Corporation.</p>

                                        <p>This is to inform you that we have successfully received your application for the registration of your shop, submitted on <strong>$AddedDate</strong>, under the name <strong>$ShopName</strong> located at <strong>$ShopAddress</strong>.</p>

                                        <p>Your application reference number is <strong>$ShopCd</strong>. Please keep this number for future correspondence.</p>

                                        <p>Our team will now begin the verification and review process. Should we require any additional information or documents, we will reach out to you via this email address or your registered phone number. Thank you for your application.</p>
                                        <br>
                                        <p>
                                            Warm regards,<br>
                                            <strong>Vikas Ramesh Newale</strong><br>
                                            Deputy Commissioner<br>
                                            Municipal Corporation Chhatrapati Sambhajinagar<br>
                                            <img src=" . $ImgURL . " alt='Corporation Log' style='width:100px; height:100px'> 
                                        </p>
                                    </body>
                                </html>";

                    

                }
            }

        } else if($operation === 'licenseApplication'){

            $BillingCd = isset($_POST['Billing_Cd']) ? trim($_POST['Billing_Cd']) : '';
            if(!empty($BillingCd)){
                $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                $Query = "SELECT ISNULL(sb.Shop_Cd, 0) as Shop_Cd,
                                ISNULL(CASE
                                                WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN sm.ShopOwnerName
                                                ELSE sm.ShopKeeperName
                                            END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN sm.ShopKeeperMobile IS NOT NULL AND sm.ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                                        CASE 
                                                            WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                                THEN CONCAT(', ', sm.ShopAddress_2)
                                                        ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(CONVERT(VARCHAR,sb.UpdatedDate,23),'') as UpdatedDate,
                                COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                                COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate
                          FROM ShopBilling sb 
                          INNER JOIN ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd
                          WHERE sb.Billing_Cd = $BillingCd";
                $db2 = new DbOperation();
                $shopDetail = $db2->ExecutveQuerySingleRowSALData($Query, $electionName, $developmentMode);
    
                if(!empty($shopDetail)){
                    $Shop_Cd = $shopDetail['Shop_Cd'];
                    $ShopKeeperName = $shopDetail['ShopKeeperName'];
                    $ShopKeeperMobile = $shopDetail['ShopKeeperMobile'];
                    $ShopEmailAddress = $shopDetail['ShopEmailAddress'];
                    $ShopAddress = $shopDetail['ShopAddress'];
                    $ShopName = $shopDetail['ShopName'];
                    $LicenseStartDate = $shopDetail['LicenseStartDate'];
                    $LicenseEndDate = $shopDetail['LicenseEndDate'];
                    $ContactType = $shopDetail['ContactType'];

                    $Subject = 'License Application Received';
                    $Message = "<html>
                                <body style='font-family: Arial, sans-serif; color: #333;'>
                                    <p>Dear Mr./Ms. $ShopKeeperName,</p>
                                    <p>We acknowledge the receipt of your <strong>license application</strong> for the shop listed below:</p>
                                    <table cellpadding='5' cellspacing='0' border='0'>
                                        <tr>
                                            <td><strong>Shop Cd:</strong></td>
                                            <td>$Shop_Cd</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Shop Name:</strong></td>
                                            <td>$ShopName</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Shop Address:</strong></td>
                                            <td>$ShopAddress</td>
                                        </tr>
                                        <tr>
                                            <td><strong>License Period:</strong></td>
                                            <td>$LicenseStartDate to $LicenseEndDate</td>
                                        </tr>
                                    </table>
                                    <p>Please note that your license will be officially issued <strong>once payment is successfully confirmed</strong>.</p>
        
                                    <p>If you have already completed the payment, kindly wait for the verification process. You will receive a confirmation message and access to your license document once the process is complete.</p>
        
                                    <p><strong>Action Required:</strong> If payment is still pending, we request you to complete it at your earliest convenience to avoid any processing delays.</p>
        
                                    <br>
                                    <p>
                                        Warm regards,<br>
                                        <strong>Vikas Ramesh Newale</strong><br>
                                        Deputy Commissioner<br>
                                        Municipal Corporation Chhatrapati Sambhajinagar<br>
                                        <img src=" . $ImgURL . " alt='Corporation Log' style='width:100px; height:100px'> 
                                    </p>
                                </body>
                    </html>";
                }

            }

        } else if($operation === 'licensePayment'){

            $BillingCd = isset($_POST['Billing_Cd']) ? trim($_POST['Billing_Cd']) : '';
            if(!empty($BillingCd)){
                $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                $Subject = 'License Application and Payment Received';
                $Query = "SELECT ISNULL(sb.Shop_Cd, 0) as Shop_Cd,
                                ISNULL(CASE
                                                WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN sm.ShopOwnerName
                                                ELSE sm.ShopKeeperName
                                            END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN sm.ShopKeeperMobile IS NOT NULL AND sm.ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                                        CASE 
                                                            WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                                THEN CONCAT(', ', sm.ShopAddress_2)
                                                        ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(CONVERT(VARCHAR,sb.UpdatedDate,23),'') as UpdatedDate,
                                COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                                COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate,
                                ISNULL(td.TransStatus, 0) AS TransStatus,
                                ISNULL(td.Amount, 0) AS Amount
                          FROM ShopBilling sb 
                          INNER JOIN ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd
                          INNER JOIN TransactionDetails td ON td.Billing_Cd = sb.Billing_Cd
                          WHERE sb.Billing_Cd = $BillingCd";
                $db2 = new DbOperation();
                $shopDetail = $db2->ExecutveQuerySingleRowSALData($Query, $electionName, $developmentMode);
    
                if(!empty($shopDetail)){
                    $Shop_Cd = $shopDetail['Shop_Cd'];
                    $ShopKeeperName = $shopDetail['ShopKeeperName'];
                    $ShopKeeperMobile = $shopDetail['ShopKeeperMobile'];
                    $ShopEmailAddress = $shopDetail['ShopEmailAddress'];
                    $ShopAddress = $shopDetail['ShopAddress'];
                    $ShopName = $shopDetail['ShopName'];
                    $LicenseStartDate = $shopDetail['LicenseStartDate'];
                    $LicenseEndDate = $shopDetail['LicenseEndDate'];
                    $TransStatus = $shopDetail['TransStatus'];
                    $Amount = $shopDetail['Amount'];
                    $ContactType = $shopDetail['ContactType'];

                    $Subject = 'License Application Received';
                    $Message = "<html>
                                    <body style='font-family: Arial, sans-serif; color: #333;'>
                                        <p>Dear $ShopKeeperName,</p>

                                        <p>We have received your <strong>license application</strong> along with the payment. Thank you for completing the required steps. Below are the details of your application:</p>

                                        <table cellpadding='5' cellspacing='0' border='0'>
                                            <tr>
                                                <td><strong>Shop Cd:</strong></td>
                                                <td>$Shop_Cd</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shop Name:</strong></td>
                                                <td>$ShopName</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shop Address:</strong></td>
                                                <td>$ShopAddress</td>
                                            </tr>
                                            <tr>
                                                <td><strong>License Period:</strong></td>
                                                <td>$LicenseStartDate to $LicenseEndDate</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td>$TransStatus</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Amount:</strong></td>
                                                <td>$Amount</td>
                                            </tr>
                                        </table>

                                        <p>Your application is currently under review. Once the verification is complete, you will receive a confirmation, and your license will be issued accordingly.</p>

                                        <p><strong>What Happens Next?</strong></p>
                                        <ul>
                                        <li>Your application will be verified, and all submitted documents will be checked.</li>
                                        <li>If everything is in order, your license will be processed and issued to you.</li>
                                        <li>You will be notified when your license is ready for download or email delivery.</li>
                                        </ul>

                                        <p>We appreciate your patience during this process. If you have any questions or need assistance, feel free to reach out to us.</p>

                                        <br>
                                        <p>
                                        Warm regards,<br>
                                        <strong>Vikas Ramesh Newale</strong><br>
                                        Deputy Commissioner<br>
                                        Municipal Corporation Chhatrapati Sambhajinagar<br>
                                        <img src=" . $ImgURL . " alt='Corporation Log' style='width:100px; height:100px'> 
                                    </p>
                                    </body>
                                </html>";
                }

            }

        } else if($operation === 'licenseIssued'){
            $transID = isset($_POST['transID']) ? trim($_POST['transID']) : '';
            $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
            if(!empty($transID)){
                 $query = "SELECT ISNULL(sb.Shop_Cd, 0) as Shop_Cd,
                                ISNULL(CASE
                                                WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN sm.ShopOwnerName
                                                ELSE sm.ShopKeeperName
                                            END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN sm.ShopKeeperMobile IS NOT NULL AND sm.ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                                        CASE 
                                                            WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                                THEN CONCAT(', ', sm.ShopAddress_2)
                                                        ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(CONVERT(VARCHAR,sb.UpdatedDate,23),'') as UpdatedDate,
                                COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                                COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate,
                                ISNULL(sb.LicenseNumber,'') as LicenseNumber,
                                ISNULL(td.ConfirmationStatus,'') as ConfirmationStatus,
                                ISNULL(td.HoldReason,'') as HoldReason,
                                ISNULL(td.ConfirmationUpdatedBy,'') as ConfirmationUpdatedBy,
                                ISNULL(CONVERT(VARCHAR,td.ConfirmationUpdatedDate,23),'') as ConfirmationUpdatedDate
                           FROM TransactionDetails td 
                           INNER JOIN ShopBilling sb ON sb.Billing_Cd = td.Billing_Cd
                           INNER JOIN ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd
                           WHERE td.Transaction_Cd = $transID";
                $db2 = new DbOperation();
                $shopDetail = $db2->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);

                if(!empty($shopDetail)){
                    $Shop_Cd = $shopDetail['Shop_Cd'];
                    $ShopKeeperName = $shopDetail['ShopKeeperName'];
                    $ShopKeeperMobile = $shopDetail['ShopKeeperMobile'];
                    $ShopEmailAddress = $shopDetail['ShopEmailAddress'];
                    $ShopAddress = $shopDetail['ShopAddress'];
                    $ShopName = $shopDetail['ShopName'];
                    $LicenseStartDate = $shopDetail['LicenseStartDate'];
                    $LicenseEndDate = $shopDetail['LicenseEndDate'];
                    $LicenseNumber = $shopDetail['LicenseNumber'];
                    $ConfirmationStatus = $shopDetail['ConfirmationStatus'];
                    $ConfirmationUpdatedDate = $shopDetail['ConfirmationUpdatedDate'];
                    $HoldReason = $shopDetail['HoldReason'];
                    $ConfirmationUpdatedBy = $shopDetail['ConfirmationUpdatedBy'];
                    $ContactType = $shopDetail['ContactType'];

                    $Subject = 'License Successfully Generated';
                    $PortalURL = "https://csmcshoplicenses.com/"; 


                    $Message = "<html>
                        <body style='font-family: Arial, sans-serif; color: #333;'>
                            <p>Dear Mr./Ms. $ShopKeeperName,</p>
                            <p>We are pleased to inform you that your license has been successfully generated.</p>
                            <table cellpadding='5' cellspacing='0' border='0'>
                                <tr>
                                    <td><strong>Shop Cd:</strong></td>
                                    <td>$Shop_Cd</td>
                                </tr>
                                <tr>
                                    <td><strong>Shop Name:</strong></td>
                                    <td>$ShopName</td>
                                </tr>
                                <tr>
                                    <td><strong>Shop Address:</strong></td>
                                    <td>$ShopAddress</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Confirmation Status:</strong></td>
                                    <td>$ConfirmationStatus</td>
                                </tr>";

                                if($ConfirmationStatus == 'Confirm'){
                                    $Message .="<tr>
                                                    <td><strong>License Number:</strong></td>
                                                    <td>$LicenseNumber</td>
                                                </tr>";
                                }else{
                                    $Message .="<tr>
                                                    <td><strong>Hold Reason:</strong></td>
                                                    <td>$HoldReason</td>
                                                </tr>";
                                }

                        $Message .="<tr>
                                        <td><strong>License Period:</strong></td>
                                        <td>$LicenseStartDate to $LicenseEndDate</td>
                                    </tr>
                                </table>

                                <p>You can now download the license by logging into your account on the portal. Please note that the license is available exclusively through the portal and will not be sent via email.</p>

                                <p><strong>Portal Login Details:</strong></p>
                                <ul>
                                    <li><strong>Login URL:</strong> <a href='$PortalURL'>$PortalURL</a></li>
                                     <li><strong>Mobile Number (for login):</strong> $ShopKeeperMobile</li>
                                    <li><strong>Password:</strong> An OTP sent to your registered mobile number</li>
                                </ul>

                                <p>If you require any assistance, feel free to reach out to our support team.</p>
                                
                                <p>Thank you.</p>
                                <br>
                                <p>
                                    Warm regards,<br>
                                    <strong>Vikas Ramesh Newale</strong><br>
                                    Deputy Commissioner<br>
                                    Municipal Corporation Chhatrapati Sambhajinagar<br>
                                    <img src='" . $ImgURL . "' alt='Corporation Logo' style='width:100px; height:100px'> 
                                </p>
                            </body>
                        </html>";
                }
                
            }
        } else if($operation === 'shopInfoUpdate'){
            $Shop_Cd = isset($_POST['Shop_Cd']) ? trim($_POST['Shop_Cd']) : '';
            if(!empty($Shop_Cd)){
                $query = "SELECT ISNULL(Shop_Cd , '') AS Shop_Cd,
                                ISNULL(CASE
                                            WHEN ShopKeeperName = '.....' OR NULLIF(ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                            ELSE ShopKeeperName
                                        END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN ShopKeeperMobile IS NOT NULL AND ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(ShopAddress_1, 
                                                    CASE 
                                                        WHEN ShopAddress_2 IS NOT NULL AND ShopAddress_2 != '' 
                                                            THEN CONCAT(', ', ShopAddress_2)
                                                    ELSE ''END), '') AS ShopAddress,
                                ISNULL(ShopName, '') AS ShopName,
                                ISNULL(CONVERT(VARCHAR,AddedDate,23),'') as AddedDate,
                                ISNULL(CONVERT(VARCHAR,UpdatedDate,23),'') as UpdatedDate
                          FROM ShopMaster WHERE Shop_Cd = '$ShopCd'";

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
                    $ContactType = $shopDetail['ContactType'];
                    $UpdatedDate = date('d-M-Y', strtotime($shopDetail['UpdatedDate']));

                    $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                    $Subject = 'Shop Information Successfully Updated';

                    $PortalURL = "https://csmcshoplicenses.com/"; 

                    $Message = "<html>
                                    <body>
                                        <p>Dear Mr./Ms. $ShopKeeperName,</p>
                                        <p>Greetings from Chhatrapati Sambhajinagar Municipal Corporation.</p>

                                        <p>This is to confirm that the details of your shop have been successfully updated in our records.</p>

                                         <ul>
                                            <li><strong>Shop Cd:</strong> $ShopCd</li>
                                            <li><strong>Shop Name:</strong> $ShopName</li>
                                            <li><strong>Shop Address:</strong> $ShopAddress</li>
                                            <li><strong>Updated Date:</strong> $UpdatedDate</li>
                                        </ul>

                                        <p>You can check the updated shop details by logging into your account on the portal. Please note that the license is available exclusively through the portal and will not be sent via email.</p>

                                        <p><strong>Portal Login Details:</strong></p>
                                        <ul>
                                            <li><strong>Login URL:</strong> <a href='$PortalURL'>$PortalURL</a></li>
                                            <li><strong>Mobile Number (for login):</strong> $ShopKeeperMobile</li>
                                            <li><strong>Password:</strong> An OTP sent to your registered mobile number</li>
                                        </ul>

                                        <p>If you did not make this change or notice any discrepancies, please contact us immediately for assistance.</p>
                                        <br>
                                        <p>
                                            Warm regards,<br>
                                            <strong>Vikas Ramesh Newale</strong><br>
                                            Deputy Commissioner<br>
                                            Municipal Corporation Chhatrapati Sambhajinagar<br>
                                            <img src=" . $ImgURL . " alt='Corporation Log' style='width:100px; height:100px'> 
                                        </p>
                                    </body>
                                </html>";

                }
            }

        } else if($operation === 'ShopNotice'){
            $Notice_Id = isset($_POST['Notice_Id']) ? trim($_POST['Notice_Id']) : '';
            if(!empty($Notice_Id)){
                $query = "SELECT ISNULL(sm.Shop_Cd , '') AS Shop_Cd,
                                ISNULL(CASE
                                            WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN sm.ShopOwnerName
                                            ELSE sm.ShopKeeperName
                                        END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), sm.ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(CASE WHEN sm.ShopKeeperMobile IS NOT NULL AND sm.ShopKeeperMobile <> '' THEN 'Shop Keeper' ELSE 'Shop Owner' END, 'Shop Owner') AS ContactType,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), sm.ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                                    CASE 
                                                        WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                            THEN CONCAT(', ', sm.ShopAddress_2)
                                                    ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(nd.Calling_Category_Cd, 0) AS Calling_Category_Cd,
                                ISNULL(cm.Calling_Category, '') AS Calling_Category,
                                ISNULL(nd.Subject, '') AS NoticeSubject,
                                ISNULL(CONVERT(VARCHAR,nd.Notice_Date,23),'') as Notice_Date
                          FROM ShopNoticeDetails nd 
                          INNER JOIN ShopMaster sm ON sm.Shop_Cd = nd.Shop_Cd
                          INNER JOIN CallingCategoryMaster cm ON cm.Calling_Category_Cd = nd.Calling_Category_Cd
                          WHERE nd.IsActive = 1 AND nd.Notice_Id = '$Notice_Id'";

                $db2 = new DbOperation();
                $shopDetail = $db2->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
             

                 if ($shopDetail) {
                    $ShopCd           = $shopDetail['Shop_Cd'];
                    $ShopKeeperName   = $shopDetail['ShopKeeperName'];
                    $ShopKeeperMobile = $shopDetail['ShopKeeperMobile'];
                    $ShopEmailAddress = $shopDetail['ShopEmailAddress'];
                    $ShopName         = $shopDetail['ShopName'];
                    $ShopAddress      = $shopDetail['ShopAddress'];
                    $Notice_Date        = date('d-M-Y', strtotime($shopDetail['Notice_Date']));
                    $ContactType = $shopDetail['ContactType'];
                    $NoticeSubject = $shopDetail['NoticeSubject'];
                    $Calling_Category_Cd = $shopDetail['Calling_Category_Cd'];
                    $Calling_Category = $shopDetail['Calling_Category'];

                    $SetFrom = 'Chhatrapati Sambhajinagar Municipal Corporation';
                    $Subject = 'Notice from Corporation Against Your Shop Registration';

                    $PortalURL = "https://csmcshoplicenses.com/"; 

                    $Message = "<html>
                                    <body style='font-family: Arial, sans-serif; color: #333;'>
                                        <p>Dear Mr./Ms. $ShopKeeperName,</p>
                                        <p>
                                        This is to inform you that an official notice has been issued by the Chhatrapati Sambhajinagar Municipal Corporation concerning your shop <strong>$ShopName ($ShopCd)</strong>. 
                                        The notice has been categorized under <strong>$Calling_Category</strong> and pertains to the subject <strong>$NoticeSubject</strong>. It was officially issued on <strong>$Notice_Date</strong>.
                                        </p>

                                        <p>
                                        This notice may contain important compliance requirements, regulatory instructions, or actions that must be taken within a stipulated time frame. We advise you to review the notice promptly to avoid any consequences of non-compliance.
                                        </p>

                                        <p>
                                        <strong>Note:</strong> All official notices and related documentation are made available exclusively through the Municipal Corporation’s online portal. No physical copies or email attachments will be provided.
                                        </p>

                                        <p><strong>Portal Login Details:</strong></p>
                                        <ul>
                                            <li><strong>Login URL:</strong> <a href='$PortalURL'>$PortalURL</a></li>
                                            <li><strong>Registered Mobile Number:</strong> $ShopKeeperMobile</li>
                                            <li><strong>Password:</strong> An OTP sent to your registered mobile number at the time of login</li>
                                        </ul>

                                        <p>After logging in, click on the <strong>Shop Notice</strong> button to view the complete notice and take any necessary action as specified.</p>

                                         <p>If you have any questions or require technical assistance, please contact our support team via the portal or using the details provided below.
                                        </p>

                                        <br>
                                        <p>
                                        Sincerely,<br>
                                        <strong>Vikas Ramesh Newale</strong><br>
                                        Deputy Commissioner<br>
                                        Municipal Corporation Chhatrapati Sambhajinagar<br>
                                        <img src='" . $ImgURL . "' alt='Corporation Logo' style='width:100px; height:100px; margin-top:10px;'>
                                        </p>
                                    </body>
                                    </html>";

                }
            }
        }


        try {
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                     
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'ornetyash@gmail.com';    
                $mail->Password   = 'cqnr mnvs cugz pfgp';   
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                $mail->SMTPSecure = 'ssl';        
                $mail->Port       = 465;

                $mail->setFrom('ornetyash@gmail.com', $SetFrom);
                $mail->addAddress('karuna.gaikwad@ornet.co.in', 'Karuna Gaikwad');
                $mail->isHTML(true);
                $mail->Subject = $Subject;  
                $mail->Body = $Message;
                $SendMail = $mail->send();

                if($SendMail){
                    $Db = new DbOperation();
                    $query = "INSERT INTO EmailLog_Details (Type,Reference_Id,EmailType,EmailStatus,EmailDate) VALUES('$ContactType', $Shop_Cd, '$operation', 'Sent', GETDATE())";
                    $Db->RunQuerySALData($query, $electionName, $developmentMode);
                }



               

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