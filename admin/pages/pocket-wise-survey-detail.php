 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
    table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
        /* cursor: pointer;
        position: relative; */
        display: none;
    }
    table.dataTable,table.dataTable th, table.dataTable td {
        border: none;
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
        // $fromDate = date('Y-m-d', strtotime('-30 days'));
        $fromDate = $currentDate;
        $toDate = $currentDate;

        if(isset($_GET['fromDate']))
        {
            $fromDate = $_GET['fromDate'];
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }
        else if(isset($_SESSION['SAL_FromDate'])){
            $fromDate  = $_SESSION['SAL_FromDate'];
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }else{
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }

        if(isset($_GET['toDate']))
        {
            $toDate = $_GET['toDate'];
            $_SESSION['SAL_ToDate'] = $toDate ;
        }
        else if(isset($_SESSION['SAL_ToDate'])){
            $toDate  = $_SESSION['SAL_ToDate'];
            $_SESSION['SAL_ToDate'] = $toDate ;
        }else{
            $_SESSION['SAL_ToDate'] = $toDate ;
        }

        // if(!isset($_SESSION['SAL_FromDate'])){
        //     $_SESSION['SAL_FromDate'] = $fromDate ;
        // }else{
        //     $fromDate  = $_SESSION['SAL_FromDate'];
        //     $_SESSION['SAL_FromDate'] = $fromDate ;
        // }

        // if(!isset($_SESSION['SAL_ToDate'])){
        //     $_SESSION['SAL_ToDate'] = $toDate;
        // }else{
        //     $toDate = $_SESSION['SAL_ToDate'];
        //     $_SESSION['SAL_ToDate'] = $toDate;
            // if($toDate != date('Y-m-d')){
            //     $_SESSION['SAL_ToDate'] = date('Y-m-d');
            //     $toDate = $_SESSION['SAL_ToDate'];
            // }
        //}

        // if(isset($_SESSION['SAL_Node_Name'])){
        //     $nodeName = $_SESSION['SAL_Node_Name'];
        //     if(isset($_GET['node_Name'])){
        //         $nodeName = $_GET['node_Name'];
        //         $_SESSION['SAL_Node_Name'] = $nodeName;
        //     }
        // }else {
            $nodeName = "All";
        // }

        if(isset($_GET['nodeId'])){
            $nodeCd = $_GET['nodeId'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }else if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            if(isset($_GET['nodeId'])){
                $nodeCd = $_GET['nodeId'];
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
            }
        }else {
            $nodeCd = "All";
        }
        
        if(isset($_GET['pocketId'])){
            $pocket_Cd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocket_Cd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocket_Cd = $_SESSION['SAL_Pocket_Cd'];    
        }else{
            $pocket_Cd = "All";  
        }

        if(isset($_SESSION['SAL_ShopStatus']) && !empty($_SESSION['SAL_ShopStatus'])){
            $shop_Status_Post = $_SESSION['SAL_ShopStatus'];
            $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;
        }else{
            $shop_Status_Post = "All";
            $_SESSION['SAL_ShopStatus'] = $shop_Status_Post;  
        }

        if(isset($_SESSION['SAL_SurveyStatus']) && !empty($_SESSION['SAL_SurveyStatus'])){
            $survey_Status_Post = $_SESSION['SAL_SurveyStatus'];
            $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;
        }else{
            $survey_Status_Post = "All";
            $_SESSION['SAL_SurveyStatus'] = $survey_Status_Post;  
        }


        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    
    ?>

    

    <div class="row">
        <div class="col-md-12">
            <div class="card">
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

                                <!-- <div class="col-md-3 col-12"> -->
                                    <?php //include 'dropdown-node.php'; ?>
                                    <input type="hidden" name="node_Name" value="<?php echo $nodeName; ?>">
                                <!-- </div> -->
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>

                                <!-- <div class="col-md-3 col-12" id="pocketSurveyListId"> -->
                                    <input type="hidden" name="pocket_Name" value="All">
                                   <?php //include 'dropdown-pocket-name-node-cd-date.php'; ?>
                                <!-- </div> -->

                                <!-- <div class="col-md-3 col-12"> -->
                                   <?php //include 'dropdown-executives-name-node-cd-date.php'; ?>
                                   
                                   <!-- <input type="hidden" name="executive_Name" value="All"> -->
                                <!-- </div> -->
                                


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pocketWiseSurveyDetailId">                               
        <?php include 'datatbl/tblGetPocketWiseSurveyDetail.php'; ?>
    </div>    

    <!-- Modal -->
    <div class="modal fade" id="modalShowApplicationTracking" tabindex="-1" role="dialog" aria-labelledby="modalShowApplicationTracking" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Application Tracking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showShopApplicationTracking">

                </div>
                
            </div>
        </div>
    </div>

</section>


        