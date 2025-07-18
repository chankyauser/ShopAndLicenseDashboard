<?php
session_start(); // Make sure the session is started before using $_SESSION

// Check if the 'ShopKeeperMobile' parameter exists in the URL
if (isset($_GET['ShopKeeperMobile'])) {
    $ShopKeeperMobile = $_GET['ShopKeeperMobile'];

  
    $_SESSION['SAL_ShopKeeperMobile'] = $ShopKeeperMobile;
    $_SESSION['EditShopOwnerNumber'] = 1;
} else {
    // Return a JSON error message if ShopKeeperMobile is not set
    echo json_encode(['success' => false, 'message' => 'ShopKeeperMobile is required']);
    exit;
}
?>
