    <?php

        $loginExecutiveCd = 0;
        $userId = $_SESSION['SAL_UserId'];
        if($userId != 0){
            $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
            if(sizeof($exeData)>0){
                $loginExecutiveCd = $exeData["Executive_Cd"];
            }
        }
    ?>

    <?php 

        $query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                ISNULL(sd.Document_Cd,0) as Document_Cd,
                ISNULL(sd.FileURL,'') as FileURL,
                ISNULL(sd.IsVerified,0) as IsVerified,
                ISNULL(sd.QC_Flag,0) as QC_Flag,
                ISNULL(sd.IsActive,0) as IsActive,
                ISNULL(CONVERT(VARCHAR,sd.UpdatedDate,100),'') as UpdatedDate,
                ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                ISNULL(sdm.DocumentName,'') as DocumentName,
                ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                ISNULL(sdm.DocumentType,'') as DocumentType,
                ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
            FROM ShopDocuments sd
            INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
            LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
            WHERE sd.Shop_Cd = $Shop_Cd ORDER BY sd.UpdatedDate DESC;";

        $DocumentsListForQC = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);
        // print_r($DocumentsListForQC);
    ?>
<style>
    embed.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;}

    embed.galleryimg:hover{
        transform: scale(2.2);
        z-index: 999999;
    }
  /*  table.dataTable th{
        display: none;
    }*/
    h4,h5{
        color: #C90D41;
        font-weight: 900;
    }
