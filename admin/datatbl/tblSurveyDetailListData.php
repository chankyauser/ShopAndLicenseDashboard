<?php

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        $queryShopStatus = "SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE IsActive = 1;";
        $ShopStatusDropDown = $db->ExecutveQueryMultipleRowSALData($queryShopStatus, $electionName, $developmentMode);

        $loginExecutiveCd = 0;
        $userId = $_SESSION['SAL_UserId'];
        if($userId != 0){
            $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
            if(sizeof($exeData)>0){
                $loginExecutiveCd = $exeData["Executive_Cd"];
            }
        }

?>
<style type="text/css">
    .btn{
        padding: 1rem 1rem;
    }
</style>
<div class="row">
   
    <div class="col-12 col-sm-12 col-md-4">
        <div class="form-group">
            <label for="shopName">Search Shop Name</label>
            <input type='text' name="shopName" value="" class="form-control" />
        </div>
    </div>

    <div class="col-12 col-md-3 col-sm-12">
        <?php include 'dropdown-executives-name-node-cd-date.php' ?>
    </div>

    <div class="col-12 col-md-2 col-sm-12">
        <div class="form-group">
            <label>Shop Status</label>
            <div class="controls"> 
                <select class="select2 form-control" name="shopStatus">
                    <option value="All">All</option>   
                        <?php if (sizeof($ShopStatusDropDown)>0) 
                            {
                                foreach($ShopStatusDropDown as $key => $value)
                                {
                                    if($shop_Status_Post == $value["ShopStatus"])
                                    {
                                     ?> 
                                        <option selected="true" value="<?php echo $value['ShopStatus'];?>"><?php echo $value['ShopStatus'];?></option>
                                    <?php }
                                    else
                                    { ?>
                                        <option value="<?php echo $value["ShopStatus"];?>"><?php echo $value["ShopStatus"];?></option>
                                <?php }
                                }
                            } 
                        ?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2 col-sm-12">
        <div class="form-group">
            <label>Survey Status</label>
            <div class="controls"> 
                <select class="select2 form-control" name="surveyStatus">
                    <option <?php echo $survey_Status_Post == 'All' ? 'selected' : '' ; ?> value="All">All</option>   
                    <option <?php echo $survey_Status_Post == 'Pending' ? 'selected' : '' ; ?> value="Pending">Pending</option>   
                    <option <?php echo $survey_Status_Post == 'Completed' ? 'selected' : '' ; ?> value="Completed">Completed</option>   
                        
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-1 col-sm-12 col-12 text-right"  style="margin-top:25px;" >
         <div class="form-group">
            <label for="refesh" ></label>
            <button type="button" name="refesh" id="searchResult" class="btn btn-primary" onclick="getShopSearchSurveyDetail()" ><i class="feather icon-search"></i></button>
        </div>
    </div>

   <div class="col-12 col-sm-12 col-md-6">
         <!-- <label>Records </label> -->
            <form method='post' action='ShopSurveyDetailDataExport.php'>
            <input type='submit' value='Export-<?php echo $total_count["SurveyDone"]; ?>' name='Export' class="btn btn-success" >

              <?php 
                $serialize_ShopSurveyDetailData = serialize($shopsSurveyDetailExport);
               ?>
            
            <textarea name='export_data' style='display: none;'><?php echo $serialize_ShopSurveyDetailData; ?></textarea>
        </form>
    </div>
    <div class="col-12 col-sm-12 col-md-6 text-right">
        <!-- <label>Pagination</label> -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end ">

               
                <?php 
                    // echo $totalRecords;
                    $loopStart = 1;
                    $loopStop = $totalRecords;

                    if($totalRecords > 5){
                         if($pageNo==1){
                            $loopStart = $pageNo;
                        }else if($pageNo==2){
                            $loopStart = $pageNo - 1;
                        }else if($pageNo>=3){
                            $loopStart = $pageNo - 2;
                        }else{
                            $loopStart = $pageNo ;
                        }
                        
                        $loopStop = $loopStart + 5;
                        if($loopStop>$totalRecords){
                            $loopStop = $totalRecords;
                            $loopStart = $loopStop - 5;
                        }
                    }
                ?>

                <?php
                    if($pageNo != $loopStart ){ 
                ?>  
                    <li class="page-item prev"><a class="page-link" onclick="setSurveyDetailPaginationPageNo(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                <?php } ?>

                <?php
                    for($i=$loopStart;$i<=$loopStop;$i++){ 

                            $activePageCondition = ""; 
                            if($pageNo == $i){
                                $activePageCondition = "active";                                
                            }
                        ?>
                        <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setSurveyDetailPaginationPageNo(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                <?php } ?>
                    <!-- <li class="page-item" > <a class="page-link"><?php //echo " of ".$total_count["SurveyDone"]; ?></a></li> -->
                <?php if($totalRecords > $loopStop){ ?> 
                    <li class="page-item next"><a class="page-link"  onclick="setSurveyDetailPaginationPageNo(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                <?php }  ?>
            </ul>
        </nav>
    </div>
    
</div>


        <?php 
            $db=new DbOperation();
            $query13 = "SELECT Calling_Category_Cd, Calling_Category, Calling_Type FROM CallingCategoryMaster WHERE IsActive = 1;";
            $ReasonDropDown = $db->ExecutveQueryMultipleRowSALData($query13, $electionName, $developmentMode);

            $qcTypeArray = array(array('QC_Title' => 'Shop Listing', 'QC_Type' =>'ShopList', 'QC_Flag' =>1), array('QC_Title' => 'Shop Survey', 'QC_Type' =>'ShopSurvey', 'QC_Flag' =>2), array('QC_Title' => 'Shop Board', 'QC_Type' =>'ShopBoard', 'QC_Flag' =>5), array('QC_Title' => 'Shop Document', 'QC_Type' =>'ShopDocument', 'QC_Flag' =>3), array('QC_Title' => 'Shop Calling', 'QC_Type' =>'ShopCalling', 'QC_Flag' =>4));

                $srNo = 0;
                if($pageNo!=1){
                    $srNo = (($pageNo * $recordPerPage) - ($recordPerPage));
                }
                // print_r($pocketShopsSurveyListDetail);
                foreach($pocketShopsSurveyListDetail as $shopData){
                    // print_r($shopData);
                    $srNo = $srNo+1;
                    $Shop_Cd = $shopData["Shop_Cd"];
                    $getShopName = $shopData["ShopName"];
                    $getShopNameMar = $shopData["ShopNameMar"];

                    $getShopArea_Cd = $shopData["ShopArea_Cd"];
                    $getShopAreaName = $shopData["ShopAreaName"];
                    $getShopCategory = $shopData["ShopCategory"];

                    $getPocketName = $shopData["PocketName"];
                    $getNodeName = $shopData["NodeName"];
                    $getWardNo = $shopData["Ward_No"];
                    $getWardArea = $shopData["WardArea"];

                    $getShopAddress_1 = $shopData["ShopAddress_1"];
                    $getShopAddress_2 = $shopData["ShopAddress_2"];

                    $getShopKeeperName = $shopData["ShopKeeperName"];
                    $getShopKeeperMobile = $shopData["ShopKeeperMobile"];

                    $getAddedBy = $shopData["AddedBy"];
                    $getAddedDate = $shopData["AddedDate"];
                    $getSurveyBy = $shopData["SurveyBy"];
                    $getSurveyDate = $shopData["SurveyDate"];

                    $getQC_Flag = $shopData["QC_Flag"];
                    $getQC_UpdatedDate = $shopData["QC_UpdatedDate"];

                    $getLetterGiven = $shopData["LetterGiven"];
                    $getIsCertificateIssued = $shopData["IsCertificateIssued"];
                    $getRenewalDate = $shopData["RenewalDate"];
                    $getParwanaDetCd = $shopData["ParwanaDetCd"];
                    $getPDetNameEng = $shopData["PDetNameEng"];

                    $getConsumerNumber = $shopData["ConsumerNumber"];

                    $getShopOwnStatus = $shopData["ShopOwnStatus"];
                    $getShopOwnPeriod = $shopData["ShopOwnPeriod"];

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


                    $getShopOwnerName = $shopData["ShopOwnerName"];
                    $getShopOwnerMobile = $shopData["ShopOwnerMobile"];
                    $getShopContactNo_1 = $shopData["ShopContactNo_1"];
                    $getShopContactNo_2 = $shopData["ShopContactNo_2"];
                    $getShopEmailAddress = $shopData["ShopEmailAddress"];
                    $getShopOwnerAddress = $shopData["ShopOwnerAddress"];

                    $getMaleEmp = $shopData["MaleEmp"];
                    $getFemaleEmp = $shopData["FemaleEmp"];
                    $getOtherEmp = $shopData["OtherEmp"];
                    $getContactNo3 = $shopData["ContactNo3"];
                    $getGSTNno = $shopData["GSTNno"];

                    $getShopOutsideImage1 = $shopData["ShopOutsideImage1"];
                    $getShopOutsideImage2 = $shopData["ShopOutsideImage2"];
                    $getShopInsideImage1 = $shopData["ShopInsideImage1"];
                    $getShopInsideImage2 = $shopData["ShopInsideImage2"];

                    $getShopDimension = $shopData["ShopDimension"];

                    $getShopStatus = $shopData["ShopStatus"];
                    $getShopStatusTextColor = $shopData["ShopStatusTextColor"];
                    $getShopStatusFaIcon = $shopData["ShopStatusFaIcon"];
                    $getShopStatusIconUrl = $shopData["ShopStatusIconUrl"];
                    $getShopStatusDate = $shopData["ShopStatusDate"];
                    $getShopStatusRemark = $shopData["ShopStatusRemark"];

                    $getBusinessCat_Cd = $shopData["BusinessCat_Cd"];
                    $getNature_of_Business = $shopData["BusinessCatName"];
            ?>
        <div class="row"> 
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            
                            <fieldset>
                                <legend><b><?php echo $srNo.") "; ?> <?php echo $getShopName; ?> <?php if(!empty($getSurveyDate)){ echo " - ".date('d/m/Y',strtotime($getSurveyDate)); }  ?></b></legend>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                           
                                            <div class="media-body my-10px col-md-9" style="margin-top: 10px;">
                                                <h6>    
                                                    <b><?php echo $getShopNameMar; ?></b> 
                                                </h6>
                                                <h6><b><?php echo $getShopKeeperName; ?> - <?php echo $getShopKeeperMobile; ?></b></h6>
                                                
                                                
                                                <h6><?php echo $getNature_of_Business; ?></h6>
                                                <h6><?php echo "Pocket : ".$getPocketName.", Ward : ".$getWardNo.", ".$getWardArea.", ".$getNodeName; ?></h6>
                                                <h6><?php echo $getShopAddress_1." ".$getShopAddress_2; ?></h6>
                                                
                                                
                                            </div>
                                            
                                            <div class="avatar mr-75 col-md-3">
                                                <?php if($getShopOutsideImage1 != ''){ ?>
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$getShopOutsideImage1; ?>" title="Outside Image 1" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                                                <?php } else { ?>   
                                                    <img src="pics/shopDefault.jpeg" class="rounded galleryimg" title="Outside Image 1" width="150" height="150" alt="Avatar" />
                                                <?php } ?>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-12 col-sm-12 col-md-4">
                                        <div class="row">
                                            <?php if($getShopOutsideImage2 != ''){ ?>
                                                <div class="avatar mr-75 col-md-4">
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                                                </div>
                                            <?php } ?>

                                            <?php if($getShopInsideImage1 != ''){ ?>
                                                <div class="avatar mr-75 col-md-4">
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$getShopInsideImage1; ?>" title="Inside Image 1" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
                                                </div>
                                            <?php } ?>

                                            <?php if($getShopInsideImage2 != ''){ ?>
                                                <div class="avatar mr-75 col-md-4">
                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$getShopInsideImage2; ?>" title="Inside Image 2" class="rounded galleryimg" width="100%" height="150" alt="Avatar" />
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
                                                <?php 
                                     

                                                    foreach ($qcTypeArray as $key => $value) {
                                                        $qc_Type_Data = $value["QC_Type"];
                                                            $queryQCDet = "SELECT 
                                                                QC_Flag, QC_Type, 
                                                                ISNULL(CONVERT(VARCHAR,max(QC_DateTime),100),'') as MaxQCDateTime
                                                            FROM QCDetails
                                                            WHERE Shop_Cd = $Shop_Cd AND QC_Type = '$qc_Type_Data'
                                                            GROUP BY QC_Flag, QC_Type;";
                                                           // echo $queryQCDet;
                                                        $shopQCDetailsData = $db->ExecutveQuerySingleRowSALData($queryQCDet, $electionName, $developmentMode);
                                                            if(sizeof($shopQCDetailsData)>0){ 
                                                    ?>
                                                                <span class="badge badge-success"><?php echo $value["QC_Title"]." QC on ".$shopQCDetailsData["MaxQCDateTime"]; ?></span>
                                                    <?php
                                                            }
                                                    }

                                                ?>
                                                
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12" style="margin-top: 10px;" >

                                        <ul class="nav nav-pills" >

                                            <!-- <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center" >
                                                    <i class="feather icon-truck mr-25"></i>
                                                    <span class="d-none d-sm-block">Application Tracking</span>
                                                </a>
                                            </li> -->

                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center active" id="shop-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#shop-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="shop-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                                    <i class="feather icon-list mr-25"></i>
                                                    <span class="d-none d-sm-block">Shop Listing</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center " id="survey-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#survey-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="survey-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                                    <i class="feather icon-edit mr-25"></i>
                                                    <span class="d-none d-sm-block">Shop Survey</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center" id="board-type-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#board-type-info-<?php echo $Shop_Cd; ?>" aria-controls="board-type-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false" >
                                                    <i class="feather icon-square mr-25"></i>
                                                    <span class="d-none d-sm-block">Board Type</span>
                                                </a>
                                            </li>
                                          
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center " id="document-qc-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#document-qc-info-<?php echo $Shop_Cd; ?>" aria-controls="document-qc-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                                    <i class="feather icon-file-text mr-25"></i>
                                                    <span class="d-none d-sm-block">Shop Document</span>
                                                </a>
                                            </li>
                                        
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center " id="schedule-info-<?php echo $Shop_Cd; ?>-tab" data-toggle="pill" href="#schedule-info-<?php echo $Shop_Cd; ?>" aria-controls="schedule-info-<?php echo $Shop_Cd; ?>" role="tab" aria-selected="false">
                                                    <i class="feather icon-clock mr-25"></i>
                                                    <span class="d-none d-sm-block">Schedule / Reschedule</span>
                                                </a>
                                            </li>
                                            
                                            

                                        </ul>

                                            
                                        <div class="tab-content">
                                            
                                            <div class="tab-pane active" id="shop-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="shop-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                                                <div class="row">

                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                        <label>Nature of Business </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                                <input type="text" value="<?php echo $getNature_of_Business; ?>" required name="<?php echo $Shop_Cd; ?>_NatureofBusiness" class="form-control" placeholder="Nature of Business" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                        <label>Shop Area Category<span style="color:red;">*</span> </label>
                                                            <div class="controls"> 
                                                            <input type="text" value="<?php echo $getShopAreaName; ?>" required name="<?php echo $Shop_Cd; ?>_ShopAreaName" class="form-control" placeholder="Shop Area Name" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                        <label>Shop Category </label><label style="color:red;">*</label>
                                                            <div class="controls"> 
                                                            <input type="text" value="<?php echo $getShopCategory; ?>" required name="<?php echo $Shop_Cd; ?>_ShopCategory" class="form-control" placeholder="Shop Area Category" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Name </label><label style="color:red;">*</label>
                                                                <input type="text" value="<?php echo $getShopName; ?>" required name="<?php echo $Shop_Cd; ?>_EstablishmentName" class="form-control" placeholder="Shop Name" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Name in Marathi</label><label style="color:red;">*</label>
                                                                <input type="text" value="<?php echo $getShopNameMar; ?>" required name="<?php echo $Shop_Cd; ?>_EstablishmentNameMar" class="form-control" placeholder="Shop Name in Marathi" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shopkeeper / Contact Person Full Name </label>
                                                                <input type="text" value="<?php echo $getShopKeeperName; ?>" required name="<?php echo $Shop_Cd; ?>_ShopkeeperName"  class="form-control" placeholder="Shopkeeper / Contact Person Name" disabled >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shopkeeper / Contact Person Primary Mobile No </label>
                                                                <input type="tel" value="<?php echo $getShopKeeperMobile; ?>" required name="<?php echo $Shop_Cd; ?>_ShopkeeperMobileNo" class="form-control" placeholder="Shopkeeper / Contact Person Mobile No" disabled pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Contact No 1</label>
                                                                <input type="tel" value="<?php echo $getShopContactNo_1; ?>" required name="<?php echo $Shop_Cd; ?>_ShopContactNo_1"   class="form-control" placeholder="Shop Contact No 1" disabled pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Contact No 2</label>
                                                                <input type="tel" value="<?php echo $getShopContactNo_2; ?>" required name="<?php echo $Shop_Cd; ?>_ShopContactNo_2" class="form-control" placeholder="Shop Contact No 2" disabled pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Address Line 1</label>
                                                                <textarea  type="text"  name="<?php echo $Shop_Cd; ?>_AddressLine1" rows="2" class="form-control" placeholder="Address Line 1" disabled><?php echo $getShopAddress_1; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Address Line 2</label>
                                                                <textarea type="text" name="<?php echo $Shop_Cd; ?>_AddressLine2" rows="2" class="form-control" placeholder="Address Line 2" disabled><?php echo $getShopAddress_2; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="tab-pane " id="survey-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="survey-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                                                <div class="row">        

                                                    <div class="col-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                        <label>Parwana Detail </label><label style="color:red;">*</label>
                                                            <div class="controls">
                                                            <input type="text" value="<?php echo $getPDetNameEng; ?>" required name="<?php echo $Shop_Cd; ?>_ShopPDetNameEng" class="form-control" placeholder="Shop Parwana Detail" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label><b>Shop Dimensions in Sq. ft.</b> </label>
                                                                <input type="number" value="<?php echo $getShopDimension; ?>"  name="<?php echo $Shop_Cd; ?>_ShopDimension" class="form-control" placeholder="Shop Dimensions in Sq. ft. " maxlength="10" disabled>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-12 col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Consumer No </label>
                                                                <input type="text" value="<?php echo $getConsumerNumber; ?>" required name="<?php echo $Shop_Cd; ?>_ConsumerNumber" id="ConsumerNumber" class="form-control" placeholder="Consumer Number" pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>GST No</label>
                                                                <input type="text" value="<?php echo $getGSTNno; ?>" name="<?php echo $Shop_Cd; ?>_GSTNno" class="form-control" placeholder="Shop GST No" required maxlength="15" disabled>
                                                            </div>
                                                        </div>
                                                    </div>                          
                                                    

                                                    <div class="col-12 col-sm-12 col-md-3">
                                                        <div class="form-group">
                                                             <div class="controls">
                                                                <label>Owned / Rented</label><label style="color:red;">*</label>
                                                                <input type="text" value="<?php echo $getShopOwnStatus; ?>" required name="<?php echo $Shop_Cd; ?>_ShopOwnStatus" class="form-control" placeholder="Shop Own Status" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Period in Yrs  </label>
                                                                <input type="text" value="<?php echo $getShopOwnPeriodYrs; ?>"  name="<?php echo $Shop_Cd; ?>_ShopOwnPeriodYrs" class="form-control" placeholder="Shop Own Period in Yrs" pattern="[0-9]{3}" maxlength="3" onkeypress="return isNumber(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Period in Months </label>
                                                                <input type="text" value="<?php echo $getShopOwnPeriodMonths; ?>"  name="<?php echo $Shop_Cd; ?>_ShopOwnPeriodMonths" id="ShopOwnPeriodMonths" class="form-control" placeholder="Shop Own Period in Months" pattern="[0-9]{2}" maxlength="2" onkeypress="return isNumber(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 
                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Owner FullName</label>
                                                                <input type="text" value="<?php echo $getShopOwnerName; ?>" required name="<?php echo $Shop_Cd; ?>_ShopOwnerName" class="form-control" placeholder="Shop Owner Full Name" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>        

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Ownere Mobile</label>
                                                                <input type="tel" value="<?php echo $getShopOwnerMobile; ?>" required name="<?php echo $Shop_Cd; ?>_ShopOwnerMobile" class="form-control" placeholder="Shop Owner Mobile No" required pattern="[0-9]{10}" maxlength="10" onkeypress="return isNumber(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Owner EmailId</label>
                                                                <input type="email" value="<?php echo $getShopEmailAddress; ?>" name="<?php echo $Shop_Cd; ?>_ShopEmailAddress" class="form-control" placeholder="Shop Owner Email Id" onchange="validateEmail(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Contact No</label>
                                                                <input type="tel" value="<?php echo $getContactNo3; ?>" required name="<?php echo $Shop_Cd; ?>_ShopContactNo_3" class="form-control" placeholder="Shop Contact No 3" required pattern="[0-9]{15}" maxlength="15" onkeypress="return isNumber(event)" disabled>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Employees</label>
                                                                <div class="row">
                                                                    <div class="col-12 col-sm-12 col-md-4">
                                                                       <label> Male </label><input type="number" value="<?php echo $getMaleEmp; ?>" required name="<?php echo $Shop_Cd; ?>_MaleEmp" class="form-control" placeholder="Shop Male Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" disabled>
                                                                    </div>

                                                                    <div class="col-12 col-sm-12 col-md-4">
                                                                        <label>Female</label> <input type="number" value="<?php echo $getFemaleEmp; ?>" required name="<?php echo $Shop_Cd; ?>_FemaleEmp" class="form-control" placeholder="Shop Female Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" disabled>
                                                                    </div>

                                                                    <div class="col-12 col-sm-12 col-md-4">
                                                                        <label>Others </label><input type="number" value="<?php echo $getOtherEmp; ?>" required name="<?php echo $Shop_Cd; ?>_OtherEmp" class="form-control" placeholder="Shop Others Employee" required pattern="[0-9]{3}" minlength="1" maxlength="3" onkeypress="return isNumber(event)" disabled>
                                                                          
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Shop Owner Address</label>
                                                                <textarea type="text" name="<?php echo $Shop_Cd; ?>_ShopOwnerAddress" rows="2" class="form-control" placeholder="Shop Owner Address" disabled><?php echo $getShopOwnerAddress; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            
                                            <div class="tab-pane " id="board-type-info-<?php echo $Shop_Cd; ?>" aria-labelledby="survey-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">
                                                <?php 
                                                    $query15 = "SELECT sbd.BoardID, sbd.Shop_Cd, sbd.BoardType, sbd.BoardHeight, sbd.BoardWidth, sbd.BoardPhoto, sbd.IsActive, sbd.QC_Flag, CONVERT(VARCHAR,sbd.UpdatedDate,100) as UpdatedDate, CONVERT(VARCHAR,sbd.QC_UpdatedDate,100) as QC_UpdatedDate FROM ShopBoardDetails sbd INNER JOIN ShopMaster sm on sm.Shop_Cd=sbd.Shop_Cd WHERE sbd.IsActive = 1 AND sm.IsActive = 1 AND sbd.Shop_Cd = $Shop_Cd ORDER BY sbd.BoardID;";

                                                    $shopBoardDetailsData = $db->ExecutveQueryMultipleRowSALData($query15, $electionName, $developmentMode);
                                                ?>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12">
                                                         <div class="table-responsive">
                                                            <table class="table table-hover-animation table-striped table-hover zero-configuration" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                    
                                                                        <th style="text-align:left;">Board Type</th>
                                                                        <th style="text-align:left;">Board Height</th>
                                                                        <th style="text-align:left;">Board Width</th>
                                                                        <th style="text-align:left;">Board Photo</th>
                                                                        <th style="text-align:left;">Is Board Active</th>
                                                                        <th style="text-align:left;">Last Updated</th>
                                                                        <th style="text-align:left;">QC Completed</th>
                                                                        <th style="text-align:left;">QC Updated</th>
                                                                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                     <?php
                                                                        foreach($shopBoardDetailsData as $valueBoardType){
                                                                            $boardPhoto = $valueBoardType["BoardPhoto"];
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $valueBoardType["BoardType"]; ?></td>
                                                                            <td><?php echo $valueBoardType["BoardHeight"]; ?></td>
                                                                            <td><?php echo $valueBoardType["BoardWidth"]; ?></td>
                                                                            <td>
                                                                                <?php if($boardPhoto != ''){ ?>
                                                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$boardPhoto; ?>" title="Board Photo" class="rounded" width="100" height="100" alt="Avatar" />
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td><?php if($valueBoardType["IsActive"]==1){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                                                            <td><?php echo $valueBoardType["UpdatedDate"]; ?></td>
                                                                            <td><?php if($valueBoardType["QC_Flag"]==5){ ?><span class="badge badge-success">Yes</span> <?php }else{ ?><span class="badge badge-danger">No</span> <?php } ?></td>
                                                                            <td><?php echo $valueBoardType["QC_UpdatedDate"]; ?></td>
                                                                            
                                                                        </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>

                                            <div class="tab-pane" id="document-qc-info-<?php echo $Shop_Cd; ?>" aria-labelledby="document-qc-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">
                                                 
                                                <div class="row"> 
                                                    <?php 
                                                        $query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                                                                ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                                                                ISNULL(sd.Document_Cd,0) as Document_Cd,
                                                                ISNULL(sd.FileURL,'') as FileURL,
                                                                ISNULL(sd.IsVerified,0) as IsVerified,
                                                                ISNULL(sd.QC_Flag,0) as QC_Flag,
                                                                ISNULL(sd.IsActive,0) as IsActive,
                                                                ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                                                                ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                                                                ISNULL(sdm.DocumentName,'') as DocumentName,
                                                                ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                                                                ISNULL(sdm.DocumentType,'') as DocumentType,
                                                                ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
                                                            FROM ShopDocuments sd
                                                            INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
                                                            LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
                                                            WHERE sd.Shop_Cd = $Shop_Cd;";

                                                        $DocumentsListForQC = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);
                                                                                    
                                                        foreach ($DocumentsListForQC as $key => $valueShopDoc) {
                                                    ?>
                                                        <div class="col-12 col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                   
                                                                    <label><a href="<?php echo $valueShopDoc["FileURL"]; ?>" target="_blank"><?php echo $valueShopDoc["DocumentName"]; ?></a></label>

                                                                    <embed <?php if($valueShopDoc["DocumentType"]=='image'){ ?> <?php }else if($valueShopDoc["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?>  src="<?php echo $valueShopDoc["FileURL"]; ?>" width="100%" height="200"></EMBED>
                                                                    

                                                                     <?php 
                                                                        
                                                                        
                                                                        if($valueShopDoc["QC_Flag"]!=0 && $valueShopDoc["IsActive"]!=0){ 
                                                                            $isShopDocQCButtonStyle = "success";
                                                                            $isShopDocQCDoneStyle = "display: block;";
                                                                    ?>
                                                                        <div  class="controls alert alert-<?php echo $isShopDocQCButtonStyle; ?>" role="alert" style="<?php echo $isShopDocQCDoneStyle; ?>"><?php echo $valueShopDoc["DocumentName"]; ?> <?php  echo " Shop Document QC on ".$valueShopDoc["QC_UpdatedDate"];  ?></div>
                                                                    <?php
                                                                        }else if($valueShopDoc["QC_Flag"]!=0 && $valueShopDoc["IsActive"]==0){
                                                                            $isShopDocQCButtonStyle = "danger";
                                                                            $isShopDocQCDoneStyle = "display: block;";
                                                                    ?>
                                                                        <div  class="controls alert alert-<?php echo $isShopDocQCButtonStyle; ?>" role="alert" style="<?php echo $isShopDocQCDoneStyle; ?>"><?php echo $valueShopDoc["DocumentName"]; ?> <?php  echo " deleted on ".$valueShopDoc["QC_UpdatedDate"];  ?></div>
                                                                    <?php 
                                                                        }
                                                                    ?>
                                                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="tab-pane" id="schedule-info-<?php echo $Shop_Cd; ?>" aria-labelledby="schedule-info-<?php echo $Shop_Cd; ?>-tab" role="tabpanel">

                                                <div class="row">        
                                                    
                                                    <div class="col-sm-12 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="scheduleDate">Schedule Date</label>
                                                            <input type='datetime-local' name="<?php echo $Shop_Cd; ?>_SCHScheduleDate" value="" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-3 col-sm-12">
                                                        <div class="form-group">
                                                        <label>Schedule Category</label>
                                                            <div class="controls"> 
                                                            <select class="select2 form-control" name="<?php echo $Shop_Cd; ?>_SCHScheduleCategory">
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
                                                    <div class="col-sm-12 col-md-4 col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Schedule Reason</label>
                                                                <input type="text" name="<?php echo $Shop_Cd; ?>_SCHCallReason" class="form-control" placeholder="Schedule Reason" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3 col-12">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Remark</label>
                                                                <input type="text" name="<?php echo $Shop_Cd; ?>_SCHRemark" class="form-control" placeholder="Remark" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-sm-12 col-md-8 col-12" >
                                                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_SCHScheduleCall_Id" value="0" >
                                                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_SCHShop_Id" value="<?php echo $Shop_Cd; ?>" >
                                                        <input type="hidden" name="<?php echo $Shop_Cd; ?>_Executive_Id" value="<?php echo $loginExecutiveCd; ?>" >
                                                        <div id="<?php echo $Shop_Cd; ?>_submitmsgsuccessSCH" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                                        <div id="<?php echo $Shop_Cd; ?>_submitmsgfailedSCH"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2 col-12 text-right" style="margin-top:20px;">
                                                        <button type="button" data-toggle="modal"  onclick="setShowApplicationTrackingModal(<?php echo $Shop_Cd; ?>,<?php echo $srNo; ?>)" data-target="#modalShowApplicationTracking" aria-selected="true" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">List</button>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2 col-12 text-right" style="margin-top:20px;">
                                                        <button type="button" id="<?php echo $Shop_Cd; ?>_btnShopScheduleId" onclick="saveShopScheduleFormData(<?php echo $Shop_Cd; ?>)" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                </div>

                            </fieldset>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php
            }  
        ?>

