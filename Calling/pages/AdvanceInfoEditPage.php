

<form action="action/saveShopAdvancedInfoData.php" method="POST" enctype="multipart/form-data" novalidate>
    <div class="row mt-1">
        
        <div class="col-12 col-sm-3">
            <div class="form-group">
            <label>Municipal Ward Number </label><label style="color:red;">*</label>
                <div class="controls"> 
                <select class="select2 form-control" name="MunicipalWardNumber" id="MunicipalWardNumber" required>
                    <option  value="">--Select--</option>   
                        <?php if (sizeof($MunicipalWardNoDropDown)>0) 
                            {
                                foreach($MunicipalWardNoDropDown as $key => $value)
                                {
                                    if($getMuncipalWN == $value["DValue"])
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
            <label>Establishment Area Category</label>
                <div class="controls"> 
                <select class="select2 form-control" name="EstablishmentAreaCategory" id="EstablishmentAreaCategory">
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
       
        <div class="col-12 col-sm-3">
            <div class="form-group">
            <label>Establishment Category </label><label style="color:red;">*</label>
                <div class="controls"> 
                <select class="select2 form-control" name="EstablishmentCategory" id="EstablishmentCategory" required>
                    <option  value="">--Select--</option>   
                        <?php if (sizeof($EstablishmentCategoryDropDown)>0) 
                            {
                                foreach($EstablishmentCategoryDropDown as $key => $value)
                                {
                                    if($getShopCategory == $value["DValue"])
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
            <label>New Registration of Parwana</label>
                <div class="controls"> 
                <select class="select2 form-control" name="NewRegistrationofParwana" id="NewRegistrationofParwana" >
                    <option  value="">--Select--</option>   
                        <?php if (sizeof($IsNewParwanaDropDown)>0) 
                            {
                                foreach($IsNewParwanaDropDown as $key => $value)
                                {
                                    if($getIsNewParwana == $value["DValue"])
                                    {
                                ?> 
                                        <option selected="true" value="<?php if($value['DValue'] == 'Yes'){
                                            echo 1;
                                        } else{
                                            echo 0;
                                        };?>"><?php echo $value['DValue'];?></option>
                                <?php 
                                    }else { 
                                ?>
                                        <option value="<?php if($value['DValue'] == 'No'){
                                            echo 0;
                                        } else {
                                            echo 1;
                                        };?>"><?php echo $value["DValue"];?></option>
                                <?php }
                                }
                            } 
                        ?>
                </select>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="form-group">
            <label>Parwana Type </label><label style="color:red;">*</label>
                <div class="controls"> 
                <select class="select2 form-control" name="ParwanaType" id="ParwanaType" required>
                    <option  value="">--Select--</option>   
                        <?php if (sizeof($ParwanaTypeDropDown)>0) 
                            {
                                foreach($ParwanaTypeDropDown as $key => $value)
                                {
                                    if($getParwana_Cd == $value["Parwana_Cd"])
                                    {
                                    ?> 
                                        <option selected="true" value="<?php echo $value['Parwana_Cd'];?>"><?php echo $value['Parwana_Name_Eng'];?></option>
                                        <?php }
                                        else
                                        { ?>
                                        <option value="<?php echo $value["Parwana_Cd"];?>"><?php echo $value["Parwana_Name_Eng"];?></option>
                                <?php }
                                }
                            } ?>
                </select>
                </div>
            </div>
        </div>


        
        <div class="col-12 col-sm-6">
            <div class="row">
                <div><input type="hidden" name="BoardID1" id="BoardID1" value="<?php echo $getBoardID1;?>"></div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                    <label>Board Type 1 </label><label style="color:red;">*</label>
                        <div class="controls"> 
                        <select class="select2 form-control" name="BoardType1" id="BoardType1" required>
                            <option  value="">--Select--</option>   
                                <?php if (sizeof($BoardTypeDropDown)>0) 
                                    {
                                        foreach($BoardTypeDropDown as $key => $value)
                                        {
                                            if($getBoardType1 == $value["DValue"])
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

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Height</label>
                            <input type="text" value="<?php echo $getBoardHeight1;?>" name="BoardHeight1" id="BoardHeight1" class="form-control" placeholder="Board Height" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Width</label>
                            <input type="text" value="<?php echo $getBoardWidth1;?>" name="BoardWidth1" id="BoardWidth1" class="form-control" placeholder="Board Width" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>

                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label>Board Type 1 Image</label>
                            <input type="file" name="BoardType1Image" id="BoardType1Image" class="form-control"  value="<?php echo $getBoardPhoto1;?>" onchange="BoardType1ImageValidation();PreviewImageBoardType1();" >
                            <input type="hidden" id="oldBoardType1Image" name="oldBoardType1Image" value="<?php echo $getBoardPhoto1;?>">
                            <br>
                            <img src="<?php echo $getBoardPhoto1;?>" id="BoardType1ImageView" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                        </div>
                    </div>
                </div>

        
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="row">

                <div><input type="hidden" name="BoardID2" id="BoardID2" value="<?php echo $getBoardID2;?>"></div>
        
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                    <label>Board Type 2 </label><label style="color:red;">*</label>
                        <div class="controls"> 
                        <select class="select2 form-control" name="BoardType2" id="BoardType2" required>
                            <option  value="">--Select--</option>   
                                <?php if (sizeof($BoardTypeDropDown)>0) 
                                    {
                                        foreach($BoardTypeDropDown as $key => $value)
                                        {
                                            if($getBoardType2 == $value["DValue"])
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

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Height</label>
                            <input type="text" value="<?php echo $getBoardHeight2; ?>" name="BoardHeight2" id="BoardHeight2" class="form-control" placeholder="Board Height" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Width</label>
                            <input type="text" value="<?php echo $getBoardWidth2; ?>" name="BoardWidth2" id="BoardWidth2" class="form-control" placeholder="Board Width" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>


                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label>Board Type 2 Image</label>
                            <input type="file" name="BoardType2Image" id="BoardType2Image" class="form-control" value="<?php echo $getBoardPhoto2;?>" onchange="BoardType2ImageValidation();PreviewImageBoardType2();" >
                            <input type="hidden" id="oldBoardType2Image" name="oldBoardType2Image" value="<?php echo $getBoardPhoto2;?>">
                            <br>
                            <img src="<?php echo $getBoardPhoto2; ?>" id="BoardType2ImageView" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="row">
        
                <div><input type="hidden" name="BoardID3" id="BoardID3" value="<?php echo $getBoardID3;?>"></div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                    <label>Board Type 3 </label><label style="color:red;">*</label>
                        <div class="controls"> 
                        <select class="select2 form-control" name="BoardType3" id="BoardType3" required>
                            <option  value="">--Select--</option>   
                                <?php if (sizeof($BoardTypeDropDown)>0) 
                                    {
                                        foreach($BoardTypeDropDown as $key => $value)
                                        {
                                            if($getBoardType3 == $value["DValue"])
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

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Height</label>
                            <input type="text" value="<?php echo $getBoardHeight3;?>" name="BoardHeight3" id="BoardHeight3" class="form-control" placeholder="Board Height" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <label>Board Width</label>
                            <input type="text" value="<?php echo $getBoardWidth3;?>" name="BoardWidth3" id="BoardWidth3" class="form-control" placeholder="Board Width" onkeypress="return isNumberKey(event,this)">
                        </div>
                    </div>


                </div>
        
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label>Board Type 3 Image</label>
                            <input type="file" name="BoardType3Image" id="BoardType3Image" class="form-control"  value="<?php echo $getBoardPhoto3;?>" onchange="BoardType3ImageValidation();PreviewImageBoardType3();" >
                            <input type="hidden" id="oldBoardType3Image" name="oldBoardType3Image" value="<?php echo $getBoardPhoto3;?>">
                            <br>
                            <img src="<?php echo $getBoardPhoto3;?>" id="BoardType3ImageView" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="row">
        
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label>Establishment Image 1 (From Inside)</label>
                            <input type="file"  name="ImagesofEstablishment" id="ImagesofEstablishment" class="form-control" value="<?php echo $getShopInsideImage1;?>" onchange="ImagesofEstablishment1Validation();PreviewImageEstablishmentImgIn1();" >
                            <input type="hidden" id="oldImagesofEstablishment" name="oldImagesofEstablishment" value="<?php echo $getShopInsideImage1;?>">
                            <br>
                            <img src="<?php echo $getShopInsideImage1 ;?>" id="ImagesofEstablishmentView" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label>Establishment Image 2 (From Inside)</label>
                            <input type="file" name="ImagesofEstablishment2" id="ImagesofEstablishment2" class="form-control" value="<?php echo $getShopInsideImage2;?>" onchange="ImagesofEstablishment2Validation();PreviewImageEstablishmentImgIn2();" >
                            <input type="hidden" id="oldImagesofEstablishment2" name="oldImagesofEstablishment2" value="<?php echo $getShopInsideImage2;?>">
                            <br>
                            <img src="<?php echo $getShopInsideImage2 ;?>" id="ImagesofEstablishmentView2" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                        </div>
                    </div>
                </div>


            </div>
        </div>



        <div class="col-12 col-sm-9">
            <div class="form-group">
                <div class="controls">
                    <label>Shop Owner Home Address</label>
                    <input type="text" value="<?php echo $getShopOwnerAddress;?>" name="ShopOwnerHomeAddress" id="ShopKeeperHomeAddress" class="form-control" placeholder="Shop Keeper Home Address" >
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="form-group">
                <div class="controls">
                    <label>Establishment Area (sq.ft)</label>
                    <input type="text" value="<?php echo $getShopArea; ?>" name="EstablishmentArea" id="EstablishmentArea" class="form-control" placeholder="Establishment Area" >
                </div>
            </div>
        </div>


        <div class="col-12 col-sm-3">
            <div class="form-group">
            <label>Owned / Rented</label><label style="color:red;">*</label>
                <div class="controls"> 
                <select class="select2 form-control" name="Owned_Rented" id="Owned_Rented" required>
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
            </div>
        </div>

        
        <div class="col-12 col-sm-3">
            <div class="form-group">
                <div class="controls">
                    <label>Owned / Rented Time (in months)</label>
                    <input type="text" value="<?php echo $getShopOwnPeriod;?>" name="Owned_RentedTime" id="Owned_RentedTime" class="form-control" placeholder="Owned / Rented Time" value="">
                </div>
            </div>
        </div>

        <div class="col-12  col-sm-6 text-right" style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

        <div class="col-12 col-sm-12">
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="hidden" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
            <input type="hidden" name="action" value="<?php echo $action; ?>" >
        </div>

    </div>
</form>