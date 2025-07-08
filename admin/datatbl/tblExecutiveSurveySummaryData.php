<?php

      $db=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];
      
    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else if(isset($_GET['nodeCd'])){
        $nodeCd = $_GET['nodeCd'];
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }else{
        $nodeCd = "All";
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }

    if(isset($_SESSION['SAL_Node_Name'])){
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = "All";
    }

    if(isset($_GET['fromDate'])){
        $from_Date = $_GET['fromDate'];
        $_SESSION['SAL_FromDate'] = $from_Date;
    }else if(isset($_SESSION['SAL_FromDate'])){
        $from_Date = $_SESSION['SAL_FromDate'];
    }

    if(isset($_GET['toDate'])){
        $to_Date = $_GET['toDate'];
        $_SESSION['SAL_ToDate'] = $from_Date;
    }else if(isset($_SESSION['SAL_ToDate'])){
        $to_Date = $_SESSION['SAL_ToDate'];
    }

    if($nodeCd == 'All'){
        $nodeCondition = " AND pm.Node_Cd <> 0  "; 
    }else{
        $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> 0  "; 
    }

    if($nodeName == 'All'){
        $nodeNameCondition = " AND nm.NodeName <> '' ";
    }else{
        $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
    }

    $fromDate = $from_Date." ".$_SESSION['StartTime'];;
    $toDate = $to_Date." ".$_SESSION['EndTime'];

    $query = "SELECT COALESCE(sm.SRExecutive_Cd, 0) as Executive_Cd,
    COALESCE(sm.SurveyBy, '') as SurveyBy,
    COALESCE(em.ExecutiveName, '') as ExecutiveName,
    COALESCE(um.Mobile, '') as MobileNo,
    COUNT(DISTINCT(sm.Shop_Cd)) as ShopCount
    FROM PocketMaster as pm
    INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
    INNER JOIN ShopMaster as sm 
    ON ( pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1)
    INNER JOIN Survey_Entry_Data..User_Master um ON (um.UserName = sm.SurveyBy)
    INNER JOIN LoginMaster lm on (lm.Executive_Cd = um.Executive_Cd
        AND sm.SRExecutive_Cd = lm.Executive_Cd )
    INNER JOIN Survey_Entry_Data..Executive_Master em
    ON ( em.Executive_Cd = lm.Executive_Cd )
    WHERE pm.IsActive = 1 
    AND sm.SurveyDate  BETWEEN '$fromDate' AND '$toDate' 
    $nodeCondition
    $nodeNameCondition
    GROUP BY sm.SRExecutive_Cd, sm.SurveyBy, 
    em.ExecutiveName, um.Mobile
    ORDER BY em.ExecutiveName ASC;";
    
    // echo $query; 

    $db1=new DbOperation();
    $dataSurveyExecutiveSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

    if (sizeof($dataSurveyExecutiveSummary)>0) 
    {
        if(!isset($_SESSION['SAL_Executive_Cd'])){
            $_SESSION['SAL_Executive_Cd'] =  $dataSurveyExecutiveSummary[0]["Executive_Cd"];
        }
   ?>

<div class="row">
    <?php 
         foreach ($dataSurveyExecutiveSummary as $key => $valueExe) {
   ?>
        
            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                <a onclick="getExecutiveWiseSurveyDetail('<?php echo $valueExe["Executive_Cd"]; ?>')">
                    <div class="card bg-primary" >
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar bg-light-danger p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-user avatar-icon p-50  mr-2"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="text-white font-weight-bolder mb-0">
                                        <?php echo $valueExe["ExecutiveName"]; ?>
                                    </h4>
                                    <p class="text-white font-medium-2 mb-0">
                                        <?php echo $valueExe['ShopCount']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> 
        
   <?php
         }
    ?>
</div>


<div id="executiveWiseSurveyDetailId">                               
    <?php include 'datatbl/tblGetExecutiveWiseSurveyDetail.php'; ?>
</div>    

    
<?php
 }
?>