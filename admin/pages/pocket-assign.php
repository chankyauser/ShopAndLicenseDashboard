
<section id="dashboard-analytics">

<?php
        $db=new DbOperation();

        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];  

        $from_Date = date('Y-m-d', strtotime('-7 days'));
        $to_Date = date('Y-m-d');
        $assignDate = date('Y-m-d');

        
        if(!isset($_SESSION['SAL_FromDate'])){
            $_SESSION['SAL_FromDate'] = $from_Date ;
        }else{
            $from_Date  = $_SESSION['SAL_FromDate'];
        }

        if(!isset($_SESSION['SAL_ToDate'])){
            $_SESSION['SAL_ToDate'] = $to_Date;
        }else{
            $to_Date = $_SESSION['SAL_ToDate'];
        }

        $fromDate = $from_Date." ".$_SESSION['StartTime'];
        $toDate =$to_Date." ".$_SESSION['EndTime'];

        if(isset($_GET['action']) && $_GET['action'] == 'assign'){
            $_SESSION['SAL_Pocket_Cd'] = $_GET['Pocket_Cd'];
            $Pocket_Cd = $_SESSION['SAL_Pocket_Cd'];
            $_SESSION['SAL_Node_Name'] = $_GET['nodename'];
            $_SESSION['SAL_Node_Cd'] = $_GET['nodeId'];
        }
        
?>



    <div class="row match-height">
        <div class="col-md-12">
             <div class="card">
                <div class="content-body">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                        
                                
                                <input type="hidden" name="executive_Name" value="All">
                                <!-- <input type="hidden" name="node_Name" value="All">
                                <input type="hidden" name="wardName" value="All"> -->

                                <div class="col-xs-12 col-xl-3 col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-xs-12 col-xl-3 col-md-3 col-12">
                                    <?php include 'dropdown-ward.php'; ?>
                                </div>
                                <div class="col-xs-12 col-xl-3 col-md-3 col-12">
                                    <?php include 'dropdown-assign-pocket-name.php'; ?>
                                </div>

                                <div class="col-xs-6 col-xl-3 col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Assign Date</label>
                                        <div class="controls"> 
                                            <input type="date" name="assignDate" value="<?php echo $assignDate; ?>"  class="form-control pickadate-disable-assigndates" placeholder="Assign Date" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-xl-12" >
                                    <span id="idAssignPocketMsg" class="btn btn-success" style="display: none;"></span>
                                    <span id="idAssignPocketMsgSuccess" class="btn btn-success" style="display: none;"></span>
                                    <span id="idAssignPocketMsgFailure" class="btn btn-danger" style="display: none;"></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id='spinnerLoader1' style='display:none'>
        <img src='app-assets/images/loader/loading.gif' width="50" height="50"/>
    </div>
    <div class="row match-height">
            <?php include 'datatbl/tblAssignPocketData.php'; ?>
    </div>

</section>
