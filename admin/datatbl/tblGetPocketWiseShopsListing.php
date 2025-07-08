<?php
  

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


    $db2=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

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
    } ;

    $queryTotal = "SELECT 
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL $nodeCondition $nodeNameCondition  ),0) as ShopListed,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) $nodeCondition $nodeNameCondition  ),0) as SurveyPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) $nodeCondition $nodeNameCondition  ),0) as SurveyAll,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) $nodeCondition $nodeNameCondition  ),0) as SurveyDocumentDenied,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Permanently Closed') $nodeCondition $nodeNameCondition  ),0) as PC,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Permission Denied') $nodeCondition $nodeNameCondition  ),0) as PD,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1 AND ShopStatus = 'Non-Cooperative') $nodeCondition $nodeNameCondition  ),0) as NC,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.ShopStatus,'') = 'Verified' $nodeCondition $nodeNameCondition  ),0) as DocumentReceived,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ISNULL(ShopMaster.ShopStatus,'') = '' $nodeCondition $nodeNameCondition  ),0) as SurveyDocumentPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ISNULL(ShopMaster.ShopStatus,'') = 'Pending' $nodeCondition $nodeNameCondition  ),0) as DocumentPending,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.ShopStatus,'') = 'In-Review' $nodeCondition $nodeNameCondition  ),0) as DocumentInReview,
    ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ISNULL(ShopMaster.ShopStatus,'') = 'Rejected' $nodeCondition $nodeNameCondition ),0) as DocumentRejected;";
    // echo $queryTotal;
    $db1=new DbOperation();
    $surveyTotalData = $db1->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 

    // print_r($surveyTotalData);

    $queryMap = "SELECT ISNULL(ShopMaster.Shop_Cd,0) as Shop_Cd, 
    ISNULL(ShopMaster.ShopLatitude,'0') as Latitude,
    ISNULL(ShopMaster.ShopLongitude,'0') as Longitude,
    ISNULL(ShopMaster.ShopStatus,'') as ShopStatus
    FROM ShopMaster 
    INNER JOIN PocketMaster ON ( ShopMaster.pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1  )
    INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd
    WHERE ShopMaster.IsActive = 1 
    $nodeCondition
    $nodeNameCondition
    AND ISNULL(ShopLatitude,'0')  <> '0' 
    ORDER BY ShopMaster.AddedDate DESC;";
    // echo $query1;
    $pocketShopsSurveyMapAndListDetail = $db2->ExecutveQueryMultipleRowSALData($queryMap, $electionName, $developmentMode);

    $queryPocketKML = "SELECT COALESCE(PocketMaster.Pocket_Cd, 0) as Pocket_Cd,
        COALESCE(PocketMaster.PocketName, '') as PocketName,
        COALESCE(PocketMaster.KML_FileUrl, '') as KML_FileUrl
        FROM PocketMaster 
        INNER JOIN ShopMaster ON ( PocketMaster.Pocket_Cd = ShopMaster.Pocket_Cd AND ShopMaster.IsActive = 1 )
        INNER JOIN NodeMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd
        WHERE PocketMaster.IsActive = 1 AND COALESCE(PocketMaster.KML_FileUrl, '') <> ''
        $nodeCondition
        $nodeNameCondition
        GROUP BY PocketMaster.Pocket_Cd, PocketMaster.PocketName, PocketMaster.KML_FileUrl
        ORDER BY PocketMaster.Pocket_Cd DESC;";
    $dataPocketSummary = $db2->ExecutveQueryMultipleRowSALData($queryPocketKML, $electionName, $developmentMode);
   
