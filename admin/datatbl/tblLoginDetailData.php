<?php

      $db=new DbOperation();
      $userName=$_SESSION['CHCZ_UserName'];
      $appName=$_SESSION['CHCZ_AppName'];
      $electionCd=$_SESSION['CHCZ_Election_Cd'];
      $electionName=$_SESSION['CHCZ_ElectionName'];
      $developmentMode=$_SESSION['DevelopmentMode'];
      $condition = "AllLoginDetail";
      $loginCd = 0;
      if(isset($_GET['loginid']) && $_GET['loginid']!=0){
        $condition = "AllLoginDetail";
        $loginCd = $_GET['LoginDetailByLoginCd'];
      }
      

      $dataLoginMaster = $db->getLoginDetailData($userName, $appName, $electionCd, $electionName, $developmentMode, $condition, $loginCd);
      // print_r($dataLoginMaster);
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login Detail - List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                      <!--   <p class="mt-1">Add <code>novalidate</code> attribute to form tag and <code>required</code> attribute to input tag.</p> -->
                       <div class="table-responsive">
                            <!-- <table class="table table-striped table-bordered complex-headers"> -->
                            <table  id="tblLoginDetailData" class="table">
                                <thead>
                                     <tr>
                                        <th>FullName</th>
                                        <th>Mobile</th>
                                        <th>Designation</th>
                                        <th>AppVersion</th>
                                        <th>UserType</th>
                                        <th>LastLogin</th>
                                        <th>ExpiryDate</th>
                                        <th>UHP</th>
                                        <!-- <th>Ward</th> -->
                                        <th>WardName</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($dataLoginMaster as $key => $value) {
                                   ?> 
                                        <tr>
                                            <td><?php echo $value["FullName"]; ?></td>
                                            <td><?php echo $value["Mobile_No"]; ?></td>
                                            <td><?php echo $value["Designation"]; ?></td>
                                            <td><?php echo $value["MobileAppVersion"]; ?></td>
                                            <td><?php echo $value["User_Type"]; ?></td>
                                            <td><?php echo date('d/m/Y h:i a', strtotime($value["UpdatedDate"])); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($value["ExpDate"])); ?></td>
                                            <td><?php echo $value["UHPName"]; ?></td>
                                           <!--  <td><?php //echo $value["WardNo"]; ?></td> -->
                                            <td><?php echo $value["NodeName"]; ?></td>
                                            <td>
                                              <?php  if(!empty($value["Latitude"]) && !empty($value["Logitude"]) ){
                                                        ?>
                                                             <a target="_blank" href="<?php echo "https://www.google.com/maps/place/".trim($value["Latitude"]).",".trim($value["Logitude"]); ?>" >
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a target="_blank"  href="">
                                                        <?php
                                                    }
                                                ?>
                                                <a href="home.php?p=login-master&action=edit&loginId=<?php echo $value["Login_Cd"]; ?>"><i class="feather icon-edit mr-50 font-medium-3"></i>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th>FullName</th>
                                        <th>Mobile</th>
                                        <th>Designation</th>
                                        <th>AppVersion</th>
                                        <th>UserType</th>
                                        <th>LastLogin</th>
                                        <th>ExpiryDate</th>
                                        <th>UHP</th>
                                        <!-- <th>Ward</th> -->
                                        <th>WardName</th>
                                        <th>Location</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>