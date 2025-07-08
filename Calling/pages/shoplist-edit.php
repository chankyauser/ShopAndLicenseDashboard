<style>
.nav.nav-tabs .nav-item .nav-link.active {
  border : none;
  position : relative;
  color: #c90d41;
  -webkit-transition : all 0.2s ease;
          transition : all 0.2s ease;
  background-color : transparent;
}
label{
    font-weight: 900;
    color: #c90d41;
}
.nav.nav-tabs .nav-item .nav-link.active:after {
    content: attr(data-before);
    height: 2px;
    width: 100%;
    left: 0;
    position: absolute;
    bottom: 0;
    top: 100%;
    background: -webkit-linear-gradient(60deg, #7367F0, rgba(115, 103, 240, 0.5)) !important;
    background: linear-gradient(30deg, #c90e42, rgb(234 162 182)) !important;
    box-shadow: 0 0 8px 0 rgb(115 103 240 / 50%) !important;
    -webkit-transform: translateY(0px);
    -ms-transform: translateY(0px);
    transform: translateY(0px);
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
}

.nav.nav-pills .nav-item .nav-link {
    border-radius: 0.357rem;
    padding: 0.5rem;
    /* padding-top: 0.3rem; */
    font-size: 1rem;
    margin-right: 0.5rem;
    color: #000000;
}

.activity-timeline.timeline-left {
    border-left: 0px solid #DAE1E7;
    padding-left: 0px;
    margin-left: 4rem;
}

.select2-container--classic .select2-selection--single:focus, .select2-container--default .select2-selection--single:focus {
    outline: 0;
    border-color: #C90D41 !important;
    box-shadow: 0 3px 10px 0 rgb(0 0 0 / 15%) !important;
}
.form-control {
    color: black;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: black;
}
.select2-container--classic.select2-container--open .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--single {
    border-color: #C90D41 !important;
    outline: 0;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    user-select: none;
    -webkit-user-select: none;
    -webkit-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.fade-out {
  animation: fadeOut ease 10s;
  -webkit-animation: fadeOut ease 10s;
  -moz-animation: fadeOut ease 10s;
  -o-animation: fadeOut ease 10s;
  -ms-animation: fadeOut ease 10s;
}
@keyframes fadeOut {
  0% {
    opacity:1;
  }
  100% {
    opacity:0;
  }
}

@-moz-keyframes fadeOut {
  0% {
    opacity:1;
  }
  100% {
    opacity:0;
  }
}

@-webkit-keyframes fadeOut {
  0% {
    opacity:1;
  }
  100% {
    opacity:0;
  }
}

@-o-keyframes fadeOut {
  0% {
    opacity:1;
  }
  100% {
    opacity:0;
  }
}

@-ms-keyframes fadeOut {
  0% {
    opacity:1;
  }
  100% {
    opacity:0;
}
}
</style>


<div class="content-body">

    <?php
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
            

        $Shop_Cd = 0;
        $getShopName = '';
        $getShopKeeperName = '';
        $getShopKeeperMobile = '';
        $getShopAddress_1 = '';
        $getShopAddress_2 = '';
        $getShopOwnerName = '';
        $getShopOwnerMobile = '';
        $getRenewalDate = '';
        $getIsCertificateIssued = '';
        $getShopContactNo_1 = '';
        $getShopContactNo_2 = '';
        $getLetterGiven = '';
        $getShopOutsideImage1 = '';
        $getShopOutsideImage2 = '';
        $getShopStatus = '';
        $getShopStatusRemark = '';
        $getBusinessCat_Cd = '';
        $getNature_of_Business = '';

    // Advanced Info Variable
        $getParwana_Cd = '';
        $getParwana_Name_Eng = '';
        $getParwana_Name_Mar = '';
        $getNewParwana = '';
        $getShopCategory = '';
        $getShopOwnerAddress = '';
        $getShopAreaName = '';
        $getShopAreaNameMar = '';
        $getShopDimension = '';
        $getShopOwnPeriod = '';
        $getShopOwnStatus = '';
        $getShopInsideImage1 = '';
        $getShopInsideImage2 = '';
        

        if(isset($_GET['Shop_Cd']) && $_GET['Shop_Cd'] != 0 && isset($_GET['action']) ){
            $Shop_Cd = $_GET['Shop_Cd'];
            $action = $_GET['action'];

        $basicInfoQuery = "SELECT 
                COALESCE(sm.Shop_Cd, 0) as Shop_Cd, 
                COALESCE(sm.ShopName, '') as ShopName, 
                COALESCE(sm.ShopNameMar, '') as ShopNameMar, 
                COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
                COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile, 
                COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
                COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 
                COALESCE(sm.ShopOwnerName, '') as ShopOwnerName, 
                COALESCE(sm.ShopOwnerMobile, '') as ShopOwnerMobile, 
                COALESCE(CONVERT(VARCHAR, sm.RenewalDate, 105), '') as RenewalDate, 
                COALESCE(sm.IsCertificateIssued, 0) as IsCertificateIssued, 
                COALESCE(sm.ShopContactNo_1, '') as ShopContactNo_1, 
                COALESCE(sm.ShopContactNo_2, '') as ShopContactNo_2,
                COALESCE(sm.LetterGiven, '') as LetterGiven, 
                COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
                COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
                COALESCE(sm.ShopStatus, '') as ShopStatus, 
                COALESCE(sm.ShopStatusRemark, '') as ShopStatusRemark, 
                COALESCE(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
                COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
                COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar   
                FROM ShopMaster AS sm 
                INNER JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
                WHERE sm.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

            $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($basicInfoQuery, $electionName, $developmentMode);

                if(sizeof($ShopListCallingDataEdit)>0){
                    $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
                    $getShopName = $ShopListCallingDataEdit["ShopName"];
                    $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
                    $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];
                    $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
                    $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];
                    $getShopOwnerName = $ShopListCallingDataEdit["ShopOwnerName"];
                    $getShopOwnerMobile = $ShopListCallingDataEdit["ShopOwnerMobile"];
                    $getRenewalDate = $ShopListCallingDataEdit["RenewalDate"];
                    $getIsCertificateIssued = $ShopListCallingDataEdit["IsCertificateIssued"];
                    $getShopContactNo_1 = $ShopListCallingDataEdit["ShopContactNo_1"];
                    $getShopContactNo_2 = $ShopListCallingDataEdit["ShopContactNo_2"];
                    $getLetterGiven = $ShopListCallingDataEdit["LetterGiven"];
                    $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];
                    $getShopOutsideImage2 = $ShopListCallingDataEdit["ShopOutsideImage2"];
                    $getShopStatus = $ShopListCallingDataEdit["ShopStatus"];
                    $getShopStatusRemark = $ShopListCallingDataEdit["ShopStatusRemark"];
                    $getBusinessCat_Cd = $ShopListCallingDataEdit["BusinessCat_Cd"];
                    
                    $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];
                }

            

            $advancedInfoQuery = "SELECT 
                    COALESCE(sm.Shop_Cd, 0) as Shop_Cd, 
                    COALESCE(pm.Parwana_Cd, 0) as Parwana_Cd, 
                    COALESCE(pm.Parwana_Name_Eng, '') as Parwana_Name_Eng, 
                    COALESCE(pm.Parwana_Name_Mar, '') as Parwana_Name_Mar, 
                    CASE WHEN COALESCE(pd.IsRenewal, 0) = 1 THEN 'Yes' ELSE 'No' END as NewParwana, 
                    COALESCE(sm.ShopCategory, '') as ShopCategory, 
                    COALESCE(sm.ShopOwnerAddress, '') as ShopOwnerAddress, 
                    COALESCE(am.ShopAreaName, '') as ShopAreaName, 
                    COALESCE(am.ShopAreaNameMar, '') as ShopAreaNameMar, 
                    COALESCE(sm.ShopDimension, '') as ShopDimension, 
                    COALESCE(sm.ShopOwnPeriod, 0) as ShopOwnPeriod, 
                    COALESCE(sm.ShopOwnStatus, '') as ShopOwnStatus, 
                    COALESCE(sm.ShopInsideImage1, '') as ShopInsideImage1, 
                    COALESCE(sm.ShopInsideImage2, '') as ShopInsideImage2,
                    COALESCE(sm.MuncipalWN, '') as MuncipalWN
                    FROM ShopMaster AS sm 
                    INNER JOIN ParwanaDetails AS pd ON (sm.ParwanaDetCd = pd.ParwanaDetCd) 
                    INNER JOIN ParwanaMaster AS pm ON (pm.Parwana_Cd = pd.Parwana_Cd) 
                    INNER JOIN ShopAreaMaster AS am ON (am.ShopArea_Cd = sm.ShopArea_Cd) 
                    WHERE sm.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

            $AdvancedInfoData = $db->ExecutveQuerySingleRowSALData($advancedInfoQuery, $electionName, $developmentMode);

            if(sizeof($AdvancedInfoData)>0){
                
                $getParwana_Cd = $AdvancedInfoData["Parwana_Cd"];
                $getParwana_Name_Eng = $AdvancedInfoData["Parwana_Name_Eng"];
                $getParwana_Name_Mar = $AdvancedInfoData["Parwana_Name_Mar"];
                $getIsNewParwana = $AdvancedInfoData["NewParwana"];
                $getShopCategory = $AdvancedInfoData["ShopCategory"];
                $getShopOwnerAddress = $AdvancedInfoData["ShopOwnerAddress"];
                $getShopAreaName = $AdvancedInfoData["ShopAreaName"];
                $getShopAreaNameMar = $AdvancedInfoData["ShopAreaNameMar"];
                $getShopArea = $AdvancedInfoData["ShopDimension"];
                $getShopOwnPeriod = $AdvancedInfoData["ShopOwnPeriod"];
                $getShopOwnStatus = $AdvancedInfoData["ShopOwnStatus"];
                $getShopInsideImage1 = $AdvancedInfoData["ShopInsideImage1"];
                $getShopInsideImage2 = $AdvancedInfoData["ShopInsideImage2"];
                $getMuncipalWN = $AdvancedInfoData["MuncipalWN"];

            }

            // Board Info
        $getBoardID1 = '';
        $getBoardType1 = '';
        $getBoardHeight1 = '';
        $getBoardWidth1 = '';
        $getBoardPhoto1 = '';


        $advancedInfoBoardQuery = "SELECT 
                    COALESCE(BoardID, 0) as BoardID, 
                    COALESCE(BoardType, '') as BoardType, 
                    COALESCE(BoardHeight, 0) as BoardHeight, 
                    COALESCE(BoardWidth, 0) as BoardWidth, 
                    COALESCE(Shop_Cd, 0) as Shop_Cd, 
                    COALESCE(BoardPhoto, '') as BoardPhoto 
                    FROM ShopBoardDetails WHERE Shop_Cd = $Shop_Cd AND IsActive = 1;";

            $AdvancedInfoBoardData = array();

            $AdvancedInfoBoardData = $db->ExecutveQueryMultipleRowSALData($advancedInfoBoardQuery, $electionName, $developmentMode);

            if(sizeof($AdvancedInfoBoardData) > 0){
                $BoardType1DataArray = $AdvancedInfoBoardData[0];
                $getBoardID1 = $BoardType1DataArray["BoardID"] ;
                $getBoardType1 = $BoardType1DataArray["BoardType"] ;
                $getBoardHeight1 =$BoardType1DataArray["BoardHeight"] ;
                $getBoardWidth1 = $BoardType1DataArray["BoardWidth"] ;
                $getBoardPhoto1 = $BoardType1DataArray["BoardPhoto"] ;

            }

            $BoardType2DataArray = '';
            $getBoardID2 = '';
            $getBoardType2 = '';
            $getBoardHeight2 = '';
            $getBoardWidth2 = '';
            $getBoardPhoto2 = '';

            if(sizeof($AdvancedInfoBoardData) >= 2){
                $BoardType2DataArray = $AdvancedInfoBoardData[1];
                $getBoardID2 = $BoardType2DataArray["BoardID"] ;
                $getBoardType2 = $BoardType2DataArray["BoardType"] ;
                $getBoardHeight2 =$BoardType2DataArray["BoardHeight"] ;
                $getBoardWidth2 = $BoardType2DataArray["BoardWidth"] ;
                $getBoardPhoto2 = $BoardType2DataArray["BoardPhoto"] ;
            }
                    
            $BoardType3DataArray = '';
            $getBoardID3 = '';
            $getBoardType3 = '';
            $getBoardHeight3 = '';
            $getBoardWidth3 = '';
            $getBoardPhoto3 = '';

            if(sizeof($AdvancedInfoBoardData) >= 3){
                
                $BoardType3DataArray = $AdvancedInfoBoardData[2];
                $getBoardID3 = $BoardType3DataArray["BoardID"] ;
                $getBoardType3 = $BoardType3DataArray["BoardType"] ;
                $getBoardHeight3 =$BoardType3DataArray["BoardHeight"] ;
                $getBoardWidth3 = $BoardType3DataArray["BoardWidth"] ;
                $getBoardPhoto3 = $BoardType3DataArray["BoardPhoto"] ;
            }

            $DocumentFileURL = "SELECT 
                    COALESCE(sdm.Document_Cd, 0) as Document_Cd, 
                    COALESCE(DocumentName, '') as DocumentName, 
                    COALESCE(DocumentNameMar, '') as DocumentNameMar, 
                    COALESCE(DocumentType, '') as DocumentType, 
                    COALESCE(IsCompulsory, 0) as IsCompulsory, 
                    COALESCE(sd.ShopDocDet_Cd, 0) as ShopDocDet_Cd, 
                    COALESCE(sd.IsVerified, 0) as IsVerified, 
                    COALESCE(sd.FileURL, '') as FileURL 
                    FROM ShopDocumentMaster AS sdm 
                    LEFT JOIN ShopDocuments AS sd ON (sdm.Document_Cd = sd.Document_Cd 
                    AND sd.Shop_Cd = $Shop_Cd AND sd.IsActive = 1) 
                    WHERE sdm.IsActive = 1;";

            $DocumentFileData = array();

            $DocumentFileData = $db->ExecutveQueryMultipleRowSALData($DocumentFileURL, $electionName, $developmentMode);
        }


            $query1 = "SELECT Status_Cd as DropDown_Cd, ApplicationStatus as DValue FROM StatusMaster
                     WHERE Remark <> 'ShopAccess' AND IsActive = 1;";

            $StatusDropDown = $db->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);        
    ?>

    <section id="nav-justified">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <form action="action/saveShopStatusRemark.php" method="POST" class="form-horizontal">
                                <div class="row">
                                   
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                        <label>Shop Status </label>
                                            <div class="controls"> 
                                            <select class="select2 form-control" required name="status" id="status" required>
                                                <option value="">--Select--</option>
                                                <?php 
                                                    if (sizeof($StatusDropDown)>0){
                                                        foreach($StatusDropDown as $key => $value)
                                                        {
                                                            if($getShopStatus == $value["DValue"])
                                                            {
                                                            ?> 
                                                                <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                        <?php  }else{ ?>
                                                                <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                        <?php }
                                                        }
                                                    } 
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="col-12 col-sm-4">
                                        <div class="select form-group">
                                            <label>Remark</label>
                                            <input type='text' name="remark" id="remark" value="" class="form-control" placeholder = "Remark"/>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-2">
                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="hidden" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
                                        <input type="hidden" name="action" value="<?php echo $action; ?>" >
                                        <div id="submitmsgsuccess" class="controls alert alert-success text-center" role="alert" style="display: none;"></div>
                                        <div id="submitmsgfailed"  class="controls alert alert-danger text-center" role="alert" style="display: none;"></div>
                                    </div>

                                    <div class="col-md-2 col-12 text-left" style="margin-top: 26px;">
                                        <div class="form-group">
                                            <label for="update"></label>
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                    <div>
                                    <?php
                                        if (isset($_GET['success']) && $_GET['success']) {?> 
                                        <h6 style="color:green;margin-left:50px;" class="fade-out" >Data Updated Successfully</h6>
                                        <?php 
                                        $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                        $time_out = 0;
                                        // header("refresh: $time_out; url=$url");
                                        // header('Location:home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');
                                            
                                        } else if (isset($_GET['success']) && !$_GET['success']) {?>
                                        <h6 style="color:red;margin-left:50px;" class="fade-out">Error.. Please try again</h6>
                                        <?php
                                            $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                            $time_out = 0;
                                            // header("refresh: $time_out; url=$url");
                                        }
                                        ?>
                                    </div>

                                    <div>
                                        <?php
                                            if (isset($_GET['success1']) && $_GET['success1']) {?> 
                                            <h6 style="color:green;margin-left:50px;" class="fade-out">Document Uploaded Successfully</h6>
                                            <?php 
                                            $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                            $time_out = 0;
                                            // header("refresh: $time_out; url=$url");
                                                
                                            } else if (isset($_GET['success1']) && !$_GET['success1']) {?>
                                            <h6 style="color:red;margin-left:50px;" class="fade-out">Error.. Please try again</h6>
                                            <?php
                                                $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                                $time_out = 0;
                                                // header("refresh: $time_out; url=$url");
                                            }
                                        ?>
                                    </div>

                                    <div>
                                        <?php
                                            if (isset($_GET['success2']) && $_GET['success2']) {?> 
                                            <h6 style="color:red;margin-left:50px;" class="fade-out">Document Deleted Successfully</h6>
                                            <?php 
                                            $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                            $time_out = 0;
                                            // header("refresh: $time_out; url=$url");
                                                
                                            } else if (isset($_GET['success2']) && !$_GET['success2']) {?>
                                            <h6 style="color:red;margin-left:50px;" class="fade-out">Error.. Please try again</h6>
                                            <?php
                                                $url ="home.php?p=shoplist-edit&action=".$action."&Shop_Cd=".$Shop_Cd;
                                                $time_out = 0;
                                                // header("refresh: $time_out; url=$url");
                                            }
                                        ?>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-md-5 col-sm-12">
                                    <div class="media mb-2">
                                        <a class="mr-2 my-25" href="#">
                                            <img src="<?php echo $getShopOutsideImage1; ?>" alt="users avatar" class="users-avatar-shadow rounded" height="150" width="150">
                                        </a>
                                        <div class="media-body mt-50">
                                            <h4 class="media-heading"><?php echo $getShopName; ?></h4>
                                            <?php  if($getShopStatus == "Verified") { ?> 
                                                    <span class="badge badge-success"><?php echo $getShopStatus; ?></span>
                                                    <i class="feather icon-check-circle mr-25" style="color:green;"></i>
                                            <?php }else if($getShopStatus == "Pending"){ ?>  
                                                    <span class="badge badge-warning"><?php echo $getShopStatus; ?></span>
                                                    <i class="feather icon-alert-circle mr-25" style="color:green;"></i>
                                            <?php }else if($getShopStatus == "In-Review"){ ?> 
                                                    <span class="badge badge-info"><?php echo $getShopStatus; ?></span>
                                                    <i class="feather icon-alert-circle mr-25 badge badge-info"></i>
                                            <?php }else if($getShopStatus == "Rejected"){ ?>
                                                    <span class="badge badge-danger"><?php echo $getShopStatus; ?></span>
                                                    <i class="feather icon-alert-circle mr-25 badge badge-danger" ></i>
                                            <?php } ?>
                                            <h6 class="media-text" style="margin-top: 10px;"><?php echo $getShopKeeperName; ?></h6>
                                            <h6 class="media-text"><?php echo $getShopKeeperMobile; ?></h6>
                                            <h6 class="media-text"><?php echo $getNature_of_Business; ?></h6>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-12 col-md-4 col-sm-12">
                                    <h6 class="card-title">Application Tracking &nbsp; &nbsp;&nbsp; <a href="home.php?p=shoplist-track&action=track&Shop_Cd=<?php echo $Shop_Cd; ?>" class="btn-icon btn btn-primary" target="_blank"> <i class="feather icon-truck font-medium-2 align-middle"></i></a></h6>
                            <?php 
                                $queryShopTrack = "SELECT top (2)
                                        ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                                        ISNULL(sd.Shop_Cd,0) as Shop_Cd,
                                        ISNULL(ccm.Calling_Type,'') as Calling_Type,
                                        ISNULL(CONVERT(VARCHAR,sd.CallingDate,121),'') as ScheduleDate,
                                        ISNULL(sd.CallReason,'') as CallReason,
                                        ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
                                        ISNULL(st.ST_Cd,0) as ST_Cd,
                                        ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate,
                                        ISNULL(CONVERT(VARCHAR,st.ST_DateTime,121),'')  as ST_DateTime,
                                        ISNULL(CONVERT(VARCHAR,st.UpdatedDate,121),'')  as UpdatedDate,
                                        ISNULL(CONVERT(VARCHAR,GETDATE(),121),'')  as CurrentDateTime,
                                        ISNULL(st.ST_StageName,'') as ST_StageName,
                                        ISNULL(st.ST_Status,0) as ST_Status,
                                        ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
                                        ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
                                        ISNULL(st.ST_Remark_3,'') as ST_Remark_3
                                      FROM ScheduleDetails sd
                                      LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                      INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                      WHERE sd.Shop_Cd = $Shop_Cd
                                      order by sd.CallingDate desc";
                                      $dbST = new DbOperation();
                                      $dataScheduleST = $dbST->ExecutveQueryMultipleRowSALData($queryShopTrack, $electionName, $developmentMode);

                            ?>
                                    <ul class="activity-timeline timeline-left list-unstyled">
                                       
                                        <?php 
                                            foreach ($dataScheduleST as $key => $value) {
                                        ?>
                                                 <li>
                                                    <?php 
                                                        if($value["ST_Cd"] == 0 ){
                                                    ?>
                                                            <div class="timeline-icon bg-info">
                                                                <i class="feather icon-clock font-medium-2 align-middle"></i>
                                                            </div>
                                                    <?php
                                                        }else if($value["ST_Cd"] != 0 && empty($value["ST_DateTime"])){
                                                    ?>
                                                            <div class="timeline-icon bg-primary">
                                                                <i class="feather icon-plus font-medium-2 align-middle"></i>
                                                            </div>
                                                    <?php
                                                        }else if($value["ST_Cd"] != 0 && !empty($value["ST_DateTime"]) && $value["ST_Status"] != 0 ){
                                                    ?>
                                                            <div class="timeline-icon bg-success">
                                                                <i class="feather icon-check font-medium-2 align-middle"></i>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                       
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0"><?php echo $value["CallReason"]." : ".$value["ST_StageName"]; ?></p>
                                                        <span class="font-small-3"><?php echo $value["ST_Remark_1"]; ?></span>
                                                        <span class="font-small-3"><?php echo $value["ST_Remark_2"]; ?></span>
                                                        <span class="font-small-3"><?php echo $value["ST_Remark_3"]; ?></span>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?php 
                                                            if($value["ST_Cd"] == 0 ){
                                                                echo "Scheduled @ ". date('d/m/Y h:i a',strtotime($value["ScheduleDate"]));
                                                            }else if($value["ST_Cd"] != 0 && empty($value["ST_DateTime"])){
                                                                echo "Assigned @ ". date('d/m/Y h:i a',strtotime($value["UpdatedDate"]));
                                                            }else if($value["ST_Cd"] != 0 && !empty($value["ST_DateTime"]) && $value["ST_Status"] != 0 ){
                                                                echo "Task Completed @ ". date('d/m/Y h:i a',strtotime($value["ST_DateTime"]));
                                                            }
                                                        ?>
                                                    </small>
                                                </li>
                                        <?php
                                            }
                                        ?>
                                       
                                    </ul>
                                   
                                </div>
                                <div class="col-12 col-md-3 col-sm-12">
                                     <ul class="nav nav-pills flex-column" >
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'basic-info'){ ?> active  <?php }  }else{ ?> active <?php } ?>" id="basic-info-tab" data-toggle="pill" href="#basic-info" aria-controls="basic-info" role="tab" aria-selected="true">
                                                <i class="feather icon-info mr-25"></i>
                                                <span class="d-none d-sm-block">Basic Info</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center  <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'advance-info'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="advance-info-tab" data-toggle="pill" href="#advance-info" aria-controls="advance-info" role="tab" aria-selected="false">
                                                <i class="feather icon-clipboard mr-25"></i>
                                                <span class="d-none d-sm-block">Advance Info</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center  <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'upload'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="upload-tab" data-toggle="pill" href="#upload" aria-controls="upload" role="tab" aria-selected="false">
                                                <i class="feather icon-upload mr-25"></i>
                                                <span class="d-none d-sm-block">Upload Documents</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center   <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'Re-schedule'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="Re-schedule-tab" data-toggle="pill" href="#Re-schedule" aria-controls="Re-schedule" role="tab" aria-selected="false">
                                                <i class="feather icon-clock mr-25"></i>
                                                <span class="d-none d-sm-block">Schedule / Reschedule</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center   <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'calling-remark'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="calling-remark-tab" data-toggle="pill" href="#calling-remark" aria-controls="calling-remark" role="tab" aria-selected="false">
                                                <i class="feather icon-edit mr-25"></i>
                                                <span class="d-none d-sm-block">Calling Remark</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                           


    <!-- ############################# Basic Info Edit Form Start Here #####################################-->
    <?php 

    //  Basic Info Drop Downs Starts

    $query2 = "SELECT BusinessCat_Cd, BusinessCatName, BusinessCatNameMar 
                FROM BusinessCategoryMaster WHERE IsActive = 1;";

    $NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);


    $query3 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'CertificateIssued' AND IsActive = 1 ORDER BY SerialNo;";

    $IsCertificateIssuedDropDown = $db->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);


    $query4 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'LetterGiven' AND IsActive = 1 ORDER BY SerialNo;";

    $LetterGivenDropDown = $db->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

    //  Basic Info Drop Downs Ends
    ?>

                                    <div class="tab-content">
                                        <div class="tab-pane <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'basic-info'){ ?> active  <?php }  }else{ ?> active <?php } ?>" id="basic-info" aria-labelledby="basic-info-tab" role="tabpanel">
                                           <?php include 'basicInfoPageForEditShop.php'; ?>
                                        </div>

    <!-- ############################# Basic Info Edit Form Ends Here #####################################-->


    <!-- ############################# Advanced Info Edit Form Starts Here #####################################-->

    <?php 



    $query5 = "SELECT Parwana_Cd, Parwana_Name_Eng, Parwana_Name_Mar
                FROM ParwanaMaster
                WHERE IsActive = 1;";

    $ParwanaTypeDropDown = $db->ExecutveQueryMultipleRowSALData($query5, $electionName, $developmentMode);


    $query6 = "SELECT DropDown_Cd, DValue 
                FROM DropDownMaster
                WHERE DTitle = 'IsNewParwana'
                AND IsActive = 1 ORDER BY SerialNo;";

    $IsNewParwanaDropDown = $db->ExecutveQueryMultipleRowSALData($query6, $electionName, $developmentMode);


    $query7 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'Category' AND IsActive = 1 
                ORDER BY SerialNo;";

    $EstablishmentCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query7, $electionName, $developmentMode);


    $query8 = "SELECT DropDown_Cd, DValue 
                FROM DropDownMaster
                WHERE DTitle = 'BoardType' AND IsActive = 1 
                ORDER BY SerialNo;";

    $BoardTypeDropDown = $db->ExecutveQueryMultipleRowSALData($query8, $electionName, $developmentMode);


    $query9 = "SELECT DropDown_Cd, DValue 
                FROM DropDownMaster
                WHERE DTitle = 'MunicipalWN' AND IsActive = 1 
                ORDER BY SerialNo;";

    $MunicipalWardNoDropDown = $db->ExecutveQueryMultipleRowSALData($query9, $electionName, $developmentMode);


    $query10 = "SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1 ORDER BY ShopAreaName;";

    $EstablishmentAreaCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);


    $query11 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'PropertyStatus' AND IsActive = 1
                ORDER BY SerialNo;";

    $OwnedORRentedDropDown = $db->ExecutveQueryMultipleRowSALData($query11, $electionName, $developmentMode);



    ?>

                                        <div class="tab-pane <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'advance-info'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="advance-info" aria-labelledby="advance-info-tab" role="tabpanel">
                                            <?php include 'AdvanceInfoEditPage.php';?>
                                        </div>

    <!-- ############################# Advanced Info Edit Form Ends Here #####################################-->


    <!-- ############################# Upload Document Form Start Here #####################################-->

    <?php 

    $query12 = "SELECT Document_Cd, DocumentName, DocumentType
                FROM ShopDocumentMaster WHERE IsActive = 1;";

    $DocumentUploadList = $db->ExecutveQueryMultipleRowSALData($query12, $electionName, $developmentMode);
    ?>
                                        <div class="tab-pane <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'upload'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="upload" aria-labelledby="upload-tab" role="tabpanel">
                                            <?php include 'UploadImagePageShopEdit.php';?>
                                        </div>

    <!-- ############################# Upload Document Form Ends Here #####################################-->


    <!-- ############################# Schedule Reschedule Form Start Here #####################################-->
    <?php 
    $getReason = '';

    $query13 = "SELECT Calling_Category_Cd
                ,Calling_Category
                ,Calling_Type
                FROM CallingCategoryMaster WHERE IsActive = 1;";

    $ReasonDropDown = $db->ExecutveQueryMultipleRowSALData($query13, $electionName, $developmentMode);
    ?>

                                        <div class="tab-pane  <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'Re-schedule'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="Re-schedule" aria-labelledby="Re-schedule-tab" role="tabpanel">
                                            
                                            <form action="action/saveShopScheduleRescheduleData.php" method="POST" enctype="multipart/form-data" novalidate>
                                                <div class="row">

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="scheduleDate">Schedule Date</label>
                                                            <input type='datetime-local' name="scheduleDate" id="scheduleDate" value="" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Schedule Category</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="reason" id="reason">
                                                                <option  value="0">--Select--</option>   
                                                                    <?php if (sizeof($ReasonDropDown)>0) 
                                                                        {
                                                                            foreach($ReasonDropDown as $key => $value)
                                                                            {
                                                                                if($getReason == $value["Calling_Category_Cd"])
                                                                                {
                                                                                 ?> 
                                                                                    <option selected="true" value="<?php echo $value['Calling_Category_Cd'];?>"><?php echo $value['Calling_Category'];?></option>
                                                                                <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["Calling_Category_Cd"];?>"><?php echo $value["Calling_Category"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Remark</label>
                                                                <input type="text" name="remark" id="remark" class="form-control" placeholder="Remark" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 col-12" >
                                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="hidden" name="Executive_Id" value="<?php echo $executiveCd; ?>" >
                                                        <input type="hidden" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
                                                        <input type="hidden" name="action" value="<?php echo $action; ?>" >
                                                    </div>

                                                    <div class="col-md-8 col-12 text-right" style="margin-top:5px;margin-left:330px;">
                                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>

    <!-- ############################# Schedule Reschedule Form Ends Here #####################################-->

    <!-- ############################# Calling Remark Form Start Here #####################################-->
    <?php 
    $scheduleCallCds = '';
    if(isset($_GET['scheduleCallCds'])){
        $scheduleCallCds = $_GET['scheduleCallCds'];

        $query14 = " SELECT
                    ISNULL(st.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                    ISNULL(st.Shop_Cd,0) as Shop_Cd, 
                    ISNULL(st.Calling_Category_Cd,0) as Calling_Category_Cd,
                    ISNULL(ccm.Calling_Category,'') as Calling_Category,
                    ISNULL(CONVERT(VARCHAR,st.ST_DateTime,23),'') as ST_DateTime, 
                    ISNULL(st.ST_Exec_Cd,0) as ST_Exec_Cd, 
                    ISNULL(st.ST_Status,0) as ST_Status,
                    ISNULL(st.ST_StageName,'') as ST_StageName,
                    ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
                    ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
                    ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
                    ISNULL(CONVERT(VARCHAR,st.AssignDate,105),'') as AssignDate
                FROM ShopTracking st 
                INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd=st.Calling_Category_Cd
                WHERE st.Shop_Cd = $Shop_Cd AND st.ScheduleCall_Cd in ($scheduleCallCds);";

        $scheduleCallsRemarks = $db->ExecutveQueryMultipleRowSALData($query14, $electionName, $developmentMode);

        $queryStages = "SELECT DropDown_Cd, DTitle, DValue FROM DropDownMaster WHERE DTitle = 'StageName' AND IsActive = 1 ORDER BY SerialNo;";
        $applicationStatusStages = $db->ExecutveQueryMultipleRowSALData($queryStages, $electionName, $developmentMode);
    }



    
    ?>

                                        <div class="tab-pane  <?php if(isset($_GET['tab'])){ if($_GET['tab'] == 'calling-remark'){ ?> active  <?php }  }else{ ?> <?php } ?>" id="calling-remark" aria-labelledby="calling-remark-tab" role="tabpanel">
                                            
                                            <?php 
                                                if(!empty($scheduleCallCds)){
                                                        $srNo=0;
                                                    foreach ($scheduleCallsRemarks as $key => $value) {
                                                        $srNo = $srNo+1;
                                                        $scheduleCallCd = $value["ScheduleCall_Cd"];
                                                        $callingCategoryCd = $value["Calling_Category_Cd"];
                                                        $callingCategory_D = $value["Calling_Category"];
                                                        $assignDate = $value["AssignDate"];
                                                        $STStageName = $value["ST_StageName"];
                                                        $STRemark1 = $value["ST_Remark_1"];
                                                        $STRemark2 = $value["ST_Remark_2"];
                                                        $STRemark3 = $value["ST_Remark_3"];
                                            ?>
                                                        <div class="row">
                                                            <div class="col-md-12 col-12">
                                                                <div class="text-bold-600 font-medium-2" style="padding: 5px;">
                                                                    <?php echo $srNo.") "; ?> <?php echo $assignDate." : ".$callingCategory_D; ?>
                                                                </div> 
                                                            </div>
                                                           
                                                            
                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group">
                                                                    <label>Application Status :- Stages </label>
                                                                    <select class="select2 form-control" multiple="multiple" name="stStageName<?php echo $scheduleCallCd; ?>">
                                                                        <option value="">--Select--</option>
                                                                        <?php 
                                                                            foreach ($applicationStatusStages as $key => $value) {
                                                                        ?>
                                                                            <option <?php echo $STStageName == $value["DValue"] ? 'selected=true' : '';?>  value="<?php echo $value["DValue"]; ?>"><?php echo $value["DValue"]; ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                      
                                                                      
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Remark 1</label>
                                                                        <input type="text" name="remark_1_<?php echo $scheduleCallCd; ?>" id="remark" class="form-control" value="<?php echo $STRemark1; ?>" placeholder="Remark 1" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Remark 2</label>
                                                                        <input type="text" name="remark_2_<?php echo $scheduleCallCd; ?>" id="remark" class="form-control" value="<?php echo $STRemark2; ?>" placeholder="Remark 2" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Remark 3</label>
                                                                        <input type="text" name="remark_3_<?php echo $scheduleCallCd; ?>" id="remark" class="form-control" value="<?php echo $STRemark3; ?>" placeholder="Remark 3" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12" id="callingRemarkMsg<?php echo $scheduleCallCd; ?>">
                                                                <div id="submitmsgsuccessCR<?php echo $scheduleCallCd; ?>" class="controls alert alert-success text-center" role="alert" style="display: none;"></div>
                                                                <div id="submitmsgfailedCR<?php echo $scheduleCallCd; ?>"  class="controls alert alert-danger text-center" role="alert" style="display: none;"></div>
                                                            </div>
                                                            
                                                           

                                                            <div class="col-md-2 col-12 text-right" style="margin-top:15px;">
                                                                <input type="hidden" name="Executive_Id" value="<?php echo $executiveCd; ?>" >
                                                                <input type="hidden" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
                                                                <input type="hidden" name="ScheduleCallCd" value="<?php echo $scheduleCallCd; ?>" >
                                                                <input type="hidden" name="action" value="<?php echo $action; ?>" >

                                                                <button type="button" id="btnshcallingRemId<?php echo $scheduleCallCd; ?>" onclick="saveShopCallingRemarkForm(<?php echo $Shop_Cd; ?>,<?php echo $scheduleCallCd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                                            </div>

                                                            
                                                            
                                                            
                                                        </div>
                                            <?php
                                                    }
                                                    
                                                }
                                            ?>
                                            
                                        </div>

    <!-- ############################# Calling Remark Form Ends Here #####################################-->

                                    </div>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>