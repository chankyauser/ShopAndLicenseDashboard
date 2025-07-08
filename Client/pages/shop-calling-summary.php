<section id="chartjs-charts">
  <?php 

    $db1=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $queryCallingCategory = "SELECT 
    (SELECT Calling_Category FROM CallingCategoryMaster WHERE Calling_Category_Cd = sm.Calling_Category_Cd) as Calling_Category, 
    COUNT(sm.Shop_Cd) as ShopCallingCount FROM ShopMaster as sm
        INNER JOIN CallingCategoryMaster as ccm ON ccm.Calling_Category_Cd = sm.Calling_Category_Cd
        INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
        INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
        WHERE 
        sm.IsActive = 1
        AND pm.IsActive = 1
        AND nm.IsActive = 1
        AND ccm.IsActive = 1
        GROUP BY sm.Calling_Category_Cd ;";

    $dataCategoryWiseCallingShop = $db1->ExecutveQueryMultipleRowSALData($queryCallingCategory, $electionName, $developmentMode);

    $queryCallingNode = "SELECT nm.NodeName, COUNT(sm.Shop_Cd) as ShopCallingCount FROM ShopMaster as sm
    INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
    INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
    WHERE 
	sm.Calling_Category_Cd IS NOT NULL
    AND sm.IsActive = 1
    AND pm.IsActive = 1
    AND nm.IsActive = 1
	GROUP BY nm.NodeName ;";

    $dataNodeWiseCallingShop = $db1->ExecutveQueryMultipleRowSALData($queryCallingNode, $electionName, $developmentMode);

    $queryCallingWard = "SELECT nm.Ward_No, COUNT(sm.Shop_Cd) as ShopCallingCount FROM ShopMaster as sm
    INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
    INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
    WHERE 
    sm.Calling_Category_Cd IS NOT NULL
    AND sm.IsActive = 1
    AND pm.IsActive = 1
    AND nm.IsActive = 1
	GROUP BY nm.Ward_No ;";

    $dataWardWiseCallingShop = $db1->ExecutveQueryMultipleRowSALData($queryCallingWard, $electionName, $developmentMode);

    ?>


    <div id="nodeWiseSurveyDetailId">                               
        <?php include 'datatbl/tblGetShopCallingSummary.php'; ?>
    </div> 

    </section>