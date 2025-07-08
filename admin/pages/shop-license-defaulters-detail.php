<?php
        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        $fromDate = date('Y-m-d', strtotime('-7 days'));
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
                                </div>

                                <div class="col-md-3 col-12 text-right" style="margin-top: 5px;">
                                     <div class="form-group"></br>
                                        <label for="refesh" ></label>
                                        <button type="button" name="refesh" class="btn btn-primary"  onclick="getLicenseDefaulterList()">Refresh</button>
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
        <?php include 'datatbl/tblGetLicenseDefaulterList.php'; ?>
    </div>    
                                           

                    
               
      




                                
   

        