                    
        
        <form action="action/saveShopBasicInfoData.php" method="POST" enctype="multipart/form-data" novalidate>
            <div class="row">
                    
                    <div class="col-12 col-sm-12">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Establishment Name </label><label style="color:red;">*</label>
                                        <input type="text" value="<?php echo $getShopName; ?>" required name="EstablishmentName" id="EstablishmentName" class="form-control" placeholder="Establishment Name" required>
                                    </div>
                                </div>
                            </div>

                             <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Shopkeeper / Contact Person Full Name <span style="color:red;">*</span> </label>
                                        <input type="text" value="<?php echo $getShopKeeperName; ?>" required name="ShopkeeperName" id="ShopkeeperName" class="form-control" placeholder="Shopkeeper / Contact Person Name" required >
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Shopkeeper / Contact Person Primary Mobile No <span style="color:red;">*</span> </label>
                                        <input type="tel" value="<?php echo $getShopKeeperMobile; ?>" required name="ShopkeeperMobileNo" id="ShopkeeperMobileNo" class="form-control" placeholder="Shopkeeper / Contact Person Mobile No" required pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Shopkeeper / Contact Person Secondary Mobile No</label>
                                        <input type="tel" value="<?php echo $getShopContactNo_2; ?>" name="SecondaryContactNumber" id="SecondaryContactNumber" class="form-control" placeholder="Secondary Contact Number" pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                
                
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                        <label>Nature of Business </label><label style="color:red;">*</label>
                            <div class="controls"> 
                            <select class="select2 form-control" required name="NatureofBusiness" id="NatureofBusiness" required>
                                <option value="">--Select--</option>
                                <?php if (sizeof($NatureOfBusinesDropDown)>0) 
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
                                        } ?>

                            </select>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                        <label>Is Certificate Issued Previosly </label><label style="color:red;">*</label>
                            <div class="controls"> 
                            <select class="select2 form-control" required name="IsCertificateIssuedPreviously" id="IsCertificateIssuedPreviously" required>
                                <option <?php echo $getIsCertificateIssued == '1' ? 'selected=true' : '';?>  value="1">Yes</option>
                                <option <?php echo $getIsCertificateIssued == '0' ? 'selected=true' : '';?>  value="0">No</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label>Letter Given to Shopkeeper</label>
                            <div class="controls"> 
                            <select class="select2 form-control" name="LetterGiventoShopkeeper" id="LetterGiventoShopkeeper">
                                <option  value="">--Select--</option>   
                                    <?php if (sizeof($LetterGivenDropDown)>0) 
                                        {
                                            foreach($LetterGivenDropDown as $key => $value)
                                            {
                                                if($getLetterGiven == $value["DValue"])
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


                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <div class="controls">
                                <label>Due Date of License Renewal</label>
                                <input type="text" value="<?php echo $getRenewalDate; ?>" name="DueDateofLicenseRenewal" id="DueDateofLicenseRenewal" class="form-control pickadate" >
                            </div>
                        </div>
                    </div>


                    

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Address Line 1</label>
                                <input  type="text" value="<?php echo $getShopAddress_1; ?>" name="AddressLine1" id="AddressLine1" class="form-control" placeholder="Address Line 1" value="">
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Address Line 2</label>
                                <input type="text" value="<?php echo $getShopAddress_2; ?>" name="AddressLine2" id="AddressLine2" class="form-control" placeholder="Address Line 2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Establishment Image 1 (From Outside)</label>
                                <input type="file" value="<?php echo $getShopOutsideImage1;?>" name="EstablishmentImages" id="EstablishmentImages" class="form-control" onchange="EstablishmestImgOut1Validation();PreviewImageEstablishmestImgOut1();" >
                                <br>
                                <img src="<?php echo $getShopOutsideImage1; ?>" id="EstablishmentImagesView" style="width: 50%; height: 200px; border-style: solid; border-width: 2px;" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" id="oldEstablishmentImages" name="oldEstablishmentImages" value="<?php echo $getShopOutsideImage1;?>">
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Establishment Image 2 (From Outside)</label>
                                <input type="file" value="<?php echo $getShopOutsideImage2;?>" name="EstablishmentImages2" id="EstablishmentImages2" class="form-control" onchange="EstablishmestImgOut2Validation();PreviewImageEstablishmestImgOut2();" >
                                <br>
                                <img src="<?php echo $getShopOutsideImage2; ?>" id="EstablishmentImagesView2" style="width: 50%; height: 200px; border-style: solid; border-width: 2px;" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" id="oldEstablishmentImages2" name="oldEstablishmentImages2" value="<?php echo $getShopOutsideImage2;?>">
                    </div>

                    <div class="col-12 col-sm-4">
                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="hidden" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
                        <input type="hidden" name="action" value="<?php echo $action; ?>" >
                    </div>
                    

                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                        <button style="margin-top:-40px;" type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                    </div>
                    
            </div>
        </form>