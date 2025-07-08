 <div class="col-xl-3 primary-sidebar sticky-sidebar mt-10">
    <div class="sidebar-widget widget-category-2 mb-10">
        <ul>
            <?php
                $db2=new DbOperation();
                if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
                    $userName=$_SESSION['SAL_UserName'];
                }
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                
                $queryBusinessCatSummary = "SELECT
                    ISNULL(bcm.BusinessCat_Cd,0) as BusinessCat_Cd,
                    ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
                    ISNULL(bcm.BusinessCatNameMar,'') as BusinessCatNameMar,
                    ISNULL(bcm.BusinessCatImage,'') as BusinessCatImage,
                    ISNULL(COUNT(DISTINCT(sm.Shop_Cd)),0) as ShopCount
                    FROM BusinessCategoryMaster bcm 
                    INNER JOIN ShopMaster sm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                    WHERE bcm.IsActive = 1 AND sm.IsActive = 1
                    GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, 
                    bcm.BusinessCatNameMar, bcm.BusinessCatImage";
                $db=new DbOperation();
                $dataBusinessCategorySummary = $db->ExecutveQueryMultipleRowSALData($queryBusinessCatSummary, $electionName, $developmentMode);
                // print_r($dataBusinessCategorySummary);
                foreach ($dataBusinessCategorySummary as $key => $valueBusinessCat) {
            ?>            
                    <li onclick="setShopBusinessCategoriesFilter(1,'<?php echo $valueBusinessCat["BusinessCat_Cd"]; ?>')"  >
                        <a > <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueBusinessCat["BusinessCatImage"]; ?>" alt="<?php echo $valueBusinessCat["BusinessCatName"]; ?>" /><?php echo $valueBusinessCat["BusinessCatName"]; ?></a><span class="count"><?php echo $valueBusinessCat["ShopCount"]; ?></span>
                    </li>
            <?php
                }

            ?>
        </ul>
    </div>
</div>