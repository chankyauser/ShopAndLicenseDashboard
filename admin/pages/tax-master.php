<?php

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
            
      $query = "SELECT * FROM TaxMaster WHERE IsActive = 1;";
      $TaxList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
      $style = "style=''";
      $style1 = "style='display:none;'";

      if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['Tax_Cd']) && !empty($_GET['Tax_Cd']))
      {
        
        $style = "style='display:none;'";
        $style1 = "style=''";
        $Tax_Cd = $_GET['Tax_Cd'];

        $query1 = "SELECT * FROM TaxMaster WHERE Tax_Cd = $Tax_Cd;";
        $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
        $Tax_Cd = $EditList['Tax_Cd'];
        $TaxName = $EditList['TaxName'];
        $PercentageOfTax = $EditList['PercentageOfTax'];
        $Remark = $EditList['Remark'];
        $IsActive = $EditList['IsActive'];
      }
      if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['Tax_Cd']) && !empty($_GET['Tax_Cd']))
      {
        
            $Tax_Cd = $_GET['Tax_Cd'];
       
            $query1 = "UPDATE TaxMaster SET IsActive = 0 WHERE Tax_Cd = $Tax_Cd;";
            $deleteTax = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=tax-master");
     }

?>
<section id="node-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create Tax</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Tax</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                    <form action="" method="post">
                            <div class="row">
                            <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>TaxName</label>
                                        <div class="controls"> 
                                        <input type="hidden" name="Tax_Cd" value="<?php if(isset($_GET['Tax_Cd'])) {echo $Tax_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Tax Cd" required>
                                        <input type="text" name="TaxName" value="<?php if(isset($_GET['Tax_Cd'])) {echo $TaxName;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Tax Name" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Percentage Of Tax</label>
                                        <div class="controls"> 
                                            <input type="number" name="PercentageOfTax" value="<?php if(isset($_GET['Tax_Cd'])) {echo $PercentageOfTax;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Percentage Of Tax" >
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="Remark" value="<?php if(isset($_GET['Tax_Cd'])) {echo $Remark;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Remark" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>IsActive</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="IsActive" >
                                            <option value="" selected disabled>--Select--</option>    
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 text-left">
                                    <button type="button" id="submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="TaxMaster()">SAVE</button>
                                    <button type="reset" class="btn btn-outline-warning mr-1 mb-1" <?php echo $style;?>>Reset</button>
                                    <button type="button" class="btn btn-outline-warning mr-1 mb-1" <?php echo $style1;?> onclick="location.href = 'home.php?p=tax-master';">Cancel</button>
                                    <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tax Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <!--   <p class="mt-1">Add <code>novalidate</code> attribute to form tag and <code>required</code> attribute to input tag.</p> -->
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                            <!-- <table  id="tblLoginDetailData" class="table"> -->
                                <thead>
                                     <tr>
                                        <th>Tax Name</th>
                                        <th>Percentage Of Tax</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($TaxList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["TaxName"]; ?></td>
                                            <td><?php echo $value["PercentageOfTax"]; ?></td>
                                           <td>
                                                <a href="home.php?p=tax-master&action=edit&Tax_Cd=<?php echo $value["Tax_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=tax-master&action=delete&Tax_Cd=<?php echo $value["Tax_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-delete mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Tax Name</th>
                                        <th>Percentage Of Tax</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
        