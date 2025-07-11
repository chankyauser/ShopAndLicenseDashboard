<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include "../../api/includes/DbOperation.php";

function fetchData()
{
    session_start();
    // echo "<pre>"; print_r($_SESSION);exit;

    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    $db = new DbOperation();

    $draw = $_POST['draw'] ?? 1;
    $start = $_POST["start"] ?? 0;
    $rowperpage = $_POST["length"] ?? 10;
    $searchValue = $_POST['search']['value'] ?? '';
    $ward = $_POST['ward'] ?? '';

    $nodeName = $_POST['nodeName'];
    $OwnerName = $_POST['OwnerName'];
    $OwnerMobile = $_POST['OwnerMobile'];

    // Base WHERE clause
    $whereClause = "AND sm.IsActive = 1";

    // Search filter
    if (!empty($searchValue)) {
        $searchValue = addslashes($searchValue);
        $whereClause .= " AND (
            sm.Shop_Cd LIKE '%$searchValue%' OR
            sm.ShopName LIKE '%$searchValue%' OR
            sm.Ward_No LIKE '%$searchValue%' OR
            sm.ShopOwnerName LIKE '%$searchValue%' OR
            sm.ShopOwnerMobile LIKE '%$searchValue%' 
        )";
    }

    // Ward filter

    if (!empty($ward) && intval($ward) != 0) {
        $whereClause .= " AND sm.Ward_No = " . intval($ward);
    }

    if (!empty($nodeName) && ($nodeName != "All")) {
        $whereClause .= " AND nm.NodeName = '$nodeName'";
    }

    if (!empty($OwnerName)) {
        $whereClause .= " AND sm.ShopOwnerName LIKE '%$OwnerName%'";
    }

    if (!empty($OwnerMobile)) {
        $whereClause .= " AND sm.ShopOwnerMobile LIKE '%$OwnerMobile%'";
    }
    // if (!empty($documentStatus)) {
    //     $whereClause .= " AND sm.Ward_No = " . intval($ward);
    // }

    // $query = "SELECT 
    //                 COALESCE(sm.Shop_Cd, '') AS Shop_Cd,
    //                 COALESCE(sm.Shop_UID, '') AS Shop_UID, 
    //                 COALESCE(sm.ShopName, '') AS ShopName, 
    //                 COALESCE(sm.ShopNameMar, '') AS ShopNameMar,
    //                 COALESCE(sm.ShopOwnerName, '') AS ShopOwnerName,
    //                 COALESCE(sm.ShopKeeperName, '') AS ShopKeeperName,
    //                 COALESCE(sm.ShopOwnerNameMar, '') AS ShopOwnerNameMar,
    //                 COALESCE(sm.ShopOwnerMobile, '') AS ShopOwnerMobile,
    //                 COALESCE(sm.ShopKeeperMobile, '') AS ShopKeeperMobile,
    //                 COALESCE(sm.Ward_No, 0) AS Ward_No,
    //                 COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
    //                 COALESCE(sb.BillNo, '') AS BillNo, 
    //                 COALESCE(sb.FinYear, '') AS FinYear, 
    //                 COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
    //                 COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate, 
    //                 COALESCE(CONVERT(VARCHAR, sb.BillingDate, 105), '') AS BillingDate,
    //                 ISNULL(sb.BillAmount, 0) AS Amount,
    //                 COALESCE(nm.Node_Cd, 0) AS Node_Cd,
    //                 COALESCE(nm.NodeName, '') AS NodeName 
    //             FROM ShopBilling sb
    //             INNER JOIN ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd 
    //             INNER JOIN TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd
	// 			INNER JOIN NodeMaster nm ON nm.Ward_No = sm.Ward_No AND nm.IsActive = 1
    //             WHERE (td.PaymentStatus IS NULL OR td.PaymentStatus <> 'SUCCESS')
    //             -- WHERE  (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS')
    //             $whereClause
    //             ORDER BY sb.LicenseEndDate DESC

    // ";

    $query ="SELECT 
                COALESCE(sm.Shop_Cd, '') AS Shop_Cd,
                COALESCE(sm.Shop_UID, '') AS Shop_UID, 
                COALESCE(sm.ShopName, '') AS ShopName, 
                COALESCE(sm.ShopNameMar, '') AS ShopNameMar,
                ISNULL(
                    CASE 
                        WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL 
                        THEN sm.ShopOwnerName
                        ELSE sm.ShopKeeperName
                    END, 
                '') AS ShopOwnerName, 
                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), sm.ShopOwnerMobile) AS ShopOwnerMobile,
                COALESCE(sm.Ward_No, 0) AS Ward_No,
                COALESCE(sb.BillNo, '') AS BillNo, 
                COALESCE(sb.FinYear, '') AS FinYear,
                COUNT(DISTINCT sb.Billing_Cd) AS BillCount, 
                (
                    SELECT 
                        sbb.BillNo, 
                        sbb.BillingDate, 
                        CONVERT(VARCHAR(20), sbb.BillAmount, 1) AS Amount,
                        COALESCE(CONVERT(VARCHAR, sbb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                        COALESCE(CONVERT(VARCHAR, sbb.LicenseEndDate, 105), '') AS LicenseEndDate,
                        COALESCE(td.paymentStatus, '') as paymentStatus
                    FROM ShopBilling sbb
                    INNER JOIN TransactionDetails td 
                        ON td.Billing_Cd = sbb.Billing_Cd AND (td.PaymentStatus IS NULL OR td.PaymentStatus <> 'SUCCESS')
                    WHERE sbb.Shop_Cd = sm.Shop_Cd AND sbb.IsActive = 1
                    ORDER BY sbb.LicenseEndDate DESC
                    FOR JSON PATH
                ) AS BillDetailsArray,
                ISNULL(SUM(sb.BillAmount), 0) AS Amount,
                COALESCE(nm.Node_Cd, 0) AS Node_Cd,
                COALESCE(nm.NodeName, '') AS NodeName,
                COALESCE(nm.Area, '') AS Area
            FROM ShopBilling sb
            INNER JOIN ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd 
            INNER JOIN TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd
            INNER JOIN NodeMaster nm ON nm.Ward_No = sm.Ward_No AND nm.IsActive = 1
            WHERE (td.PaymentStatus IS NULL OR td.PaymentStatus <> 'SUCCESS')
            $whereClause
            GROUP BY 
                sm.Shop_Cd, 
                sm.Shop_UID, 
                sm.ShopName, 
                sm.ShopNameMar, 
                sm.ShopKeeperName, 
                sm.ShopOwnerName, 
                sm.ShopKeeperMobile, 
                sm.ShopOwnerMobile, 
                sm.Ward_No, 
                sb.BillNo, 
                sb.FinYear, 
                sb.BillAmount, 
                nm.Node_Cd, 
                nm.NodeName,
                nm.Area";
    // echo $query;
    // exit;
    // $data = $db->getMultiRecordsAJAXDatatable($query);
    $data = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    // print_r($data);
    if (isset($data['Shop_Cd'])) {
        $data = [$data]; // ensure array format
    }
    // Total count
    // $countAll = "SELECT COUNT(*) as total FROM ShopMaster WHERE IsActive = 1";
    // $resAll = $db->getSingleAJAXDatatable($countAll);
    // $recordsTotal = $resAll['total'] ?? 0;

    // $countFiltered = "SELECT COUNT(*) as total 
    //     FROM ShopBilling sb
    //     INNER JOIN ShopMaster as sm ON sm.Shop_Cd = sb.Shop_Cd
    //     LEFT JOIN TransactionDetails as td ON sb.Billing_Cd = td.Billing_Cd
    //     INNER JOIN NodeMaster as nm ON sm.Ward_No = nm.Ward_No
    //     WHERE  (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS')
    //      $whereClause";

    // echo $countFiltered;

    // $resFiltered = $db->getSingleAJAXDatatable($countFiltered);
    // $recordsFiltered = $resFiltered['total'] ?? 0;

    return [
        "draw" => intval($draw),
        "recordsTotal" => count($data),
        "recordsFiltered" => count($data),
        "data" => $data
    ];
}

echo json_encode(fetchData());
exit;
?>