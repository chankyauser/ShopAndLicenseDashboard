<div class="row">

  <?php 

        // $qcType = $_SESSION['SAL_SHOP_QC_Type'];

        if($qcType == 'ShopSurvey'){


          $db=new DbOperation();
          $userName=$_SESSION['SAL_UserName'];
          $appName=$_SESSION['SAL_AppName'];
          $electionName=$_SESSION['SAL_ElectionName'];
          $developmentMode=$_SESSION['SAL_DevelopmentMode'];

         
          $DocScheduleCall_Cd = 0;
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
          
          $getSurveyByName = '';

          $getQC_Flag = '';
          $getQC_UpdatedDate = '';
         
          $getShopKeeperName = '';
          $getShopKeeperMobile = '';
          

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

          $getMaleEmp = '';
          $getFemaleEmp = '';
          $getOtherEmp = '';
          $getContactNo3 = '';
          $getGSTNno = '';
          
          
          $getConsumerNumber = '';

          $getShopOutsideImage1 = '';
          $getShopOutsideImage2 = '';
          $getShopInsideImage1 = '';
          $getShopInsideImage2 = '';

          $getShopDimension = '';
          
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

              COALESCE(um.Remarks, '') as SurveyByName,

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
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
              ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
              ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark3
              FROM ScheduleDetails sd
              INNER JOIN ShopMaster AS sm ON (sd.Shop_Cd=sm.Shop_Cd)
              LEFT JOIN Survey_Entry_Data..User_Master um on (um.UserName=sm.SurveyBy) 
              LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
              INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
              INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
              INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
              LEFT JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
              LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
              WHERE sd.ScheduleCall_Cd = $ScheduleCall_Cd AND sd.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

             

        if($executiveCd==669){
            // echo $surveyInfoQuery;
          $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($surveyInfoQuery, $electionName, $developmentMode);
          // print_r($ShopListCallingDataEdit);
        }else{

          $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($surveyInfoQuery, $electionName, $developmentMode);
        }

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
              
              $getSurveyByName = $ShopListCallingDataEdit["SurveyByName"];



              $getQC_Flag = $ShopListCallingDataEdit["QC_Flag"];
              $getQC_UpdatedDate = $ShopListCallingDataEdit["QC_UpdatedDate"];


      
              $getLetterGiven = $ShopListCallingDataEdit["LetterGiven"];
              $getIsCertificateIssued = $ShopListCallingDataEdit["IsCertificateIssued"];
              $getRenewalDate = $ShopListCallingDataEdit["RenewalDate"];
              $getParwanaDetCd = $ShopListCallingDataEdit["ParwanaDetCd"];


              
              $getConsumerNumber = $ShopListCallingDataEdit["ConsumerNumber"];

              $getShopOwnStatus = $ShopListCallingDataEdit["ShopOwnStatus"];
              $getShopOwnPeriod = $ShopListCallingDataEdit["ShopOwnPeriod"];

              if($getShopOwnPeriod == 0){
                $getShopOwnPeriodYrs = 0;
                $getShopOwnPeriodMonths = 0;
              }else if($getShopOwnPeriod < 12){
                $getShopOwnPeriodYrs = 0;
                $getShopOwnPeriodMonths = $getShopOwnPeriod;
              }else if($getShopOwnPeriod == 12){
                $getShopOwnPeriodYrs = 1;
                $getShopOwnPeriodMonths = 0;
              }else if($getShopOwnPeriod > 12){
                $yrMonthVal = $getShopOwnPeriod / 12;
                $yrMonthValArr = explode(".", $yrMonthVal);
                $getShopOwnPeriodYrs = $yrMonthValArr[0];
                $getShopOwnPeriodMonths = ( $getShopOwnPeriod - ($yrMonthValArr[0] * 12) );
              }
              

              $getShopOwnerName = $ShopListCallingDataEdit["ShopOwnerName"];
              $getShopOwnerMobile = $ShopListCallingDataEdit["ShopOwnerMobile"];
              $getShopContactNo_1 = $ShopListCallingDataEdit["ShopContactNo_1"];
              $getShopContactNo_2 = $ShopListCallingDataEdit["ShopContactNo_2"];
              $getShopEmailAddress = $ShopListCallingDataEdit["ShopEmailAddress"];
              $getShopOwnerAddress = $ShopListCallingDataEdit["ShopOwnerAddress"];
             
              $getMaleEmp = $ShopListCallingDataEdit["MaleEmp"];
              $getFemaleEmp = $ShopListCallingDataEdit["FemaleEmp"];
              $getOtherEmp = $ShopListCallingDataEdit["OtherEmp"];
              $getContactNo3 = $ShopListCallingDataEdit["ContactNo3"];
              $getGSTNno = $ShopListCallingDataEdit["GSTNno"];
              
              $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];
              $getShopOutsideImage2 = $ShopListCallingDataEdit["ShopOutsideImage2"];
              $getShopInsideImage1 = $ShopListCallingDataEdit["ShopInsideImage1"];
              $getShopInsideImage2 = $ShopListCallingDataEdit["ShopInsideImage2"];

              
              $getShopDimension = $ShopListCallingDataEdit["ShopDimension"];
              

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

               include 'pages/shopSurveyQCForm.php'; 
          }
      
         
      }else if($qcType == 'ShopDocument'){

          $surveyInfoQuery = "SELECT 
              COALESCE(sd.ScheduleCall_Cd, 0) as ScheduleCall_Cd, 
              COALESCE(sd.Shop_Cd, 0) as Shop_Cd, 
              COALESCE(sm.ShopName, '') as ShopName, 
              COALESCE(sm.ShopNameMar, '') as ShopNameMar, 
              COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
              COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile, 

              ISNULL(pm.PocketName,'') as PocketName,
              ISNULL(nm.NodeName,'') as NodeName,
              ISNULL(nm.Ward_No,0) as Ward_No,
              ISNULL(nm.Area,'') as WardArea,

              COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
              COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 
              
              COALESCE(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
              COALESCE(CONVERT(VARCHAR, sm.SurveyDate, 100), '') as SurveyDate, 

              COALESCE(sm.QC_Flag, 0) as QC_Flag,
              COALESCE(CONVERT(VARCHAR, sm.QC_UpdatedDate, 100), '') as QC_UpdatedDate, 

              COALESCE(sm.IsCertificateIssued, 0) as IsCertificateIssued, 
            
              COALESCE(ccm.Calling_Category,'') as Calling_Category,

              COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
              COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
              COALESCE(sm.ShopInsideImage1,'') as ShopInsideImage1, 
              COALESCE(sm.ShopInsideImage2,'') as ShopInsideImage2,
              

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
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
              ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
              ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                WHERE ScheduleCall_Cd = $ScheduleCall_Cd AND Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
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
          // print_r($ShopListCallingDataEdit);

          if(sizeof($ShopListCallingDataEdit)>0){
              $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
              $DocScheduleCall_Cd = $ShopListCallingDataEdit["ScheduleCall_Cd"];
              $getShopName = $ShopListCallingDataEdit["ShopName"];
              $getShopNameMar = $ShopListCallingDataEdit["ShopNameMar"];
              $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
              $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];

              $getPocketName = $ShopListCallingDataEdit["PocketName"];
              $getNodeName = $ShopListCallingDataEdit["NodeName"];
              $getWardNo = $ShopListCallingDataEdit["Ward_No"];
              $getWardArea = $ShopListCallingDataEdit["WardArea"];
              
              $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
              $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];

              $getAddedDate = $ShopListCallingDataEdit["AddedDate"];
              $getSurveyDate = $ShopListCallingDataEdit["SurveyDate"];

              $getQC_Flag = $ShopListCallingDataEdit["QC_Flag"];
              $getQC_UpdatedDate = $ShopListCallingDataEdit["QC_UpdatedDate"];


              $getIsCertificateIssued = $ShopListCallingDataEdit["IsCertificateIssued"];
                                                 
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
              
            include 'pages/shopDocumentQCForm.php'; 

          }
      
      }

  ?>

</div>
