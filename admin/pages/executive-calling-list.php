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

    $calling_filter_type = "today";
    if(!isset($_SESSION['SAL_Calling_Filter_Type'])){
        $_SESSION['SAL_Calling_Filter_Type']=$calling_filter_type;
    }else{
        $calling_filter_type = $_SESSION['SAL_Calling_Filter_Type']; 
    }

    if(isset($_SESSION['SAL_CC_Executive_Cd'])){
        $executiveCd = $_SESSION['SAL_CC_Executive_Cd'];
    }else{
        $executiveCd = 0;
    }

    if(isset($_SESSION['SAL_Calling_Category_Cd'])){
        $callingCategoryCd = $_SESSION['SAL_Calling_Category_Cd'];
    }else{
        $callingCategoryCd = 0;
    }

        
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
               <!--  <div class="card-header">
                    <h4 class="card-title">Calling List</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                
                               <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="fromDate">From Date</label>
                                        <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate"  onchange="setFromAndToDateInSession()"/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate"  onchange="setFromAndToDateInSession()"/>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>                              

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <?php include  'datatbl/tblExecutiveCallingSummaryData.php'; ?>
    </div>