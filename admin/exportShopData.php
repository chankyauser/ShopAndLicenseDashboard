<?php
session_start();

if(
    (isset($_SESSION['SAL_ListingSurveyFilterName']) && !empty(isset($_SESSION['SAL_ListingSurveyFilterName']))) &&
    (isset($_SESSION['SAL_ListingSurveyFilterType']) && !empty(isset($_SESSION['SAL_ListingSurveyFilterType'])))
  )
{
    $FilterName = $_SESSION['SAL_ListingSurveyFilterName'];
    $FilterType = $_SESSION['SAL_ListingSurveyFilterType'];

    if(
        (isset($_SESSION['SAL_FilterCondition']) && $_SESSION['SAL_FilterCondition']) &&
        (isset($_SESSION['SAL_FilterConditionName']) && $_SESSION['SAL_FilterConditionName'])
        )
    {
        $Condition = $_SESSION['SAL_FilterCondition'];
        $ConditionName = $_SESSION['SAL_FilterConditionName'];
    }
    


    if(isset($_SESSION['SAL_FromDate'])){
        $from_Date = $_SESSION['SAL_FromDate'];
    }
    else{
        $from_Date = '';
    }
    
    if(isset($_SESSION['SAL_ToDate'])){
        $to_Date = $_SESSION['SAL_ToDate'];
    }
    else
    {
        $to_Date = '';
    }

    $fromDate = $from_Date." ".$_SESSION['StartTime'];
    $toDate = $to_Date." ".$_SESSION['EndTime'];
}

$filename = ''.$FilterType.'-'.$FilterName.'-'.$Condition.'-'.$ConditionName.'.csv';
$export_data = unserialize($_POST['export_data']);

// file creation
$file = fopen($filename,"w");

$condition_array = array($FilterType.' - '.$FilterName.' - '.$Condition.' - '.$ConditionName);
fputcsv($file, $condition_array);


$header_array = array("Shop Cd", "Shop Name", "Node Name", "Ward No", "Shop Keeper Name", 
"Shop Keeper Mobile","Shop Address1", "AddedBy", "AddedDate", "SurveyBy", "SurveyDate", 
"Shop Status", "Shop Status Remark","Shop OutsideImage1", "QC Flag", 
"QC UpdatedDate", "QC UpdatedBy");

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