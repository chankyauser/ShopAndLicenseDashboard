<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include 'api/includes/DbOperation.php';

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

  
    
    if(!isset($_SESSION['SAL_Node_Name'])){
        $_SESSION['SAL_Node_Name'] = "All";
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = $_SESSION['SAL_Node_Name'];
    }

    if(!isset($_SESSION['SAL_Node_Cd'])){
        $_SESSION['SAL_Node_Cd'] = "All";
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    
    if(!isset($_SESSION['SAL_Document_Status'])){
        $_SESSION['SAL_Document_Status'] = "All";
        $documentStatus = $_SESSION['SAL_Document_Status'];
    }else{
        $documentStatus = $_SESSION['SAL_Document_Status'];
    }

   if($nodeName == "All"){
        $nodeNameCondition = "  ";
    }else{
        $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName'  ";   
    }

    if($nodeCd != "All"){
        $nodeCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0 ";
    }else{
        $nodeCondition = " AND PocketMaster.Node_Cd <> 0  ";
    }

    $dataNodeName = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
        ISNULL(NodeMaster.NodeName,'') as NodeName,
        ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar
        FROM NodeMaster 
        INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
        INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
        WHERE NodeMaster.IsActive = 1 
        GROUP BY NodeMaster.NodeName, NodeMaster.NodeNameMar
        ORDER BY NodeMaster.NodeName";
    $db=new DbOperation();
    $dataNodeName = $db->ExecutveQueryMultipleRowSALData($dataNodeName, $electionName, $developmentMode);
    // print_r($dataNodeName);

    $queryNode = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
            ISNULL(NodeMaster.Node_Cd,0) as Node_Cd,
            ISNULL(NodeMaster.NodeName,'') as NodeName,
            ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar,
            ISNULL(NodeMaster.Ac_No,0) as Ac_No,
            ISNULL(NodeMaster.Ward_No,0) as Ward_No,
            ISNULL(NodeMaster.Address,'') as Address,
            ISNULL(NodeMaster.Area,'') as Area
            FROM NodeMaster 
            INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
            INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
            WHERE NodeMaster.IsActive = 1 
            $nodeNameCondition
            GROUP BY NodeMaster.Node_Cd, NodeMaster.NodeName,
            NodeMaster.NodeNameMar, NodeMaster.Ac_No,
            NodeMaster.Ward_No, NodeMaster.Address, NodeMaster.Area
            ORDER BY NodeMaster.Ward_No";
    $db=new DbOperation();
    $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
      

    $queryPocketKML = "SELECT COALESCE(PocketMaster.Pocket_Cd, 0) as Pocket_Cd,
        COALESCE(PocketMaster.PocketName, '') as PocketName,
        COALESCE(PocketMaster.KML_FileUrl, '') as KML_FileUrl
        FROM PocketMaster
        INNER JOIN ShopMaster
        ON PocketMaster.Pocket_Cd = ShopMaster.Pocket_Cd AND ShopMaster.IsActive = 1
        INNER JOIN NodeMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd
        WHERE PocketMaster.IsActive = 1 AND COALESCE(PocketMaster.KML_FileUrl, '') <> ''
        $nodeNameCondition
        $nodeCondition
        GROUP BY PocketMaster.Pocket_Cd, PocketMaster.PocketName, PocketMaster.KML_FileUrl
        ORDER BY PocketMaster.Pocket_Cd DESC;";
    $dataPocketSummary = $db2->ExecutveQueryMultipleRowSALData($queryPocketKML, $electionName, $developmentMode);

    $queryMap = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd 
    AND PocketMaster.IsActive = 1 
    --AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified'
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    $nodeNameCondition
    $nodeCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate DESC;";
    // echo $queryMap;

    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($queryMap, $electionName, $developmentMode);


    $dbelec=new DbOperation();
    $dataElectionName = $dbelec->getSALCorporationElectionData($appName, $developmentMode);
    // die();
?>
<div class="container mb-0 mt-30">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Election Name</label>
                        <select class="form-control" onchange="setElectionHeaderNameInSession(this.value)">
                            <?php 
                                foreach ($dataElectionName as $key => $valueElectionName) {
                                    if($electionName==$valueElectionName["ElectionName"]){
                            ?>
                                        <option selected value="<?php echo $valueElectionName["ElectionName"]; ?>"><?php echo "".$valueElectionName["ElectionName"]; ?></option>
                            <?php
                                    }else{
                                ?>
                                        <option value="<?php echo $valueElectionName["ElectionName"]; ?>"><?php echo "".$valueElectionName["ElectionName"]; ?></option>
                            <?php            
                                    }
                                }
                            ?>  
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Zone</label>
                        <select class="form-control" name="nodeName" onchange="setNodeNameInSession(this.value)">
                            <option value="All">All Zone </option>
                            <?php 
                                foreach ($dataNodeName as $key => $valueNodeName) {
                                    if($nodeName==$valueNodeName["NodeName"]){
                            ?>
                                        <option selected value="<?php echo $valueNodeName["NodeName"]; ?>"><?php echo "".$valueNodeName["NodeName"]; ?></option>
                            <?php
                                    }else{
                                ?>
                                        <option value="<?php echo $valueNodeName["NodeName"]; ?>"><?php echo "".$valueNodeName["NodeName"]; ?></option>
                            <?php            
                                    }
                                }
                            ?>  
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-md-3 col-12" >
                    <div class="form-group">
                        <label>Ward</label>
                        <select class="form-control" name="nodeCd" onchange="setNodeCdAndWardNoInSession(this.value)">
                            <option value="All">All Ward </option>
                            <?php 
                                foreach ($dataNode as $key => $valueNode) {
                                    if($nodeCd==$valueNode["Node_Cd"]){
                            ?>
                                        <option selected value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                            <?php
                                    }else{
                                ?>
                                        <option value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                            <?php            
                                    }
                                }
                            ?>  
                        </select>
                    </div>
                </div>
                <div class="col-12 col-xl-12">
                    <div id="mapSurveyShops" style="height: 800px;width: 100%;opacity: 1;visibility: visible;"></div>
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