

<div class="content-body">
    <section id="dashboard-analytics">

    <?php
            if(isset($_GET['qcType'])){
                $_SESSION['SAL_SHOP_QC_Type'] = $_GET['qcType'];
            }

            if(isset($_GET['qcFilter'])){
                $_SESSION['SAL_SHOP_QC_Filter'] = $_GET['qcFilter'];
            }

            if(isset($_GET['minDate']) && !empty($_GET['minDate'])){
                $_SESSION['SAL_FromDate'] = $_GET['minDate'];
            }

            if(isset($_GET['maxDate']) && !empty($_GET['maxDate'])){
                $_SESSION['SAL_ToDate'] = $_GET['maxDate'];
            }

            if(!isset($_SESSION['SAL_SHOP_QC_Type'])){
                $qcType = "ShopList";
                $_SESSION['SAL_SHOP_QC_Type'] = $qcType;
            }else{
                $qcType = $_SESSION['SAL_SHOP_QC_Type'];
            }
            if(!isset($_SESSION['SAL_SHOP_QC_Filter'])){
                $qcFilter = "All";
                $_SESSION['SAL_SHOP_QC_Filter'] = $qcFilter;
            }else{
                $qcFilter = $_SESSION['SAL_SHOP_QC_Filter'];
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
            }

            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            
            $executiveCd = 0;
            $userId = $_SESSION['SAL_UserId'];
            if($userId != 0){
                $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
                if(sizeof($exeData)>0){
                    $executiveCd = $exeData["Executive_Cd"];
                }
            }else{
                session_unset();
                session_destroy();
                header('Location:../index.php?p=login');
            }

?>
    
      <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-2 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="fromDate">From Date</label>
                                            <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="toDate">To Date</label>
                                            <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-12 col-md-2">
                                        <?php include 'dropdown-ward.php'; ?>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>QC Type</label>
                                            <select class="select2 form-control"  name="qcType" id="qcType">
                                                <option <?php echo $qcType == 'ShopList' ? 'selected=true' : '';?>  value="ShopList">Shop List</option>
                                                <option <?php echo $qcType == 'ShopSurvey' ? 'selected=true' : '';?>  value="ShopSurvey">Shop Survey</option>
                                                <option <?php echo $qcType == 'ShopDocument' ? 'selected=true' : '';?>  value="ShopDocument">Shop Document</option>
                                                <option <?php echo $qcType == 'ShopCalling' ? 'selected=true' : '';?>  value="ShopCalling">Shop Calling</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>QC Filter</label>
                                            <select class="select2 form-control" name="qcFilter" id="qcFilter" >
                                                <option <?php echo $qcFilter == 'All' ? 'selected=true' : '';?>  value="All">All</option>
                                                <option <?php echo $qcFilter == 'Pending' ? 'selected=true' : '';?>  value="Pending">Pending</option>
                                                <option <?php echo $qcFilter == 'Completed' ? 'selected=true' : '';?>  value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-2 text-right" style="margin-top: 25px; margin-left: -15px;">
                                        <div class="form-group">
                                            <label for="update"></label>
                                            <input type="hidden" name="Executive_Id" value="<?php echo $executiveCd; ?>">
                                            <button type="button" class="btn btn-primary" onclick="setQCShopFilterData()">Refresh</button>
                                        </div>
                                    </div>

                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row" id="shoplist-qc">
            <?php include 'datatbl/tblShopListQCEdit2.php'; ?>
        </div>


    </section>


</div>