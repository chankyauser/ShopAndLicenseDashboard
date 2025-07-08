<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    
    $query ="SELECT
            ISNULL(um.User_Id,0) as User_Cd,
            ISNULL(um.Executive_Cd,0) as Executive_Cd,
            ISNULL(um.UserName,'') as UserName,
            ISNULL(um.UserType,'') as UM_UserType,
            COALESCE(
                        CASE WHEN um.UserType = 'A' THEN 'ORNET' END,
                        CASE WHEN um.UserType = 'C' THEN 'CLIENT' END,
                '') as UM_UserCategory,
            ISNULL(um.Remarks, '') as FullName, 
            ISNULL(um.Mobile,'') as Mobile,
            ISNULL(um.ExpDate,'') as ExpDate
        FROM Survey_Entry_Data..User_Master um 
        LEFT JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = um.Executive_Cd
        WHERE AppName = '$appName'";
      $dataUser = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
      // print_r($dataUser);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>User</label>
        <div class="controls">
            <select class="select2 form-control" name="userName"
                <?php if(isset($_GET['loginId']) && $_GET['loginId'] != 0 ){ ?> disabled <?php } ?>
            >
                <option value="">--Select--</option>
                 <?php
                if (sizeof($dataUser)>0) 
                {
                    foreach ($dataUser as $key => $value) 
                      {
                          if($userCd == $value["User_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['User_Cd']; ?>"><?php echo $value["FullName"]." ". $value["Mobile"]. " [". $value["UM_UserCategory"]."]" ; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["User_Cd"];?>"><?php echo $value["FullName"]." ". $value["Mobile"]. " [". $value["UM_UserCategory"]."]" ;?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->