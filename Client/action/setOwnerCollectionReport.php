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
                    sm.Shop_Cd,
                    sm.Shop_UID, 
                    sm.ShopName,
                    ISNULL(
                        CASE 
                            WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL 
                            THEN sm.ShopOwnerName
                            ELSE sm.ShopKeeperName
                        END, 
                    '') AS ShopOwnerName, 
                    ISNULL(NULLIF(sm.ShopKeeperMobile, ''), sm.ShopOwnerMobile) AS ShopOwnerMobile,
                    SUM(td.Amount) AS TotalAmount,
                    COUNT(DISTINCT sb.Billing_Cd) AS BillCount,
                    COALESCE(sm.Ward_No, 0) AS Ward_No,
                    COALESCE(nm.Node_Cd, 0) AS Node_Cd,
                    COALESCE(nm.NodeName, '') AS NodeName,
                    COALESCE(nm.Area, '') AS Area,
                    ISNULL((
                            SELECT SUM(td_renew.Amount)
                            FROM ShopBilling sb_renew
                            INNER JOIN TransactionDetails td_renew 
                                ON td_renew.Billing_Cd = sb_renew.Billing_Cd 
                                AND td_renew.paymentStatus = 'SUCCESS'
                            WHERE sb_renew.Shop_Cd = sm.Shop_Cd 
                            AND sb_renew.IsActive = 1
                            AND sb_renew.IsLicenseRenewal = 1 
                        ), 0) AS RenewalAmount,
                    (
                        SELECT 
                            sb.BillNo, 
                            sb.BillingDate, 
                            CONVERT(VARCHAR(20), td.Amount, 1) AS Amount,
                            COALESCE(CONVERT(VARCHAR, sb.LicenseStartDate, 105), '') AS LicenseStartDate, 
                            COALESCE(CONVERT(VARCHAR, sb.LicenseEndDate, 105), '') AS LicenseEndDate,
                            sb.IsLicenseRenewal
                        FROM ShopBilling sb
                        INNER JOIN TransactionDetails td 
                            ON td.Billing_Cd = sb.Billing_Cd AND td.paymentStatus = 'SUCCESS'
                        WHERE sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                        ORDER BY  sb.LicenseEndDate DESC
                        FOR JSON PATH
                    ) AS BillDetailsArray

                FROM 
                    ShopMaster sm
                INNER JOIN ShopBilling sb 
                    ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                INNER JOIN TransactionDetails td 
                    ON td.Billing_Cd = sb.Billing_Cd AND td.paymentStatus = 'SUCCESS'
                LEFT JOIN ParwanaDetails pb 
                    ON sm.ParwanaDetCd = pb.ParwanaDetCd
                LEFT JOIN NodeMaster nm 
                    ON sm.Ward_No = nm.Ward_No
                $whereClause
                GROUP BY 
                    sm.Shop_Cd, 
                    sm.Shop_UID, 
                    sm.ShopName, 
                    sm.ShopKeeperName, 
                    sm.ShopOwnerName, 
                    sm.ShopKeeperMobile, 
                    sm.ShopOwnerMobile,
                    sm.Ward_No,
                    nm.Node_Cd, 
                    nm.NodeName,
                    nm.Area";


    // echo $query;exit;
    // $data = $db->getMultiRecordsAJAXDatatable($query);
    $data = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

    if (isset($data['Shop_Cd'])) {
        $data = [$data]; 
    }
    // // Total count
    // $countAll = "SELECT COUNT(*) as total FROM ShopMaster WHERE IsActive = 1";
    // // $resAll = $db->getSingleAJAXDatatable($countAll);
    // $resAll = $db->ExecutveQuerySingleRowSALData($countAll, $electionName, $developmentMode);
    // $recordsTotal = $resAll['total'] ?? 0;
    
    // $countFiltered = "SELECT COUNT(*) as total 
    //     FROM ShopMaster sm
    //     LEFT JOIN ShopBilling as sb ON sm.Shop_Cd = sb.Shop_Cd
    //     LEFT JOIN TransactionDetails as td ON sm.Shop_Cd = td.Shop_Cd AND sb.Billing_Cd = td.Billing_Cd
    //     LEFT JOIN ParwanaDetails as pb ON sm.ParwanaDetCd = pb.ParwanaDetCd
    //     LEFT JOIN NodeMaster as nm ON sm.Ward_No = nm.Ward_No
    //      $whereClause";

    // // $resFiltered = $db->getSingleAJAXDatatable($countFiltered);
    // $resFiltered = $db->ExecutveQuerySingleRowSALData($countFiltered, $electionName, $developmentMode);
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