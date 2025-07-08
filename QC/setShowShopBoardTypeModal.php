<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shopid']) && !empty($_GET['shopid']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  
            
        $ScheduleCall_Cd = $_GET['schedulecallid'];
        $Shop_Cd = $_GET['shopid'];
        $srNo = $_GET['srNo'];

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];


        $loginExecutiveCd = 0;
        $userId = $_SESSION['SAL_UserId'];
        if($userId != 0){
            $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
            if(sizeof($exeData)>0){
                $loginExecutiveCd = $exeData["Executive_Cd"];
            }
        }


        $getShopName = '';
        $getShopNameMar = '';
        $getShopArea_Cd = '';
        $getShopAreaName = '';
        $getShopCategory = '';

        $getPocketName = '';
        $getNodeName = '';
        $getWardNo = '';
        $getWardArea = '';

        $getShopAddress_1 = '';
        $getShopAddress_2 = '';

        $getAddedDate = '';
        $getSurveyDate = '';

        $getQC_Flag = '';
        $getQC_UpdatedDate = '';

        $getShopKeeperName = '';
        $getShopKeeperMobile = '';

        $getShopOutsideImage1 = '';
        $getShopOutsideImage2 = '';
        $getShopInsideImage1 = '';
        $getShopInsideImage2 = '';


        $getShopStatus = '';
        $getShopStatusTextColor = '';
        $getShopStatusFaIcon = '';
        $getShopStatusIconUrl = '';
        $getShopStatusDate = '';
        $getShopStatusRemark = '';

        $getBusinessCat_Cd = '';
        $getNature_of_Business = '';

        $getCalling_Category = '';
         
        $getQCRemark1 = '';
        $getQCRemark2 = '';
        $getQCRemark3 = '';

        $surveyInfoQuery = "SELECT 
              COALESCE(sd.ScheduleCall_Cd, 0) as ScheduleCall_Cd, 
              COALESCE(sd.Shop_Cd, 0) as Shop_Cd, 
              COALESCE(sm.ShopName, '') as ShopName, 
              COALESCE(sm.ShopNameMar, '') as ShopNameMar, 

              COALESCE(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
              COALESCE(sam.ShopAreaName, '') as ShopAreaName, 
              COALESCE(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
              COALESCE(sm.ShopCategory, '') as ShopCategory, 

              ISNULL(pm.PocketName,'') as PocketName,
              ISNULL(nm.NodeName,'') as NodeName,
              ISNULL(nm.Ward_No,0) as Ward_No,
              ISNULL(nm.Area,'') as WardArea,

              COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
              COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 
              
              COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
              COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile,

              COALESCE(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
              COALESCE(CONVERT(VARCHAR, sm.SurveyDate, 100), '') as SurveyDate, 

              COALESCE(sm.QC_Flag, 0) as QC_Flag,
              COALESCE(CONVERT(VARCHAR, sm.QC_UpdatedDate, 100), '') as QC_UpdatedDate, 

              COALESCE(sm.LetterGiven, '') as LetterGiven, 
              COALESCE(sm.IsCertificateIssued, 0) as IsCertificateIssued, 
              COALESCE(CONVERT(VARCHAR, sm.RenewalDate, 105), '') as RenewalDate, 
              COALESCE(sm.ParwanaDetCd, 0) as ParwanaDetCd, 
              
              COALESCE(ccm.Calling_Category,'') as Calling_Category,
              
              COALESCE(sm.ConsumerNumber, '') as ConsumerNumber, 

              COALESCE(sm.ShopOwnStatus, '') as ShopOwnStatus, 
              COALESCE(sm.ShopOwnPeriod, 0) as ShopOwnPeriod, 
              COALESCE(sm.ShopOwnerName, '') as ShopOwnerName, 
              COALESCE(sm.ShopOwnerMobile, '') as ShopOwnerMobile, 
              COALESCE(sm.ShopContactNo_1, '') as ShopContactNo_1, 
              COALESCE(sm.ShopContactNo_2, '') as ShopContactNo_2,
              COALESCE(sm.ShopEmailAddress, '') as ShopEmailAddress, 
              COALESCE(sm.ShopOwnerAddress, '') as ShopOwnerAddress,

              COALESCE(sm.MaleEmp, '') as MaleEmp,
              COALESCE(sm.FemaleEmp, '') as FemaleEmp,
              COALESCE(sm.OtherEmp, '') as OtherEmp,
              COALESCE(sm.ContactNo3, '') as ContactNo3,
              COALESCE(sm.GSTNno, '') as GSTNno,


              COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
              COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
              COALESCE(sm.ShopInsideImage1,'') as ShopInsideImage1, 
              COALESCE(sm.ShopInsideImage2,'') as ShopInsideImage2,

              COALESCE(sm.ShopDimension, '') as ShopDimension, 

              COALESCE(sm.ShopStatus, '') as ShopStatus, 
              COALESCE(stm.TextColor, '') as ShopStatusTextColor, 
              COALESCE(stm.FaIcon, '') as ShopStatusFaIcon, 
              COALESCE(stm.IconUrl, '') as ShopStatusIconUrl, 
              COALESCE(CONVERT(VARCHAR, sm.ShopStatusDate, 100), '') as ShopStatusDate, 
              COALESCE(sm.ShopStatusRemark, '') as ShopStatusRemark, 

              COALESCE(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
              COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
              COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar,

              ISNULL((SELECT top (1) QC_Remark1 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = 'ShopBoard' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
              ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = 'ShopBoard' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
              ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = 'ShopBoard' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark3

              FROM ScheduleDetails sd
              INNER JOIN ShopMaster AS sm ON (sd.Shop_Cd=sm.Shop_Cd)
              LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
              INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
              INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
              INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
              LEFT JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
              LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
              WHERE sd.ScheduleCall_Cd = $ScheduleCall_Cd AND sd.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

              // echo $surveyInfoQuery;
            $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($surveyInfoQuery, $electionName, $developmentMode);

            if(sizeof($ShopListCallingDataEdit)>0){
                $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
                $ScheduleCall_Cd = $ShopListCallingDataEdit["ScheduleCall_Cd"];
                $getShopName = $ShopListCallingDataEdit["ShopName"];
                $getShopNameMar = $ShopListCallingDataEdit["ShopNameMar"];

                $getShopArea_Cd = $ShopListCallingDataEdit["ShopArea_Cd"];
                $getShopAreaName = $ShopListCallingDataEdit["ShopAreaName"];
                $getShopCategory = $ShopListCallingDataEdit["ShopCategory"];

                $getPocketName = $ShopListCallingDataEdit["PocketName"];
                $getNodeName = $ShopListCallingDataEdit["NodeName"];
                $getWardNo = $ShopListCallingDataEdit["Ward_No"];
                $getWardArea = $ShopListCallingDataEdit["WardArea"];

                $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
                $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];

                $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
                $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];


                $getAddedDate = $ShopListCallingDataEdit["AddedDate"];
                $getSurveyDate = $ShopListCallingDataEdit["SurveyDate"];

                $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];
                $getShopOutsideImage2 = $ShopListCallingDataEdit["ShopOutsideImage2"];
                $getShopInsideImage1 = $ShopListCallingDataEdit["ShopInsideImage1"];
                $getShopInsideImage2 = $ShopListCallingDataEdit["ShopInsideImage2"];              

                $getShopStatus = $ShopListCallingDataEdit["ShopStatus"];
                $getShopStatusTextColor = $ShopListCallingDataEdit["ShopStatusTextColor"];
                $getShopStatusFaIcon = $ShopListCallingDataEdit["ShopStatusFaIcon"];
                $getShopStatusIconUrl = $ShopListCallingDataEdit["ShopStatusIconUrl"];
                $getShopStatusDate = $ShopListCallingDataEdit["ShopStatusDate"];
                $getShopStatusRemark = $ShopListCallingDataEdit["ShopStatusRemark"];


                $getBusinessCat_Cd = $ShopListCallingDataEdit["BusinessCat_Cd"];
                $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];

                $getCalling_Category = $ShopListCallingDataEdit["Calling_Category"];

                $getQCRemark1 = $ShopListCallingDataEdit["QC_Remark1"];
                $getQCRemark2 = $ShopListCallingDataEdit["QC_Remark2"];
                $getQCRemark3 = $ShopListCallingDataEdit["QC_Remark3"];

            }

            
            $query14 = "SELECT Type_SrNo, Calling_Type
                FROM CallingCategoryMaster 
                WHERE IsActive = 1
                GROUP BY Type_SrNo, Calling_Type";

            $CallingTypeDropDown = $db->ExecutveQueryMultipleRowSALData($query14, $electionName, $developmentMode);

            $query15 = "SELECT sbd.BoardID, sbd.Shop_Cd, sbd.BoardType, sbd.BoardHeight, sbd.BoardWidth, sbd.BoardPhoto, sbd.IsActive, sbd.QC_Flag, CONVERT(VARCHAR,sbd.UpdatedDate,100) as UpdatedDate, CONVERT(VARCHAR,sbd.QC_UpdatedDate,100) as QC_UpdatedDate 
                FROM ShopBoardDetails sbd 
                INNER JOIN ShopMaster sm on sm.Shop_Cd=sbd.Shop_Cd
                WHERE sbd.IsActive = 1 AND sm.IsActive = 1 AND sbd.Shop_Cd = $Shop_Cd ORDER BY sbd.BoardID;";

            $shopBoardDetailsData = $db->ExecutveQueryMultipleRowSALData($query15, $electionName, $developmentMode);
                       
            $ST_Date = "";
            $queryST = "SELECT CONVERT(VARCHAR,ST_DateTime,23) as ST_Date from ShopTracking Where ScheduleCall_Cd = $ScheduleCall_Cd AND ST_Status = 1";
            $STForQC = $db->ExecutveQuerySingleRowSALData($queryST, $electionName, $developmentMode);

            if(sizeof($STForQC)>0){
                $ST_Date = $STForQC["ST_Date"];
            }

    ?>

        <div class="row">
            <legend><b><?php echo $srNo.") "; ?> Shop QC :: <?php echo $getShopName." - ".$getCalling_Category; ?> - <?php echo date('d/m/Y',strtotime($ST_Date)); ?></b></legend>
            <div class="col-12 col-sm-12 col-md-5">
                <div class="row">
                    <div class="avatar mr-75 col-md-3" style="margin-top: 10px;">
                        <?php if($getShopOutsideImage1 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage1; ?>" title="Outside Image 1" class="rounded" width="100%" height="150" alt="Avatar" />
                        <?php } else { ?>   
                            <img src="pics/shopDefault.jpeg" class="rounded" title="Outside Image 1" width="150" height="150" alt="Avatar" />
                        <?php } ?>
                    </div>
                    <div class="media-body my-10px col-md-9" style="margin-top: 10px;">
                        <h6>    
                            <b><?php echo $getShopNameMar; ?></b> 
                        </h6>
                        <h6><b><?php echo $getShopKeeperName; ?> - <?php echo $getShopKeeperMobile; ?></b></h6>
                        
                        
                        <h6><?php echo $getNature_of_Business; ?></h6>
                        <h6><?php echo "Pocket : ".$getPocketName.", Ward : ".$getWardNo.", ".$getWardArea.", ".$getNodeName; ?></h6>
                        <h6><?php echo $getShopAddress_1." ".$getShopAddress_2; ?></h6>
                    
                    </div>
                    
                    

                </div>

            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="row">
                    <?php if($getShopOutsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage1 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage1; ?>" title="Inside Image 1" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage2; ?>" title="Inside Image 2" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-3 text-right" >
                <div class="media">
                    <div class="media-body my-10px">
                        <h5>
                            <?php if(!empty($getShopStatus)) { ?> 
                                    <b style="color:<?php echo $getShopStatusTextColor; ?>;"><?php echo $getShopStatus; ?></b>
                                    <i class="<?php echo $getShopStatusFaIcon; ?>" style="color:<?php echo $getShopStatusTextColor; ?>;font-size:22px"></i>
                            <?php } ?>
                        </h5>
                        <h6><?php echo "<b>Shop Listed : </b>  ".$getAddedDate; ?></h6>
                        <h6><?php if(!empty($getSurveyDate)){ echo "<b>Survey Date : </b>".$getSurveyDate; }  ?></h6>
                        <h6><?php if(!empty($getShopStatusDate)){ echo "<b>Status Date : </b>".$getShopStatusDate; }  ?></h6>
                        
                    </div>

                </div>
            </div>
        </div>
        <?php

                $BoardId = 0;
                $BoardType = "";
                $BoardHeight = 0;
                $BoardWidth = 0;
                $BoardPhoto = "";
                $IsBoardActive = 1;

        ?>
          
        <div class="col-12 col-sm-12 col-md-12" id="shopBoardDetail">

            <?php include 'getShopBoardDetailAddEdit.php'; ?>
        </div>

        <div class="col-12 col-sm-12 col-md-12">
             <div class="table-responsive">
                <table class="table table-hover-animation table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                        
                            <th style="text-align:center;">Sr<br>No</th>
                            <th style="text-align:left;">Board Type</th>
                            <th style="text-align:left;">Board Height</th>
                            <th style="text-align:left;">Board Width</th>
                            <th style="text-align:left;">Board Photo</th>
                            <th style="text-align:left;">Is Board Active</th>
                            <th style="text-align:left;">Last Updated</th>
                            <th style="text-align:left;">QC Completed</th>
                            <th style="text-align:left;">QC Updated</th>
                            <th style="text-align:left;">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                            $srno = 1;
                            foreach($shopBoardDetailsData as $value){
                                $boardPhoto = $value["BoardPhoto"];
                        ?>
                            <tr>
                                <td><?php echo $srno++; ?></td>
                                <td><?php echo $value["BoardType"]; ?></td>
                                <td><?php echo $value["BoardHeight"]; ?></td>
                                <td><?php echo $value["BoardWidth"]; ?></td>
                                <td>
                                    <?php if($boardPhoto != ''){ ?>
                                        <img src="<?php echo $boardPhoto; ?>" title="Board Photo" class="rounded" width="100" height="100" alt="Avatar" />
                                    <?php } ?>
                                </td>
                                <td><?php if($value["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                <td><?php echo $value["UpdatedDate"]; ?></td>
                                <td><?php if($value["QC_Flag"]==5){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                <td><?php echo $value["QC_UpdatedDate"]; ?></td>
                                <td><a onclick="setShowShopBoardDetailForm(<?php echo $ScheduleCall_Cd; ?>,<?php echo $Shop_Cd; ?>,<?php echo $value["BoardID"]; ?>)"><i class="feather icon-edit"></i></a></td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

                            
            <?php
    

        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                                                          

  }else{
    //echo "ddd";
  }

}
?>

