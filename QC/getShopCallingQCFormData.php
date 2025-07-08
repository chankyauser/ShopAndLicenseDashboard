<div class="row">
  <?php 

        // $qcType = $_SESSION['SAL_SHOP_QC_Type'];

        if($qcType=='ShopCalling'){

         

          if(sizeof($shopData)>0){
              $Shop_Cd = $shopData["Shop_Cd"];
              $getShopName = $shopData["ShopName"];
  
              $getShopNameMar = $shopData["ShopNameMar"];
              $getShopKeeperName = $shopData["ShopKeeperName"];
              $getShopKeeperMobile = $shopData["ShopKeeperMobile"];
              $getShopAddress_1 = $shopData["ShopAddress_1"];
              $getShopAddress_2 = $shopData["ShopAddress_2"];
              $getShopOutsideImage1 = $shopData["ShopOutsideImage1"];

              $getAddedDate = $shopData["AddedDate"];
              $getSurveyDate = $shopData["SurveyDate"];

              $getShopStatus = $shopData["ShopStatus"];
              $getShopStatusTextColor = $shopData["ShopStatusTextColor"];
              $getShopStatusFaIcon = $shopData["ShopStatusFaIcon"];
              $getShopStatusIconUrl = $shopData["ShopStatusIconUrl"];
              $getShopStatusDate = $shopData["ShopStatusDate"];
              $getShopStatusRemark = $shopData["ShopStatusRemark"];
     
              $getBusinessCat_Cd = $shopData["BusinessCat_Cd"];
              $getNature_of_Business = $shopData["BusinessCatName"];

              $getQC_Flag = $shopData["QC_Flag"];

              $getCall_Date = $shopData["Call_Date"];
              $getCall_DateTime = $shopData["Call_DateTime"];
              $getExecutiveName = $shopData["ExecutiveName"];

            include 'pages/shopCallingQCForm.php'; 

        }
      }

  ?>

</div>
