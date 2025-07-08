<?php
    session_start();
    include '../api/includes/DbOperation.php';
    $Document = new DbOperation();
    // $Shop_Cd = $_SESSION['ShopOwner_Shop_Cd'] || 123;
    $Shop_Cd = $_POST['Shop_Cd'];
    $electionName = $_SESSION['SAL_ElectionName'];
    $developmentMode= $_SESSION['SAL_DevelopmentMode'];

    $DocumentDetailsQuery = "SELECT ISNULL(sd.ShopDocDet_Cd, 0) as ShopDocDet_Cd, 
                                    ISNULL(sd.Shop_Cd,0) as Shop_Cd,
                                    ISNULL(sd.Document_Cd,0) as Document_Cd, 
                                    ISNULL(sd.FileURL,'') as FileURL, 
                                    ISNULL(dm.DocumentName,'') as DocumentName,
                                    ISNULL(dm.DocumentNameMar,'') as DocumentNameMar
                             FROM ShopDocuments as sd 
                             JOIN ShopDocumentMaster as dm ON sd.Document_Cd = dm.Document_Cd
                             WHERE sd.Shop_Cd = '$Shop_Cd' AND sd.IsActive = 1";
    $DocumentDetails = $Document->ExecutveQueryMultipleRowSALData($DocumentDetailsQuery,$electionName, $developmentMode);

    echo json_encode([
         $DocumentDetails
    ]);

    

?>


