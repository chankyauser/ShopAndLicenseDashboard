<?php

      $db=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];

      $dataElectionName = $db->getSALCorporationElectionData($appName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
         <label>Corporation</label>
        <div class="controls">
            <select class="select2 form-control" name="electionName" onChange="setElectionNameInSession(this.value)" >
                 <?php
                if (sizeof($dataElectionName)>0) 
                {
                    foreach ($dataElectionName as $key => $value) 
                      {
                          if($_SESSION['SAL_Election_Cd'] == $value["Election_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Election_Cd']; ?>"><?php echo $value["ElectionName"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Election_Cd"];?>"><?php echo $value["ElectionName"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->