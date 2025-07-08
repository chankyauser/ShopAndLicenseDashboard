

<div class="content-body">
<section id="dashboard-analytics">

<?php
        if(isset($_GET['dataValidation'])){
            $_SESSION['SAL_SHOP_Data_Validation'] = $_GET['dataValidation'];
        }

        // if(isset($_GET['qcType'])){
        //     $_SESSION['SAL_SHOP_QC_Type'] = $_GET['qcType'];
        // }

        // if(isset($_GET['qcFilter'])){
        //     $_SESSION['SAL_SHOP_QC_Filter'] = $_GET['qcFilter'];
        // }

        if(isset($_GET['minDate']) && !empty($_GET['minDate'])){
            $_SESSION['SAL_FromDate'] = $_GET['minDate'];
        }

        if(isset($_GET['maxDate']) && !empty($_GET['maxDate'])){
            $_SESSION['SAL_ToDate'] = $_GET['maxDate'];
        }

        if(!isset($_SESSION['SAL_SHOP_Data_Validation'])){
            $valType = "MobilePending";
            $_SESSION['SAL_SHOP_Data_Validation'] = $valType;
        }else{
            $valType = $_SESSION['SAL_SHOP_Data_Validation'];
        }

        // if(!isset($_SESSION['SAL_SHOP_QC_Type'])){
        //     $qcType = "ShopList";
        //     $_SESSION['SAL_SHOP_QC_Type'] = $qcType;
        // }else{
        //     $qcType = $_SESSION['SAL_SHOP_QC_Type'];
        // }

        // if(!isset($_SESSION['SAL_SHOP_QC_Filter'])){
        //     $qcFilter = "All";
        //     $_SESSION['SAL_SHOP_QC_Filter'] = $qcFilter;
        // }else{
        //     $qcFilter = $_SESSION['SAL_SHOP_QC_Filter'];
        // }

        // if(!isset($_SESSION['SAL_ShopStatus'])){
        //     $shopStatus = "All";
        //     $_SESSION['SAL_ShopStatus'] = $shopStatus;
        // }else{
        //     $shopStatus = $_SESSION['SAL_ShopStatus'];
        // }
    
        
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

        $shop_Name_Post= "";
        if(isset($_SESSION['SAL_ShopName']) && !empty($_SESSION['SAL_ShopName'])){
            $shop_Name_Post = $_SESSION['SAL_ShopName'];
            $_SESSION['SAL_ShopName'] = "";
        }

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $queryShopStatus = "SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ApplicationStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1);";
        $ShopStatusDropDown = $db->ExecutveQueryMultipleRowSALData($queryShopStatus, $electionName, $developmentMode);

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
                                        <input type='text' name="fromDate" value="<?php echo $fromDate;?>" onchange="setValidateFromAndToDate()" class="form-control pickadate" />
                                    </div>
                                </div>
                                
                                <div class="col-md-2 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type='text' name="toDate" value="<?php echo $toDate;?>" onchange="setValidateFromAndToDate()" class="form-control pickadate" />
                                    </div>
                                </div>
                                
                                <div class="col-12 col-sm-12 col-md-2">
                                    <?php include 'dropdown-ward.php'; ?>
                                </div>

                                <div class="col-12 col-sm-12 col-md-2">
                                    <div class="form-group">
                                        <label>Data Validation Type</label>
                                        <select class="select2 form-control"  name="dataValidation" id="dataValidation">
                                            <option <?php echo $valType == 'MobilePending' ? 'selected=true' : '';?>  value="MobilePending">Mobile Pending</option>
                                            <option <?php echo $valType == 'PhotoPending' ? 'selected=true' : '';?>  value="PhotoPending">Photo Pending</option>
                                            <option <?php echo $valType == 'DocumentPending' ? 'selected=true' : '';?>  value="DocumentPending">Document Pending</option>
                                            <option <?php echo $valType == 'PermanentlyClosed' ? 'selected=true' : '';?>  value="PermanentlyClosed">Permanently Closed</option>
                                            <option <?php echo $valType == 'NonCooperative' ? 'selected=true' : '';?>  value="NonCooperative">Non-Cooperative</option>
                                            <option <?php echo $valType == 'PermissionDenied' ? 'selected=true' : '';?>  value="PermissionDenied">Permission Denied</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-2 text-right" style="margin-top: 25px; margin-left: -15px;">
                                    <div class="form-group">
                                        <label for="update"></label>
                                        <input type="hidden" name="Executive_Id" value="<?php echo $executiveCd; ?>">
                                        <button type="button" class="btn btn-primary" onclick="setShopDataValidationData()"><i class="feather icon-refresh-cw"></i></button>
                                    </div>
                                </div>

                                

                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row" id="shoplist-qc">
        <?php include 'datatbl/tblShopDataValidation.php'; ?>
    </div>


    <!-- Modal -->
    <!-- <div class="modal fade" id="modalShowApplicationTracking" tabindex="-1" role="dialog" aria-labelledby="modalShowApplicationTracking" aria-hidden="true">
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
    </div> -->

    <!-- Modal -->
    <!-- <div class="modal fade" id="modalShowShopBoardType" tabindex="-1" role="dialog" aria-labelledby="modalShowShopBoardType" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Shop Board Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showShopBoardType">

                </div>
                
            </div>
        </div>
    </div> -->

</section>


</div>