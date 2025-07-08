 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
   
 </style>
 <section id="nav-justified">
<?php 

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }

        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = date('Y-m-d', strtotime('-7 days'));
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

        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            if(isset($_GET['nodeId'])){
                $nodeCd = $_GET['nodeId'];
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
            }
        }else {
            $nodeCd = "All";
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }

        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
            if(isset($_GET['node_Name'])){
                $nodeName = $_GET['node_Name'];
                $_SESSION['SAL_Node_Name'] = $nodeName;
            }
        }else {
            $nodeName = "All";
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
                                        <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate-disable-forwarddates"  onchange="setFromAndToDateInSession()"/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate-disable-forwarddates"  onchange="setFromAndToDateInSession()"/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>
                                <!-- <div class="col-md-2 col-12 text-right" style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh"></label>
                                        <button type="button" name="refesh" class="btn btn-primary" onclick="getCallingSummaryList()">Refresh</button>
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="callingSummaryId">
        <?php include 'datatbl/tblGetCalliingSummary.php'; ?>
    </div>
                    
</section>


        