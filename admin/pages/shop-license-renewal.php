<?php
        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = date('Y-m-d', strtotime('-365 days'));
        $toDate = $currentDate;
    
        if(!isset($_SESSION['SAL_FromDate']))
        {
            $_SESSION['SAL_FromDate'] = $fromDate ;
            $fr_date = $fromDate;
            
        }
        else
        {
            $fromDate  = $_SESSION['SAL_FromDate'];
            $fr_date = $_SESSION['SAL_FromDate']; 
        }

        if(!isset($_SESSION['SAL_ToDate']))
        {
            $_SESSION['SAL_ToDate'] = $toDate;
            $t_date = $toDate;
            
        }
        else
        {
            $toDate = $_SESSION['SAL_ToDate'];
            $t_date = $_SESSION['SAL_ToDate'];
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
                    <h4 class="card-title">License Defaulters List</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="fromDate">From Date</label>
                                        <input type='text' name="fromDate" value="<?php echo $fr_date;?>" class="form-control pickadate" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $t_date;?>" class="form-control pickadate" />
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

                                <div class="col-md-6 col-12" id="pocketSurveyListId">
                                  
                                </div>

                               

                                <div class="col-md-3 col-12 text-right" style="margin-top: 5px;">
                                     <div class="form-group"></br>
                                        <label for="refesh" ></label>
                                        <button type="button" name="refesh" class="btn btn-primary"  onclick="getLicenseRenewalList()">Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="DefaulterListId">                               
        <?php include 'datatbl/tblGetLicenseRenewalList.php'; ?>
    </div>    
                                           

                    
               
      




                                
   

        