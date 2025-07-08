<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include '../api/includes/DbOperation.php';


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

    if(isset($_GET['mapFilterType']))
    {
        $filterType = $_GET['mapFilter'];
    }
    else if(isset($_SESSION['SAL_Map_FilterType']))
    {
        $filterType = $_SESSION['SAL_Map_FilterType'];
    }
    else
    {
        $filterType = "all";
    }

    $db2=new DbOperation();

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $userData = $db->ExecutveQuerySingleRowSALData("SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
        if(sizeof($userData)>0){
            $_SESSION['SAL_UserName'] = $userData["UserName"];
        }
    }else{
        session_unset();
        session_destroy();
        header('Location:index.php');
    }

    $queryPocketKML = "SELECT COALESCE(pm.Pocket_Cd, 0) as Pocket_Cd,
        COALESCE(pm.PocketName, '') as PocketName,
        COALESCE(pm.KML_FileUrl, '') as KML_FileUrl
        FROM PocketMaster as pm
        INNER JOIN ShopMaster as sm 
        ON pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1
        INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
        WHERE pm.IsActive = 1 AND COALESCE(pm.KML_FileUrl, '') <> ''
        GROUP BY pm.Pocket_Cd, pm.PocketName, pm.KML_FileUrl
        ORDER BY pm.Pocket_Cd DESC;";
    $dataPocketSummary = $db2->ExecutveQueryMultipleRowSALData($queryPocketKML, $electionName, $developmentMode);

    $queryMap = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus,
    ISNULL(CONVERT(varchar,ShopMaster.SurveyDate,23),'') as SurveyDate
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1 
    --AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
    
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    AND PocketMaster.Node_Cd <> 0
    AND ShopMaster.BusinessCat_Cd <> 0
    ORDER BY ShopMaster.AddedDate DESC;";
    // echo $queryMap;
// die();
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($queryMap, $electionName, $developmentMode);

$queryTotal = "SELECT ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )),0) as SurveyAll,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND  ISNULL(ShopMaster.ShopStatus,'') = 'In-Review'  ),0) as SurveyDocumentInReview,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND  ISNULL(ShopMaster.ShopStatus,'') = 'Pending'  ),0) as SurveyDocumentPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND  ISNULL(ShopMaster.ShopStatus,'') = ''  ),0) as SurveyPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)),0) as SurveyDenied,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified'),0) as SurveyVerified,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL),0) as ShopListed;";
    $surveyTotalData = $db2->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 

    $que = "SELECT ShopMaster.ShopStatus, StatusMaster.ShortCode, ISNULL(count(*),0) as Count
    FROM ShopMaster
    INNER JOIN StatusMaster on StatusMaster.ApplicationStatus = ShopMaster.ShopStatus
    WHERE ShopMaster.IsActive = 1  
    AND  ShopStatus in (SELECT ApplicationStatus as ShopStatus 
          FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1
      )
    GROUP BY ShopMaster.ShopStatus, StatusMaster.ShortCode";
   $queData = $db2->ExecutveQueryMultipleRowSALData($que, $electionName, $developmentMode);
   $pdDeniedCount = 0;
   $ncDeniedCount = 0;
   $pcDeniedCount = 0;
   foreach ($queData as $key => $value) {
       if($value["ShortCode"] == "PD"){
            $pdDeniedCount = IND_money_format($value["Count"]);
       }else if($value["ShortCode"] == "NC"){
            $ncDeniedCount = IND_money_format($value["Count"]);
       }else if($value["ShortCode"] == "PC"){
            $pcDeniedCount = IND_money_format($value["Count"]);
       }
   }


?>

<!--<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">

                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="toDate">Map Filter</label>
                                <select class="select2 form-control" name="mapfilterType" style="height:35px;">
									  <option value="All">All Ward </option></span>
                                      <option value="Zone">Zone wise</option> 
                                      <option value="Ward">Ward wise</option> 
                                      <option value="Area">Shop Area wise</option> 
                                      <option value="BusinessCategory">Business Category wise</option> 
                                      <option value="ShopCategory">Shop Category wise</option> 
                                      <option value="ShopDocument">Shop Document wise</option> 
                                      <option value="RevenueCollection">Revenue Collection wise</option> 
                                      <option value="ShopLicense">Shop License wise</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12 text-right"   style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh" ></label>
                                        <button type="button" name="refesh" class="btn btn-primary" onclick="setShopSurveyBusinessCategoriesFilter(1,'All')" style="padding: 8px 10px;">Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

