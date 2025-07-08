 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
   
 </style>


<?php 

    $currentDate = date('Y-m-d');
    $curDate = date('Y');
    $fromDate = date('Y-m-d', strtotime('-7 days'));
    $toDate = $currentDate;
    
    $callingDate = "";

    if(isset($_GET['callingDate'])){
        $callingDate = $_GET['callingDate'];
        $_SESSION['SAL_Calling_Date'] = $callingDate;
    }else{
        if(!isset($_SESSION['SAL_Calling_Date'])){
            $currentDate = date('Y-m-d');
            $curDate = date('Y');
            $callingDate = $currentDate;
        }else{
            $callingDate = $_SESSION['SAL_Calling_Date'];
        }
    }
    if(isset($_GET['executiveId'])){
        $executiveCd = $_GET['executiveId'];
        $_SESSION['SAL_CC_Executive_Cd'] = $executiveCd;
    }

    if(isset($_SESSION['SAL_CC_Executive_Cd']) && !empty($_SESSION['SAL_CC_Executive_Cd'])){
        $executiveCd = $_SESSION['SAL_CC_Executive_Cd'];
    }else{
        $executiveCd = 0;
        $_SESSION['SAL_CC_Executive_Cd'] = $executiveCd;
    }

    

?> 
 <section id="nav-justified">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="callingDate">Calling Date</label>
                                        <input type='text' name="callingDate" value="<?php echo $callingDate;?>" class="form-control pickadate" onchange="setCallingDateInSession()" />
                                    </div>
                                </div>
                              
                                <div class="col-md-3 col-12">
                                    <?php
                                       $queryExecCC = "SELECT 
                                            ISNULL(lm.Executive_Cd,0) as Executive_Cd,
                                            ISNULL(em.ExecutiveName,'') as ExecutiveName
                                            FROM LoginMaster lm
                                            INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                                            INNER JOIN CallingDetails cdt on ( cdt.Executive_Cd = lm.Executive_Cd 
                                                AND CONVERT(VARCHAR,cdt.Call_DateTime,23) = '$callingDate' AND lm.User_Type like '%Calling%' ) 
                                            GROUP BY lm.Executive_Cd, em.ExecutiveName";
                                            // echo $queryExecCC;
                                        $db2=new DbOperation();
                                        $userName=$_SESSION['SAL_UserName'];
                                        $appName=$_SESSION['SAL_AppName'];
                                        $electionName=$_SESSION['SAL_ElectionName'];
                                        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                        $dataExecutiveList = $db2->ExecutveQueryMultipleRowSALData($queryExecCC, $electionName, $developmentMode);
                                    ?>
                                    <div class="form-group">
                                        <label>Executive Name</label>
                                        <div class="controls">
                                            <select class="select2 form-control" name="executive_Name" onChange="setCCExecutiveInSession(this.value)">
                                                <!-- <option value="">--Select--</option> -->
                                            <?php
                                                if (sizeof($dataExecutiveList)>0) 
                                                {
                                                    if($executiveCd == 0){ 
                                                        $executiveCd = $dataExecutiveList[0]["Executive_Cd"];
                                                        $_SESSION['SAL_CC_Executive_Cd'] = $executiveCd;
                                                    }
                                                    echo $_SESSION['SAL_CC_Executive_Cd'];
                                                    foreach ($dataExecutiveList as $key => $value) 
                                                    {
                                                        if($_SESSION['SAL_CC_Executive_Cd'] == $value["Executive_Cd"]){
                                            ?>
                                                            <option selected="true" value="<?php echo $value['Executive_Cd']; ?>"><?php echo $value["ExecutiveName"]; ?></option>
                                            <?php
                                                        }else{
                                            ?>
                                                            <option value="<?php echo $value["Executive_Cd"];?>"><?php echo $value["ExecutiveName"];?></option>
                                           <?php
                                                        }
                                                    }
                                                }
                                            ?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="callingSummaryId">
        <?php include 'datatbl/tblGetCallingDetail.php'; ?>
    </div>
                    
</section>


        