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
        transform-origin: 10% 50%;
    }

    img.galleryimg:hover{
         z-index: 999999;
        transform: scale(4.2);
    }
    table.dataTable th{
        display: none;
    }
</style>

<?php 
    // $query7 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
    //             WHERE DTitle = 'Category' AND IsActive = 1 
    //             ORDER BY SerialNo;";
    $query7 = "SELECT Category from ParwanaMaster GROUP BY Category;";

    $EstablishmentCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query7, $electionName, $developmentMode);

    // $query2 = "SELECT BusinessCat_Cd, BusinessCatName, BusinessCatNameMar 
    //             FROM BusinessCategoryMaster WHERE IsActive = 1;";

    if(!empty($getShopCategory)){
       $shopCatCondition =  " AND prm.Category = '".$getShopCategory."' " ;
    }else{
        $shopCatCondition = " ";
    }

    $query2 = "SELECT bcm.BusinessCat_Cd, bcm.BusinessCatName, bcm.BusinessCatNameMar FROM BusinessCategoryMaster bcm INNER JOIN ParwanaMaster prm on bcm.BusinessCat_Cd = prm.BusinessCat_Cd WHERE prm.IsActive = 1 $shopCatCondition GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, bcm.BusinessCatNameMar;";
    $NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);


    $query10 = "SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1 ORDER BY ShopAreaName;";

    $EstablishmentAreaCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);

