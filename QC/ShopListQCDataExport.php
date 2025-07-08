<?php
$qcType = $_POST['qcType'];
$filename = $qcType.'_QC.csv';
$export_data = unserialize($_POST['export_data']);

// file creation
$file = fopen($filename,"w");

if($qcType == 'ShopList'){
    $header_array = array("ShopCd", "ShopUID", "ShopName", "ShopKeeperName", 
    "ShopKeeperMobile","PocketName", "NodeName", "Ward_No", "Area", "ShopAddress_1", 
    "ShopAddress_2", "ShopOutsideImage1", "ShopOutsideImage2", "ShopInsideImage1", "ShopInsideImage2",
     "Nature_of_Business", "ShopArea_Cd", "ShopAreaName", "ShopCategory", "IsCertificateIssued", 
     "AddedDate", "AddedByName", "AddedByMobile", "SurveyDate", "QC_Flag", 
    "ShopStatus", "ShopStatusDate", "ShopStatusRemark");

}else if($qcType == 'ShopSurvey' || $qcType == 'ShopDocument'){
    $header_array = array("ShopCd", "ShopUID", "ShopName", "ShopKeeperName", 
    "ShopKeeperMobile","PocketName", "NodeName", "Ward_No", "Area", "ShopAddress_1", 
    "ShopAddress_2", "ShopOutsideImage1", "ShopOutsideImage2", "ShopInsideImage1", "ShopInsideImage2",
    "Nature_of_Business", "ShopArea_Cd", "ShopAreaName", 
    "ShopCategory", "IsCertificateIssued", "AddedDate", "SurveyDate", "QC_Flag", 
    "ShopStatus", "ShopStatusDate", "ShopStatusRemark", "ScheduleCall_Cd", 
    "SD_Shop_Cd", "Calling_Category_Cd", "Calling_Category", "SD_QC_Type", 
    "ScheduleDate", "ScheduleReason", "ST_DateTime", "ST_Remark_1", "ST_Remark_2",
    "ST_Remark_3", "ST_Status", "QC_Detail_Cd", "QC_DateTime", "QC_Remark1", 
    "QC_Remark2", "QC_Remark3");

}else if($qcType == 'ShopCalling'){
    $header_array = array("ShopCd", "Calling_Category_Cd", "Calling_Cd", "Call_Response_Cd", 
    "Call_DateTime","AudioFile_Url", "Executive_Cd", "CallRecordStatus", "GoodCall", "QC_Flag", 
    "Appreciation", "AudioListen", "Remark1", "Remark2", "Remark3", 
    "Shop_UID", "ShopName", "ShopNameMar", "ShopKeeperName", "ShopKeeperMobile", 
    "ShopOutsideImage1", "ShopOutsideImage2", "ShopInsideImage1", "ShopInsideImage2",
    "ShopStatus", "IsCertificateIssued", "AddedDate", 
    "SurveyDate", "Nature_of_Business", "ShopArea_Cd", "ShopAreaName", 
    "ShopAreaNameMar", "ShopCategory", "Calling_Category", "Call_Response");

}

fputcsv($file, $header_array);

foreach ($export_data as $line){
 fputcsv($file,$line);
}

fclose($file);

// download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/csv; "); 

readfile($filename);

// deleting file
unlink($filename);
exit();