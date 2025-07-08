
<?php 
    $db5=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];

$query5 = "SELECT
            ISNULL(NodeName,'') as NodeName,
            ISNULL(Address,'') as Address,
            ISNULL(Area,'') as Area
            FROM NodeMaster 
            WHERE IsActive = 1 
            GROUP BY ISNULL(NodeName,''), 
            ISNULL(Area,''), ISNULL(Address,'') ";
      $dataNode = $db5->ExecutveQueryMultipleRowSALData($query5, $electionName, $developmentMode);

if(sizeof($dataNode)>0){

    ?>

    <style type="text/css">
        .avatar .avatar-content .avatar-icon {
            font-size: 1.3rem;
        }
    </style>

    <div class="row match-height">
        <?php
            foreach ($dataNode as $key => $valueNode) {
                $node_Name =$valueNode["NodeName"];
        ?>

            <div class="col-xl-6 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo $valueNode["NodeName"]." : ".$valueNode["Address"].", ".$valueNode["Area"] ?></h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                            </p>
                        </div>
                    </div>
                   
                    <div class="card-body statistics-body">
                        <div class="row">
                            <?php 
                                $db6=new DbOperation();
                                $userName=$_SESSION['SAL_UserName'];
                                $appName=$_SESSION['SAL_AppName'];
                                $electionName=$_SESSION['SAL_ElectionName'];
                                $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                                $query6 = "
                                    SELECT
                                        ISNULL(nnm.Node_Cd,0) as Node_Cd, 
                                        ISNULL(nnm.Ac_No,0) as Ac_No, 
                                        ISNULL(nnm.Ward_No,0) as Ward_No, 
                                        ISNULL(nnm.NodeName,'') as NodeName, 
                                        -- (SELECT 
                                        --     ISNULL(count(*),0)
                                        -- FROM PocketMaster pm 
                                        -- INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
                                        -- WHERE nm.NodeName = '$node_Name'
                                        -- AND nm.Ward_No = nnm.Ward_No ) as PocketsTotal,
                                        (select 
                                        count(distinct(td.Shop_Cd))
                                        FROM TransactionDetails td 
                                        INNER JOIN ShopMaster sm 
                                        ON sm.Shop_Cd = td.Shop_Cd
                                        INNER JOIN PocketMaster pm
                                        ON pm.Pocket_Cd = sm.Pocket_Cd
                                        INNER JOIN NodeMaster nm 
                                        ON nm.Node_Cd = pm.Node_Cd
                                        WHERE td.Shop_Cd is not null
                                        AND TransStatus = 'Done'
                                        AND nm.NodeName = '$node_Name' 
                                        AND nm.Ward_No = nnm.Ward_No ) as ShopLicensee,
                                        (select 
                                        sum(cast (Amount as int))
                                        FROM TransactionDetails td 
                                        INNER JOIN ShopMaster sm 
                                        ON sm.Shop_Cd = td.Shop_Cd
                                        INNER JOIN PocketMaster pm
                                        ON pm.Pocket_Cd = sm.Pocket_Cd
                                        INNER JOIN NodeMaster nm 
                                        ON nm.Node_Cd = pm.Node_Cd
                                        WHERE td.Shop_Cd is not null
                                        AND TransStatus = 'Done'
                                        AND nm.NodeName = '$node_Name' 
                                        AND nm.Ward_No = nnm.Ward_No) as RevenueCollected,
                                        (SELECT 
                                            ISNULL(count(*),0) 
                                        FROM ShopMaster sm 
                                        INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
                                        INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
                                        WHERE nm.NodeName = '$node_Name' 
                                        AND nm.Ward_No = nnm.Ward_No )  as ShopsTotal
                                    FROM NodeMaster nnm 
                                    WHERE nnm.NodeName = '$node_Name'
                                ";
                                $dataNodeWardNoSurvey = $db6->ExecutveQueryMultipleRowSALData($query6, $electionName, $developmentMode);

                                if(sizeof($dataNodeWardNoSurvey)>0){

                                    foreach ($dataNodeWardNoSurvey as $key => $value) {
                                        ?>

                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-bottom: 15px;">
                                                <a target="_blank" href="home.php?p=pocket-wise-survey-summary&nodeId=<?php echo $value["Node_Cd"]; ?>">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary p-50  mr-2">
                                                            <div class="avatar-content">
                                                                <span class="avatar-icon p-50"> <?php echo $value["Ward_No"]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <!-- <h4 class="font-weight-bolder mb-0">1130</h4> -->
                                                            <h4 class="font-weight-bolder mb-0"><?php echo $value["ShopsTotal"]; ?></h4>
                                                            <p class="text-success font-small-4 mb-0">Shops</p>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <!-- <h4 class="font-weight-bolder mb-0">1130</h4> -->
                                                            <h4 class="font-weight-bolder mb-0"><?php echo $value["ShopLicensee"]; ?></h4>
                                                            <p class="text-success font-small-4 mb-0">Licensee</p>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <!-- <h4 class="font-weight-bolder mb-0">1130</h4> -->
                                                            <h4 class="font-weight-bolder mb-0"><?php if(!empty( $value["RevenueCollected"]) ){ echo "₹ ".$value["RevenueCollected"]."/-"; }else{ echo "₹ 0"; } ?></h4>
                                                            <p class="text-success font-small-4 mb-0">Revenue</p>
                                                        </div>
                                                    </div>
                                            </div>
                                        <?php
                                    }

                                }

                            ?>
                           
                           

                        </div>
                    </div>
                </div>
            </div>
            <?php    
            }
        ?>
    </div>
    


   <?php
}
?>