<div class="container mb-0 mt-30">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
    <div class="row">
        <div class="col-12 col-lg-1-5 col-sm-12">
            <h6><img src = "https://maps.google.com/mapfiles/ms/icons/green-dot.png" /> - Documents Collected 
			(<?php
//			echo IND_money_format($surveyTotalData["SurveyVerified"]+$surveyTotalData["SurveyDocumentPending"]+$surveyTotalData["SurveyDocumentInReview"]); 
echo IND_money_format(32780);
			?>)</h6>
        </div>
        <div class="col-12 col-lg-1-5 col-sm-12 mb-20">
                <h6><img src = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png" /> - Permission Denied  (<?php echo $pdDeniedCount;?>) </h6>
        </div>
        <div class="col-12 col-lg-1-5 col-sm-12">
            <h6> <img src = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png" /> - Non-Cooperative  (<?php echo $ncDeniedCount;?>)</h6>
        </div>
        <div class="col-12 col-lg-1-5 col-sm-12">
            <h6><img src = "https://maps.google.com/mapfiles/ms/icons/red-dot.png" /> - Permanently Closed  (<?php echo $pcDeniedCount;?>)</h6>
        </div>
        <div class="col-12 col-lg-1-5 col-sm-12">
            <h6><img src = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png" />  - Documents Pending  (<?php 
			//echo IND_money_format((($surveyTotalData["ShopListed"] - $surveyTotalData["SurveyAll"]) - $surveyTotalData["SurveyDenied"])); 
			echo IND_money_format(1134);
			?>)</h6>
        </div>
        <div class="col-12 col-xl-12 col-sm-12">
            <div id="mapSurveyShops" style="height: 800px;width: 100%;opacity: 1;visibility: visible;"></div>
        </div>
            </div>
        </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        // Google Maps

        function initMap() {

            <?php  
                   $centerLat  = $pocketShopsSurveyMapAndListDetail[0]["Latitude"];
                   $centerLng  = $pocketShopsSurveyMapAndListDetail[0]["Longitude"];
            ?>
            
            var marker;
            var infowindowKML = new google.maps.InfoWindow();

            const map = new google.maps.Map(document.getElementById("mapSurveyShops"), {
                center: { lat: <?php echo $centerLat; ?>, lng: <?php echo $centerLng; ?> }, 
                zoom: 16,
            });

              
            function addKMLMarkerWithTimeout(src, timeout) {
              // window.setTimeout(function() {
                  var kmlLayer = new google.maps.KmlLayer(src, {
                    suppressInfoWindows: true,
                    preserveViewport: false,
                    map: map
                  });

                  google.maps.event.addListener(kmlLayer, 'click', function(event) {
                          var content = "<div>" + event.featureData.infoWindowHtml + "</div>";
                          infowindowKML.setPosition(event.latLng);
                          infowindowKML.setOptions({
                              pixelOffset: event.pixelOffset,
                              content: content
                          });
                          infowindowKML.open(map);
                  });
                  
              // }, timeout);
            }

              <?php
                  $srNoKML = 0;
                  foreach ($dataPocketSummary as $key => $value){
                      $srNoKML = $srNoKML+1;
                      if(filter_var($value["KML_FileUrl"], FILTER_VALIDATE_URL)){
              ?>
                       addKMLMarkerWithTimeout('<?php echo $value["KML_FileUrl"]; ?>', '<?php echo ($srNoKML*300); ?>');
              <?php
                      }
                  }
             ?>
            <?php
                foreach ($pocketShopsSurveyMapAndListDetail as $key => $value){
                    
                    if($value['Latitude'] != '0'){
            ?>
                      addMarkerWithTimeout(500,'<?php echo $value["Latitude"]; ?>', '<?php echo $value["Longitude"]; ?>','<?php echo $value["ShopStatus"]; ?>',<?php echo $value["Shop_Cd"]; ?>,map, '<?php echo $value["SurveyDate"]; ?>');
            <?php
                    }
                }
                
            ?>


            function addMarkerWithTimeout(timeout, lat, lng, shpSts, shopId,map, SurveyDate) {
                    // if(shpSts == 'Approved'){ 
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                    // }else if(shpSts == 'In-Review'){ 
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                    // }else if(shpSts == 'Pending'){ 
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                    // }else if(shpSts == 'Rejected' || shpSts == 'Non-Cooperative' || shpSts == 'Permission Denied'){ 
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                    // }else if(shpSts == 'Verified'){ 
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
                    // }else{
                    //   var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                    // }

                    

                    if(SurveyDate == ''){ 
                    
                    if(shpSts == 'Permission Denied') {
                            var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                        }
                        else if(shpSts == 'Non-Cooperative') {
                            var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                        }
                        else if(shpSts == 'Permanently Closed') {
                            var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                        }else{
                            var image = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";        
                        }
                    }else if(SurveyDate != ''){ 

                        // if(shpSts == 'Permission Denied') {
                        //     var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                        // }
                        // else if(shpSts == 'Non-Cooperative') {
                        //     var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                        // }
                        // else if(shpSts == 'Permanently Closed') {
                        //     var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                        // }
                        // else{
                            var image = "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
                        // }
                    }
                    

                    // if(shpSts == 'Rejected'){ 
                    // var image = "https://maps.google.com/mapfiles/ms/icons/pink-dot.png";
                    // }else if(shpSts == 'In-Review'){ 
                    // var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                    // }else if(shpSts == 'Pending'){ 
                    // var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                    // }else if(shpSts == 'Permission Denied' || shpSts == 'Non-Cooperative' || shpSts == 'Permanently Closed'){ 
                    // var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                    // }else if(shpSts == 'Verified'){ 
                    // var image = "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
                    // }else{
                    // var image = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                    // }

                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, lng),
                        map: map,
                        icon: image
                    });
                    google.maps.event.addListener(marker, 'click', function(e) {
                        shopQuickViewShopDetailModal(shopId);
                    });
            }
        }

        window.initMap = initMap;

    </script>


     <?php 
        if(sizeof($pocketShopsSurveyMapAndListDetail)>0){
    ?>
        <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap" async></script>-->
        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap"  ></script>
    <?php
        }
    ?>