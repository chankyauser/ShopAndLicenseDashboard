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
    $whereClause = "WHERE sm.IsActive = 1";

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
            -- COALESCE(sm.ShopOwnerName, '') AS ShopOwnerName,
            -- COALESCE(sm.ShopOwnerNameMar, '') AS ShopOwnerNameMar,
            -- COALESCE(sm.ShopOwnerMobile, '') AS ShopOwnerMobile,
            ISNULL(CASE
                        WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN ShopOwnerName
                    ELSE ShopKeeperName
            END,'') AS ShopOwnerName,
            ISNULL(CASE
                        WHEN sm.ShopKeeperNameMar = '.....' OR NULLIF(sm.ShopKeeperNameMar, '') IS NULL THEN ShopOwnerNameMar
                    ELSE ShopKeeperNameMar
            END,'') AS ShopOwnerNameMar,
            ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopOwnerMobile,
            COALESCE(sm.Ward_No, 0) AS Ward_No,
            COALESCE(sb.Billing_Cd, 0) AS Billing_Cd, 
            COALESCE(sb.BillNo, '') AS BillNo, 
            COALESCE(sb.FinYear, '') AS FinYear, 
            COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
            COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate, 
            COALESCE(CONVERT(VARCHAR, sb.BillingDate, 105), '') AS BillingDate,
            COALESCE(td.Amount, 0) AS PaidAmount,
            COALESCE(nm.Node_Cd, 0) AS Node_Cd,
            COALESCE(nm.NodeName, '') AS NodeName,
            CASE 
                WHEN sb.LicenseEndDate < CAST(GETDATE() AS DATE) THEN COALESCE(pb.Amount, 0)
                ELSE 0 
            END AS RenewalAmount,
            CASE 
                WHEN sb.LicenseEndDate < CAST(GETDATE() AS DATE) THEN 1 
                ELSE 0 
            END AS IsRenewal
        FROM Aurangabad_ShopAndLicense..ShopMaster sm
        LEFT JOIN Aurangabad_ShopAndLicense..ShopBilling as sb ON sm.Shop_Cd = sb.Shop_Cd
        LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails as td ON sm.Shop_Cd = td.Shop_Cd AND sb.Billing_Cd = td.Billing_Cd
        LEFT JOIN Aurangabad_ShopAndLicense..ParwanaDetails as pb ON sm.ParwanaDetCd = pb.ParwanaDetCd
        LEFT JOIN Aurangabad_ShopAndLicense..NodeMaster as nm ON sm.Ward_No = nm.Ward_No
        $whereClause
        ORDER BY sb.LicenseEndDate DESC
        OFFSET $start ROWS FETCH NEXT $rowperpage ROWS ONLY
    ";

    $data = $db->getMultiRecordsAJAXDatatable($query);
    if (isset($data['Shop_Cd'])) {
        $data = [$data]; // ensure array format
    }
    // Total count
    $countAll = "SELECT COUNT(*) as total FROM Aurangabad_ShopAndLicense..ShopMaster WHERE IsActive = 1";
    $resAll = $db->getSingleAJAXDatatable($countAll);
    $recordsTotal = $resAll['total'] ?? 0;
    
    $countFiltered = "SELECT COUNT(*) as total 
        FROM Aurangabad_ShopAndLicense..ShopMaster sm
        LEFT JOIN Aurangabad_ShopAndLicense..ShopBilling as sb ON sm.Shop_Cd = sb.Shop_Cd
        LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails as td ON sm.Shop_Cd = td.Shop_Cd AND sb.Billing_Cd = td.Billing_Cd
        LEFT JOIN Aurangabad_ShopAndLicense..ParwanaDetails as pb ON sm.ParwanaDetCd = pb.ParwanaDetCd
        LEFT JOIN Aurangabad_ShopAndLicense..NodeMaster as nm ON sm.Ward_No = nm.Ward_No
         $whereClause";

    $resFiltered = $db->getSingleAJAXDatatable($countFiltered);
    $recordsFiltered = $resFiltered['total'] ?? 0;

    return [
        "draw" => intval($draw),
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data
    ];
}

echo json_encode(fetchData());
exit;
?>