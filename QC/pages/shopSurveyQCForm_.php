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

     embed.docimg{
        transition: 0.4s ease;
        transform-origin: 30% 30%;
    }

    embed.docimg:hover{
        z-index: 999999;
        transform: scale(8.2);
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


    $query2 = "SELECT pd.ParwanaDetCd, pd.Parwana_Cd, pd.IsRenewal, pm.Parwana_Name_Eng, pm.Parwana_Name_Mar, pd.PDetNameEng, pd.PDetNameMar, pd.Amount from ParwanaDetails pd  INNER JOIN ParwanaMaster pm on pm.Parwana_Cd = pd.Parwana_Cd
        WHERE pd.IsRenewal = $getIsCertificateIssued AND pd.IsActive = 1;";

    $ParwanaDetailDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

    $query3 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'CertificateIssued' AND IsActive = 1 ORDER BY SerialNo;";

    $IsCertificateIssuedDropDown = $db->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);


    $query4 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'LetterGiven' AND IsActive = 1 ORDER BY SerialNo;";

    $LetterGivenDropDown = $db->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

    $query10 = "SELECT Status_Cd as DropDown_Cd, ApplicationStatus as DValue FROM StatusMaster
                WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1;";

    $ShopStatusDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);


    $query11 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'PropertyStatus' AND IsActive = 1
                ORDER BY SerialNo;";

    $OwnedORRentedDropDown = $db->ExecutveQueryMultipleRowSALData($query11, $electionName, $developmentMode);

    $getReason = '';

    $query13 = "SELECT Calling_Category_Cd
                ,Calling_Category
                ,Calling_Type
                FROM CallingCategoryMaster WHERE IsActive = 1;";

    $ReasonDropDown = $db->ExecutveQueryMultipleRowSALData($query13, $electionName, $developmentMode);

    

   


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

    $ST_Date = "";
    $queryST = "SELECT CONVERT(VARCHAR,ST_DateTime,23) as ST_Date, (SELECT COALESCE(em.ExecutiveName, '') FROM Survey_Entry_Data..Executive_Master em WHERE em.Executive_Cd=ShopTracking.ST_Exec_Cd) as ST_ExecutiveName  from ShopTracking Where ScheduleCall_Cd = $ScheduleCall_Cd AND ST_Status = 1";
    $STForQC = $db->ExecutveQuerySingleRowSALData($queryST, $electionName, $developmentMode);

        if($executiveCd==669){
            // echo $queryST;
        }
    if(sizeof($STForQC)>0){
        $ST_Date = $STForQC["ST_Date"];
        $getSurveyByName = $STForQC["ST_ExecutiveName"];
    }

    $DocScheduleCall_Cd = 0;

    if(sizeof($DocumentsListForQC)>0){
        $queryScheduleDoc = "SELECT st.ScheduleCall_Cd from ShopTracking st Where st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,23) = '$ST_Date' AND st.Calling_Category_Cd = (SELECT TOP 1 Calling_Category_Cd  FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument' ) AND st.Shop_Cd = $Shop_Cd ";
        $ScheduleDocForQC = $db->ExecutveQuerySingleRowSALData($queryScheduleDoc, $electionName, $developmentMode);

        if(sizeof($ScheduleDocForQC)>0){
            $DocScheduleCall_Cd = $ScheduleDocForQC["ScheduleCall_Cd"];
        }else{
			$queryScheduleDoc = "SELECT st.ScheduleCall_Cd from ShopTracking st Where st.ST_Status = 1 AND st.Calling_Category_Cd = (SELECT TOP 1 Calling_Category_Cd  FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument' ) AND st.Shop_Cd = $Shop_Cd ORDER BY st.ST_DateTime DESC";
			$ScheduleDocForQC = $db->ExecutveQuerySingleRowSALData($queryScheduleDoc, $electionName, $developmentMode);
			if(sizeof($ScheduleDocForQC)>0){
				$DocScheduleCall_Cd = $ScheduleDocForQC["ScheduleCall_Cd"];
			}
		}

    }
        
