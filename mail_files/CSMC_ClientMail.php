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
    // $electionName = $_SESSION['SAL_ElectionName'];
    // $developmentMode = $_SESSION['SAL_DevelopmentMode'];

    $electionName = 'CSMC';
    $developmentMode = 'Live';

    $StartDate = '';
    $EndDate = '';

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];

    $ImgURL = $protocol . '://' . $host  . '/ShopAndLicenseDashboard/assets/imgs/'. trim($_SESSION['SAL_ElectionName']) . '_Logo.jpeg';

    $Db = new DbOperation();
    $Query = "SELECT ISNULL(Receiver_Id, 0) as Receiver_Id,  
                    ISNULL(Receiver_Name, '') as Receiver_Name, 
                    ISNULL(Receiver_Designation, '') as Receiver_Designation, 
                    ISNULL(Receiver_Mobile, '') as Receiver_Mobile,
                    ISNULL(Receiver_Email, '') as Receiver_Email,
                    ISNULL(IsActive, 0) as IsActive
              FROM EmailReceiver_Master WHERE IsActive = 1";
    $result = $Db->ExecutveQueryMultipleRowSALData($Query, $electionName, $developmentMode);

    if(!empty($result)){
        foreach($result as $res){
            $Designation = $res['Receiver_Designation'];
            $Email = $res['Receiver_Email'];
            $Receiver_Id = $res['Receiver_Id'];
            $Receiver_Name = $res['Receiver_Name'];
            
            $query ="SELECT ISNULL(EmailProc_id, 0) as EmailProc_id,
                            ISNULL(Designation, '') as Designation,
                            ISNULL(Email_Period, '') as Email_Period,
                            ISNULL(EmailProcess, '') as EmailProcess
                     FROM EmailProcess_Details 
                     WHERE Designation = '$Designation'";
            $EPDb = new DbOperation();
            $EmailProcess = $EPDb->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
            // echo "<pre>"; print_r($EmailProcess);exit;

            $EmailLogQuery = "SELECT TOP 1 
                                     ISNULL(Log_Id, 0) as Log_Id,
                                     ISNULL(Type, '') as Type,
                                     ISNULL(EmailStatus, '') as EmailStatus,
                                     ISNULL(EmailType, '') as EmailType,
                                     ISNULL(CONVERT(VARCHAR,EmailDate,23),'') as EmailDate
                              FROM EmailLog_Details 
                              WHERE Reference_Id = $Receiver_Id
                              ORDER BY Log_Id DESC";
            $EmailLog = $EPDb->ExecutveQuerySingleRowSALData($EmailLogQuery, $electionName, $developmentMode);
            // echo "<pre>"; print_r($EmailLog);exit;
            
            if (!empty($EmailProcess)) {
                foreach ($EmailProcess as $EP) {
                    $Email_Period = json_decode($EP['Email_Period']);
                    $ProcessName = $EP['EmailProcess'];
                    $shopBillingCountData = array();

                    if (!empty($Email_Period) && is_array($Email_Period)) {
                            $currentDate = date('Y-m-d'); 
                            if (!empty($EmailLog)) {
                                $EmailDate = $EmailLog['EmailDate']; 
                                $startDate = strtotime($EmailDate);  
                                $currentTimestamp = strtotime($currentDate); 

                                $diffInDays = ($currentTimestamp - $startDate) / (60 * 60 * 24);

                                if ($diffInDays <= 7) {
                                    $reportType = 'Weekly';
                                } elseif ($diffInDays <= 30) {
                                    $reportType = 'Monthly';
                                } elseif ($diffInDays <= 365) {
                                    $reportType = 'Annually';
                                } else {
                                    $reportType = 'Annually'; 
                                }

                                if (in_array(strtolower($reportType), $Email_Period)) {
                                    switch (strtolower($reportType)) {
                                        case 'weekly':
                                            $nextDate = date('Y-m-d', strtotime($EmailDate . ' +7 days'));
                                            $EndDate = date('Y-m-d', strtotime($nextDate . ' +7 days'));
                                            $Subject = "Weekly Status Report - " . date('d-m-Y', strtotime($nextDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;

                                        case 'monthly':
                                            $nextDate = date('Y-m-d', strtotime($EmailDate . ' +1 month'));
                                            $EndDate = date('Y-m-d', strtotime($nextDate . ' +1 month'));
                                            $Subject = "Monthly Status Report - " . date('d-m-Y', strtotime($nextDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;

                                        case 'annually':
                                            $nextDate = date('Y-m-d', strtotime($EmailDate . ' +1 year'));
                                            $EndDate = date('Y-m-d', strtotime($nextDate . ' +1 year'));
                                            $Subject = "Annual Status Report - " . date('d-m-Y', strtotime($nextDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;

                                        default:
                                            $Subject = "Unknown Report Type";
                                            break;
                                    }

                                    if ($currentDate === $nextDate) {
                                        $StartDate = $currentDate;

                                    
                                        $queryCount = "SELECT (SELECT COUNT(Shop_Cd) 
                                                            FROM ShopMaster WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1 AND (RenewalDate IS NULL OR RenewalDate = '')) AS TotalNewShops,
                                                        (SELECT COUNT(Shop_Cd) 
                                                            FROM ShopMaster WHERE IsActive = 1 AND (AddedDate BETWEEN '$StartDate' AND '$EndDate' OR UpdatedDate  BETWEEN '$StartDate' AND '$EndDate')) AS TotalShops,
                                                        (SELECT COUNT(Billing_Cd) 
                                                            FROM ShopBilling WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1) AS TotalBillGenerated,
                                                        (SELECT ISNULL(SUM(BillAmount), 0) 
                                                            FROM ShopBilling WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1) AS BillAmount,
                                                        (SELECT ISNULL(SUM(Amount), 0) 
                                                            FROM TransactionDetails 
                                                            WHERE PaymentStatus = 'SUCCESS' AND (TranDateTime BETWEEN '$StartDate' AND '$EndDate')) AS CollectedAmount,
                                                        (SELECT COUNT(Billing_Cd) 
                                                            FROM TransactionDetails 
                                                            WHERE PaymentStatus = 'SUCCESS' AND (TranDateTime BETWEEN '$StartDate' AND '$EndDate')) AS BillPaidShopCount,
                                                        (SELECT COUNT(DISTINCT sb.Shop_Cd)
                                                            FROM ShopBilling sb
                                                            INNER JOIN ShopMaster sm 
                                                                ON sm.Shop_Cd = sb.Shop_Cd 
                                                                AND YEAR(sm.RenewalDate) = YEAR(GETDATE())
                                                            LEFT JOIN TransactionDetails td 
                                                                ON sb.Billing_Cd = td.Billing_Cd
                                                            WHERE sb.IsLicenseRenewal = 1
                                                            AND (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS') AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1) AS LicenseRenewalPending,
                                                        (SELECT COUNT(DISTINCT sb.Shop_Cd)
                                                            FROM ShopBilling sb
                                                            INNER JOIN TransactionDetails td 
                                                                ON td.Billing_Cd = sb.Billing_Cd
                                                            WHERE sb.IsLicenseRenewal = 1 
                                                            AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE()) AND sb.IsActive = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate')) AS LicenseRenewedShops,
                                                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                            FROM ShopBilling sb
                                                            INNER JOIN TransactionDetails td 
                                                                ON td.Billing_Cd = sb.Billing_Cd
                                                            WHERE sb.IsLicenseRenewal = 1 
                                                            AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE()) AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1 ) AS RenewalBillAmount,
                                                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                            FROM ShopBilling sb
                                                            INNER JOIN TransactionDetails td 
                                                                ON td.Billing_Cd = sb.Billing_Cd
                                                            WHERE sb.IsLicenseRenewal = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1
                                                            AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                                                            AND td.PaymentStatus = 'SUCCESS') AS RenewalPaidAmount,
                                                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                            FROM ShopBilling sb
                                                            INNER JOIN TransactionDetails td 
                                                                ON td.Billing_Cd = sb.Billing_Cd
                                                            WHERE sb.IsLicenseRenewal = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1
                                                            AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                                                            AND td.PaymentStatus <> 'SUCCESS') AS RenewalUnpaidAmount";

                                        $db2 = new DbOperation();
                                        $shopBillingCountData = $db2->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);
                                    }
                                }
                            } else {
                               $availablePeriods = array_map('strtolower', $Email_Period); 

                                if (in_array('weekly', $availablePeriods)) {
                                    $reportType = 'weekly';
                                } elseif (in_array('monthly', $availablePeriods)) {
                                    $reportType = 'monthly';
                                } elseif (in_array('annually', $availablePeriods)) {
                                    $reportType = 'annually';
                                } else {
                                    $reportType = 'unknown'; 
                                }

                                $currentTimestamp = strtotime($currentDate);

                                if (in_array($reportType, $availablePeriods)) {
                                    switch ($reportType) {
                                        case 'weekly':
                                            $StartDate = date('Y-m-d', strtotime($currentDate . ' -7 days'));
                                            $EndDate = $currentDate;
                                            $Subject = "Weekly Status Report - " . date('d-m-Y', strtotime($StartDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;
                                        case 'monthly':
                                            $StartDate = date('Y-m-d', strtotime($currentDate . ' -1 month'));
                                            $EndDate = $currentDate;
                                            $Subject = "Monthly Status Report - " . date('d-m-Y', strtotime($StartDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;
                                        case 'annually':
                                            $StartDate = date('Y-m-d', strtotime($currentDate . ' -1 year'));
                                            $EndDate = $currentDate;
                                            $Subject = "Annual Status Report - " . date('d-m-Y', strtotime($StartDate)) . " to " . date('d-m-Y', strtotime($EndDate));
                                            break;
                                        default:
                                            $StartDate = $EndDate = $currentDate;
                                            $Subject = "Unknown Report Type";
                                            break;
                                    }

                                    if(!empty($reportType) && $reportType != 'unknown' && !empty($StartDate) && !empty($EndDate) ){
                                        
                                        $queryCount = "SELECT (SELECT COUNT(Shop_Cd) 
                                                                FROM ShopMaster WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1 AND (RenewalDate IS NULL OR RenewalDate = '')) AS TotalNewShops,
                                                            (SELECT COUNT(Shop_Cd) 
                                                                FROM ShopMaster WHERE IsActive = 1 AND (AddedDate BETWEEN '$StartDate' AND '$EndDate' OR UpdatedDate  BETWEEN '$StartDate' AND '$EndDate')) AS TotalShops,
                                                            (SELECT COUNT(Billing_Cd) 
                                                                FROM ShopBilling WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1) AS TotalBillGenerated,
                                                            (SELECT ISNULL(SUM(BillAmount), 0) 
                                                                FROM ShopBilling WHERE (AddedDate BETWEEN '$StartDate' AND '$EndDate') AND IsActive = 1) AS BillAmount,
                                                            (SELECT ISNULL(SUM(Amount), 0) 
                                                                FROM TransactionDetails 
                                                                WHERE PaymentStatus = 'SUCCESS' AND (TranDateTime BETWEEN '$StartDate' AND '$EndDate')) AS CollectedAmount,
                                                            (SELECT COUNT(Billing_Cd) 
                                                                FROM TransactionDetails 
                                                                WHERE PaymentStatus = 'SUCCESS' AND (TranDateTime BETWEEN '$StartDate' AND '$EndDate')) AS BillPaidShopCount,
                                                            (SELECT COUNT(DISTINCT sb.Shop_Cd)
                                                                FROM ShopBilling sb
                                                                INNER JOIN ShopMaster sm 
                                                                    ON sm.Shop_Cd = sb.Shop_Cd 
                                                                    AND YEAR(sm.RenewalDate) = YEAR(GETDATE())
                                                                LEFT JOIN TransactionDetails td 
                                                                    ON sb.Billing_Cd = td.Billing_Cd
                                                                WHERE sb.IsLicenseRenewal = 1
                                                                AND (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS') AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1) AS LicenseRenewalPending,
                                                            (SELECT COUNT(DISTINCT sb.Shop_Cd)
                                                                FROM ShopBilling sb
                                                                INNER JOIN TransactionDetails td 
                                                                    ON td.Billing_Cd = sb.Billing_Cd
                                                                WHERE sb.IsLicenseRenewal = 1 
                                                                AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE()) AND sb.IsActive = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate')) AS LicenseRenewedShops,
                                                            (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                                FROM ShopBilling sb
                                                                INNER JOIN TransactionDetails td 
                                                                    ON td.Billing_Cd = sb.Billing_Cd
                                                                WHERE sb.IsLicenseRenewal = 1 
                                                                AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE()) AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1 ) AS RenewalBillAmount,
                                                            (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                                FROM ShopBilling sb
                                                                INNER JOIN TransactionDetails td 
                                                                    ON td.Billing_Cd = sb.Billing_Cd
                                                                WHERE sb.IsLicenseRenewal = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1
                                                                AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                                                                AND td.PaymentStatus = 'SUCCESS') AS RenewalPaidAmount,
                                                            (SELECT ISNULL(SUM(sb.BillAmount), 0)
                                                                FROM ShopBilling sb
                                                                INNER JOIN TransactionDetails td 
                                                                    ON td.Billing_Cd = sb.Billing_Cd
                                                                WHERE sb.IsLicenseRenewal = 1 AND (sb.AddedDate BETWEEN '$StartDate' AND '$EndDate') AND sb.IsActive = 1
                                                                AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                                                                AND td.PaymentStatus <> 'SUCCESS') AS RenewalUnpaidAmount";
    
                                        $db2 = new DbOperation();
                                        $shopBillingCountData = $db2->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);
                                    }

                                }
                            }

                            if (!empty($shopBillingCountData)) {

                                $NewShops = $shopBillingCountData['TotalNewShops'];
                                $TotalShops = $shopBillingCountData['TotalShops'];
                                $TotalBills = $shopBillingCountData['TotalBillGenerated'];
                                $BillsPaid = $shopBillingCountData['BillPaidShopCount'];
                                $Demand = $shopBillingCountData['BillAmount'];
                                $Collection = $shopBillingCountData['CollectedAmount'];
                                $Pending = $Demand - $Collection;
                                $RenewedShops = $shopBillingCountData['LicenseRenewedShops'];
                                $RenewalPending = $shopBillingCountData['LicenseRenewalPending'];

                                $Message = "<html>
                                                <body>
                                                    <p>Dear Mr./Ms. $Receiver_Name,</p>
                                                    <p>Greetings from CSMC Shop Trade.</p>

                                                    <p>We are pleased to provide the <strong>Revenue Summary</strong> for the period <strong>" . date('d-M-Y', strtotime($StartDate)) . "</strong> to <strong>" . date('d-M-Y', strtotime($EndDate)) . "</strong>:</p>";

                                if(strtolower($ProcessName) == 'shopsummary'){
                                    $Message .=    " <h3> Shop Registration</h3>
                                                        <ul>
                                                            <li>New Shops Registered: <strong> {$NewShops} </strong></li>
                                                            <li>Total Shops Registered: <strong> {$TotalShops} </strong></li>
                                                        </ul>";
                                }

                                if(strtolower($ProcessName) == 'licensesummary'){

                                    $Message .= "<h3> Billing Summary</h3>
                                                    <ul>
                                                        <li>Total Bills Generated: <strong> {$TotalBills} </strong></li>
                                                        <li>Bills Paid: <strong> {$BillsPaid} </strong></li>
                                                        <li>Outstanding Demand: <strong> Rs. {$Demand} </strong></li>
                                                        <li>Total Collection: <strong> Rs. {$Collection} </strong></li>
                                                        <li>Pending Amount: <strong> Rs. {$Pending} </strong></li>
                                                    </ul>";
                                }

                                if(strtolower($ProcessName) == 'renewLicensesummary'){

                                    $Message .= "<h3> License Updates</h3>
                                                    <ul>
                                                        <li>Licenses Renewed This Week: <strong> {$RenewedShops} </strong></li>
                                                        <li>Licenses Due for Renewal: <strong> {$RenewalPending} </strong></li>
                                                    </ul>";
                                }

                                     $Message .= " <p>Kindly review the above details and let us know if you have any questions or require assistance.</p>

                                                    <p>Thank you.</p>

                                                    <p>
                                                        Warm regards,<br>
                                                        <strong>CSMC Shop Trade</strong><br>
                                                        <strong>website: <a href='https://csmcshoplicenses.com/'> https://csmcshoplicenses.com/</a></strong><br>
                                                        <br>
                                                        <img src='{$ImgURL}' alt='Corporation Logo' style='width:100px; height:100px;'>
                                                    </p>
                                                </body>
                                            </html>";


                                try {
                                        $mail->isSMTP();                                            
                                        $mail->Host = 'smtp.gmail.com';                     
                                        $mail->SMTPAuth   = true;                                  
                                        $mail->Username   = 'ornetyash@gmail.com';    
                                        $mail->Password   = 'cqnr mnvs cugz pfgp';   
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                                        $mail->SMTPSecure = 'ssl';        
                                        $mail->Port       = 465;

                                        $mail->setFrom('ornetyash@gmail.com', 'Shop Trade');
                                        $mail->addAddress('karuna.gaikwad@ornet.co.in', 'Karuna Gaikwad');
                                        $mail->isHTML(true);
                                        $mail->Subject = $Subject;  
                                        $mail->Body = $Message;
                                                    
                                        $SendMail = $mail->send();

                                        if($SendMail){
                                            $Db = new DbOperation();
                                            $query = "INSERT INTO EmailLog_Details (Type,Reference_Id,EmailType,EmailStatus,EmailDate) VALUES('$Designation', $Receiver_Id, '$ProcessName', 'Sent', GETDATE())";
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
                    }
                }
            }
        }


?>