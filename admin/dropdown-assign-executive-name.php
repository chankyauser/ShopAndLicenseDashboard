<!-- <div class="col-sm-12"> -->
    <?php 
        if($callingType == 'Survey'){
            $userTypeCondition = " lm.User_Type like '%Executive%' ";       
        }else if($callingType == 'Calling'){
            $userTypeCondition = " lm.User_Type like '%Calling%' ";       
        }else if($callingType == 'Collection'){
            $userTypeCondition = " lm.User_Type like '%Collection%' ";       
        }else{
            $userTypeCondition = " ";
        }
     

    $query1 = "SELECT
            ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
            ISNULL(em.ExecutiveName,'')  as ExecutiveName,
            ISNULL(em.MobileNo,'')  as MobileNo
            FROM LoginMaster lm
            INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
            WHERE $userTypeCondition
            GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
            ";
            // echo $query1;
                $db1=new DbOperation();
                $userName=$_SESSION['SAL_UserName'];
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                $dataSurveyAssignExecutives = $db1->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
?>
    <div class="form-group">
        <label for="survey_executive_name"><?php echo $callingType; ?> Executive Name</label>
        <select class="select2 form-control" name="executiveCd" >
           <?php 
                foreach ($dataSurveyAssignExecutives as $key => $value) {
            ?>
                     <option value="<?php echo $value["Executive_Cd"]; ?>"><?php echo $value["ExecutiveName"]; ?></option>   
            <?php
                }
           ?>
        </select>
    </div>
<!-- </div> -->