?>
<div class="col-12 col-sm-12">
    <fieldset>
        <legend><b><?php echo $srNo.") "; ?> Shop QC :: <?php echo $getShopName." - ".$getCalling_Category." - ".$getSurveyByName; ?>  - <?php echo date('d/m/Y',strtotime($ST_Date)); ?></b></legend>
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
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
                        <?php }else if($getShopOutsideImage2 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        <?php } else { ?>   
                            <img src="pics/shopDefault.jpeg" class="rounded galleryimg" title="Outside Image 1" width="150" height="150" alt="Avatar" />
                        <?php } ?>
                    </div>

                </div>

            </div>

            <?php if($getShopInsideImage1 != '' || $getShopInsideImage2 != ''){  ?>
                <div class="col-12 col-sm-12 col-md-2">
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

            <div class="col-12 col-sm-12 col-md-3">

            <?php }else{ ?> 

            <div class="col-12 col-sm-12 col-md-5">

            <?php } ?>

                <div class="row">
                    <?php 
                        foreach ($DocumentsListForQC as $key => $value) {
                            if(sizeof($DocumentsListForQC)>3){
                                $heightImg = "75";
                            }else{
                                $heightImg = "150";
                            }
                    ?>
                        <div class="avatar col-md-3">
                            <embed <?php if($value["DocumentType"]=='image'){ ?> <?php }else if($value["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?> class="rounded docimg"   title="<?php echo $value["DocumentName"]; ?>" src="<?php echo $value["FileURL"]; ?>" width="100%" height="<?php echo $heightImg; ?>"></embed>
                        </div>
                            
                    <?php
                        }
                    ?>
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
                        
                        $qcTypeFlag_ShopListQCActiveTab = true;

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
                                        if($qc_Type_Data == "ShopList"){
                                            $qcTypeFlag_ShopListQCActiveTab = false;
                                        }
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

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center <?php if($qcTypeFlag_ShopListQCActiveTab){ ?> active <?php } ?>" id="shop-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#shop-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="shop-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-list mr-25"></i>
                            <span class="d-none d-sm-block">Shop Listing</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center <?php if(!$qcTypeFlag_ShopListQCActiveTab){ ?> active <?php } ?>" id="survey-qc-info-<?php echo $ScheduleCall_Cd; ?>-tab" data-toggle="pill" href="#survey-qc-info-<?php echo $ScheduleCall_Cd; ?>" aria-controls="survey-qc-info-<?php echo $ScheduleCall_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-edit mr-25"></i>
                            <span class="d-none d-sm-block">Shop Survey</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-toggle="modal"  onclick="setShowShopBoardTypeModal(<?php echo $Shop_Cd; ?>,<?php echo $ScheduleCall_Cd; ?>,<?php echo $srNo; ?>)" data-target="#modalShowShopBoardType" aria-selected="true">
                            <i class="feather icon-square mr-25"></i>
                            <span class="d-none d-sm-block">Board Type</span>
                        </a>
                    </li>
                 <?php if(sizeof($DocumentsListForQC)>0){ ?> 
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center " id="document-qc-info-<?php echo $DocScheduleCall_Cd; ?>-tab" data-toggle="pill" href="#document-qc-info-<?php echo $DocScheduleCall_Cd; ?>" aria-controls="document-qc-info-<?php echo $DocScheduleCall_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-file-text mr-25"></i>
                            <span class="d-none d-sm-block">Shop Document</span>
                        </a>
                    </li>
                <?php } ?> 
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center " id="schedule-info-<?php echo $ScheduleCall_Cd; ?>-tab" data-toggle="pill" href="#schedule-info-<?php echo $ScheduleCall_Cd; ?>" aria-controls="schedule-info-<?php echo $ScheduleCall_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-clock mr-25"></i>
                            <span class="d-none d-sm-block">Schedule / Reschedule</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center " id="shop-status-info-<?php echo $ScheduleCall_Cd; ?>-tab" data-toggle="pill" href="#shop-status-info-<?php echo $ScheduleCall_Cd; ?>" aria-controls="shop-status-info-<?php echo $ScheduleCall_Cd; ?>" role="tab" aria-selected="false">
                            <i class="feather icon-check-circle mr-25"></i>
                            <span class="d-none d-sm-block">Application Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-toggle="modal"  onclick="setShowApplicationTrackingModal(<?php echo $Shop_Cd; ?>,<?php echo $ScheduleCall_Cd; ?>,<?php echo $srNo; ?>)" data-target="#modalShowApplicationTracking" aria-selected="true">
                            <i class="feather icon-truck mr-25"></i>
                            <span class="d-none d-sm-block">Application Tracking</span>
                        </a>
                    </li>
                </ul>

                    
                <div class="tab-content">
                    
                    <div class="tab-pane <?php if($qcTypeFlag_ShopListQCActiveTab){ ?> active <?php } ?>" id="shop-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="shop-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">
                        <div class="row">
                            <?php include 'shopListQCForm.php'; ?>
                        </div>
                    </div>

                    <div class="tab-pane <?php if(!$qcTypeFlag_ShopListQCActiveTab){ ?> active <?php } ?>" id="survey-qc-info-<?php echo $ScheduleCall_Cd; ?>" aria-labelledby="survey-qc-info-<?php echo $ScheduleCall_Cd; ?>-tab" role="tabpanel">

                        <div class="row">        
                            
                            

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
                                        <label>QC Remark</label>
                                        <textarea type="text" name="<?php echo $ScheduleCall_Cd; ?>_QCRemark1" rows="2" class="form-control" placeholder="QC Remark" ><?php echo $getQCRemark1; ?></textarea>
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
                                    WHERE Shop_Cd = $Shop_Cd AND QC_Type = 'ShopSurvey' AND ScheduleCall_Cd = $ScheduleCall_Cd   
                                    GROUP BY QC_Flag, QC_Type";

                                $shopQCDetailsData = $db->ExecutveQuerySingleRowSALData($queryQCDet, $electionName, $developmentMode);
                                $isShopQCDone = "primary";
                                $isShopQCDoneStyle = "display: none;";
                                if(sizeof($shopQCDetailsData)>0){ 
                                    $isShopQCDone = "success";
                                    $isShopQCDoneStyle = "display: block;";
                                }
                            ?>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <div class="controls">
                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>

                                        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_Shop_Id" value="<?php echo $Shop_Cd; ?>" >
                                        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_ScheduleCall_Id" value="<?php echo $ScheduleCall_Cd; ?>" >
                                        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCType" value="<?php echo $qcType; ?>" >
                                        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_QCFlag" value="<?php echo "2"; ?>" >
                                        <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgsuccess" class="controls alert alert-success" role="alert" style="<?php echo $isShopQCDoneStyle; ?>"><?php if(sizeof($shopQCDetailsData)>0){  echo "Shop Survey QC on ".$shopQCDetailsData["MaxQCDateTime"]; } ?></div>
                                        <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-12 col-sm-12 col-md-2 text-right">
                                <div class="form-group">
                                    <div class="controls">
                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <button type="button" id="<?php echo $ScheduleCall_Cd; ?>_btnShopSurveyQCId" onclick="saveShopSurveyQCFormData(<?php echo $ScheduleCall_Cd; ?>)" class="btn btn-<?php echo $isShopQCDone; ?> glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
               <?php if(sizeof($DocumentsListForQC)>0){ ?>
                    <div class="tab-pane" id="document-qc-info-<?php echo $DocScheduleCall_Cd; ?>" aria-labelledby="document-qc-info-<?php echo $DocScheduleCall_Cd; ?>-tab" role="tabpanel">
                        <?php 
                            if($DocScheduleCall_Cd > 0){
                                include 'shopDocumentsListQCForm.php';
                            }
                         ?>
                    </div>
                <?php } ?>

                    <div class="tab-pane" id="schedule-info-<?php echo $ScheduleCall_Cd; ?>" aria-labelledby="schedule-info-<?php echo $ScheduleCall_Cd; ?>-tab" role="tabpanel">

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

                    <div class="tab-pane" id="shop-status-info-<?php echo $ScheduleCall_Cd; ?>" aria-labelledby="shop-status-info-<?php echo $ScheduleCall_Cd; ?>-tab" role="tabpanel">

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