?>
<div class="col-12 col-sm-12">
    <?php if($qcType == "ShopList"){ ?> 
    <fieldset>
        <legend><b><?php echo $srNo.") "; ?> Shop Listing QC  :: <?php echo $getShopName; ?> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $getAddedByName; ?> - <?php echo $getAddedDate; ?></b></legend>
    <?php } ?>
        <div class="row">
        
        <?php if($qcType == "ShopList"){ ?> 
        
            <div class="col-12 col-sm-12 col-md-2">
                <div class="media">
                    <div class="avatar mr-75">
                        <?php if($getShopOutsideImage1 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage1; ?>" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        <?php }else if($getShopOutsideImage2 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        <?php } else { ?>   
                            <img src="pics/shopDefault.jpeg" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                        <?php } ?>
                        
                    </div>
                </div>

            </div>
        <?php } ?>
        
        <?php if($qcType == "ShopList"){ ?> 
            <div class="col-12 col-sm-12 col-md-10"  style="margin-left: -20px;">
        <?php }else{ ?>  
            <div class="col-12 col-sm-12 col-md-12">
        <?php } ?>

                <div class="row">        
                    <div class="col-12 col-sm-12 col-md-4">
                        <div class="form-group">
                        <label>Shop Category </label><label style="color:red;">*</label>
                            <div class="controls"> 
                            <select class="select2 form-control" name="<?php echo $Shop_Cd; ?>_EstablishmentCategory"  required onchange="setBusinessCatListForQC(this.value,'<?php echo $Shop_Cd; ?>')">
                                <option  value="">--Select--</option>   
                                    <?php if (sizeof($EstablishmentCategoryDropDown)>0) 
                                        {
                                            foreach($EstablishmentCategoryDropDown as $key => $value)
                                            {
                                                if($getShopCategory == $value["Category"])
                                                {
                                        ?> 
                                                    <option selected="true" value="<?php echo $value['Category'];?>"><?php echo $value['Category'];?></option>
                                        <?php } else { ?>
                                                    <option value="<?php echo $value["Category"];?>"><?php echo $value["Category"];?></option>
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
                        <label>Nature of Business </label><label style="color:red;">*</label>
                            <div class="controls"> 
                            <select class="select2 form-control" required name="<?php echo $Shop_Cd; ?>_NatureofBusiness" required id="<?php echo $Shop_Cd; ?>_NatureofBusiness">
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
                            <select class="select2 form-control" name="<?php echo $Shop_Cd; ?>_EstablishmentAreaCategory" >
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
                    

                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Shop Name </label><label style="color:red;">*</label>
                                <input type="text" value="<?php echo $getShopName; ?>" required name="<?php echo $Shop_Cd; ?>_EstablishmentName" class="form-control" placeholder="Shop Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Shop Name in Marathi</label><label style="color:red;">*</label>
                                <input type="text" value="<?php echo $getShopNameMar; ?>" required name="<?php echo $Shop_Cd; ?>_EstablishmentNameMar" class="form-control" placeholder="Shop Name in Marathi" required>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

             <div class="col-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <div class="controls">
                        <label>Shopkeeper / Contact Person Full Name </label>
                        <input type="text" value="<?php echo $getShopKeeperName; ?>" required name="<?php echo $Shop_Cd; ?>_ShopkeeperName"  class="form-control" placeholder="Shopkeeper / Contact Person Name" required >
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <div class="controls">
                        <label>Shopkeeper / Contact Person Primary Mobile No </label>
                        <input type="text" value="<?php echo $getShopKeeperMobile; ?>" required name="<?php echo $Shop_Cd; ?>_ShopkeeperMobileNo" class="form-control" placeholder="Shopkeeper / Contact Person Mobile No" required pattern="[6-9]{1}[0-9]{9}" maxlength="10" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <div class="controls">
                        <label>Shop Contact No 1</label>
                        <input type="tel" value="<?php echo $getShopContactNo_1; ?>" required name="<?php echo $Shop_Cd; ?>_ShopContactNo_1"   class="form-control" placeholder="Shop Contact No 1" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <div class="controls">
                        <label>Shop Contact No 2</label>
                        <input type="tel" value="<?php echo $getShopContactNo_2; ?>" required name="<?php echo $Shop_Cd; ?>_ShopContactNo_2" class="form-control" placeholder="Shop Contact No 2" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <div class="controls">
                        <label>Address Line 1</label>
                        <textarea  type="text"  name="<?php echo $Shop_Cd; ?>_AddressLine1" rows="2" class="form-control" placeholder="Address Line 1"><?php echo $getShopAddress_1; ?></textarea>
                    </div>
                </div>
            </div>
                
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <div class="controls">
                        <label>Address Line 2</label>
                        <textarea type="text" name="<?php echo $Shop_Cd; ?>_AddressLine2" rows="2" class="form-control" placeholder="Address Line 2" ><?php echo $getShopAddress_2; ?></textarea>
                    </div>
                </div>
            </div>
        

            <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark </label>
                        <textarea type="text" name="<?php echo $Shop_Cd; ?>_QCRemark1" rows="2" class="form-control" placeholder="QC Remark" ><?php echo $getQCRemark1; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark 2</label> -->
                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_QCRemark2" value="<?php echo $getQCRemark2; ?>" class="form-control" placeholder="QC Remark 2" >
                    <!-- </div>
                </div>
            </div> -->

            <!-- <div class="col-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label>QC Remark 3</label> -->
                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_QCRemark3" value="<?php echo $getQCRemark3; ?>" class="form-control" placeholder="QC Remark 3" >
                    <!-- </div>
                </div>
            </div> -->
            <?php 
                $queryQCDet = "SELECT 
                        QC_Flag, QC_Type, 
                        ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                    FROM QCDetails
                    WHERE Shop_Cd = $Shop_Cd AND QC_Type = 'ShopList'   
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

                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_Shop_Id" value="<?php echo $Shop_Cd; ?>" >
                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_QCType" value="ShopList" >
                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_QCType_Main" value="<?php echo $qcType; ?>" >
                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_QCFlag" value="<?php echo "1"; ?>" >
                        <div id="<?php echo $Shop_Cd; ?>_submitmsgsuccess" class="controls alert alert-success" role="alert" style="<?php echo $isShopQCDoneStyle; ?>"><?php if(sizeof($shopQCDetailsData)>0){  echo "Shop Listing QC on ".$shopQCDetailsData["MaxQCDateTime"]; } ?></div>
                        <div id="<?php echo $Shop_Cd; ?>_submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                    </div>
                </div>
            </div>
            

            <div class="col-12 col-sm-12 col-md-2 text-right" style="margin-top:50px;">
                <div class="form-group">
                    <div class="controls">
                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type="button" id="<?php echo $Shop_Cd; ?>_btnShopListQCId" onclick="saveShopListQCFormData(<?php echo $Shop_Cd; ?>)" class="btn btn-<?php echo $isShopQCDone; ?> glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                    </div>
                </div>
            </div>
            
        </div>

<?php if($qcType == "ShopList"){ ?> 
    </fieldset>
<?php } ?>

</div>


        