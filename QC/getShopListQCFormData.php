<div class="row">

    <?php 

        // $qcType = $_SESSION['SAL_SHOP_QC_Type'];

        if($qcType=='ShopList'){

          $db=new DbOperation();
          $userName=$_SESSION['SAL_UserName'];
          $appName=$_SESSION['SAL_AppName'];
          $electionName=$_SESSION['SAL_ElectionName'];
          $developmentMode=$_SESSION['SAL_DevelopmentMode'];

          $getShopName = '';
          $getShopNameMar = '';
          $getShopArea_Cd = '';
          $getShopAreaName = '';
          $getShopCategory = '';

          $getShopAddress_1 = '';
          $getShopAddress_2 = '';
          
          $getAddedDate = '';
          $getSurveyDate = '';

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
          
          $getAddedByName = '';
          $getAddedDate = '';

          $getShopDimension = '';
          
          $getShopStatus = '';
          $getShopStatusRemark = '';

          $getBusinessCat_Cd = '';
          $getNature_of_Business = '';

          $getQCRemark1 = '';
          $getQCRemark2 = '';
          $getQCRemark3 = '';



            $basicInfoQuery = "SELECT 
              COALESCE(sm.Shop_Cd, 0) as Shop_Cd, 
              COALESCE(sm.ShopName, '') as ShopName, 
              COALESCE(sm.ShopNameMar, '') as ShopNameMar, 
              
              COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
              COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile,

              COALESCE(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
              COALESCE(sam.ShopAreaName, '') as ShopAreaName, 
              COALESCE(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
              COALESCE(sm.ShopCategory, '') as ShopCategory, 

              COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
              COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 

              COALESCE(sm.ShopContactNo_1, '') as ShopContactNo_1, 
              COALESCE(sm.ShopContactNo_2, '') as ShopContactNo_2,
              
              COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
              COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
             
              COALESCE(sm.ShopStatus, '') as ShopStatus, 
              COALESCE(sm.ShopStatusRemark, '') as ShopStatusRemark, 

              COALESCE(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
              COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
              COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar,

              COALESCE(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
              COALESCE(um.Remarks, '') as AddedByName, 



              ISNULL((SELECT top (1) QC_Remark1 FROM QCDetails 
                WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark1,
              ISNULL((SELECT top (1) QC_Remark2 FROM QCDetails 
                WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark2,
              ISNULL((SELECT top (1) QC_Remark3 FROM QCDetails 
                WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qcType' 
                ORDER BY QC_DateTime DESC ),'') as QC_Remark3
              FROM ShopMaster AS sm
              INNER JOIN Survey_Entry_Data..User_Master um on (um.UserName=sm.AddedBy) 
              LEFT JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
              LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
              WHERE sm.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

              // echo $basicInfoQuery;
          $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($basicInfoQuery, $electionName, $developmentMode);
          // print_r($ShopListCallingDataEdit);

          if(sizeof($ShopListCallingDataEdit)>0){
              $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
              $getShopName = $ShopListCallingDataEdit["ShopName"];
              $getShopNameMar = $ShopListCallingDataEdit["ShopNameMar"];

              $getShopArea_Cd = $ShopListCallingDataEdit["ShopArea_Cd"];
              $getShopAreaName = $ShopListCallingDataEdit["ShopAreaName"];
              $getShopCategory = $ShopListCallingDataEdit["ShopCategory"];

              $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
              $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];

              $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
              $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];
              $getShopContactNo_1 = $ShopListCallingDataEdit["ShopContactNo_1"];
              $getShopContactNo_2 = $ShopListCallingDataEdit["ShopContactNo_2"];

              $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];
              $getShopOutsideImage2 = $ShopListCallingDataEdit["ShopOutsideImage2"];
              
              $getAddedByName = $ShopListCallingDataEdit["AddedByName"];
              $getAddedDate = $ShopListCallingDataEdit["AddedDate"];

              $getShopStatus = $ShopListCallingDataEdit["ShopStatus"];
              $getShopStatusRemark = $ShopListCallingDataEdit["ShopStatusRemark"];
     
              $getBusinessCat_Cd = $ShopListCallingDataEdit["BusinessCat_Cd"];
              $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];

              $getQCRemark1 = $ShopListCallingDataEdit["QC_Remark1"];
              $getQCRemark2 = $ShopListCallingDataEdit["QC_Remark2"];
              $getQCRemark3 = $ShopListCallingDataEdit["QC_Remark3"];
          }

        include 'pages/shopListQCForm.php'; 
      }

  ?>

</div>