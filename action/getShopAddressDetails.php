<?php
include '../api/includes/DbOperation.php';
session_start();
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['Shop_Cd'])) {
        $Shop_Cd = $_POST['Shop_Cd'];
        $dbshop = new DbOperation();
        $sql = "SELECT
                    ISNULL(Title, '') AS Title,
                    ISNULL(Shop_Cd , '') AS Shop_Cd,
                    ISNULL(ShopOwnerAadharNo, '') AS ShopOwnerAadharNo,
                    ISNULL(ShopOwnerPinCode, '') AS ShopOwnerPinCode,
                    -- ISNULL(NULLIF(ShopKeeperName, ''), ShopOwnerName) AS ShopKeeperName,
                     ISNULL(CASE
                                    WHEN ShopKeeperName = '.....' OR NULLIF(ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                    ELSE ShopKeeperName
                                END,'') AS ShopKeeperName,
                    ISNULL(NULLIF(ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                    ISNULL(NULLIF(ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                    ISNULL(ShopOwnerAddress, '') AS ShopOwnerAddress,
                    ISNULL(FirstName, '') AS FirstName,
                    ISNULL(MiddleName, '') AS MiddleName,
                    ISNULL(LastName, '') AS LastName
                FROM 
                    ShopMaster 
                WHERE Shop_Cd = $Shop_Cd";
        $data = $dbshop->ExecutveQueryMultipleRowSALData($sql, $electionName, $developmentMode);
        if (!empty($data)) {
            echo json_encode([
                'status' => 200,
                'message' => 'Records Fetched Successfully',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 500,
                'message' => 'something went Wrong',
            ]);
        }

    }
}
?>