<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include "../../api/includes/DbOperation.php";

function fetchData()
{
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

    $query = "SELECT 
                    COALESCE(sm.Shop_Cd, '') AS Shop_Cd,
                    COALESCE(sm.Shop_UID, '') AS Shop_UID, 
                    COALESCE(sm.ShopName, '') AS ShopName, 
                    COALESCE(sm.ShopNameMar, '') AS ShopNameMar,
                    COALESCE(sm.ShopOwnerName, '') AS ShopOwnerName,
                    COALESCE(sm.ShopKeeperName, '') AS ShopKeeperName,
                    COALESCE(sm.ShopOwnerNameMar, '') AS ShopOwnerNameMar,
                    COALESCE(sm.ShopOwnerMobile, '') AS ShopOwnerMobile,
                    COALESCE(sm.ShopKeeperMobile, '') AS ShopKeeperMobile,
                    COALESCE(sm.Ward_No, 0) AS Ward_No,
                    COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
                    COALESCE(sb.BillNo, '') AS BillNo, 
                    COALESCE(sb.FinYear, '') AS FinYear, 
                    COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                    COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate, 
                    COALESCE(CONVERT(VARCHAR, sb.BillingDate, 105), '') AS BillingDate,
                    ISNULL(td.Amount, 0) AS Amount,
                    COALESCE(nm.Node_Cd, 0) AS Node_Cd,
                    COALESCE(nm.NodeName, '') AS NodeName 
                FROM Aurangabad_ShopAndLicense..ShopBilling sb
                INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sm.Shop_Cd = sb.Shop_Cd 
                LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails td ON sb.Billing_Cd = td.Billing_Cd
				INNER JOIN Aurangabad_ShopAndLicense..NodeMaster nm ON nm.Ward_No = sm.Ward_No AND nm.IsActive = 1
                WHERE  td.PaymentStatus <> 'SUCCESS'
                -- WHERE  (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS')
                $whereClause
                ORDER BY sb.LicenseEndDate DESC

    ";
    // echo $query;
    // exit;
    $data = $db->getMultiRecordsAJAXDatatable($query);
    // print_r($data);
    if (isset($data['Shop_Cd'])) {
        $data = [$data]; // ensure array format
    }
    // Total count
    $countAll = "SELECT COUNT(*) as total FROM Aurangabad_ShopAndLicense..ShopMaster WHERE IsActive = 1";
    $resAll = $db->getSingleAJAXDatatable($countAll);
    $recordsTotal = $resAll['total'] ?? 0;

    $countFiltered = "SELECT COUNT(*) as total 
        FROM Aurangabad_ShopAndLicense..ShopBilling sb
        INNER JOIN Aurangabad_ShopAndLicense..ShopMaster as sm ON sm.Shop_Cd = sb.Shop_Cd
        LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails as td ON sb.Billing_Cd = td.Billing_Cd
        INNER JOIN Aurangabad_ShopAndLicense..NodeMaster as nm ON sm.Ward_No = nm.Ward_No
        WHERE  (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS')
         $whereClause";

    // echo $countFiltered;

    $resFiltered = $db->getSingleAJAXDatatable($countFiltered);
    $recordsFiltered = $resFiltered['total'] ?? 0;

    return [
        "draw" => intval($draw),
        "recordsTotal" => $recordsFiltered,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data
    ];
}

echo json_encode(fetchData());
exit;
?>