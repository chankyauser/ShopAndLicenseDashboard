<?php

    include 'setShopSurveyDetailFilterData.php';
    
    

    $db1=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    //$fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
    //$toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];


    $dateCondition  =  " AND CONVERT(VARCHAR, ShopMaster.SurveyDate ,120) BETWEEN '$fromDate' AND '$toDate'  ";

    $queryTotal = "SELECT ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) $nodeCondition $nodeNameCondition $pcktCondition $dateCondition),0) as SurveyAll,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) $nodeCondition $nodeNameCondition $pcktCondition ),0) as SurveyPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) $nodeCondition $nodeNameCondition $pcktCondition ),0) as SurveyDenied,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Permanently Closed' ) $nodeCondition $nodeNameCondition $pcktCondition ),0) as PC,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Permission Denied' ) $nodeCondition $nodeNameCondition $pcktCondition ),0) as PD,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Non-Cooperative' ) $nodeCondition $nodeNameCondition $pcktCondition ),0) as NC,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified'  $nodeCondition $nodeNameCondition $pcktCondition $dateCondition),0) as SurveyVerified,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL $nodeCondition $nodeNameCondition $pcktCondition ),0) as ShopListed;";
    $surveyTotalData = $db1->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 


    // echo $queryTotal;
    if($pocketCd != 'All'){
        $db3=new DbOperation();
        $query3 ="SELECT 
        PocketName
        FROM PocketMaster WHERE Pocket_Cd = $pocketCd";
        $dataPocket = $db3->ExecutveQuerySingleRowSALData($query3, $electionName, $developmentMode);
    }

    if($executiveCd != 'All'){
        $db4=new DbOperation();
        $query4 ="SELECT 
        em.ExecutiveName
        FROM LoginMaster lm 
        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
        WHERE lm.Executive_Cd = $executiveCd";
        $dataSurveyExe= $db4->ExecutveQuerySingleRowSALData($query4, $electionName, $developmentMode);
    }


    ?>

    <div class="row">
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["ShopListed"]); ?></h2>
                        <label>Shops Listed</label>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyAll"]); ?></h2>
                        <label>Shops Surveyed </label>
						<?php 
                        $newFromDate = date("m-d-y", strtotime($fromDate));  
                        $newToDate = date("m-d-y", strtotime($toDate));  
                        ?>
                        <p>(<?php echo $newFromDate;?> - <?php echo $newToDate;?>) </p>
                      
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyPending"]); ?></h2>
                        <label>Survey Pending </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyAll"]); ?></h2>
                        <label>Document Collected </label>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDenied"]); ?>  </h2>
                        <label>Documents Denied </label> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;

                        <label>PC - </label><b><?php echo IND_money_format($surveyTotalData["PC"]); ?></b>
                        <label> PD - </label><b><?php echo IND_money_format($surveyTotalData["PD"]); ?></b>
                        <label> NC - </label><b><?php echo IND_money_format($surveyTotalData["NC"]); ?></b> 
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php if($surveyTotalData["SurveyAll"]!=0){  echo IND_money_format( ($surveyTotalData["SurveyVerified"] / $surveyTotalData["SurveyAll"]) * 100 )."%"; } ?></h2>
                        <label>Documents Verified</label>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
    </div>
    

  

<style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 70% 70%;}

    img.galleryimg:hover{
        transform: scale(3.2);
        z-index: 9999;
    }

     fieldset {
      /*display: block;*/
      margin-left: 2px;
      margin-right: 2px;
      padding-top: 0.35em;
      padding-bottom: 0.625em;
      padding-left: 0.75em;
      padding-right: 0.75em;
      border: 2px groove #C90D41;;
    }
    legend{
        font-size: 1.4rem;
        padding-left: 1em;
        color: #C90D41;
        font-weight: 900;
    }
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;
    }

    img.galleryimg:hover{
        z-index: 999999;
        transform: scale(3.2);
    }

    .avatar {
        background-color: transparent;
    }
</style>
    

        <div id="surveyDetailListData">
            <?php include 'tblSurveyDetailListData.php'; ?>
        </div>        
