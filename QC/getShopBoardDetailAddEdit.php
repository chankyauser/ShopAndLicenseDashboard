<div class="row">
    <div class="col-12 col-sm-12 col-md-3">
        <div class="form-group">
        <label>Board Type</label><label style="color:red;">*</label>
            <div class="controls"> 
              <select class="select2 form-control" required name="<?php echo $ScheduleCall_Cd; ?>_ShopBoardType">
                  <option value="">--Select--</option>
                  <option <?php echo $BoardType == 'Glow Sign' ? 'selected' : '' ; ?> value="Glow Sign">Glow Sign</option>
                  <option <?php echo $BoardType == 'Neon Sign' ? 'selected' : '' ; ?> value="Neon Sign">Neon Sign</option>
                  <option <?php echo $BoardType == 'Plain Board' ? 'selected' : '' ; ?> value="Plain Board">Plain Board</option>
              </select>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-3">
        <div class="form-group">
            <div class="controls">
                <label>Board Height (ft.)  </label>
                <input type="number" value="<?php echo $BoardHeight; ?>"  name="<?php echo $ScheduleCall_Cd; ?>_ShopBoardHeight" class="form-control" placeholder="Height (ft.) " maxlength="10" > 
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-3">
        <div class="form-group">
            <div class="controls">
                <label>Board Width (ft.)  </label>
                <input type="number" value="<?php echo $BoardWidth; ?>"  name="<?php echo $ScheduleCall_Cd; ?>_ShopBoardWidth"  class="form-control" placeholder="Width (ft.) " >
            </div>
        </div>
    </div>

    

    <div class="col-12 col-sm-12 col-md-2">
        <div class="form-group">
        <label>Is Board Detail Acitve</label><label style="color:red;">*</label>
            <div class="controls"> 
              <select class="select2 form-control" required name="<?php echo $ScheduleCall_Cd; ?>_IsShopBoardActive">
                  <option value="">--Select--</option>
                  <option <?php echo $IsBoardActive == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                  <option <?php echo $IsBoardActive == '0' ? 'selected' : '' ; ?> value="0">No</option>
              </select>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-3">
        <div class="form-group">
            <div class="controls">
                <label>Board Photo  </label>
                <input type="file" id="<?php echo $ScheduleCall_Cd; ?>_ShopBoardPhoto" name="<?php echo $ScheduleCall_Cd; ?>_ShopBoardPhoto"  class="form-control" onchange="BoardTypeQCImageValidation(<?php echo $ScheduleCall_Cd; ?>);" >
                <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_ShopBoardPhoto_URL" value="<?php echo $BoardPhoto; ?>" class="form-control" >
                <img id="<?php echo $ScheduleCall_Cd; ?>_ShopBoardPhoto_URL" src="<?php echo $BoardPhoto; ?>" height="100" width="100%">
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-3">
        <div class="form-group">
            <div class="controls">
                <label>QC Remark </label>
                <input type="text" name="<?php echo $ScheduleCall_Cd; ?>_SHBQCRemark1" value="<?php echo $getQCRemark1; ?>"  class="form-control" placeholder="QC Remark 1" >
                <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBQCRemark2" value="<?php echo $getQCRemark2; ?>" class="form-control" placeholder="QC Remark 2" >
                <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBQCRemark3" value="<?php echo $getQCRemark3; ?>" class="form-control" placeholder="QC Remark 3" >
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4 col-12" >
        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBScheduleCall_Id" value="<?php echo $ScheduleCall_Cd; ?>" >
        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBBoard_Id" value="<?php echo $BoardId; ?>" >
        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBShop_Id" value="<?php echo $Shop_Cd; ?>" >
        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBQCType" value="<?php echo "ShopBoard"; ?>" >
        <input type="hidden" name="<?php echo $ScheduleCall_Cd; ?>_SHBQCFlag" value="<?php echo "5"; ?>" >
        <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgsuccessSHB" class="controls alert alert-success" role="alert" style="display: none;"></div>
        <div id="<?php echo $ScheduleCall_Cd; ?>_submitmsgfailedSHB"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
    </div>

    <div class="col-sm-12 col-md-2 col-12 text-right" style="margin-top:20px;">
        <button type="button" id="<?php echo $ScheduleCall_Cd; ?>_btnShopBoardId" onclick="saveShopBoardDetailFormData(<?php echo $ScheduleCall_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1"><?php if($BoardId == 0){ echo "Add"; }else if($BoardId != 0){ ?>  Edit <?php } ?></button>
    </div>
</div>