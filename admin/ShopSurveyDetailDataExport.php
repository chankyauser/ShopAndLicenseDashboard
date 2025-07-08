<?php
$todayDate = date('Y-m-d');
$filename = 'ShopSurveyDetail_'.$todayDate.'.csv';
$export_data = unserialize($_POST['export_data']);

// file creation
$file = fopen($filename,"w");


$header_array = array("Shop Name in Eng", "Pocket", "Ward", 
    "Area","Node","Shop Status", 
    "Shop Status Date", "Location", "Listed By", "Listed Date", "Survey By",
     "Survey Date");

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