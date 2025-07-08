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
            if($toDate != date('Y-m-d')){
                $_SESSION['SAL_ToDate'] = date('Y-m-d');
                $toDate = $_SESSION['SAL_ToDate'];
            }
        }

        if(isset($_SESSION['SAL_Node_Cd'])){
            $node_Cd = $_SESSION['SAL_Node_Cd'];
            if(isset($_GET['nodeId'])){
                $node_Cd = $_GET['nodeId'];
                $_SESSION['SAL_Node_Cd'] = $node_Cd;
            }
        }else {
            $node_Cd = 0;
        }
        
        if(isset($_GET['pocketId'])){
            $pocket_Cd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocket_Cd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocket_Cd = $_SESSION['SAL_Pocket_Cd'];    
        }else{
            $pocket_Cd = 0;  
        }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Shop Survey Detail</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="fromDate">From Date</label>
                                        <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate" />
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>

                                <div class="col-md-3 col-12" id="pocketSurveyListId">
                                   <?php include 'dropdown-pocket-name-node-cd-date.php'; ?>
                                </div>

                                <div class="col-md-9 col-12 text-right"   style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh" ></label>
                                        <button type="button" name="refesh" class="btn btn-primary" onclick="getPocketWiseSurveyDetail()" >Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pocketWiseSurveyDetailId">                               
        <?php include 'datatbl/tblGetShopSurveyDetails.php'; ?>
    </div>    

</section>   