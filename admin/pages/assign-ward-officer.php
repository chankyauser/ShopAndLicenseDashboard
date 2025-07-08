<section id="login-master">

    <?php 

        $db=new DbOperation();
      
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $query = "SELECT *,
        COALESCE((SELECT Remarks as UserName FROM
        Survey_Entry_Data..User_Master WHERE User_Id = nm.WardOfficerUser_Cd), '') as WardOfficerName
        FROM NodeMaster as nm;";
        $NodeList = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
        $style = "style=''";
        $style1 = "style='display:none;'";
        $IsActive = 1;
        $userCd = 0;

    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assign Ward Officer </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <?php include 'dropdown-ward-officer.php'; ?>
                                </div>

                                <div class="col-xs-3 col-md-3 col-xl-3">
                                     <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <div class="controls text-left">
                                     <input type="hidden" class="form-control" name="multipleWards" >
                                        <label for="refesh"></label>
                                        <button id="submitOfficeCdId" type="button" class="btn btn-primary" onclick="AssignWardOfficer()" >
                                            Assign
                                        </button>
                                    </div>
                                </div>
                            
                                <div class="col-xs-3 col-md-3 col-xl-3">
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
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

    <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Node (ward) - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    
                       <div class="table-responsive">
                       <table class="table table-striped table-bordered zero-configuration complex-headers">
                                <thead>
                                     <tr>
                                        <th>Select</th>
                                        <th>Node Name</th>
                                        <th>Node Name (Marathi)</th>
                                        <th>Assembly No</th>
                                        <th>Ward No</th>
                                        <th>Address</th>
                                        <th>Area</th>
                                        <th>Ward Officer Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($NodeList as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td> 
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="<?php echo $value["Node_Cd"]; ?>" name="assignWards" onclick="setSelectMultipleWards()" >
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><?php echo $value["NodeName"]; ?></td>
                                            <td><?php echo $value["NodeNameMar"]; ?></td>
                                            <td><?php echo $value["Ac_No"]; ?></td>
                                            <td><?php echo $value["Ward_No"]; ?></td>
                                            <td><?php echo $value["Address"]; ?></td>
                                            <td><?php echo $value["Area"]; ?></td>
                                            <td><?php echo $value["WardOfficerName"]; ?></td>
                                            <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>Node Name</th>
                                        <th>Node Name (Marathi)</th>
                                        <th>Assembly No</th>
                                        <th>Ward No</th>
                                        <th>Address</th>
                                        <th>Area</th>
                                        <th>Ward Officer Name</th>
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


</section>