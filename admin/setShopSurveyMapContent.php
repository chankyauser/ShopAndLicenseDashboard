<?php

session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
    if(isset($_POST['electionName']) && !empty($_POST['electionName'])  && 
        isset($_POST['shopCd']) && !empty($_POST['shopCd'])  
    ){

        try  
            {  


                $electionName = $_POST['electionName'];
                $shopCd = $_POST['shopCd'];
                $_SESSION['SAL_ElectionName'] = $electionName;
                
                $db1=new DbOperation();
                $userName=$_SESSION['SAL_UserName'];
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                $query1 = "SELECT top (1) ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
                    ISNULL(ShopMaster.Shop_UID,'') as Shop_UID, 
                    ISNULL(ShopMaster.ShopName,'') as ShopName, 
                    ISNULL(ShopMaster.ShopKeeperName,'') as ShopKeeperName, 
                    ISNULL(ShopMaster.ShopKeeperMobile,'') as ShopKeeperMobile, 
                    ISNULL(ShopMaster.ShopAddress_1,'') as ShopAddress_1, 
                    ISNULL(ShopMaster.ShopAddress_2,'') as ShopAddress_2,
                    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
                    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
                    ISNULL(NodeMaster.Ward_No,0) as Ward_No,
                    ISNULL(PocketMaster.PocketName,'') as PocketName,
                    ISNULL(ShopMaster.AddedBy,'') as AddedBy,
                    ISNULL(ShopMaster.SurveyBy,'') as SurveyBy,
                    ISNULL(convert(varchar, ShopMaster.AddedDate, 121),'') as AddedDate, 
                    ISNULL(convert(varchar, ShopMaster.SurveyDate, 121),'') as SurveyDate, 
                    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus, 
                    ISNULL(ShopMaster.ShopOutsideImage1,'') as ShopOutsideImage1,
                    ISNULL((SELECT top (1) BusinessCatName FROM BusinessCategoryMaster 
                    WHERE BusinessCat_Cd = ShopMaster.BusinessCat_Cd ),'') as Nature_of_Business
                FROM ShopMaster 
                INNER JOIN PocketMaster ON (ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
                AND PocketMaster.IsActive = 1)
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
                WHERE ShopMaster.IsActive = 1
                AND ShopMaster.Shop_Cd = $shopCd";
                    
                $dataShopSurvey = $db1->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                // print_r($dataShopSurvey);
                
                $shopListExecutive = "";
                $shopSurveyExecutive = "";
                if(strpos($dataShopSurvey["AddedBy"], "_") !== false){
                    $shpListExecutiveArr = explode("_", $dataShopSurvey["AddedBy"]);
                    $shopListExecutive = "  |  By : ".$shpListExecutiveArr[0];
                }else{
                    $shopListExecutive = "  |  By : ".$dataShopSurvey["AddedBy"];
                }

                if(strpos($dataShopSurvey["SurveyBy"], "_") !== false){
                    $shpSurveyExecutiveArr = explode("_", $dataShopSurvey["SurveyBy"]);
                    $shopSurveyExecutive = "  |  By : ".$shpSurveyExecutiveArr[0];
                }else{
                    $shopSurveyExecutive = "  |  By : ".$dataShopSurvey["SurveyBy"];
                }

                $shopUID = "";
                if(!empty($dataShopSurvey["Shop_UID"])){
                    $shopUID = " : ".$dataShopSurvey["Tree_UID"];
                } 

                $PocketAndWard = "";
                if(!empty($dataShopSurvey["Ward_No"])){
                    $PocketAndWard = "Pocket : ".$dataShopSurvey["PocketName"]." | Ward : ".$dataShopSurvey["Ward_No"];
                } 
                $shopOutsidePhoto1 = "";
                if(!empty($dataShopSurvey["ShopOutsideImage1"])){
                    $shopOutsidePhoto1 = "".$dataShopSurvey["ShopOutsideImage1"];
                }else{
                    $shopOutsidePhoto1 = "pics/shopDefault.jpeg";  
                }

                $surveyDate = "";
                if(!empty($dataShopSurvey['SurveyDate'])){
                    $surveyDate = date('d/m/Y h:i a',strtotime($dataShopSurvey['SurveyDate']));
                }
                echo  "<table class='table-bordered'><tr><td rowspan='6' ><img src='".$shopOutsidePhoto1."' height='100' width='80' /></td><th> ".$dataShopSurvey['ShopName']."  ".$shopUID." | ".$PocketAndWard." </th></tr><tr><th> Shop Keeper : ".$dataShopSurvey["ShopKeeperName"]."   |   Mobile : ".$dataShopSurvey["ShopKeeperMobile"]." </th></tr><tr><th> Nature of Business : ".$dataShopSurvey['Nature_of_Business']."   </th></tr><tr><th>Latitude : ".$dataShopSurvey['Latitude']."  | Longitude : ".$dataShopSurvey['Longitude']." </th></tr><tr><th>Shop Listed Date : ".date('d/m/Y h:i a',strtotime($dataShopSurvey['AddedDate']))."  ".$shopListExecutive." </th></tr><tr><th>Shop Survey Date : ".$surveyDate."  ".$shopSurveyExecutive." </th></tr></table>";
                    
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                          

  }else{
    echo "";
  }

}else{
    echo "";
}
?>

