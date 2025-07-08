<!-- <div class="col-sm-12"> -->
    <?php 

        $query1 = "SELECT
            ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
            ISNULL(em.ExecutiveName,'')  as ExecutiveName,
            ISNULL(em.MobileNo,'')  as MobileNo
            FROM LoginMaster lm
            INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
            WHERE lm.User_Type like '%QC%' 
            GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
			ORDER BY em.ExecutiveName ASC
            ";
            // echo $query1;
            $db1=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];
            $dataQCExecutives = $db1->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
?>
    <div class="form-group">
        <label for="survey_executive_name">QC Executive Name</label>
        <select class="select2 form-control" name="executiveCd" >
            <option <?php echo $qcExecutiveCd == 'All' ? 'selected=true' : '';
                                if($qcExecutiveCd == 'All'){
                                $_SESSION['SAL_QC_Executive_Cd'] = $qcExecutiveCd;
                            }
                ?> value="All">All</option>
           <?php 
                foreach ($dataQCExecutives as $key => $value) {

                    if($_SESSION['SAL_QC_Executive_Cd'] == $value["Executive_Cd"])
                    {

            ?>
                     <option selected value="<?php echo $value["Executive_Cd"]; ?>"><?php echo $value["ExecutiveName"]; ?></option>   
            <?php
                    }else{
            ?>
                    <option value="<?php echo $value["Executive_Cd"]; ?>"><?php echo $value["ExecutiveName"]; ?></option>   
            <?php
                    }
                }
           ?>
        </select>
    </div>
<!-- </div> -->