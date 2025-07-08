<?php
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    // include 'api/includes/DbOperation.php';

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }


    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $nodeData = array();
    $businessCatData = array();

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    
    if(!isset($_SESSION['SAL_BusinessCat_Cd'])){
        $_SESSION['SAL_BusinessCat_Cd'] = "All";
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
    }else{
        $businessCatCd = $_SESSION['SAL_BusinessCat_Cd'];
    }


    if($nodeCd != "All"){
        $nodeCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0 ";
        $queryNode = "SELECT
            ISNULL(Node_Cd,0) as Node_Cd,
            ISNULL(NodeName,'') as NodeName,
            ISNULL(NodeNameMar,'') as NodeNameMar,
            ISNULL(Ac_No,0) as Ac_No,
            ISNULL(Ward_No,0) as Ward_No,
            ISNULL(Address,'') as Address,
            ISNULL(Area,'') as Area
        FROM NodeMaster
        WHERE Node_Cd = $nodeCd";
        $db1=new DbOperation();
        $nodeData = $db1->ExecutveQuerySingleRowSALData($queryNode, $electionName, $developmentMode);
    }else{
        $nodeCondition = " AND PocketMaster.Node_Cd <> 0  ";
    }

    if($businessCatCd != "All"){
        $businessCatCondition = " AND ShopMaster.BusinessCat_Cd = $businessCatCd AND ShopMaster.BusinessCat_Cd <> 0 ";
        $queryBusinessCat = "SELECT
            ISNULL(BusinessCat_Cd,0) as BusinessCat_Cd,
            ISNULL(BusinessCatName,'') as BusinessCatName,
            ISNULL(BusinessCatNameMar,'') as BusinessCatNameMar
            FROM BusinessCategoryMaster
        WHERE BusinessCat_Cd = $businessCatCd";
        $db1=new DbOperation();
        $businessCatData = $db1->ExecutveQuerySingleRowSALData($queryBusinessCat, $electionName, $developmentMode);
    }else{
        $businessCatCondition = " AND ShopMaster.BusinessCat_Cd <> 0 ";
    }


     if($businessCatCd != "All"){
        $queryParwanaShopCount = "SELECT 
            prm.Parwana_Cd, prm.Parwana_Name_Eng, prm.Parwana_Name_Mar, bcm.BusinessCatImage,
            ISNULL((
                SELECT
                    COUNT(DISTINCT(ShopMaster.Shop_Cd))
                FROM ShopMaster 
                INNER JOIN PocketMaster ON (ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 
                $businessCatCondition
                )
                INNER JOIN ParwanaDetails ON ParwanaDetails.ParwanaDetCd = ShopMaster.ParwanaDetCd AND ParwanaDetails.Parwana_Cd = prm.Parwana_Cd
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
                WHERE ShopMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
                $nodeCondition
            ),0) as ParwanaCatShopCount
        FROM ParwanaMaster prm
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = prm.BusinessCat_Cd
        WHERE prm.BusinessCat_Cd = $businessCatCd";
        $db2=new DbOperation();
        $shopParwanaDetail = $db2->ExecutveQueryMultipleRowSALData($queryParwanaShopCount, $electionName, $developmentMode);

        // if(sizeof($shopParwanaDetail)>0){
        //     $_SESSION['SAL_Parwana_Cd'] = $shopParwanaDetail[0]["Parwana_Cd"];
        //     $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
        // }else{
        //     $_SESSION['SAL_Parwana_Cd'] = "All";
        //     $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
        // }
    }else{
        $shopParwanaDetail = array();
    }

     if(!isset($_SESSION['SAL_Parwana_Cd'])){
        $_SESSION['SAL_Parwana_Cd'] = "All";
        $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
    }else{
        $parwanaCd = $_SESSION['SAL_Parwana_Cd'];
    }

    if($businessCatCd != "All" && $parwanaCd != "All"){
        $parwanaCondition = " AND prm.BusinessCat_Cd = $businessCatCd AND prm.Parwana_Cd = $parwanaCd ";
    }else{
        $parwanaCondition = "  ";
    }
 

    $queryTotal = "SELECT 
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1  ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.IsCertificateIssued,0) = 1 AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )       ),0) as CertificateIssued,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1  ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.IsNewCertificateIssued,0) = 1 AND ShopMaster.BillGeneratedDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )      ),0) as NewCertificateIssued,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1  ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.ShopApproval,'') = 'Approved' AND ShopMaster.ShopApprovalDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )      ),0) as ShopApproved,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )       ),0) as SurveyAll,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )        ),0) as SurveyPending,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)         ),0) as SurveyDenied,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified'         ),0) as SurveyVerified,

    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) 
    LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL         ),0) as ShopListed;";
    $db1=new DbOperation();
    $surveyTotalData = $db1->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 

    $queryShopStatus = "SELECT
        t.SrNo, t.ShopStatus, t.TextColor, t.ShopCount
    FROM (
        SELECT
            '0' as SrNo, 'Survey Pending' as ShopStatus, '#C90D41' as TextColor,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus = ShopMaster.ShopStatus) WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL         ),0)  as ShopCount 

        UNION ALL 

        SELECT  
        ISNULL(stm.SrNo,0) as SrNo,ISNULL(stm.ApplicationStatus,'') as ShopStatus, ISNULL(stm.TextColor,'') as TextColor,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd LEFT JOIN ParwanaDetails AS pd ON (ShopMaster.ParwanaDetCd = pd.ParwanaDetCd) LEFT JOIN ParwanaMaster AS prm ON (pd.Parwana_Cd = prm.Parwana_Cd) WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = stm.ApplicationStatus   ),0)  as ShopCount
        FROM StatusMaster stm
        
    ) as t
    GROUP BY t.SrNo, t.ShopStatus, t.TextColor, t.ShopCount
    ";
    $db2=new DbOperation();
    // echo $queryShopStatus;
    $surveyShopStatusData = $db2->ExecutveQueryMultipleRowSALData($queryShopStatus, $electionName, $developmentMode); 

// $nodeCondition $businessCatCondition $parwanaCondition



?>

<!-- <div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="breadcrumb">
                    <a href="index.php" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> <a href="#" class="inactiveLink " >  <i class="fi-rs-location-alt"></i> Ward : </a> <?php if($nodeCd != "All"){ if(sizeof($nodeData)>0){ echo $nodeData["Ward_No"]." - ".$nodeData["Area"]; } }else{ echo $nodeCd; } ?> <span></span> <a href="#" class="inactiveLink" > <i class="fi-rs-apps"></i> Categories : </a> <?php if($businessCatCd != "All"){ if(sizeof($businessCatData)>0){ echo $businessCatData["BusinessCatName"]; } }else{ echo $businessCatCd; } ?> <span> Shop Survey And License Statistics </span>
                </div>
            </div>
        </div>
    </div>
</div>
 -->