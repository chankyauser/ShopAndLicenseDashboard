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
        $fromDate = date('Y-m-d', strtotime('-30 days'));
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
        
        if(isset($_GET['pocketId'])){
            $pocketCd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocketCd = $_SESSION['SAL_Pocket_Cd'];    
        }else{
            $pocketCd = "All"; 
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd; 
        }
    ?>

     <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Exeutives Survey Detail</h4>
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

    <div id="executiveSurveyListId">
       <?php include 'datatbl/tblExecutiveSurveySummaryData.php'; ?>
    </div>

    












































               <!--      <div class="row">
                        <div class="col-sm-12">
                            <div class="card overflow-hidden">
                                <div class="card-header">
                                
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                       
                                        <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab-justified" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just" aria-selected="true">Survey</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab-justified" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just" aria-selected="true">Calling</a>
                                            </li>
                                        
                                        </ul>

                                        
                                        <div class="tab-content pt-1">
                                            <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">
                                                <h5>
                                                Executive wise Survey Status</h5>
                                                  
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                   
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                    
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                    <tr>
                                                        <th>Executive Name</th>
                                                        <th>Last DateTime</th>
                                                        <th>Last Pocket</th>
                                                        <th>SP</th>
                                                        <th>SD</th>
                                                        <th>Assigned</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ajay</td>
                                                        <td>12:10 Pm</td>
                                                        <td>Belapur Sector 11</td>
                                                        <td>4</td>
                                                        <td>20</td>
                                                        <td>24</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                        <td>12:10 Pm</td>
                                                        <td>Belapur Sector 11</td>
                                                        <td>4</td>
                                                        <td>20</td>
                                                        <td>24</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                        <td>12:10 Pm</td>
                                                        <td>Belapur Sector 11</td>
                                                        <td>4</td>
                                                        <td>20</td>
                                                        <td>24</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                   
                                                    <td>Ajay</td>
                                                        <td>12:10 Pm</td>
                                                        <td>Belapur Sector 11</td>
                                                        <td>4</td>
                                                        <td>20</td>
                                                        <td>24</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                
                                                    <td>Ajay</td>
                                                 
                                                        <td>12:10 Pm</td>
                                                        <td>Belapur Sector 11</td>
                                                        <td>4</td>
                                                        <td>20</td>
                                                        <td>24</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th>Executive Name</th>
                                                        <th>Last DateTime</th>
                                                        <th>Last Pocket</th>
                                                        <th>SP</th>
                                                        <th>SD</th>
                                                        <th>Assigned</th>
                                                        <th>Action</th>
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
                
                                            </div>
                                            <div class="tab-pane" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-justified">
                                                <h5>
                                                Executive wise Calling Status </h5>
                                                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                   
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                    
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                    <tr>
                                                        <th>Executive Name</th>
                                                        <th>Last DateTime</th>
                                                        <th>CP</th>
                                                        <th>CD</th>
                                                        <th>Assigned</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Ajay</td>
                                                    <td>12:10 Pm</td>
                                                        <td>4</td>
                                                        <td>13</td>
                                                        <td>17</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                    <td>12:10 Pm</td>
                                                        <td>4</td>
                                                        <td>13</td>
                                                        <td>17</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                    <td>12:10 Pm</td>
                                                        <td>4</td>
                                                        <td>13</td>
                                                        <td>17</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                    <td>12:10 Pm</td>
                                                        <td>4</td>
                                                        <td>13</td>
                                                        <td>17</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Ajay</td>
                                                    <td>12:10 Pm</td>
                                                        <td>4</td>
                                                        <td>13</td>
                                                        <td>17</td>
                                                        <td><button class="btn btn-primary" type="submit">View</button></td>
                                                    </tr>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th>Executive Name</th>
                                                        <th>Last DateTime</th>
                                                        <th>CP</th>
                                                        <th>CD</th>
                                                        <th>Assigned</th>
                                                        <th>Action</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->





</section>
                


        