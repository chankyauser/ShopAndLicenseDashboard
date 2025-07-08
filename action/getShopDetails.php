<?php
session_start();
include '../api/includes/DbOperation.php';
$db = new DbOperation();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if (isset($_POST['shop_cd'])) {
    $ShopOwner_Shop_Cd = $_POST['shop_cd'];

    $dbshop = new DbOperation();
    $sql = "SELECT ISNULL(sm.ShopOwnPeriod,'') as ShopOwnPeriod,
                    ISNULL(sm.ShopCategory,'') as ShopCategory,  
                   ISNULL(sm.Shop_Cd, '') as Shop_Cd,
                   ISNULL(pd.Parwana_Cd,'') as Parwana_Cd,
                   ISNULL(sm.ShopLength,'') as ShopLength,
                   ISNULL(sm.ShopWidth,'') as ShopWidth,
                   ISNULL(sm.ShopHeight,'') as ShopHeight,
                   ISNULL(sm.ShopName,'') as ShopName,
                   ISNULL(sm.ShopArea_Cd,'') as ShopArea_Cd,
                    ISNULL(CONCAT(ShopAddress_1, 
                                CASE 
                                    WHEN ShopAddress_2 IS NOT NULL AND ShopAddress_2 != '' 
                                        THEN CONCAT(', ', ShopAddress_2)
                                ELSE ''END), '') AS ShopAddress_1,
                   ISNULL(sm.ShopOwnStatus,'') as ShopOwnStatus,
                   ISNULL(sm.BusinessCat_Cd,'') as BusinessCat_Cd,
                   ISNULL(sam.ShopAreaName,'') as ShopAreaName,
                   ISNULL(pd.Amount,'') as Amount,
                   ISNULL(sm.Ward_No, '') as Ward_No,
                   ISNULL(nm.Node_Cd, '') as Node_Cd,
                   ISNULL(nm.NodeName, '') as NodeName,
                   ISNULL(sm.ShopArea_Name, '') as ShopArea_Name,
                   ISNULL(CONVERT(VARCHAR,sm.BusinessStartDate,23),'') as BusinessStartDate
            FROM ShopMaster sm
            LEFT JOIN ParwanaDetails AS pd ON (pd.ParwanaDetCd = sm.ParwanaDetCd)
            LEFT JOIN ShopAreaMaster AS sam ON (sam.ShopArea_Cd=sm.ShopArea_Cd)
            LEFT JOIN NodeMaster As nm ON (nm.Ward_No = sm.Ward_No)
            WHERE Shop_Cd = $ShopOwner_Shop_Cd";

    $data = $dbshop->ExecutveQuerySingleRowSALData($sql, $electionName, $developmentMode);

    echo json_encode($data);

}