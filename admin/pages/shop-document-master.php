<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT * FROM ShopDocumentMaster;";
    $ShopDocumentList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    $style = "style=''";
    $style1 = "style='display:none;'";

    $DocumentType = "";
    $IsCompulsory = 0;
    $IsActive = 1;

        if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['Document_Cd']) && !empty($_GET['Document_Cd']))
        {
        
            $style = "style='display:none;'";
            $style1 = "style=''";
            $Document_Cd = $_GET['Document_Cd'];

            $query1 = "SELECT * FROM ShopDocumentMaster WHERE Document_Cd = $Document_Cd;";
            $EditList = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
            $Document_Cd = $EditList['Document_Cd'];
            $DocumentName = $EditList['DocumentName'];
            $DocumentNameMar = $EditList['DocumentNameMar'];
            $DocumentType = $EditList['DocumentType'];
            $IsCompulsory = $EditList['IsCompulsory'];
            $IsActive = $EditList['IsActive'];

        }else if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['Document_Cd']) && !empty($_GET['Document_Cd']))
        { 
        
            $Document_Cd = $_GET['Document_Cd'];
       
            $query1 = "UPDATE ShopDocumentMaster SET IsActive = 0 WHERE Document_Cd = $Document_Cd;";
            $deleteDoc = $db->RunQuerySALData($query1, $electionName, $developmentMode);

            header("Location: home.php?p=shop-document-master");

        }

?>
<section id="shop-document-master">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- nodeCd -->
                <h4 class="card-title" <?php echo $style;?>>Create Shop Document</h4>
                    <h4 class="card-title" <?php echo $style1;?>>Edit Shop Document</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Document Name *</label>
                                    <div class="controls"> 
                                        <input type="hidden" name="Document_Cd" value="<?php if(isset($_GET['Document_Cd'])) {echo $Document_Cd;}?>" class="form-control" data-validation-required-message="This field is required" placeholder="Document Cd" required>
                                        <input type="text" name="documentName" value="<?php if(isset($_GET['Document_Cd'])) {echo $DocumentName;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Document Name">
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Document Name (Marathi)</label>
                                    <div class="controls"> 
                                        <input type="text" name="documentNameMar" value="<?php if(isset($_GET['Document_Cd'])) {echo $DocumentNameMar;}?>"  class="form-control" data-validation-required-message="This field is required" placeholder="Document Name (Marathi)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Document Type *</label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="documentType" >
                                        <option value="">--Select--</option>   
                                        <option <?php echo $DocumentType == 'image' ? 'selected' : '' ; ?> value="image">Image</option>
                                        <option <?php echo $DocumentType == 'pdf' ? 'selected' : '' ; ?> value="pdf">Pdf</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>IsCompulsory</label>
                                    <div class="controls"> 
                                        <select class="select2 form-control" name="isCompulsory" >
                                        <option value="" >--Select--</option>  
                                        <option <?php echo $IsCompulsory == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                                        <option <?php echo $IsCompulsory == '0' ? 'selected' : '' ; ?> value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>IsActive *</label>
                                    <div class="controls"> 
                                    <select class="select2 form-control" name="IsActive" >
                                        <option value="" >--Select--</option>  
                                        <option <?php echo $IsActive == '1' ? 'selected' : '' ; ?> value="1">Yes</option>
                                        <option <?php echo $IsActive == '0' ? 'selected' : '' ; ?> value="0">No</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 30px;">
                                <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-3 text-right" style="margin-top: 30px;">
                                <button type="button" id="submitBtnId" class="btn btn-primary mr-1 mb-1" onclick="ShopDocumentMaster()">SAVE</button>
                            </div>          
                        </div>               
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
                    <h4 class="card-title">Shop Document Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                       <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>Document Name</th>
                                        <th>Document Name (Marathi)</th>
                                        <th>Document Type</th>
                                        <th>Is Compulsory</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($ShopDocumentList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["DocumentName"]; ?></td>
                                            <td><?php echo $value["DocumentNameMar"]; ?></td>
                                            <td><?php echo $value["DocumentType"]; ?></td>
                                            <td><?php if($value["IsCompulsory"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                           <td>
                                                <a href="home.php?p=shop-document-master&action=edit&Document_Cd=<?php echo $value["Document_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                                <a href="home.php?p=shop-document-master&action=delete&Document_Cd=<?php echo $value["Document_Cd"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="feather icon-trash-2 mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Document Name (Marathi)</th>
                                        <th>Document Type</th>
                                        <th>Is Compulsory</th>
                                        <th>Active</th>
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


        