 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
   
 </style>
 <section id="nav-justified">
<?php 

        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = date('Y-m-d', strtotime('-365 days'));
        $toDate = $currentDate;
        if(!isset($_SESSION['SAL_FromDate'])){
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }else{
            $fromDate  = $_SESSION['SAL_FromDate'];
        }

        if(!isset($_SESSION['SAL_ToDate'])){
            $_SESSION['SAL_ToDate'] = $toDate;
        }else{
            $toDate = $_SESSION['SAL_ToDate'];
            // if($toDate != date('Y-m-d')){
            //     $_SESSION['SAL_ToDate'] = date('Y-m-d');
            //     $toDate = $_SESSION['SAL_ToDate'];
            // }
        }

        if(isset($_GET['nodeId'])){
            $_SESSION['SAL_Node_Cd'] = $_GET['nodeId'];
        }

        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            if($nodeCd != 'All' ){
                $query2 = "SELECT
                    ISNULL(Node_Cd,0) as Node_Cd,
                    ISNULL(NodeName,'') as NodeName,
                    ISNULL(NodeNameMar,'') as NodeNameMar,
                    ISNULL(Ac_No,0) as Ac_No,
                    ISNULL(Ward_No,0) as Ward_No,
                    ISNULL(Address,'') as Address,
                    ISNULL(Area,'') as Area
                    FROM NodeMaster
                    WHERE Node_Cd = $nodeCd";
                $db2=new DbOperation();
                $userName=$_SESSION['SAL_UserName'];
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                $dataNode = $db2->ExecutveQuerySingleRowSALData($query2, $electionName, $developmentMode);
                if(sizeof($dataNode)>0){
                    $_SESSION['SAL_Node_Name'] = $dataNode["NodeName"];
                }    
            }
        }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Pocket Survey Summary</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="fromDate">From Date</label>
                                        <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate-disable-forwarddates" onchange="setFromAndToDateInSession()" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate-disable-forwarddates" onchange="setFromAndToDateInSession()" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>
                                <!-- <div class="col-md-2 col-12 text-right"  style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh"></label>
                                        <button type="button" name="refesh" class="btn btn-primary" onclick="getPocketWiseSurveySummary()" >Refresh</button>
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pocketWiseSurveySummaryId">
        <?php include 'datatbl/tblGetPocketWiseSurveySummary.php'; ?>
    </div>

                    
</section>


        