
<section id="dashboard-analytics">

<?php
    
    $db=new DbOperation();
    
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];   

    $Pocket_Cd = 0;
    $PocketName = "";
    $PocketNameMar = "";
    $Node_Cd = 0;
    $KMLFile_Url = "";
    $deActiveDate = "";
    $action = "";
    $isActive = 1;

    if(isset($_GET['Pocket_Cd']) && $_GET['Pocket_Cd'] != 0 && isset($_GET['action']) ){
        $Pocket_Cd = $_GET['Pocket_Cd'];
        $action = $_GET['action'];

        $query = "SELECT top(1) ISNULL(pm.Pocket_Cd,0) as Pocket_Cd,
                    ISNULL(pm.PocketName,'') as PocketName,
                    ISNULL(pm.PocketNameMar,'') as PocketNameMar, 
                    ISNULL(pm.Node_Cd,0) as Node_Cd,
                    ISNULL(pm.KML_FileUrl,'') as KML_FileUrl,  
                    ISNULL(pm.IsActive,0) as IsActive,
                    ISNULL(CONVERT(VARCHAR,pm.DeActiveDate,23),'') as DeActiveDate  
                    FROM PocketMaster pm 
                    WHERE pm.Pocket_Cd = $Pocket_Cd;";
                
            $PocketMasterData = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);

            if(sizeof($PocketMasterData)>0){
                $Pocket_Cd = $PocketMasterData["Pocket_Cd"];
                $PocketName = $PocketMasterData["PocketName"];
                $PocketNameMar = $PocketMasterData["PocketNameMar"];
                $Node_Cd = $PocketMasterData["Node_Cd"];
                $KMLFile_Url = $PocketMasterData["KML_FileUrl"];
                $_SESSION['SAL_KML_FileUrl'] = $KMLFile_Url;
                $deActiveDate = $PocketMasterData["DeActiveDate"];
                $isActive = $PocketMasterData["IsActive"];
                

                if(!empty($action) && $action == 'edit'){
                    $action = "Update";
                }else if(!empty($action) && $action == 'delete'){
                    $action = "Remove";
                    $isActive = 0;
                }
            }else{
                $action = "Insert";
                $Pocket_Cd = 0;
            }
    }else{
        $action = "Insert";
    } 

    
?>


