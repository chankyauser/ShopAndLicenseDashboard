<style type="text/css">
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
  /*  table.dataTable th{
        display: block;
    }*/
    .nav.nav-pills .nav-item .nav-link {
        font-size: 1.2rem;
        color: #C90D41;
        font-weight: 900;
    }
</style>

<?php 

 
?>
<div class="col-12 col-sm-12">
    <fieldset>
        <legend><b><?php echo $srNo.") "; ?>  <?php echo $getShopName." - ".$getCall_DateTime." - ".$getExecutiveName; ?></b></legend>
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-5">
                <div class="row">
                   
                    <div class="media-body my-10px col-md-9" style="margin-top: 10px;">
                        <h6>    
                            <b><?php echo $getShopNameMar; ?></b> 
                        </h6>
                        <h6><b><?php echo $getShopKeeperName; ?> - <?php echo $getShopKeeperMobile; ?></b></h6>
                        
                        
                        <h6><?php echo $getNature_of_Business; ?></h6>
                        <h6><?php echo "Pocket : ".$getPocketName.", Ward : ".$getWardNo.", ".$getWardArea.", ".$getNodeName; ?></h6>
                        <h6><?php echo $getShopAddress_1." ".$getShopAddress_2; ?></h6>
                        
                        
                    </div>
                    
                    <div class="avatar mr-75 col-md-3">
                        <?php if($getShopOutsideImage1 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage1; ?>" title="Outside Image 1" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        <?php } else { ?>   
                            <img src="pics/shopDefault.jpeg" class="rounded galleryimg" title="Outside Image 1" width="150" height="150" alt="Avatar" />
                        <?php } ?>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="row">
                    <?php if($getShopOutsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage1 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage1; ?>" title="Inside Image 1" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage2; ?>" title="Inside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-3 text-right" >
                <div class="media">
                    <div class="media-body my-10px">
                        <h5>
                            <?php if(!empty($getShopStatus)) { ?> 
                                    <b style="color:<?php echo $getShopStatusTextColor; ?>;"><?php echo $getShopStatus; ?></b>
                                    <i class="<?php echo $getShopStatusFaIcon; ?>" style="color:<?php echo $getShopStatusTextColor; ?>;font-size:22px"></i>
                            <?php } ?>
                        </h5>
                        <h6><?php echo "<b>Shop Listed : </b>  ".$getAddedDate; ?></h6>
                        <h6><?php if(!empty($getSurveyDate)){ echo "<b>Survey Date : </b>".$getSurveyDate; }  ?></h6>
                        <h6><?php if(!empty($getShopStatusDate)){ echo "<b>Status Date : </b>".$getShopStatusDate; }  ?></h6>
                  
                        <?php 
             

                            foreach ($qcTypeArray as $key => $value) {
                                $qc_Type_Data = $value["QC_Type"];
                                    $queryQCDet = "SELECT 
                                        QC_Flag, QC_Type, 
                                        ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                                    FROM QCDetails
                                    WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qc_Type_Data'
                                    GROUP BY QC_Flag, QC_Type;";
                                   // echo $queryQCDet;
                                $shopQCDetailsData = $db->ExecutveQuerySingleRowSALData($queryQCDet, $electionName, $developmentMode);
                                    if(sizeof($shopQCDetailsData)>0){ 
                            ?>
                                        <span class="badge badge-success"><?php echo $value["QC_Title"]." QC on ".$shopQCDetailsData["MaxQCDateTime"]; ?></span>
                            <?php
                                    }
                            }

                        ?>
                        
                    </div>

                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12" style="margin-top: 10px;" >
                 <ul class="nav nav-pills" >

                    <?php 
                         $callingInfoQuery = "SELECT
                            ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
                            ISNULL(cd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                            ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
                            ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
                            ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
                            ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
                            ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
                            ISNULL(cd.AudioDuration,'') as AudioDuration, 
                            ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
                            ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
                            ISNULL(cd.GoodCall,0) as GoodCall, 
                            ISNULL(cd.QC_Flag,0) as QC_Flag, 
                            ISNULL(CONVERT(VARCHAR,cd.QC_UpdatedDate,100),'') as QC_UpdatedDate, 
                            ISNULL(cd.Appreciation,0) as Appreciation, 
                            ISNULL(cd.AudioListen,0) as AudioListen, 
                            ISNULL(ccm.Calling_Category,'') as Calling_Category,
                            ISNULL(ccm.QC_Type,'') as QC_Type,
                            ISNULL(crm.Call_Response,'') as Call_Response,

                            ISNULL((SELECT top (1) QC_Remark1 FROM QCDetails 
                              WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = cd.Calling_Cd AND ScheduleCall_Cd = cd.ScheduleCall_Cd AND QC_Type = '$qcType' 
                              ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
                            ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                              WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = cd.Calling_Cd AND ScheduleCall_Cd = cd.ScheduleCall_Cd AND QC_Type = '$qcType' 
                              ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
                            ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                              WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = cd.Calling_Cd AND ScheduleCall_Cd = cd.ScheduleCall_Cd AND QC_Type = '$qcType' 
                              ORDER BY QC_DateTime DESC ),'') as QC_Remark3
                            FROM CallingDetails cd
                            INNER JOIN ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd AND 
                                cd.Calling_Cd in ( $Calling_Cds ) AND cd.Shop_Cd = $Shop_Cd 
                            )
                            INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
                            INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd;";

                            // echo $callingInfoQuery;
                            $shopCallingScheduleData = $db->ExecutveQueryMultipleRowSALData($callingInfoQuery, $electionName, $developmentMode);
                            // print_r($shopCallingScheduleData);
                    
                            foreach ($shopCallingScheduleData as $key => $valueCalling) {
                                $getAudioFile_Url = $valueCalling["AudioFile_Url"];
                                $getAudioDuration = $valueCalling["AudioDuration"];
                                $getGoodCall = $valueCalling["GoodCall"];
                                $getAppreciation = $valueCalling["Appreciation"];
                                $getAudioListen = $valueCalling["AudioListen"];
                            }

                    ?>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center active" id="shop-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#shop-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="shop-calling-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-headphones mr-25"></i>
                            <span class="d-none d-sm-block">Shop Calling QC</span>
                        </a>
                    </li>

                    <?php 
                        foreach ($shopCallingScheduleData as $key => $valueCallingSchedule) {
                            $getScheduleQCType = $valueCallingSchedule["QC_Type"];
                            $getCalling_Category = $valueCallingSchedule["Calling_Category"];

                            if($getScheduleQCType == "ShopSurvey"){
                    ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center " id="survey-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#survey-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="survey-calling-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                    <i class="feather icon-edit mr-25"></i>
                                    <span class="d-none d-sm-block"><?php echo $getCalling_Category; ?> QC</span>
                                </a>
                            </li>
                    <?php   
                            }else if($getScheduleQCType == "ShopDocument"){
                    ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center " id="document-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#document-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="document-calling-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                    <i class="feather icon-edit mr-25"></i>
                                    <span class="d-none d-sm-block"><?php echo $getCalling_Category; ?> QC</span>
                                </a>
                            </li>
                    <?php   
                            }
                        }
                    ?>
                    
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center " id="schedule-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#schedule-info-<?php echo $Shop_Cd; ?>" aria-controls="schedule-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-clock mr-25"></i>
                            <span class="d-none d-sm-block">Schedule / Reschedule</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center " id="shop-status-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#shop-status-info-<?php echo $Shop_Cd; ?>" aria-controls="shop-status-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-check-circle mr-25"></i>
                            <span class="d-none d-sm-block">Application Status</span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content">
                    
                    <div class="tab-pane active" id="shop-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="shop-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">
                        <div class="row">        
                            
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                <label>Audio File</label>
                                    <div class="controls"> 
                                        <?php 
                                            if(!empty($getAudioFile_Url)){
                                        ?>
                                            <audio controls preload="none">
                                                <source src="<?php echo $getAudioFile_Url; ?>" type="audio/mpeg" />
                                            </audio>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                <label>Audio Listen </label><label style="color:red;">*</label>
                                    <div class="controls"> 
                                        <select class="select2 form-control" name="<?php echo $Calling_Cd_s; ?>_AudioListen" required>
                                            <option  value="">--Select--</option>   
                                            <option <?php echo $getAudioListen == '1' ? 'selected=true' : '';?> value="1">Yes</option>   
                                            <option <?php echo $getAudioListen == '0' ? 'selected=true' : '';?> value="0">No</option>   
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Good Call </label><label style="color:red;">*</label>
                                        <select class="select2 form-control" name="<?php echo $Calling_Cd_s; ?>_GoodCall"  required>
                                            <option  value="">--Select--</option>   
                                            <option <?php echo $getGoodCall == '1' ? 'selected=true' : '';?> value="1">Yes</option>   
                                            <option <?php echo $getGoodCall == '0' ? 'selected=true' : '';?> value="0">No</option>   
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label>Appreciate Call</label><label style="color:red;">*</label>
                                    <div class="controls"> 
                                        <select class="select2 form-control" name="<?php echo $Calling_Cd_s; ?>_AppreciationCall" required>
                                            <option  value="">--Select--</option>   
                                            <option <?php echo $getAppreciation == '1' ? 'selected=true' : '';?> value="1">Yes</option>   
                                            <option <?php echo $getAppreciation == '0' ? 'selected=true' : '';?> value="0">No</option> 
                                        </select>
                                    </div>
                                </div>
                            </div>


                             <div class="col-12 col-sm-12 col-md-2 text-right" style="margin-top:30px;">
                                <div class="form-group">
                                    <div class="controls">
                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <button type="button" id="<?php echo $Calling_Cd_s; ?>_btnShopCallingQCId" onclick="saveShopCallingQCFormData(<?php echo $Calling_Cd_s; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                <input type="hidden" name="<?php echo $Calling_Cd_s; ?>_Calling_Ids" value="<?php echo $Calling_Cd_s; ?>">
                                <input type="hidden" name="<?php echo $Calling_Cd_s; ?>_QCTypeCall" value="<?php echo $qcType; ?>">
                                <input type="hidden" name="<?php echo $Calling_Cd_s; ?>_QCFlagCall" value="4">
                                <div id="<?php echo $Calling_Cd_s; ?>_submitmsgsuccessCall" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                <div id="<?php echo $Calling_Cd_s; ?>_submitmsgfailedCall"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                            </div>

                        </div>

                    </div>

                <?php 


                   $ScheduleCall_Cd = 0;
                   $Calling_Cd = 0;

                    foreach ($shopCallingScheduleData as $key => $valueCallingSchedule) {
                        $Shop_Cd = $valueCallingSchedule["Shop_Cd"];
                        $ScheduleCall_Cd = $valueCallingSchedule["ScheduleCall_Cd"];
                        $Calling_Cd = $valueCallingSchedule["Calling_Cd"];
                        $getScheduleQCType = $valueCallingSchedule["QC_Type"];
                        $getCalling_Category = $valueCallingSchedule["Calling_Category"];

                        if($getScheduleQCType == "ShopSurvey"){

                            $callingDataInfoQuery = "SELECT
                                ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
                                ISNULL(cd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                                ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
                                ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
                                ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
                                ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
                                ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
                                ISNULL(cd.AudioDuration,'') as AudioDuration, 
                                ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
                                ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
                                ISNULL(cd.GoodCall,0) as GoodCall, 
                                ISNULL(cd.QC_Flag,0) as QC_Flag, 
                                ISNULL(CONVERT(VARCHAR,cd.QC_UpdatedDate,100),'') as QC_UpdatedDate, 
                                ISNULL(cd.Appreciation,0) as Appreciation, 
                                ISNULL(cd.AudioListen,0) as AudioListen, 

                                ISNULL(sm.Shop_UID,'') as Shop_UID,
                                COALESCE(sm.ShopName, '') as ShopName, 
                                COALESCE(sm.ShopNameMar, '') as ShopNameMar, 

                                COALESCE(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
                                COALESCE(sam.ShopAreaName, '') as ShopAreaName, 
                                COALESCE(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
                                COALESCE(sm.ShopCategory, '') as ShopCategory, 

                                ISNULL(pm.PocketName,'') as PocketName,
                                ISNULL(nm.NodeName,'') as NodeName,
                                ISNULL(nm.Ward_No,0) as Ward_No,
                                ISNULL(nm.Area,'') as WardArea,

                                COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
                                COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 

                                COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
                                COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile,

                                COALESCE(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
                                COALESCE(CONVERT(VARCHAR, sm.SurveyDate, 100), '') as SurveyDate, 

                                ISNULL(sm.QC_Flag,0) as Shop_QC_Flag, 
                                ISNULL(CONVERT(VARCHAR,sm.QC_UpdatedDate,100),'') as Shop_QC_UpdatedDate, 

                                COALESCE(sm.LetterGiven, '') as LetterGiven, 
                                COALESCE(sm.IsCertificateIssued, 0) as IsCertificateIssued, 
                                COALESCE(CONVERT(VARCHAR, sm.RenewalDate, 105), '') as RenewalDate, 
                                COALESCE(sm.ParwanaDetCd, 0) as ParwanaDetCd, 

                                COALESCE(ccm.Calling_Category,'') as Calling_Category,

                                COALESCE(sm.ConsumerNumber, '') as ConsumerNumber, 

                                COALESCE(sm.ShopOwnStatus, '') as ShopOwnStatus, 
                                COALESCE(sm.ShopOwnPeriod, 0) as ShopOwnPeriod, 
                                COALESCE(sm.ShopOwnerName, '') as ShopOwnerName, 
                                COALESCE(sm.ShopOwnerMobile, '') as ShopOwnerMobile, 
                                COALESCE(sm.ShopContactNo_1, '') as ShopContactNo_1, 
                                COALESCE(sm.ShopContactNo_2, '') as ShopContactNo_2,
                                COALESCE(sm.ShopEmailAddress, '') as ShopEmailAddress, 
                                COALESCE(sm.ShopOwnerAddress, '') as ShopOwnerAddress,

                                COALESCE(sm.MaleEmp, '') as MaleEmp,
                                COALESCE(sm.FemaleEmp, '') as FemaleEmp,
                                COALESCE(sm.OtherEmp, '') as OtherEmp,
                                COALESCE(sm.ContactNo3, '') as ContactNo3,
                                COALESCE(sm.GSTNno, '') as GSTNno,

                                COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
                                COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
                                COALESCE(sm.ShopInsideImage1,'') as ShopInsideImage1, 
                                COALESCE(sm.ShopInsideImage2,'') as ShopInsideImage2,

                                COALESCE(sm.ShopDimension, '') as ShopDimension, 

                                COALESCE(sm.ShopStatus, '') as ShopStatus, 
                                COALESCE(stm.TextColor, '') as ShopStatusTextColor, 
                                COALESCE(stm.FaIcon, '') as ShopStatusFaIcon, 
                                COALESCE(stm.IconUrl, '') as ShopStatusIconUrl, 
                                COALESCE(CONVERT(VARCHAR, sm.ShopStatusDate, 100), '') as ShopStatusDate, 
                                COALESCE(sm.ShopStatusRemark, '') as ShopStatusRemark, 

                                COALESCE(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
                                COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
                                COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar,

                                ISNULL(ccm.Calling_Category,'') as Calling_Category,
                                ISNULL(ccm.QC_Type,'') as QC_Type,
                                ISNULL(crm.Call_Response,'') as Call_Response,

                                ISNULL((SELECT top (1) QC_Remark1 FROM QCDetails 
                                  WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = 'ShopSurvey' 
                                  ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
                                ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                                  WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = 'ShopSurvey' 
                                  ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
                                ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                                  WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = 'ShopSurvey' 
                                  ORDER BY QC_DateTime DESC ),'') as QC_Remark3
                                FROM CallingDetails cd
                                INNER JOIN ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd AND 
                                    cd.Calling_Cd in ( $Calling_Cd ) AND cd.Shop_Cd = $Shop_Cd 
                                )
                                LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
                                INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                                INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
                                INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
                                LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) ;";

                                // echo $callingDataInfoQuery;
                                $ShopCallingDataEdit = $db->ExecutveQuerySingleRowSALData($callingDataInfoQuery, $electionName, $developmentMode);
                                // echo sizeof($ShopCallingDataEdit );
                                // print_r($ShopCallingDataEdit);

                                $ScheduleCall_Cd = $ShopCallingDataEdit["ScheduleCall_Cd"];
                                $Calling_Cd = $ShopCallingDataEdit["Calling_Cd"];
                                $Shop_Cd = $ShopCallingDataEdit["Shop_Cd"];


                                $getShopName = $ShopCallingDataEdit["ShopName"];
                                $getShopNameMar = $ShopCallingDataEdit["ShopNameMar"];

                                $getShopArea_Cd = $ShopCallingDataEdit["ShopArea_Cd"];
                                $getShopAreaName = $ShopCallingDataEdit["ShopAreaName"];
                                $getShopCategory = $ShopCallingDataEdit["ShopCategory"];

                                $getPocketName = $ShopCallingDataEdit["PocketName"];
                                $getNodeName = $ShopCallingDataEdit["NodeName"];
                                $getWardNo = $ShopCallingDataEdit["Ward_No"];
                                $getWardArea = $ShopCallingDataEdit["WardArea"];

                                $getShopAddress_1 = $ShopCallingDataEdit["ShopAddress_1"];
                                $getShopAddress_2 = $ShopCallingDataEdit["ShopAddress_2"];

                                $getShopKeeperName = $ShopCallingDataEdit["ShopKeeperName"];
                                $getShopKeeperMobile = $ShopCallingDataEdit["ShopKeeperMobile"];


                                $getAddedDate = $ShopCallingDataEdit["AddedDate"];
                                $getSurveyDate = $ShopCallingDataEdit["SurveyDate"];



                                $getQC_Flag = $ShopCallingDataEdit["QC_Flag"];
                                $getQC_UpdatedDate = $ShopCallingDataEdit["QC_UpdatedDate"];



                                $getLetterGiven = $ShopCallingDataEdit["LetterGiven"];
                                $getIsCertificateIssued = $ShopCallingDataEdit["IsCertificateIssued"];
                                $getRenewalDate = $ShopCallingDataEdit["RenewalDate"];
                                $getParwanaDetCd = $ShopCallingDataEdit["ParwanaDetCd"];



                                $getConsumerNumber = $ShopCallingDataEdit["ConsumerNumber"];

                                $getShopOwnStatus = $ShopCallingDataEdit["ShopOwnStatus"];
                                $getShopOwnPeriod = $ShopCallingDataEdit["ShopOwnPeriod"];

                                if($getShopOwnPeriod == 0){
                                $getShopOwnPeriodYrs = 0;
                                $getShopOwnPeriodMonths = 0;
                                }else if($getShopOwnPeriod < 12){
                                $getShopOwnPeriodYrs = 0;
                                $getShopOwnPeriodMonths = $getShopOwnPeriod;
                                }else if($getShopOwnPeriod == 12){
                                $getShopOwnPeriodYrs = 1;
                                $getShopOwnPeriodMonths = 0;
                                }else if($getShopOwnPeriod > 12){
                                $yrMonthVal = $getShopOwnPeriod / 12;
                                $yrMonthValArr = explode(".", $yrMonthVal);
                                $getShopOwnPeriodYrs = $yrMonthValArr[0];
                                $getShopOwnPeriodMonths = ( $getShopOwnPeriod - ($yrMonthValArr[0] * 12) );
                                }


                                $getShopOwnerName = $ShopCallingDataEdit["ShopOwnerName"];
                                $getShopOwnerMobile = $ShopCallingDataEdit["ShopOwnerMobile"];
                                $getShopContactNo_1 = $ShopCallingDataEdit["ShopContactNo_1"];
                                $getShopContactNo_2 = $ShopCallingDataEdit["ShopContactNo_2"];
                                $getShopEmailAddress = $ShopCallingDataEdit["ShopEmailAddress"];
                                $getShopOwnerAddress = $ShopCallingDataEdit["ShopOwnerAddress"];

                                $getMaleEmp = $ShopCallingDataEdit["MaleEmp"];
                                $getFemaleEmp = $ShopCallingDataEdit["FemaleEmp"];
                                $getOtherEmp = $ShopCallingDataEdit["OtherEmp"];
                                $getContactNo3 = $ShopCallingDataEdit["ContactNo3"];
                                $getGSTNno = $ShopCallingDataEdit["GSTNno"];

                                $getShopOutsideImage1 = $ShopCallingDataEdit["ShopOutsideImage1"];
                                $getShopOutsideImage2 = $ShopCallingDataEdit["ShopOutsideImage2"];
                                $getShopInsideImage1 = $ShopCallingDataEdit["ShopInsideImage1"];
                                $getShopInsideImage2 = $ShopCallingDataEdit["ShopInsideImage2"];


                                $getShopDimension = $ShopCallingDataEdit["ShopDimension"];


                                $getShopStatus = $ShopCallingDataEdit["ShopStatus"];
                                $getShopStatusTextColor = $ShopCallingDataEdit["ShopStatusTextColor"];
                                $getShopStatusFaIcon = $ShopCallingDataEdit["ShopStatusFaIcon"];
                                $getShopStatusIconUrl = $ShopCallingDataEdit["ShopStatusIconUrl"];
                                $getShopStatusDate = $ShopCallingDataEdit["ShopStatusDate"];
                                $getShopStatusRemark = $ShopCallingDataEdit["ShopStatusRemark"];


                                $getBusinessCat_Cd = $ShopCallingDataEdit["BusinessCat_Cd"];
                                $getNature_of_Business = $ShopCallingDataEdit["BusinessCatName"];

                                $getCall_DateTime = $ShopCallingDataEdit["Call_DateTime"];
                                $getCalling_Category = $ShopCallingDataEdit["Calling_Category"];

                                $getQCRemark1 = $ShopCallingDataEdit["QC_Remark1"];
                                $getQCRemark2 = $ShopCallingDataEdit["QC_Remark2"];
                                $getQCRemark3 = $ShopCallingDataEdit["QC_Remark3"];



                    $query2 = "SELECT BusinessCat_Cd, BusinessCatName, BusinessCatNameMar 
                                FROM BusinessCategoryMaster WHERE IsActive = 1;";

                    $NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

                    $query7 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                                WHERE DTitle = 'Category' AND IsActive = 1 
                                ORDER BY SerialNo;";

                    $EstablishmentCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query7, $electionName, $developmentMode);

                    $query10 = "SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1 ORDER BY ShopAreaName;";

                    $EstablishmentAreaCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);


                    $query12 = "SELECT pd.ParwanaDetCd, pd.Parwana_Cd, pd.IsRenewal, pm.Parwana_Name_Eng, pm.Parwana_Name_Mar, pd.PDetNameEng, pd.PDetNameMar, pd.Amount from ParwanaDetails pd  INNER JOIN ParwanaMaster pm on pm.Parwana_Cd = pd.Parwana_Cd
                        WHERE pd.IsRenewal = $getIsCertificateIssued AND pd.IsActive = 1;";

                    $ParwanaDetailDropDown = $db->ExecutveQueryMultipleRowSALData($query12, $electionName, $developmentMode);

                    $query13 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                                WHERE DTitle = 'CertificateIssued' AND IsActive = 1 ORDER BY SerialNo;";

                    $IsCertificateIssuedDropDown = $db->ExecutveQueryMultipleRowSALData($query13, $electionName, $developmentMode);


                    $query4 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                                WHERE DTitle = 'LetterGiven' AND IsActive = 1 ORDER BY SerialNo;";

                    $LetterGivenDropDown = $db->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

                    $query110 = "SELECT Status_Cd as DropDown_Cd, ApplicationStatus as DValue FROM StatusMaster
                                WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1;";

                    $ShopStatusDropDown = $db->ExecutveQueryMultipleRowSALData($query110, $electionName, $developmentMode);


                    $query111 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                                WHERE DTitle = 'PropertyStatus' AND IsActive = 1
                                ORDER BY SerialNo;";

                    $OwnedORRentedDropDown = $db->ExecutveQueryMultipleRowSALData($query111, $electionName, $developmentMode);

                    $getReason = '';

                    $query113 = "SELECT Calling_Category_Cd
                                ,Calling_Category
                                ,Calling_Type
                                FROM CallingCategoryMaster WHERE IsActive = 1;";

                    $ReasonDropDown = $db->ExecutveQueryMultipleRowSALData($query113, $electionName, $developmentMode);


                ?>
                        <div class="tab-pane" id="survey-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="survey-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                            <div class="row">

                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="row">        
                        
                                        <div class="col-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                            <label>Nature of Business </label><label style="color:red;">*</label>
                                                <div class="controls"> 
                                                <select class="select2 form-control" required name="<?php echo $ScheduleCall_Cd; ?>_NatureofBusiness" required>
                                                    <option value="">--Select--</option>
                                                        <?php   
                                                            if (sizeof($NatureOfBusinesDropDown)>0) 
                                                            {
                                                                foreach($NatureOfBusinesDropDown as $key => $value)
                                                                {
                                                                    if($getNature_of_Business == $value["BusinessCatName"])
                                                                    {
                                                                    ?> 
                                                                        <option selected="true" value="<?php echo $value['BusinessCat_Cd'];?>"><?php echo $value['BusinessCatName'];?></option>
                                                                        <?php }
                                                                        else
                                                                        { ?>
                                                                        <option value="<?php echo $value["BusinessCat_Cd"];?>"><?php echo $value["BusinessCatName"];?></option>
                                                                <?php }
                                                                }
                                                            } 
                                                        ?>

                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                    <label>Shop Area Category<span style="color:red;">*</span> </label>
                                                        <div class="controls"> 
                                                        <select class="select2 form-control" name="<?php echo $ScheduleCall_Cd; ?>_EstablishmentAreaCategory" >
                                                            <option  value="">--Select--</option>   
                                                                <?php if (sizeof($EstablishmentAreaCategoryDropDown)>0) 
                                                                    {
                                                                        foreach($EstablishmentAreaCategoryDropDown as $key => $value)
                                                                        {
                                                                            if($getShopAreaName == $value["ShopAreaName"])
                                                                            {
                                                                            ?> 
                                                                                <option selected="true" value="<?php echo $value['ShopArea_Cd'];?>"><?php echo $value['ShopAreaName'];?></option>
                                                                            <?php }
                                                                            else
                                                                            { ?>
                                                                                <option value="<?php echo $value["ShopArea_Cd"];?>"><?php echo $value["ShopAreaName"];?></option>
                                                                        <?php }
                                                                        }
                                                                    } ?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                    <label>Shop Category </label><label style="color:red;">*</label>
                                                        <div class="controls"> 
                                                        <select class="select2 form-control" name="<?php echo $ScheduleCall_Cd; ?>_EstablishmentCategory"  required>
                                                            <option  value="">--Select--</option>   
                                                                <?php if (sizeof($EstablishmentCategoryDropDown)>0) 
                                                                    {
                                                                        foreach($EstablishmentCategoryDropDown as $key => $value)
                                                                        {
                                                                            if($getShopCategory == $value["DValue"])
                                                                            {
                                                                    ?> 
                                                                                <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                    <?php } else { ?>
                                                                                <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                    <?php }
                                                                        }
                                                                    } 
                                                                ?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Shop Name </label><label style="color:red;">*</label>
                                                    <input type="text" value="<?php echo $getShopName; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_EstablishmentName" class="form-control" placeholder="Shop Name" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Shop Name in Marathi</label><label style="color:red;">*</label>
                                                    <input type="text" value="<?php echo $getShopNameMar; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_EstablishmentNameMar" class="form-control" placeholder="Shop Name in Marathi" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shopkeeper / Contact Person Full Name </label>
                                            <input type="text" value="<?php echo $getShopKeeperName; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopkeeperName"  class="form-control" placeholder="Shopkeeper / Contact Person Name" required >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shopkeeper / Contact Person Primary Mobile No </label>
                                            <input type="tel" value="<?php echo $getShopKeeperMobile; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopkeeperMobileNo" class="form-control" placeholder="Shopkeeper / Contact Person Mobile No" required pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shop Contact No 1</label>
                                            <input type="tel" value="<?php echo $getShopContactNo_1; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopContactNo_1"   class="form-control" placeholder="Shop Contact No 1" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shop Contact No 2</label>
                                            <input type="tel" value="<?php echo $getShopContactNo_2; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopContactNo_2" class="form-control" placeholder="Shop Contact No 2" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Address Line 1</label>
                                            <textarea  type="text"  name="<?php echo $ScheduleCall_Cd; ?>_AddressLine1" rows="2" class="form-control" placeholder="Address Line 1"><?php echo $getShopAddress_1; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Address Line 2</label>
                                            <textarea type="text" name="<?php echo $ScheduleCall_Cd; ?>_AddressLine2" rows="2" class="form-control" placeholder="Address Line 2" ><?php echo $getShopAddress_2; ?></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                    <label>Parwana Detail </label><label style="color:red;">*</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" required name="<?php echo $ScheduleCall_Cd; ?>_ParwanaDetCd">
                                            <option value="">--Select--</option>
                                                <?php   
                                                    if (sizeof($ParwanaDetailDropDown)>0) 
                                                    {
                                                        foreach($ParwanaDetailDropDown as $key => $value)
                                                        {
                                                            if($getParwanaDetCd == $value["ParwanaDetCd"])
                                                            {
                                                            ?> 
                                                                <option selected="true" value="<?php echo $value['ParwanaDetCd'];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['Amount'];?></option>
                                                                <?php }
                                                                else
                                                                { ?>
                                                                <option value="<?php echo $value["ParwanaDetCd"];?>"><?php echo $value['Parwana_Name_Eng']." ".$value['Parwana_Name_Mar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['PDetNameEng']." ".$value['PDetNameMar'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['Amount'];?></option>
                                                        <?php }
                                                        }
                                                    } 
                                                ?>

                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <!-- <label><b>Shop Dimensions in Sq. ft.</b> </label> -->
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Shop Length (ft.)  </label>
                                                    <input type="number" value=""  name="<?php echo $ScheduleCall_Cd; ?>_ShopDimensionLength" class="form-control" placeholder="Length (ft.) " maxlength="10" onchange="setShopDimension(<?php echo $ScheduleCall_Cd; ?>)"> 
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Shop Width (ft.)  </label>
                                                    <input type="number" value=""  name="<?php echo $ScheduleCall_Cd; ?>_ShopDimensionWidth"  class="form-control" placeholder="Width (ft.) " onchange="setShopDimension(<?php echo $ScheduleCall_Cd; ?>)" maxlength="10">
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Area (Sq. ft.)  </label>
                                                    <input type="number" value="<?php echo $getShopDimension; ?>"  name="<?php echo $ScheduleCall_Cd; ?>_ShopDimension" class="form-control" placeholder="Shop Dimensions in Sq. ft. " maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <!-- <label><b>Shop Detail</b> </label> -->
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-6">
                                                    <label>Consumer No </label>
                                                    <input type="text" value="<?php echo $getConsumerNumber; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ConsumerNumber" id="ConsumerNumber" class="form-control" placeholder="Consumer Number" pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6">
                                                    <label>GST No</label>
                                                    <input type="text" value="<?php echo $getGSTNno; ?>" name="<?php echo $ScheduleCall_Cd; ?>_GSTNno" class="form-control" placeholder="Shop GST No" required maxlength="15" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <!-- <label><b>Shop Own Status </b></label> -->
                                            <div class="row">

                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Owned / Rented</label><label style="color:red;">*</label>
                                                    <select class="select2 form-control" name="<?php echo $ScheduleCall_Cd; ?>_Owned_Rented" required>
                                                        <option  value="">--Select--</option>   
                                                            <?php if (sizeof($OwnedORRentedDropDown)>0) 
                                                                {
                                                                    foreach($OwnedORRentedDropDown as $key => $value)
                                                                    {
                                                                        if($getShopOwnStatus == $value["DValue"])
                                                                        {
                                                                        ?> 
                                                                            <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                        <?php }
                                                                        else
                                                                        { ?>
                                                                            <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                    <?php }
                                                                    }
                                                                } ?>
                                                    </select>
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Period in Yrs  </label>
                                                    <input type="text" value="<?php echo $getShopOwnPeriodYrs; ?>"  name="<?php echo $ScheduleCall_Cd; ?>_ShopOwnPeriodYrs" class="form-control" placeholder="Shop Own Period in Yrs" pattern="[0-9]{3}" maxlength="3" onkeypress="return isNumber(event)">
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Period in Months </label>
                                                    <input type="text" value="<?php echo $getShopOwnPeriodMonths; ?>"  name="<?php echo $ScheduleCall_Cd; ?>_ShopOwnPeriodMonths" id="ShopOwnPeriodMonths" class="form-control" placeholder="Shop Own Period in Months" pattern="[0-9]{2}" maxlength="2" onkeypress="return isNumber(event)">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shop Owner Details </label>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-3">
                                                    <label>Full Name</label>
                                                    <input type="text" value="<?php echo $getShopOwnerName; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopOwnerName" class="form-control" placeholder="Shop Owner Full Name" required >
                                                </div>        

                                                <div class="col-12 col-sm-12 col-md-3">
                                                    <label>Mobile No</label>
                                                    <input type="tel" value="<?php echo $getShopOwnerMobile; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopOwnerMobile" class="form-control" placeholder="Shop Owner Mobile No" required pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)">
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-3">
                                                    <label>Email Id</label>
                                                    <input type="email" value="<?php echo $getShopEmailAddress; ?>" name="<?php echo $ScheduleCall_Cd; ?>_ShopEmailAddress" class="form-control" placeholder="Shop Owner Email Id" onchange="validateEmail(event)">
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-3">
                                                    <label>Contact No</label>
                                                    <input type="tel" value="<?php echo $getContactNo3; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_ShopContactNo_3" class="form-control" placeholder="Shop Contact No 3" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shop Employees</label>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-4">
                                                   <label> Male </label><input type="number" value="<?php echo $getMaleEmp; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_MaleEmp" class="form-control" placeholder="Shop Male Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)">
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Female</label> <input type="number" value="<?php echo $getFemaleEmp; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_FemaleEmp" class="form-control" placeholder="Shop Female Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)">
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <label>Others </label><input type="number" value="<?php echo $getOtherEmp; ?>" required name="<?php echo $ScheduleCall_Cd; ?>_OtherEmp" class="form-control" placeholder="Shop Others Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)">
                                                      
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shop Owner Address</label>
                                            <textarea type="text" name="<?php echo $ScheduleCall_Cd; ?>_ShopOwnerAddress" rows="2" class="form-control" placeholder="Shop Owner Address" ><?php echo $getShopOwnerAddress; ?></textarea>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>QC Remark  <span style="color:red;">*</span> </label>
                                            <input type="text" name="<?php echo $ScheduleCall_Cd; ?>_QCRemark1" value="<?php echo $getQCRemark1; ?>" class="form-control" placeholder="QC Remark " >
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>QC Remark 2</label> -->
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCRemark2" value="<?php echo $getQCRemark2; ?>" class="form-control" placeholder="QC Remark 2" >
                                        <!-- </div>
                                    </div>
                                </div> -->

                                <!-- <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>QC Remark 3</label> -->
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCRemark3" value="<?php echo $getQCRemark3; ?>" class="form-control" placeholder="QC Remark 3" >
                                        <!-- </div>
                                    </div>
                                </div> -->

                                <?php 
                                    $queryQCDet = "SELECT 
                                            QC_Flag, QC_Type, 
                                            ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                                        FROM QCDetails
                                        WHERE Shop_Cd = $Shop_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND Calling_Cd = $Calling_Cd AND  QC_Type = 'ShopSurvey'   
                                        GROUP BY QC_Flag, QC_Type";

                                    $shopQCDetailsData = $db->ExecutveQuerySingleRowSALData($queryQCDet, $electionName, $developmentMode);
                                    $isShopQCDone = "primary";
                                    $isShopQCDoneStyle = "display: none;";
                                    if(sizeof($shopQCDetailsData)>0){ 
                                        $isShopQCDone = "success";
                                        $isShopQCDoneStyle = "display: block;";
                                    }
                                ?>
                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>

                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_Shop_Id" value="<?php echo $Shop_Cd; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_Calling_Id" value="<?php echo $Calling_Cd; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_ScheduleCall_Id" value="<?php echo $ScheduleCall_Cd; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCTypeMain" value="<?php echo $qcType; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCType" value="<?php echo "ShopSurvey"; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCFlag" value="<?php echo "2"; ?>" >
                                            <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_CallingCategory" value="<?php echo $getCalling_Category; ?>" >
                                            <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgsuccess" class="controls alert alert-success" role="alert" style="<?php echo $isShopQCDoneStyle; ?>"><?php if(sizeof($shopQCDetailsData)>0){  echo $getCalling_Category." QC on ".$shopQCDetailsData["MaxQCDateTime"]; } ?></div>
                                            <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="col-12 col-sm-12 col-md-2 text-right" style="margin-top:30px;">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <button type="button" id="<?php echo $ScheduleCall_Cd; ?>_btnShopCallingSurveyQCId" onclick="saveShopCallingSurveyQCFormData(<?php echo $ScheduleCall_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>

                    <?php   
                        }else if($getScheduleQCType == "ShopDocument"){


                            $DocScheduleCall_Cd = $valueCallingSchedule["ScheduleCall_Cd"];
                            $query22 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                                ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                                ISNULL(sd.Document_Cd,0) as Document_Cd,
                                ISNULL(sd.FileURL,'') as FileURL,
                                ISNULL(sd.IsVerified,0) as IsVerified,
                                ISNULL(sd.QC_Flag,0) as QC_Flag,
                                ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                                ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                                ISNULL(sdm.DocumentName,'') as DocumentName,
                                ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                                ISNULL(sdm.DocumentType,'') as DocumentType,
                                ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
                            FROM ShopDocuments sd
                            INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
                            LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
                            WHERE sd.IsActive = 1
                            AND sd.Shop_Cd = $Shop_Cd;";

                        $DocumentsListForQC = $db->ExecutveQueryMultipleRowSALData($query22, $electionName, $developmentMode);
                        // print_r($DocumentsListForQC);
                    ?>
                            <div class="tab-pane" id="document-calling-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="document-calling-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">
                                <?php 
                                    if($DocScheduleCall_Cd > 0){
                                        include 'shopDocumentsListQCForm.php';
                                    }
                                 ?>

                            </div>
                    <?php   
                            }
                        }
                    ?>

                        <div class="tab-pane" id="schedule-info-<?php echo $Shop_Cd; ?>" aria-labelledby="schedule-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                            <div class="row">        
                            
                            <div class="col-sm-12 col-md-2 col-12">
                                <div class="form-group">
                                    <label for="scheduleDate">Schedule Date</label>
                                    <input type='datetime-local' name="<?php echo $ScheduleCall_Cd; ?>_SCHScheduleDate" value="" class="form-control" />
                                </div>
                            </div>

                            <div class="col-12 col-md-3 col-sm-12">
                                <div class="form-group">
                                <label>Schedule Category</label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="<?php echo $ScheduleCall_Cd; ?>_SCHScheduleCategory">
                                        <option  value="0">--Select--</option>   
                                            <?php if (sizeof($ReasonDropDown)>0) 
                                                {
                                                    foreach($ReasonDropDown as $key => $value)
                                                    {
                                                        if($getReason == $value["Calling_Category_Cd"])
                                                        {
                                                         ?> 
                                                            <option selected="true" value="<?php echo $value['Calling_Category_Cd'];?>"><?php echo $value['Calling_Category'];?></option>
                                                        <?php }
                                                        else
                                                        { ?>
                                                            <option value="<?php echo $value["Calling_Category_Cd"];?>"><?php echo $value["Calling_Category"];?></option>
                                                    <?php }
                                                    }
                                                } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Schedule Reason</label>
                                        <input type="text" name="<?php echo $ScheduleCall_Cd; ?>_SCHCallReason" class="form-control" placeholder="Schedule Reason" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Remark</label>
                                        <input type="text" name="<?php echo $ScheduleCall_Cd; ?>_SCHRemark" class="form-control" placeholder="Remark" >
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-12 col-md-10 col-12" >
                                <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SCHScheduleCall_Id" value="0" >
                                <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SCHShop_Id" value="<?php echo $Shop_Cd; ?>" >
                                <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgsuccessSCH" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgfailedSCH"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                            </div>

                            <div class="col-sm-12 col-md-2 col-12 text-right" style="margin-top:20px;">
                                <button type="button" id="<?php echo $ScheduleCall_Cd; ?>_btnShopScheduleId" onclick="saveShopScheduleFormData(<?php echo $ScheduleCall_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                            </div>
                        </div>
                        </div>


                        <div class="tab-pane" id="shop-status-info-<?php echo $Shop_Cd; ?>" aria-labelledby="shop-status-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                            <div class="row">        
                                
                                <div class="col-12 col-md-3 col-sm-12">
                                    <div class="form-group">
                                    <label>Application Status</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="<?php echo $ScheduleCall_Cd; ?>_ShopStatus">
                                            <option  value="">--Select--</option>   
                                                <?php if (sizeof($ShopStatusDropDown)>0) 
                                                    {
                                                        foreach($ShopStatusDropDown as $key => $value)
                                                        {
                                                            if($getShopStatus == $value["DValue"])
                                                            {
                                                             ?> 
                                                                <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                            <?php }
                                                            else
                                                            { ?>
                                                                <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                        <?php }
                                                        }
                                                    } ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-4 col-12">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Application Status Remark</label>
                                            <input type="text" name="<?php echo $ScheduleCall_Cd; ?>_ShopStatusRemark" class="form-control" placeholder="Remark" value="<?php echo $getShopStatusRemark; ?>" >
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-12 col-md-3 col-12" >
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_ShopStatusScheduleCall_Id" value="<?php echo $ScheduleCall_Cd; ?>" >
                                    <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_ShopStatusShop_Id" value="<?php echo $Shop_Cd; ?>" >
                                    <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgsuccessSS" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgfailedSS"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>

                                <div class="col-sm-12 col-md-2 col-12 text-right" style="margin-top:20px;">
                                    <button type="button" id="<?php echo $ScheduleCall_Cd; ?>_btnShopStatusId" onclick="saveShopStatusFormData(<?php echo $ScheduleCall_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                </div>
                            </div>
                        </div>

                </div>

            </div>
        </div>
        


                    

            
    </fieldset>
</div>


        