</style>
        <div class="row">

            <?php
                if(sizeof($DocumentsListForQC)>0){
            ?>
                <div class="col-12 col-sm-12 col-md-10" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <div class="controls">
                            <label>Selected Documents</label><label style="color:red;">*</label>
                            <input type="text" name="<?php echo $DocScheduleCall_Cd; ?>_selectedDocumentNames" value="" disabled class="form-control" placeholder="Selected Documents" >
                            <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_selectedDocumentIds" class="form-control" >
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Action</label><label style="color:red;">*</label>
                        <div class="controls"> 
                            <select class="select2 form-control" name="<?php echo $DocScheduleCall_Cd; ?>_docQCAction" onchange="setDocQCRemark(<?php echo $DocScheduleCall_Cd; ?>)" required>
                                <option value="">--Select--</option>   
                                <option value="QC">QC</option>   
                                <option value="Delete">Delete</option> 
                            </select>
                        </div>
                    </div>
                </div>

            <?php 
                foreach ($DocumentsListForQC as $key => $value) {
            ?>
                    <div class="col-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <div class="vs-checkbox-con vs-checkbox-primary">
                                    <input type="checkbox" value="<?php echo $value["ShopDocDet_Cd"]; ?>,<?php echo $value["DocumentName"]; ?>" name="<?php echo $DocScheduleCall_Cd; ?>_selectDocumentsQCChk" onclick="setSelectMultipleDocumentsQC(<?php echo $DocScheduleCall_Cd; ?>)" >
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <span>Uploaded on <?php echo $value["UpdatedDate"]; ?></span>
                                </div>
                                <label><a href="<?php echo $value["FileURL"]; ?>" target="_blank"><?php echo $value["DocumentName"]; ?></a> </label>
                                

                                <input type="file" id="<?php echo $DocScheduleCall_Cd; ?><?php echo $value["Document_Cd"]; ?><?php echo $value["ShopDocDet_Cd"]; ?>_Doc" name="<?php echo $DocScheduleCall_Cd; ?><?php echo $value["Document_Cd"]; ?><?php echo $value["ShopDocDet_Cd"]; ?>_Doc"  class="form-control" onchange="DocumentQCImageValidation(<?php echo $DocScheduleCall_Cd; ?><?php echo $value["Document_Cd"]; ?><?php echo $value["ShopDocDet_Cd"]; ?>);"  >

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <img id="<?php echo $DocScheduleCall_Cd; ?><?php echo $value["Document_Cd"]; ?><?php echo $value["ShopDocDet_Cd"]; ?>_Upload"   src="" width="100%" height="200"/>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <embed <?php if($value["DocumentType"]=='image'){ ?> <?php }else if($value["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?>  src="<?php echo $value["FileURL"]; ?>" width="100%" height="200"></EMBED>

                                    </div>
                                </div>  
                                    
                                    <button style="margin-top: 10px;margin-bottom: 10px;" type="button" id="<?php echo $value["ShopDocDet_Cd"]; ?><?php echo $DocScheduleCall_Cd; ?>_btnShopDocumentUploadQCId" onclick="uploadShopDocumentQCFormData(<?php echo $DocScheduleCall_Cd; ?><?php echo $value["Document_Cd"]; ?><?php echo $value["ShopDocDet_Cd"]; ?>,<?php echo $value["ShopDocDet_Cd"]; ?>,<?php echo $value["ShopDocDet_Cd"]; ?><?php echo $DocScheduleCall_Cd; ?>,<?php echo $DocScheduleCall_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 text-right">Upload</button>
                                    <div id="<?php echo $value["ShopDocDet_Cd"]; ?><?php echo $DocScheduleCall_Cd; ?>_submitmsgsuccessDocDet" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="<?php echo $value["ShopDocDet_Cd"]; ?><?php echo $DocScheduleCall_Cd; ?>_submitmsgfailedDocDet"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                
                                

                                 <?php 
                                    
                                    
                                    if($value["QC_Flag"]!=0 && $value["IsActive"]!=0){ 
                                        $isShopDocQCButtonStyle = "success";
                                        $isShopDocQCDoneStyle = "display: block;";
                                ?>
                                    <div  class="controls alert alert-<?php echo $isShopDocQCButtonStyle; ?>" role="alert" style="<?php echo $isShopDocQCDoneStyle; ?>"><?php echo $value["DocumentName"]; ?> <?php  echo " Shop Document QC on ".$value["QC_UpdatedDate"];  ?></div>
                                <?php
                                    }else if($value["QC_Flag"]!=0 && $value["IsActive"]==0){
                                        $isShopDocQCButtonStyle = "danger";
                                        $isShopDocQCDoneStyle = "display: block;";
                                ?>
                                    <div  class="controls alert alert-<?php echo $isShopDocQCButtonStyle; ?>" role="alert" style="<?php echo $isShopDocQCDoneStyle; ?>"><?php echo $value["DocumentName"]; ?> <?php  echo " deleted on ".$value["QC_UpdatedDate"];  ?></div>
                                <?php 
                                    }
                                ?>
                                    
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
           
        </div>

        <div class="row">

            <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark  <span style="color:red;">*</span> </label>
                        <input type="text" name="<?php echo $DocScheduleCall_Cd; ?>_DOCQCRemark1" value="<?php echo $getQCRemark1; ?>" class="form-control" placeholder="QC Remark " >
                    </div>
                </div>
            </div>

            <!-- <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark 2</label> -->
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_DOCQCRemark2"  value="<?php echo $getQCRemark2; ?>" class="form-control" placeholder="QC Remark 2" >
                    <!-- </div>
                </div>
            </div> -->

            <!-- <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark 3</label> -->
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_DOCQCRemark3"  value="<?php echo $getQCRemark3; ?>" class="form-control" placeholder="QC Remark 3" >
                    <!-- </div>
                </div>
            </div> -->
             <?php 
                $queryQCDet = "SELECT 
                        QC_Flag, QC_Type, 
                        ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                    FROM QCDetails
                    WHERE Shop_Cd = $Shop_Cd AND QC_Type = 'ShopDocument' AND ScheduleCall_Cd = $DocScheduleCall_Cd   
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

                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_Shop_Id" value="<?php echo $Shop_Cd; ?>" >
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_DOC_ScheduleCall_Id" value="<?php echo $DocScheduleCall_Cd; ?>" >
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_Shop_QCFlag" value="<?php echo $getQC_Flag; ?>" >
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_DOCQCType" value="<?php echo "ShopDocument"; ?>" >
                        <input type="hidden" name="<?php echo $DocScheduleCall_Cd; ?>_DOCQCFlag" value="<?php echo "3"; ?>" >
                        <div id="<?php echo $DocScheduleCall_Cd; ?>_submitmsgsuccessDC" class="controls alert alert-success" role="alert" style="<?php echo $isShopQCDoneStyle; ?>"><?php if(sizeof($shopQCDetailsData)>0){  echo "Shop Documents QC on ".$shopQCDetailsData["MaxQCDateTime"]; } ?></div>
                        <div id="<?php echo $DocScheduleCall_Cd; ?>_submitmsgfailedDC"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                    </div>
                </div>
            </div>
            

            <div class="col-12 col-sm-12 col-md-2 text-right">
                <div class="form-group">
                    <div class="controls">
                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type="button" id="<?php echo $DocScheduleCall_Cd; ?>_btnShopDocumentQCId" onclick="saveShopDocumentQCFormData(<?php echo $DocScheduleCall_Cd; ?>)" class="btn btn-<?php echo $isShopQCDone; ?> glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                    </div>
                </div>
            </div>
            
        </div>


    <?php 
        }
    ?>