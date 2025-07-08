<?php

        $db=new DbOperation();
      
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        
        $query = "
            SELECT
                ISNULL(lm.Login_Cd,0) as Login_Cd,
                ISNULL(lm.User_Cd,0) as User_Cd,
                ISNULL(lm.Executive_Cd,0) as Executive_Cd,
                ISNULL(lm.User_Type,'') as User_Type,
                ISNULL(lm.Mobile_No,'') as Mobile_No,
                ISNULL(um.UserName,'') as UserName,
                ISNULL(um.UserType,'') as UM_UserType,
                COALESCE(
                        CASE WHEN um.UserType = 'A' THEN 'ORNET' END,
                        CASE WHEN um.UserType = 'C' THEN 'CLIENT' END,
                '') as UM_UserCategory,
                ISNULL(um.Executive_Cd,0) as UM_Executive_Cd,
                ISNULL(um.Remarks, '') as FullName, 
                ISNULL(um.Mobile,'') as Mobile,
                ISNULL(um.ExpDate,'') as ExpDate,
                ISNULL(um.ElectionName,'') as DefaultElectionName,
                ISNULL( (SELECT CONVERT(VARCHAR,max(ld.UpdatedDate),121) 
                    FROM LoginDetails ld WHERE ld.User_Cd = lm.User_Cd ),'') as LastLoginDate,
                ISNULL(um.DeactiveFlag,'') as DeactiveFlag
            FROM LoginMaster lm
            LEFT JOIN Survey_Entry_Data..User_Master um on um.User_Id = lm.User_Cd
            LEFT JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd 
            ORDER BY LastLoginDate DESC";

      $dataLoginMaster = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
      // print_r($dataLoginMaster);
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login Master - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                     
                        <div class="table-responsive">
                            <table id="tblLoginMasterData" class="table table-striped table-bordered complex-headers">
                            <!-- <table class="table row-grouping"> -->
                                <thead>
                                     <tr>
                                        <th>Sr No</th>
                                        <th>Full Name</th>
                                        <th>Designation</th>
                                        <th>Mobile No</th>
                                        <th>Default Corporation</th>
                                        <th>User Category</th>
                                        <th>Last Login</th>
                                        <th>License Expire</th>
                                        <th>License Deactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $srNo=0;
                                        foreach ($dataLoginMaster as $key => $value) {
                                            $srNo = $srNo + 1;
                                   ?> 
                                        <tr>
                                            <td><?php echo $srNo; ?></td>
                                            <td><?php echo $value["FullName"]; ?></td>
                                            <td><?php echo $value["User_Type"]; ?></td>
                                            <td><?php echo $value["Mobile"]; ?></td>
                                            <td><?php echo $value["DefaultElectionName"]; ?></td>
                                            <td><?php //if($value["UM_UserType"]=='A'){ echo "ORNET"; }else if($value["UM_UserType"]=='C'){ echo "CLIENT"; } ?> <?php echo $value["UM_UserCategory"] ?></td>
                                            <td><?php if(!empty($value["LastLoginDate"])){  echo date('d/m/Y h:i a', strtotime($value["LastLoginDate"])); } ?></td>
                                            <td <?php if(date('Y-m-d', strtotime($value["ExpDate"])) <= date('Y-m-d') ){ ?> style="color: red;" <?php } ?> ><?php echo $value["ExpDate"]; ?></td>
                                            <td><?php if($value["DeactiveFlag"]=='D'){ ?> <span class="badge badge-danger">Yes</span><?php }else if(empty($value["DeactiveFlag"])){ ?> <span class="badge badge-success">No</span><?php } ?> </td>
                                            <td>
                                                <!-- <a href="home.php?p=login-detail&loginId=<?php //echo $value["Login_Cd"]; ?>"><i class="feather icon-list mr-50 font-medium-3"></i></a> -->
                                                <a href="home.php?p=login-master&action=edit&loginId=<?php echo $value["Login_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i></a>
                                                <a href="home.php?p=login-master&action=delete&loginId=<?php echo $value["Login_Cd"]; ?>"><i class="feather icon-trash-2 mr-50 font-medium-3"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                       <th>Sr No</th>
                                        <th>Full Name</th>
                                        <th>Designation</th>
                                        <th>Mobile No</th>
                                        <th>User Category</th>
                                        <th>Last Login</th>
                                        <th>License Expire</th>
                                        <th>License Deactive</th>
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