<div class="row match-height">
    <div class="col-md-12">
         <div class="card">
            <div class="card-header">
                
            <h4 class="card-title">Pocket Master - <?php if(isset($Pocket_Cd) && $Pocket_Cd != 0 && $action == 'Update' ){ ?> Edit <?php } else if(isset($Pocket_Cd) && $Pocket_Cd != 0 && $action == 'Remove' ){ ?> Delete <?php }else{ ?> Add  <?php } ?></h4>
    
            </div>
        <div class="content-body">
            <div class="card-content">
                <div class="card-body">
                    <form method="post" action="action/savePocketMasterFormData.php"  enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="electionName" value="<?php echo $electionName; ?>">

                            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Pocket Name *</label>
                                    <div class="controls"> 
                                        <input type="text" name="PocketName" value="<?php echo $PocketName; ?>"  class="form-control" placeholder="Pocket Name" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Pocket Name in Marathi *</label>
                                    <div class="controls"> 
                                        <input type="text" name="PocketNameMar" value="<?php echo $PocketNameMar; ?>"  class="form-control" placeholder="Pocket Name in Marathi" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                            
                                <?php
                                    $queryWard = "SELECT ISNULL(Node_Cd,0) as Node_Cd,
                                    ISNULL(NodeName,'') as NodeName,
                                    ISNULL(NodeNameMar,'') as NodeNameMar,
                                    ISNULL(Area,'') as Area,
                                    ISNULL(Ward_No,0) as Ward_No
                                    FROM NodeMaster 
                                    WHERE ISNULL(IsActive,0) = 1 ";
                                    

                                    $dbWard=new DbOperation();
                                    $dataWard = $dbWard->ExecutveQueryMultipleRowSALData($queryWard, $electionName, $developmentMode);

                                ?>
                                <div class="form-group">
                                    <label>Ward No - Node Name *</label>
                                    <div class="controls">
                                        <select class="select2 form-control"  name="Node_Cd">
                                            <option value="">--Select--</option>
                                            <?php
                                                if (sizeof($dataWard)>0) 
                                                {
                                                    foreach ($dataWard as $key => $value) 
                                                    {
                                                        if($Node_Cd == $value["Node_Cd"])
                                                        {
                                            ?>
                                                            <option selected="true" value="<?php echo $value['Node_Cd']; ?>"><?php echo $value["Ward_No"]." - ".$value["NodeName"]; ?><?php if(!empty($value["Area"])){ echo " - ".$value["Area"];  } ?></option>
                                            <?php
                                                        }
                                                        else
                                                        {
                                            ?>
                                                            <option value="<?php echo $value["Node_Cd"];?>"><?php echo $value["Ward_No"]." - ".$value["NodeName"];?><?php if(!empty($value["Area"])){ echo " - ".$value["Area"];  } ?></option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?> 
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>KML File Url *</label>
                                    <div class="controls"> 
                                        <input type="file" name="KMLFile_Url" value="<?php echo $KMLFile_Url; ?>"  class="form-control" placeholder="KML File Url" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-xl-12 col-md-12 col-12" style="margin-top:10px;margin-bottom: 10px;">
                                
                                <?php 
                                    if(!empty($KMLFile_Url)){
                                ?>
                                    <div id="mapTreesSurvey" style="height: 500px;" ></div>
                                    <!-- <div id="capture"></div> -->

                                    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap&v=weekly" async></script>-->
                                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap&v=weekly" async></script>
                                    <script type="text/javascript">
                                     // Google Maps
                                        function initMap() {

                                            const map = new google.maps.Map(document.getElementById("mapTreesSurvey"), {
                                             
                                                mapTypeId: google.maps.MapTypeId.SATELLITE,
                                                zoom: 18,
                                            });

                                            var src = '<?php echo $KMLFile_Url; ?>';
                                        
                                            var infowindow = new google.maps.InfoWindow();

                                            var kmlLayer = new google.maps.KmlLayer(src, {
                                              suppressInfoWindows: true,
                                              preserveViewport: false,
                                              map: map
                                            });
                                            kmlLayer.addListener('click', function(event) {
                                              // var content = event.featureData.infoWindowHtml;
                                              // var testimonial = document.getElementById('capture');
                                              // testimonial.innerHTML = content;
                                              var content = "<div>" + event.featureData.infoWindowHtml + "</div>";
                                                    infowindow.setPosition(event.latLng);
                                                    infowindow.setOptions({
                                                      pixelOffset: event.pixelOffset,
                                                      content: content
                                                    });
                                                    infowindow.open(map);
                                            });
                                        }

                                    </script>

                                <?php  
                                // echo $KMLFile_Url;  
                                    }
                                ?>
                            </div>

                            <div class="col-xl-3 col-md-3 col-sm-12 col-12" style="display:none;">
                                <div class="form-group">
                                    <label>DeActive Date</label>
                                    <div class="controls"> 
                                        <input type="date" name="deActiveDate" value="<?php echo $deActiveDate; ?>"  class="form-control" placeholder="DeActive Date" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-3 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Is Pocket Active * </label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="isActive" <?php if(isset($PocketCd) && $PocketCd != 0 && $action == 'Remove' ){ ?> disabled <?php }  ?> >
                                        <option value="">--Select--</option>   
                                        <option <?php echo $isActive == '1' ? 'selected=true' : '';?>  value="1">Yes</option>
                                        <option <?php echo $isActive == '0' ? 'selected=true' : '';?>  value="0">No</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                       
                       
                       <?php if(!empty($deActiveDate)){  ?>
                             <div class="col-xs-12 col-md-6 col-xl-6  text-right"> 
                       <?php }else{ ?>
                            <div class="col-xs-12 col-md-9 col-xl-9 text-right">
                       <?php }  ?>
                        
                        
                                <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <div class="controls text-right">


                                    <input type="hidden" name="Pocket_Cd" value="<?php echo $Pocket_Cd; ?>" >
                                    <input type="hidden" name="action" value="<?php echo $action; ?>" >
                                    <div id="submitmsgsuccess" class="controls alert alert-success text-center" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailed"  class="controls alert alert-danger text-center" role="alert" style="display: none;"></div>

                                    <!-- onclick="submitPocketMasterFormData()" -->
                                    <button id="submitPocketMasterBtnId" type="submit" class="btn btn-primary"  >
                                
                                    <?php if(isset($Pocket_Cd) && $Pocket_Cd != 0 && $action == 'Update' ){ ?> Edit Pocket<?php } else if(isset($Pocket_Cd) && $Pocket_Cd != 0 && $action == 'Remove' ){ ?> Delete Pocket <?php }else{ ?> Add Pocket <?php } ?>

                                    </button>
                                </div>
                            </div>
                       
                        </div>
                    </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row match-height">
    <?php include 'datatbl/tblPocketMaster.php'; ?>
</div>


</section>
