<style>
.nav.nav-tabs .nav-item .nav-link.active {
  border : none;
  position : relative;
  color: #c90d41;
  -webkit-transition : all 0.2s ease;
          transition : all 0.2s ease;
  background-color : transparent;
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
.select2-container--classic .select2-selection--single:focus, .select2-container--default .select2-selection--single:focus {
    outline: 0;
    border-color: #C90D41 !important;
    box-shadow: 0 3px 10px 0 rgb(0 0 0 / 15%) !important;
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
</style>



<div class="content-body">



    <?php
        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $currentDate = date('Y-m-d');
          

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
        $getBusinessCat_Cd = '';
        $getNature_of_Business = '';
    // Advanced Info Variable
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
        
    // Board Info

        $getBoardType1 = '';
        $getBoardHeight1 = '';
        $getBoardWidth1 = '';
        $getBoardPhoto1 = '';


        if(isset($_GET['Shop_Cd']) && $_GET['Shop_Cd'] != 0 && isset($_GET['action']) ){
            $Shop_Cd = $_GET['Shop_Cd'];
            $action = $_GET['action'];

            $query = "SELECT 
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
                    COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
                    COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar   
                    FROM ShopMaster AS sm 
                    INNER JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
                    WHERE sm.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";


            $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);


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
                    $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];
                    
                }
                if($getIsCertificateIssued == 1){
                    $IsCertificateIssuedCompare = 1;
                }
                else{
                    $IsCertificateIssuedCompare = 2;    
                }

                $advancedInfoQuery = "SELECT 
                    COALESCE(sm.Shop_Cd, 0) as Shop_Cd, 
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

        $advancedInfoBoardQuery = "SELECT 
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

                $getBoardType1 = $BoardType1DataArray["BoardType"] ;
                $getBoardHeight1 =$BoardType1DataArray["BoardHeight"] ;
                $getBoardWidth1 = $BoardType1DataArray["BoardWidth"] ;
                $getBoardPhoto1 = $BoardType1DataArray["BoardPhoto"] ;

        }

            $BoardType2DataArray = '';
            $getBoardType2 = '';
            $getBoardHeight2 = '';
            $getBoardWidth2 = '';
            $getBoardPhoto2 = '';

        if(sizeof($AdvancedInfoBoardData) >= 2){
            $BoardType2DataArray = $AdvancedInfoBoardData[1];

            $getBoardType2 = $BoardType2DataArray["BoardType"] ;
            $getBoardHeight2 =$BoardType2DataArray["BoardHeight"] ;
            $getBoardWidth2 = $BoardType2DataArray["BoardWidth"] ;
            $getBoardPhoto2 = $BoardType2DataArray["BoardPhoto"] ;
        }
        
            $BoardType3DataArray = '';
            $getBoardType = '';
            $getBoardHeight3 = '';
            $getBoardWidth3 = '';
            $getBoardPhoto3 = '';

            if(sizeof($AdvancedInfoBoardData) >= 2){

                $BoardType3DataArray = $AdvancedInfoBoardData[2];

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

            if(sizeof($DocumentFileData)>0){

                    $CCOCImage = $DocumentFileData[0];
                    $CCOCImageFileURL = $CCOCImage["FileURL"] ;

                    $ShopAct = $DocumentFileData[1];
                    $ShopActFileURL = $ShopAct["FileURL"] ;

                    $FDACertificate = $DocumentFileData[2];
                    $FDACertificateFileURL = $FDACertificate["FileURL"] ;

                    $FireChallan = $DocumentFileData[3];
                    $FireChallanFileURL = $FireChallan["FileURL"] ;

                    $NOCofSociety = $DocumentFileData[4];
                    $NOCofSocietyFileURL = $NOCofSociety["FileURL"] ;

                    $PestControlCertificate = $DocumentFileData[5];
                    $PestControlCertificateFileURL = $PestControlCertificate["FileURL"] ;

                    $RentAgreement = $DocumentFileData[6];
                    $RentAgreementFileURL = $RentAgreement["FileURL"] ;

                    $PropertyTaxChallan = $DocumentFileData[7];
                    $PropertyTaxChallanFileURL = $PropertyTaxChallan["FileURL"] ;

                    $WaterTaxChallan = $DocumentFileData[8];
                    $WaterTaxChallanFileURL = $WaterTaxChallan["FileURL"] ;

                    $GSTCertificate = $DocumentFileData[9];
                    $GSTCertificateFileURL = $GSTCertificate["FileURL"] ;
            }

        }


    //  Basic Info Drop Downs Starts

    $query2 = "SELECT BusinessCat_Cd, BusinessCatName, BusinessCatNameMar 
                FROM BusinessCategoryMaster WHERE IsActive = 1;";

    $NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

    $query3 = "SELECT DropDown_Cd, DValue FROM  DropDownMaster
                WHERE DTitle = 'CertificateIssued' AND IsActive = 1 ORDER BY SerialNo;";

    $IsCertificateIssuedDropDown = $db->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);


    $query4 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'LetterGiven' AND IsActive = 1 ORDER BY SerialNo;";

    $LetterGivenDropDown = $db->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

    //  Basic Info Drop Downs Ends

    ?>

    <section id="nav-justified">


        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">

                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center active" id="basic-info-tab" data-toggle="tab" href="#basic-info" aria-controls="basic-info" role="tab" aria-selected="true">
                                        <span class="d-none d-sm-block">Basic Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="advance-info-tab" data-toggle="tab" href="#advance-info" aria-controls="advance-info" role="tab" aria-selected="false">
                                        <span class="d-none d-sm-block">Advance Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="upload-tab" data-toggle="tab" href="#upload" aria-controls="upload" role="tab" aria-selected="false">
                                        <span class="d-none d-sm-block">Upload Documents</span>
                                    </a>
                                </li>
                            </ul>


    <!-- ############################# Basic Info Edit Form Start Here #####################################-->

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="basic-info" aria-labelledby="basic-info-tab" role="tabpanel">
                                        
                                            <form action="" method="POST" enctype="multipart/form-data" novalidate>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Establishment Name </label><label style="color:red;">*</label>
                                                                <input type="text" value="<?php echo $getShopName; ?>" name="EstablishmentName" id="EstablishmentName" class="form-control" placeholder="Establishment Name" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Nature of Business </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" required name="NatureofBusiness" id="NatureofBusiness" disabled required>
                                                                <option value="">--Select--</option>
                                                                <?php if (sizeof($NatureOfBusinesDropDown)>0) 
                                                                        {
                                                                            foreach($NatureOfBusinesDropDown as $key => $value)
                                                                            {
                                                                                if($getNature_of_Business == $value["BusinessCatName"])
                                                                                {
                                                                                ?> 
                                                                                 <option selected="true" value="<?php echo $value['BusinessCatName'];?>"><?php echo $value['BusinessCatName'];?></option>
                                                                                 <?php }
                                                                                 else
                                                                                 { ?>
                                                                                    <option value="<?php echo $value["BusinessCatName"];?>"><?php echo $value["BusinessCatName"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>

                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shopkeeper / Contact Person Name </label><label style="color:red;"><b>*</b></label>
                                                                <input type="text" value="<?php echo $getShopKeeperName; ?>" name="ShopkeeperName" id="ShopkeeperName" class="form-control" placeholder="Shopkeeper / Contact Person Name" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shopkeeper / Contact Person Mobile No </label><label style="color:red;">*</label>
                                                                <input type="text" value="<?php echo $getShopKeeperMobile; ?>" name="ShopkeeperMobileNo" id="ShopkeeperMobileNo" class="form-control" placeholder="Shopkeeper / Contact Person Mobile No" value="" maxlength="10" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                              
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Is Certificate Issued Previosly </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" required name="IsCertificateIssuedPreviously" id="IsCertificateIssuedPreviously" disabled required>
                                                                <?php if (sizeof($IsCertificateIssuedDropDown)>0) 
                                                                    {
                                                                        foreach($IsCertificateIssuedDropDown as $key => $value)
                                                                        {
                                                                            if($IsCertificateIssuedCompare == $value["DropDown_Cd"])
                                                                            {
                                                                            ?> 
                                                                                <option selected="true" value="<?php echo $value['DropDown_Cd'];?>"><?php echo $value['DValue'];?></option>
                                                                                <?php }
                                                                                else
                                                                                { ?>
                                                                                <option value="<?php echo $value["DropDown_Cd"];?>"><?php echo $value["DValue"];?></option>
                                                                        <?php }
                                                                        }
                                                                    } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Due Date of License Renewal</label>
                                                                <input type="text" value="<?php echo $getRenewalDate; ?>" class="form-control" placeholder="Due Date of License Renewal" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
     
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <label>Letter Given to Shopkeeper</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="LetterGiventoShopkeeper" id="LetterGiventoShopkeeper" disabled>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($LetterGivenDropDown)>0) 
                                                                        {
                                                                            foreach($LetterGivenDropDown as $key => $value)
                                                                            {
                                                                                if($getLetterGiven == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                    else
                                                                                    { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Secondary Contact Number</label>
                                                                <input type="text" value="<?php echo $getShopContactNo_2;?>" name="SecondaryContactNumber" id="SecondaryContactNumber" class="form-control" placeholder="Secondary Contact Number" value="" maxlength="10" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Address Line 1</label>
                                                                <input type="text" value="<?php echo $getShopAddress_1;?>" name="AddressLine1" id="AddressLine1" class="form-control" placeholder="Address Line 1" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Address Line 2</label>
                                                                <input type="text" value="<?php echo $getShopAddress_2;?>" name="AddressLine2" id="AddressLine2" class="form-control" placeholder="Address Line 2" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Establishment Image 1 (From Outside)</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getShopOutsideImage1;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="EstablishmentImagesView" id="EstablishmentImagesView" class="image" src="<?php echo $getShopOutsideImage1;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Establishment Image 2 (From Outside)</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getShopOutsideImage2;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="EstablishmentImagesView2" id="EstablishmentImagesView2" class="image" src="<?php echo $getShopOutsideImage2;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

    <!-- ############################# Basic Info Edit Form Ends Here #####################################-->


    <!-- ############################# Advanced Info Edit Form Starts Here #####################################-->

    <?php 

    //  Advanced Info Drop Downs Starts

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

    $query10 = " SELECT ShopArea_Cd, ShopAreaName FROM ShopAreaMaster WHERE IsActive = 1 ORDER BY ShopAreaName;";

    $EstablishmentAreaCategoryDropDown = $db->ExecutveQueryMultipleRowSALData($query10, $electionName, $developmentMode);

    $query11 = "SELECT DropDown_Cd, DValue FROM DropDownMaster
                WHERE DTitle = 'PropertyStatus' AND IsActive = 1
                ORDER BY SerialNo;";

    $OwnedORRentedDropDown = $db->ExecutveQueryMultipleRowSALData($query11, $electionName, $developmentMode);

    //  Advanced Info Drop Downs Ends

    ?>


                                        <div class="tab-pane" id="advance-info" aria-labelledby="advance-info-tab" role="tabpanel">
                                            <form novalidate>
                                                <div class="row mt-1">

                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Parwana Type </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="ParwanaType" id="ParwanaType" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($ParwanaTypeDropDown)>0) 
                                                                        {
                                                                            foreach($ParwanaTypeDropDown as $key => $value)
                                                                            {
                                                                                if($getParwana_Name_Eng == $value["Parwana_Name_Eng"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['Parwana_Cd'];?>"><?php echo $value['Parwana_Name_Eng'];?></option>
                                                                                    <?php }
                                                                                    else
                                                                                    { ?>
                                                                                    <option value="<?php echo $value["Parwana_Cd"];?>"><?php echo $value["Parwana_Name_Eng"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                 
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>New Registration of Parwana</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="NewRegistrationofParwana" id="NewRegistrationofParwana" disabled>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($IsNewParwanaDropDown)>0) 
                                                                        {
                                                                            foreach($IsNewParwanaDropDown as $key => $value)
                                                                            {
                                                                                if($getIsNewParwana == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DropDown_Cd'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                    else
                                                                                    { ?>
                                                                                    <option value="<?php echo $value["DropDown_Cd"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Establishment Category </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="EstablishmentCategory" id="EstablishmentCategory" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($EstablishmentCategoryDropDown)>0) 
                                                                        {
                                                                            foreach($EstablishmentCategoryDropDown as $key => $value)
                                                                            {
                                                                                if($getShopCategory == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
      

                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                        <label>Board Type 1 </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="BoardType1" id="BoardType1" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($BoardTypeDropDown)>0) 
                                                                        {
                                                                            foreach($BoardTypeDropDown as $key => $value)
                                                                            {
                                                                                if($getBoardType1 == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Height</label>
                                                                <input type="text" value="<?php echo $getBoardHeight1;?>" name="BoardHeight" id="BoardHeight" class="form-control" placeholder="Board Height" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Width</label>
                                                                <input type="text" value="<?php echo $getBoardWidth1;?>" name="BoardWidth" id="BoardWidth" class="form-control" placeholder="Board Width" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Type 1 Image</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getBoardPhoto1;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="BoardType1ImageView" id="BoardType1ImageView" class="image" src="<?php echo $getBoardPhoto1;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   

                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                        <label>Board Type 2 </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="BoardType2" id="BoardType2" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($BoardTypeDropDown)>0) 
                                                                        {
                                                                            foreach($BoardTypeDropDown as $key => $value)
                                                                            {
                                                                                if($getBoardType2 == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Height</label>
                                                                <input type="text" value="<?php echo $getBoardHeight2; ?>" name="BoardHeight" id="BoardHeight" class="form-control" placeholder="Board Height" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Width</label>
                                                                <input type="text" value="<?php echo $getBoardWidth2; ?>" name="BoardWidth" id="BoardWidth" class="form-control" placeholder="Board Width" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Type 2 Image</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getBoardPhoto2; ?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="BoardType2ImageView" id="BoardType2ImageView" class="image" src="<?php echo $getBoardPhoto2; ?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                        <label>Board Type 3 </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="BoardType3" id="BoardType3" disabled>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($BoardTypeDropDown)>0) 
                                                                        {
                                                                            foreach($BoardTypeDropDown as $key => $value)
                                                                            {
                                                                                if($getBoardType3 == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Height</label>
                                                                <input type="text" value="<?php echo $getBoardHeight3;?>" name="BoardHeight3" id="BoardHeight3" class="form-control" placeholder="Board Height" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Width</label>
                                                                <input type="text" value="<?php echo $getBoardWidth3;?>" name="BoardWidth3" id="BoardWidth3" class="form-control" placeholder="Board Width" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Board Type 3 Image</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getBoardPhoto3;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="BoardType2ImageView" id="BoardType2ImageView" class="image" src="<?php echo $getBoardPhoto3;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                        <label>Municipal Ward Number </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="MunicipalWardNumber" id="MunicipalWardNumber" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($MunicipalWardNoDropDown)>0) 
                                                                        {
                                                                            foreach($MunicipalWardNoDropDown as $key => $value)
                                                                            {
                                                                                if($getMuncipalWN == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                    <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Owner Home Address</label>
                                                                <input type="text" value="<?php echo $getShopOwnerAddress;?>" name="ShopKeeperHomeAddress" id="ShopKeeperHomeAddress" class="form-control" placeholder="Shop Keeper Home Address" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Establishment Area (sq.ft)</label>
                                                                <input type="text" value="<?php echo $getShopArea; ?>" name="EstablishmentArea" id="EstablishmentArea" class="form-control" placeholder="Establishment Area" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Establishment Area Category</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="EstablishmentAreaCategory" id="EstablishmentAreaCategory" disabled>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($EstablishmentAreaCategoryDropDown)>0) 
                                                                        {
                                                                            foreach($EstablishmentAreaCategoryDropDown as $key => $value)
                                                                            {
                                                                                if($getShopAreaName == $value["ShopAreaName"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['ShopAreaName'];?>"><?php echo $value['ShopAreaName'];?></option>
                                                                                <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["ShopAreaName"];?>"><?php echo $value["ShopAreaName"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                   
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                        <label>Owned / Rented</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="Owned_Rented" id="Owned_Rented" disabled required>
                                                                <option  value="">--Select--</option>   
                                                                    <?php if (sizeof($OwnedORRentedDropDown)>0) 
                                                                        {
                                                                            foreach($OwnedORRentedDropDown as $key => $value)
                                                                            {
                                                                                if($getShopOwnStatus == $value["DValue"])
                                                                                {
                                                                                ?> 
                                                                                    <option selected="true" value="<?php echo $value['DValue'];?>"><?php echo $value['DValue'];?></option>
                                                                                <?php }
                                                                                else
                                                                                { ?>
                                                                                    <option value="<?php echo $value["DValue"];?>"><?php echo $value["DValue"];?></option>
                                                                            <?php }
                                                                            }
                                                                        } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Owned / Rented Time (in months)</label>
                                                                <input type="text" value="<?php echo $getShopOwnPeriod;?>" name="Owned/RentedTime" id="Owned/RentedTime" class="form-control" placeholder="Owned / Rented Time" value="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                            <label>Establishment Image 1 (From Inside)</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getShopInsideImage1 ;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="EstablishmentImagesViewIn1" id="EstablishmentImagesViewIn1" class="image" src="<?php echo $getShopInsideImage1 ;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                            <label>Establishment Image 2 (From Inside)</label>
                                                                <br>
                                                                <a target="_blank" href="<?php echo $getShopInsideImage2 ;?>">
                                                                    <img  style="width: 150px; height: 150px; border-style: solid;border-width: 2px;" 
                                                                    name="EstablishmentImagesViewIn1" id="EstablishmentImagesViewIn1" class="image" src="<?php echo $getShopInsideImage2 ;?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </form>
                                        </div>

    <?php 

        $query12 = "SELECT Document_Cd, DocumentName
                    FROM ShopDocumentMaster WHERE IsActive = 1;";

        $DocumentUploadList = $db->ExecutveQueryMultipleRowSALData($query12, $electionName, $developmentMode);

    ?>

                                        <div class="tab-pane" id="upload" aria-labelledby="upload-tab" role="tabpanel">
                                            <form novalidate>
                                                <div class="row">
                                                <?php foreach($DocumentUploadList as $list){?>
                                                    <div class="col-12 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label><?php echo $list['DocumentName'];?></label> 

                                                                    <?php if($list['DocumentName'] == 'C.C. , O.C. Document' || $list['DocumentName'] == 'Shop Act'
                                                                    || $list['DocumentName'] == 'Fire Challan' || $list['DocumentName'] == 'NOC of Society' 
                                                                    || $list['DocumentName'] == 'Rent Agreement if Applicable' || $list['DocumentName'] == 'Property Tax Challan'
                                                                    || $list['DocumentName'] == 'Water Tax Challan'){?>
                                                                    <label style="color:red;">*</label><?php } ?>
                                                                    
                                                                        <br>
                                                                        <a target="_blank" href="<?php 
                                                                                foreach($DocumentFileData as $key => $value){
                                                                                        if($value['Document_Cd'] == $list['Document_Cd']){
                                                                                                echo $value['FileURL'];
                                                                                            }
                                                                                        }?>">
                                                                        <img src="<?php
                                                                            foreach($DocumentFileData as $key => $value){
                                                                                if($value['Document_Cd'] == $list['Document_Cd']){
                                                                                        echo $value['FileURL'];
                                                                                }
                                                                            }
                                                                            ?>" id="filePreview" style="width: 150px; height: 150px;border-style: solid; border-width: 2px;" />
                                                                        </a>

                                                                </div>
                                                            </div>
                                                            
                                                        <?php// } ?>
                                                    </div>

                                                    <?php } ?>

                                                </div>
                                            </form>

                                        </div>

                                    </div>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>



</div>