?>

    <div class="row">

        <div class="col-lg-2 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["ShopListed"]); ?></h2>
                        <h6>Shops Listed </h6>
                    </div>
                    <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-map-pin font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyAll"]); ?></h2>
                        <h6>Shops Surveyed </h6>

                        <!-- <label>PC - </label><b><?php echo IND_money_format($surveyTotalData["PC"]); ?></b>
                        <label> PD - </label><b><?php echo IND_money_format($surveyTotalData["PD"]); ?></b>
                        <label> NC - </label><b><?php echo IND_money_format($surveyTotalData["NC"]); ?></b>  -->
                        
                    </div>
                    <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-check-circle font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyPending"]); ?></h2>
                        <h6>Shops Survey Pending </h6>
                    </div>
                    <div class="avatar p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-activity  font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDocumentDenied"]); ?>  </h2>
                        <label>Documents Denied </label> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;

                        <label>PC - </label><b><?php echo IND_money_format($surveyTotalData["PC"]); ?></b>
                        <label> PD - </label><b><?php echo IND_money_format($surveyTotalData["PD"]); ?></b>
                        <label> NC - </label><b><?php echo IND_money_format($surveyTotalData["NC"]); ?></b> 
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card bg-rgba-success">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["DocumentReceived"]); ?></h2>
                        <h6>Documents Received</h6>
                    </div>
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <!-- <i class="feather icon-square-check text-success font-medium-5"></i> -->
                            <img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png" class="font-medium-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card bg-rgba-yellow">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDocumentPending"]); ?></h2>
                        <h6>Documents Pending </h6>
                    </div>
                    <div class="avatar bg-rgba-yellow p-50 m-0">
                        <div class="avatar-content">
                            <!-- <i class="feather icon-activity text-yellow font-medium-5"></i> -->
                            <img src="https://maps.google.com/mapfiles/ms/icons/yellow-dot.png" class="font-medium-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card bg-rgba-danger">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDocumentDenied"]); ?></h2>
                        <h6>Documents Denied </h6>
                    </div>
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <!-- <i class="feather icon-alert-triangle text-warning font-medium-5"></i> -->
                            <img src="https://maps.google.com/mapfiles/ms/icons/red-dot.png" class="font-medium-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card bg-rgba-warning">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format(($surveyTotalData["DocumentPending"]+$surveyTotalData["DocumentInReview"])); ?></h2>
                        <h6>Documents In-Review </h6>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <!-- <i class="feather icon-alert-triangle text-warning font-medium-5"></i> -->
                            <img src="https://maps.google.com/mapfiles/ms/icons/orange-dot.png" class="font-medium-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <!--       <div class="col-lg-3 col-sm-6 col-12">
            <div class="card bg-rgba-info">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["DocumentRejected"]); ?></h2>
                        <h6>Documents Rejected </h6>
                    </div>
                    <div class="avatar bg-rgba-info p-50 m-0">
                        <div class="avatar-content">
                            <img src="https://maps.google.com/mapfiles/ms/icons/blue-dot.png" class="font-medium-5">
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
    </div>


    <div class="row">
        <div class="col-md-12">
    
               <!--  <div class="card-header">
                    <h4 class="card-title">Node : <?php //echo $_SESSION['SAL_Node_Name']; ?> &nbsp;&nbsp;&nbsp; Pocket : <?php //if($pocketCd != 'All'){ echo $dataPocket["PocketName"]; }else{ echo "All"; } ?> &nbsp;&nbsp;&nbsp; Supervisor : <?php //if($executiveCd != 'All'){ echo $dataSupervisor["ExecutiveName"]; }else{ echo "All"; } ?> - (<?php //echo sizeof($pocketShopsSurveyMapAndListDetail); ?>)</h4>

                    <h4 class="card-title" style="margin-right:15px;"><?php //if(isset($_SESSION['SAL_Ward_No'])){ echo "Ward No : ".$_SESSION['SAL_Ward_No']; } ?></h4>
                </div> -->

     
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'mapIcon' ){ ?> active <?php } else{ ?>  <?php } }else{ ?> active <?php } ?> " id="mapIcon-tab" data-toggle="tab" href="#mapIcon" aria-controls="home" role="tab" aria-selected="true"> <i class="feather icon-map"></i> Map View  </a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'listIcon' ){ ?> active <?php } else{ ?>  <?php } }else{ ?>  <?php } ?>  " id="listIcon-tab" data-toggle="tab" href="#listIcon" aria-controls="profile" role="tab" aria-selected="false"><i class="feather icon-list"></i> List View</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane  <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'mapIcon' ){ ?> active <?php } else{ ?>  <?php } }else{ ?> active <?php } ?> " id="mapIcon" aria-labelledby="mapIcon-tab" role="tabpanel">
                                 <div class="row">
                                    <div class="col-md-3">
                                        <?php include 'dropdown-nodecd-and-wardno-listing.php'; ?>
                                    </div>
                                    <div class="col-md-9">
                                    </div>
                                    <div class="col-md-12">
                                        <div id="mapPocketShops" style="margin-top: 15px;" class="height-500"></div>
                                    </div>
                                </div>
                                    
                           

                            </div>
                            <div class="tab-pane <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'listIcon' ){ ?> active <?php } else{ ?>  <?php } }else{ ?>  <?php } ?>  " id="listIcon" aria-labelledby="listIcon-tab" role="tabpanel">
                                <div  id="tblPocketsShopList"> 

                                    <?php include 'datatbl/tblShopsListingDetailData.php'; ?>
                                    
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
                                            if(shpSts == 'Rejected'){ 
                                              var image = "https://maps.google.com/mapfiles/ms/icons/pink-dot.png";
                                            }else if(shpSts == 'In-Review'){ 
                                              var image = "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                                            }else if(shpSts == 'Pending'){ 
                                              var image = "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
                                            }else if(shpSts == 'Permission Denied' || shpSts == 'Non-Cooperative' || shpSts == 'Permanently Closed'){ 
                                              var image = "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
                                            }else if(shpSts == 'Verified'){ 
                                              var image = "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
                                            }else{
                                              var image = "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
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

        </div>
    </div>

