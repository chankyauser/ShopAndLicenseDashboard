  <?php
if(isset($_GET['pocketCd'])){
        $pocketCd = $_GET['pocketCd'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else if(isset($_SESSION['SAL_Pocket_Cd'])){
        $pocketCd = $_SESSION['SAL_Pocket_Cd'];
    }else if(isset($_GET['pocketId'])){
        $pocketCd = $_GET['pocketId'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else{
        $pocketCd = "All";
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }
     
    if(isset($_GET['executiveCd'])){
        $executiveCd = $_GET['executiveCd'];
        $_SESSION['SAL_Executive_Cd'] = $executiveCd;
    }else if(isset($_SESSION['SAL_Executive_Cd'])){
        $executiveCd = $_SESSION['SAL_Executive_Cd'];
    }else{
        $executiveCd = "All";
    }
    
    // if(isset($_SESSION['SAL_Node_Name'])){
    //     $nodeName = $_SESSION['SAL_Node_Name'];
    //     if(isset($_GET['node_Name'])){
    //         $nodeName = $_GET['node_Name'];
    //         $_SESSION['SAL_Node_Name'] = $nodeName;
    //     }
    // }else {
        $nodeName = "All";
    // }

    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
        if(isset($_GET['nodeId'])){
            $nodeCd = $_GET['nodeId'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }
    }else {
        $nodeCd = "All";
    }

    $shop_Name_Post= "";
    if(isset($_SESSION['SAL_ShopName']) && !empty($_SESSION['SAL_ShopName'])){
        $shop_Name_Post = $_SESSION['SAL_ShopName'];
        $_SESSION['SAL_ShopName'] = "";
    }


    if(isset($_SESSION['SAL_ShopStatus']) && !empty($_SESSION['SAL_ShopStatus'])){
        $shop_Status_Post = $_SESSION['SAL_ShopStatus'];
        $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;
    }else{
        $shop_Status_Post = "Pending";
        $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;  
    }

    if(isset($_SESSION['SAL_SurveyStatus']) && !empty($_SESSION['SAL_SurveyStatus'])){
        $survey_Status_Post = $_SESSION['SAL_SurveyStatus'];
        $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;
    }else{
        $survey_Status_Post = "All";
        $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;  
    }

    $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
    $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];


    $dateCondition  =  " AND CONVERT(VARCHAR, ShopMaster.SurveyDate ,120) BETWEEN '$fromDate' AND '$toDate'  ";

    if($nodeCd == 'All'){
        $nodeCondition = " AND PocketMaster.Node_Cd <> 0  "; 
    }else{
        $nodeCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0  "; 
    }

    if($nodeName == 'All'){
        $nodeNameCondition = " AND NodeMaster.NodeName <> '' ";
    }else{
        $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName' ";
    }

     if($pocketCd == 'All'){
        $pcktCondition = "  ";
    }else{
        $pcktCondition = " AND ShopMaster.pocket_Cd = $pocketCd ";
    }

    if($shop_Status_Post == "All"){
        $shopStatusCondition = " AND ( ISNULL(ShopMaster.ShopStatus,'') <> '' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) "; 
    }else if($shop_Status_Post == "Pending"){
        $shopStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) "; 
    }else if($shop_Status_Post != "Pending" || $shop_Status_Post != "Rejected" || $shop_Status_Post != "Verified" || $shop_Status_Post != "In-Review"){
        $shopStatusCondition = " AND ShopMaster.ShopStatus = '$shop_Status_Post'  "; 
        $dateCondition  =  " ";
    }else{  
        $shopStatusCondition = " AND  ShopMaster.ShopStatus = '$shop_Status_Post' ";
    }
    

    if($shop_Status_Post == "All" && $survey_Status_Post == "All"){
        $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)  "; 
    }else if($shop_Status_Post == "All" && $survey_Status_Post == "Pending"){
        $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NULL  AND ISNULL(ShopMaster.ShopStatus,'') = '' )       "; 
    }else if($shop_Status_Post == "All" && $survey_Status_Post == "Completed"){
        // $dateCondition = " "; 
        $surveyStatusCondition = " AND ( ShopMaster.SurveyDate IS NOT NULL  OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster
                WHERE IsActive = 1) )       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "All"){
        $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "Pending"){
        $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND (  ShopMaster.SurveyDate IS NULL)       "; 
    }else if($shop_Status_Post == "Pending" && $survey_Status_Post == "Completed"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' OR ISNULL(ShopMaster.ShopStatus,'') = '' ) AND (  ShopMaster.SurveyDate IS NOT NULL)       "; 
    }else if(( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "All"){
        $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' ) AND ( ShopMaster.SurveyDate IS NOT NULL OR ShopMaster.SurveyDate IS NULL)       "; 
    }else if(( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "Pending"){
        $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post' ) AND (  ShopMaster.SurveyDate IS NULL)       "; 
    }else if( ( $shop_Status_Post != "Pending" && $shop_Status_Post != "All") && $survey_Status_Post == "Completed"){
        // $dateCondition = " "; 
        $shopStatusCondition = "";
        $surveyStatusCondition = " AND ( ShopMaster.ShopStatus = '$shop_Status_Post'  ) AND (  ShopMaster.SurveyDate IS NOT NULL)       "; 
    }

 



    $db2=new DbOperation();
    $query1 = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1 $dateCondition
    $shopStatusCondition
    $pcktCondition  
    $executiveCondition  
    
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    
    $nodeCondition
    $nodeNameCondition
    AND ISNULL(ShopLatitude,'0')  <> '0'
    ORDER BY ShopMaster.SurveyDate ASC ;";
    // echo $query1;
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?>
            <script type="text/javascript">
                // Google Maps
                

                function initMap() {

                    <?php  
                           $centerLat  = $pocketShopsSurveyMapAndListDetail[0]["Latitude"];
                           $centerLng  = $pocketShopsSurveyMapAndListDetail[0]["Longitude"];
                    ?>
                    
                    var marker;
                    var infowindow = new google.maps.InfoWindow();

                    const map = new google.maps.Map(document.getElementById("mapPocketShops"), {
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


                function addMarkerWithTimeout(timeout, lat, lng, shpSts, shopCd,map) {

            // window.setTimeout(function() {
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
                        var electionName = document.getElementsByName('electionName')[0].value;
                        // console.log(electionName);
                        if (electionName === '') {
                            alert("Select Corporation!!");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: 'setShopSurveyMapContent.php',
                                data: {
                                    electionName: electionName,
                                    shopCd: shopCd
                                },
                                beforeSend: function() { 
                                   
                                },
                                success: function(dataResult) {
                                    var content = dataResult;
                                    infowindow.setContent(content);
                                    infowindow.open(map, marker);
                                   
                                    // return data;
                                },
                                complete: function() {
                                        
                                    }
                                    //,
                                    // error: function () {
                                    //    alert('Error occured');
                                    // }
                            });
                        }
                    
                });
                
                
            // if (marker && marker.setMap) {
                    // marker.setMap(null);
                  // }
                                
            // }, timeout);
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