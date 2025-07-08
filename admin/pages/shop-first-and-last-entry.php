<section id="ExecutiveWiseLog-report"> 

<?php

    $DateFormat = Date('Y-m-d');
    $filterType = 'ShopSurvey';
       
    if(isset($_SESSION['SAL_SHOP_QC_Type']) && !empty($_SESSION['SAL_SHOP_QC_Type'])){
        $filterType = $_SESSION['SAL_SHOP_QC_Type'];
    }

    if(isset($_SESSION['SAL_Calling_Date']) && !empty($_SESSION['SAL_Calling_Date'])){
        $DateFormat = $_SESSION['SAL_Calling_Date'];
    }
?>
 <div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">

            <div class="card-content">
                <div class="card-body">
                        <div class="row">

                            <div class="col-xl-3 col-md-3 col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="controls"> 
                                        <input type="date" name="surveyDate" value="<?php echo $DateFormat;?>"  class="form-control pickadate-disable-forwarddates" placeholder="Date" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group">
                                    <label>Filter Type</label>
                                    <div class="controls"> 
                                        <select class="select2 form-control" name="filterType" required>
                                            <option value="">--Select--</option>   
                                            <option <?php echo $filterType == 'ShopList' ? 'selected' : '' ; ?> value="ShopList">Shop List</option>
                                            <option <?php echo $filterType == 'ShopSurvey' ? 'selected' : '' ; ?> value="ShopSurvey">Shop Survey</option>
                                            <option <?php echo $filterType == 'ShopCalling' ? 'selected' : '' ; ?> value="ShopCalling">Shop Calling</option>
                                            <option <?php echo $filterType == 'ShopQC' ? 'selected' : '' ; ?> value="ShopQC">Shop QC</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-3 col-xl-3">
                            </div>
    
                            <div class="col-xs-12 col-md-3 col-xl-3 text-right">
                                 <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                 <div class="controls">
                                    <button id="submitData" type="button" class="btn btn-primary" onclick="setFirstAndLastEntryData()">Refresh</button>
                                </div>
                            </div>

                        </div>
              </div>
            </div>
        </div>
    </div>
</div>
      

    <div id="showFirstAndLastEntryDetail">
        <?php include 'datatbl/tblFirstAndLastEntryDetail.php'; ?>
    </div>

</section>