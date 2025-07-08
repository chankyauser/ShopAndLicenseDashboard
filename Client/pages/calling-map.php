<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include '../api/includes/DbOperation.php';

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

    $queryMap = "	SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
	INNER JOIN CallingCategoryMaster ON ShopMaster.Calling_Category_Cd = CallingCategoryMaster.Calling_Category_Cd
    WHERE ShopMaster.IsActive = 1 
	AND CallingCategoryMaster.Calling_Type = 'Calling'
    AND ISNULL(ShopLatitude,'0')  <> '0'
    AND PocketMaster.Node_Cd <> 0
    AND ShopMaster.BusinessCat_Cd <> 0
    AND ShopMaster.Calling_Category_Cd <> '' 
    ORDER BY ShopMaster.AddedDate DESC;";
    // echo $query1;

    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($queryMap, $electionName, $developmentMode);

?>
<div class="container mb-0 mt-30">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div id="mapSurveyShops" style="height: 800px;width: 100%;opacity: 1;visibility: visible;"></div>
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
                      addMarkerWithTimeout(500,'<?php echo $value["Latitude"]; ?>', '<?php echo $value["Longitude"]; ?>','<?php echo $value["ShopStatus"]; ?>',<?php echo $value["Shop_Cd"]; ?>,map);
            <?php
                    }
                }
                
            ?>


            function addMarkerWithTimeout(timeout, lat, lng, shpSts, shopId,map) {
                    if(shpSts == 'Approved'){ 
                      var image = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                    }else if(shpSts == 'In-Review'){ 
                      var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                    }else if(shpSts == 'Pending'){ 
                      var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                    }else if(shpSts == 'Rejected' || shpSts == 'Non-Cooperative' || shpSts == 'Permission Denied'){ 
                      var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                    }else if(shpSts == 'Verified'){ 
                      var image = "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
                    }else{
                      var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                    }

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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap" async></script>
        <!-- <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap"  ></script> -->
    <?php
        }
    ?>