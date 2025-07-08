<?php
  session_start();
  include '../api/includes/DbOperation.php';

  if( $_SERVER['REQUEST_METHOD'] === "POST" ) 
  {
  
  if(isset($_GET['shopid']) && !empty($_GET['shopid']) && 
    isset($_GET['callingid']) && !empty($_GET['callingid']) && 
    isset($_GET['schedulecallid']) && !empty($_GET['schedulecallid']) 
     )
  {
    try  
        {  
          $db=new DbOperation();
          $userName=$_SESSION['SAL_UserName'];
          $appName=$_SESSION['SAL_AppName'];
          $electionName=$_SESSION['SAL_ElectionName'];
          $developmentMode=$_SESSION['SAL_DevelopmentMode'];

          $Shop_Cd = 0;
          $getShopName = '';
          $getShopNameMar = '';
          $getShopKeeperName = '';
          $getShopKeeperMobile = '';

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


          $getShop_QC_Flag = '';
          $getShop_QC_UpdatedDate = '';

          $getCall_DateTime = '';
          $getCalling_Category = '';
          $getAudioFile_Url = '';
          $getAudioDuration = '';
          $getGoodCall = '';
          $getAppreciation = '';
          $getAudioListen = '';
         
          $getLetterGiven = '';
          $getIsCertificateIssued = '';
          $getRenewalDate = '';
          $getParwanaDetCd = 0;
         
          $getShopOwnPeriodYrs = 0;
          $getShopOwnPeriodMonths = 0;

          $getShopOwnStatus = '';
          $getShopOwnPeriod = '';
          $getShopOwnerName = '';
          $getShopOwnerMobile = '';
          $getShopContactNo_1 = '';
          $getShopContactNo_2 = '';
          $getShopEmailAddress = '';
          $getShopOwnerAddress = '';
          $getShopCategory = '';
          $getConsumerNumber = '';

          $getShopOutsideImage1 = '';
          $getShopOutsideImage2 = '';

          $getShopDimension = '';
          
          $getShopStatus = '';
          $getShopStatusRemark = '';
        
          $getBusinessCat_Cd = '';
          $getNature_of_Business = '';

          $getShopArea_Cd = '';
          $getShopAreaName = '';
         
          
            $getQCRemark1 = '';
            $getQCRemark2 = '';
            $getQCRemark3 = '';

            $Shop_Cd = $_GET['shopid'];
            $Calling_Cd = $_GET['callingid'];
            $ScheduleCall_Cd = $_GET['schedulecallid'];
            $srNo = $_GET['srNo'];
      
              
          
      ?>




          <div class="card">
              <div class="card-title">
                
              </div>
              <div class="card-content">
                  <div class="card-body">
                    

                      <div class="row">

                        <?php 

                              $qcType = $_SESSION['SAL_SHOP_QC_Type'];

                              if($qcType=='ShopCalling'){

                                $callingInfoQuery = "SELECT
                                  ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
                                  ISNULL(cd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                                  ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
                                  ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
                                  ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
                                  ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
                                  ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
                                  ISNULL(cd.AudioDuration,'') as AudioDuration, 
                                  ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
                                  ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
                                  ISNULL(cd.GoodCall,0) as GoodCall, 
                                  ISNULL(cd.QC_Flag,0) as QC_Flag, 
                                  ISNULL(CONVERT(VARCHAR,cd.QC_UpdatedDate,100),'') as QC_UpdatedDate, 
                                  ISNULL(cd.Appreciation,0) as Appreciation, 
                                  ISNULL(cd.AudioListen,0) as AudioListen, 
                                  -- ISNULL(cd.Remark1,'') as Remark1, 
                                  -- ISNULL(cd.Remark2,'') as Remark2, 
                                  -- ISNULL(cd.Remark3,'') as Remark3,
                                  ISNULL(sm.Shop_UID,'') as Shop_UID,
                                  ISNULL(sm.ShopName,'') as ShopName,
                                  ISNULL(sm.ShopNameMar,'') as ShopNameMar,
                                  ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
                                  ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
                                  
                                  ISNULL(pm.PocketName,'') as PocketName,
                                  ISNULL(nm.NodeName,'') as NodeName,
                                  ISNULL(nm.Ward_No,0) as Ward_No,
                                  ISNULL(nm.Area,'') as WardArea,

                                  ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                                  ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
                                  ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
                                  ISNULL(CONVERT(VARCHAR,sm.AddedDate,105),0) as AddedDate,
                                  ISNULL(CONVERT(VARCHAR,sm.SurveyDate,105),0) as SurveyDate,
                                  ISNULL(ccm.Calling_Category,'') as Calling_Category,
                                  ISNULL(crm.Call_Response,'') as Call_Response,

                                  ISNULL(sm.QC_Flag,0) as Shop_QC_Flag, 
                                  ISNULL(CONVERT(VARCHAR,sm.QC_UpdatedDate,100),'') as Shop_QC_UpdatedDate, 
                                  
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
                                    WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = '$qcType' 
                                    ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
                                  ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                                    WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = '$qcType' 
                                    ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
                                  ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                                    WHERE Shop_Cd = $Shop_Cd AND Calling_Cd = $Calling_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND QC_Type = '$qcType' 
                                    ORDER BY QC_DateTime DESC ),'') as QC_Remark3
                                  FROM CallingDetails cd
                                  INNER JOIN ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd AND 
                                      cd.Calling_Cd = $Calling_Cd AND cd.Shop_Cd = $Shop_Cd 
                                  )
                                  INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                  INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                  INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                                  INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
                                  INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd;";

                                    // echo $callingInfoQuery;
                                $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($callingInfoQuery, $electionName, $developmentMode);
                                // print_r($ShopListCallingDataEdit);

                                if(sizeof($ShopListCallingDataEdit)>0){
                                    $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
                                    $ScheduleCall_Cd = $ShopListCallingDataEdit["ScheduleCall_Cd"];
                                    $Calling_Cd = $ShopListCallingDataEdit["Calling_Cd"];
                                    $getShopName = $ShopListCallingDataEdit["ShopName"];
                                    $getShopNameMar = $ShopListCallingDataEdit["ShopNameMar"];
                                    $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
                                    $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];
                                    $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
                                    $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];
                                    $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];

                                    $getAddedDate = $ShopListCallingDataEdit["AddedDate"];
                                    $getSurveyDate = $ShopListCallingDataEdit["SurveyDate"];

                                    $getQC_Flag = $ShopListCallingDataEdit["QC_Flag"];
                                    $getQC_UpdatedDate = $ShopListCallingDataEdit["QC_UpdatedDate"];
                                    
                                    $getShop_QC_Flag = $ShopListCallingDataEdit["Shop_QC_Flag"];
                                    $getShop_QC_UpdatedDate = $ShopListCallingDataEdit["Shop_QC_UpdatedDate"];

                                    $getCall_DateTime = $ShopListCallingDataEdit["Call_DateTime"];
                                    $getCalling_Category = $ShopListCallingDataEdit["Calling_Category"];
                                    $getAudioFile_Url = $ShopListCallingDataEdit["AudioFile_Url"];
                                    $getAudioDuration = $ShopListCallingDataEdit["AudioDuration"];
                                    $getGoodCall = $ShopListCallingDataEdit["GoodCall"];
                                    $getAppreciation = $ShopListCallingDataEdit["Appreciation"];
                                    $getAudioListen = $ShopListCallingDataEdit["AudioListen"];





                                    $getShopStatus = $ShopListCallingDataEdit["ShopStatus"];
                                    $getShopStatusRemark = $ShopListCallingDataEdit["ShopStatusRemark"];
                           
                                    $getBusinessCat_Cd = $ShopListCallingDataEdit["BusinessCat_Cd"];
                                    $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];

                                    $getQCRemark1 = $ShopListCallingDataEdit["QC_Remark1"];
                                    $getQCRemark2 = $ShopListCallingDataEdit["QC_Remark2"];
                                    $getQCRemark3 = $ShopListCallingDataEdit["QC_Remark3"];
                                }

                              include 'pages/shopCallingQCForm.php'; 
                            }

                        ?>

                      </div>

                  </div>
              </div>    

          </div>


<?php
    } 
    catch(Exception $e)  
    {  
        echo("Error!");  
    }
                
  } else{
    echo "<script> alert('Failed'); </script>";
  }

}

?>