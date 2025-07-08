<?php

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

       
        if(isset($_GET['fromDate'])){
            $from_Date = $_GET['fromDate'];
            $_SESSION['SAL_FromDate'] = $from_Date;
        }else if(isset($_SESSION['SAL_FromDate'])){
            $from_Date = $_SESSION['SAL_FromDate'];
        }
    
        if(isset($_GET['toDate'])){
            $to_Date = $_GET['toDate'];
            $_SESSION['SAL_ToDate'] = $from_Date;
        }else if(isset($_SESSION['SAL_ToDate'])){
            $to_Date = $_SESSION['SAL_ToDate'];
        }
    
        $fromDate = $from_Date." 00:00:00.000";
        $toDate = $to_Date." 23:59:59.999";

        $query = "SELECT 
        ISNULL(ShopName,'') as ShopName,
        ISNULL(ShopKeeperName,'') as ShopKeeperName,
        ISNULL(ShopKeeperMobile,'') as ShopKeeperMobile,
        CONVERT(VARCHAR, RenewalDate ,103) as RenewalDate
        FROM ShopMaster WHERE RenewalDate < CONVERT(date, DATEADD(DAY, -15, GETDATE()))
        AND IsActive = 1 AND CONVERT(VARCHAR, PLCreatedDate ,120) BETWEEN '$fromDate' AND '$toDate';";
        $LicenseDefaulter = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>
<div class="row">
        <div class="col-md-12">
            <div class="card">
               
    <div class="card-content">
                                <div class="card-body">
                                        <!-- Tab panes -->
                                        <div class="tab-content pt-1">
                                            <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">
                                               
                                                  <!-- Column selectors with Export Options and print table -->
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                               
                                <div class="card-content">
                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                            <!-- <table class="table table-striped table-bordered complex-headers "> -->
                                                <thead>
                                                    <tr>
                                                    <th>Shop Name</th>
                                                        <th>ShopKeeper Name </th>
                                                        <th>ShopKeeper Mobile No. </th>
                                                        <th>Liscense Renewal Date</th>
                                                        <!-- <th>Charges</th> -->
                                                     
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                foreach ($LicenseDefaulter as $key => $value) { 
                                                
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value['ShopName'];?></td>
                                                        <td><?php echo $value['ShopKeeperName'];?></td>
                                                        <td><?php echo $value['ShopKeeperMobile'];?></td>
                                                        <td><?php echo $value['RenewalDate'];?></td>
                                                        <!-- <td><?php //echo $value['ShopName'];?></td> -->
                                                    </tr>
                                                    <?php } ?>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th>Shop Name</th>
                                                        <th>ShopKeeper Name </th>
                                                        <th>ShopKeeper Mobile No. </th>
                                                        <th>Liscense Renewal Date</th>
                                                        <!-- <th>Charges</th> -->
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Column selectors with Export Options and print table -->
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

