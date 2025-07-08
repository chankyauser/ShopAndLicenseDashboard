<?php
header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('Asia/Kolkata');
include 'function.php';
$data = array();
$empty = array();
$finalresult = array();
if (isTheseParametersAvailable(array('appName', 'electionName', 'Date', 'User_Id'))) {
    include 'connection.php';
    $Date = $_POST["Date"];
    $User_Id = $_POST["User_Id"];

    $AddedBy = "";
    if($User_Id > 0){
        $AddedBy = "(SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $User_Id)";
    
            runquery($con, "DROP TABLE ##LossOfHour$User_Id;");
            runquery($con, "CREATE TABLE ##LossOfHour$User_Id (ExecutiveName VARCHAR(100), TreeCensusCd INT, Lattitude1 DECIMAL(12,7), Longitude1 DECIMAL(12,7), AddedDate1 DATETIME, Lattitude2 DECIMAL(12,7), Longitude2 DECIMAL(12,7), AddedDate2 DATETIME,  EntryDiff INT, Distance INT, TravelTime INT, FinalTime INT);");

            runquery($con, "INSERT INTO ##LossOfHour$User_Id (ExecutiveName, TreeCensusCd, Lattitude1, Longitude1, AddedDate1, Lattitude2, Longitude2, AddedDate2) 
                SELECT TOP((SELECT COUNT(*) - 1 AS cnt FROM TreeCensus WHERE AddedBY= $AddedBy AND [Replicate] IS NULL AND CONVERT(VARCHAR, AddedDate, 105) = '$Date'))  
                um.ExecutiveName, tc.TreeCensusCd, tc.Lattitude AS Lattitude1, tc.Longitude AS Longitude1, AddedDate AS AddedDate1, 
                (SELECT TOP(1) Lattitude FROM TreeCensus WHERE TreeCensusCd > tc.TreeCensusCd AND AddedBY= tc.AddedBY 
                AND [Replicate] IS NULL  AND CONVERT(VARCHAR, AddedDate, 105) = CONVERT(VARCHAR, tc.AddedDate, 105))  AS Lattitude2, (SELECT TOP(1) Longitude FROM TreeCensus 
                WHERE TreeCensusCd > tc.TreeCensusCd AND AddedBY= tc.AddedBY AND [Replicate] IS NULL  AND CONVERT(VARCHAR, AddedDate, 105) = CONVERT(VARCHAR, tc.AddedDate, 105)) AS Longitude2, (SELECT TOP(1) AddedDate 
                FROM TreeCensus WHERE TreeCensusCd > tc.TreeCensusCd AND AddedBY= tc.AddedBY AND [Replicate] IS NULL  AND CONVERT(VARCHAR, AddedDate, 105) = CONVERT(VARCHAR, tc.AddedDate, 105)) AS AddedDate2
                FROM TreeCensus AS tc 
                INNER JOIN Survey_Entry_Data..User_Master AS um ON (tc.AddedBy = um.UserName) 
                WHERE AddedBY= $AddedBy AND [Replicate] IS NULL AND CONVERT(VARCHAR, AddedDate, 105) = '$Date'
                ORDER BY ExecutiveName, AddedDate;");

            runquery($con, "UPDATE ##LossOfHour$User_Id SET EntryDiff = DATEDIFF(SECOND, AddedDate1, AddedDate2), Distance = CASE WHEN Lattitude1 = Lattitude2 AND Lattitude1 = Lattitude1 THEN 0 ELSE CAST((((acos(sin((Lattitude1*pi()/180)) * 
                sin((Lattitude2*pi()/180)) + cos((Lattitude1*pi()/180)) * cos((Lattitude2*pi()/180)) * cos(((Longitude1- Longitude2) * pi()/180)))) 
                * 180/pi()) * 60 * 1.1515 * 1.609344) * 1000 AS int) END;");

            //runquery($con, "UPDATE ##LossOfHour$User_Id SET TravelTime = ((Distance/100)*60);");
            runquery($con, "UPDATE ##LossOfHour$User_Id SET TravelTime = ((Distance/25)*15);");

            runquery($con, "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN EntryDiff > TravelTime THEN EntryDiff - TravelTime ELSE TravelTime - EntryDiff END;");

            runquery($con, "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN FinalTime > 150 THEN FinalTime - 150 ELSE 0 END;");
    $query = "SELECT ExecutiveName, TreeCensusCd, Lattitude1, Longitude1, CONVERT(VARCHAR, AddedDate1, 0) AS AddedDate1, 
                Lattitude2, Longitude2, CONVERT(VARCHAR, AddedDate2, 0) AS AddedDate2, Distance,  
                CONCAT((EntryDiff / 60) / 60, ':', ((EntryDiff / 60) % 60), ':', EntryDiff % 60) AS EntryDiff,
                CONCAT((TravelTime / 60) / 60, ':', ((TravelTime / 60) % 60), ':', TravelTime % 60) AS TravelTime,
                CONCAT((FinalTime / 60) / 60, ':', ((FinalTime / 60) % 60), ':', FinalTime % 60) AS FinalTimeDiff
                FROM  ##LossOfHour$User_Id;";

            /*$result1 = sqlsrv_query($con, $query);
            $numrows1 = sqlsrv_has_rows($result1);
            if ($numrows1 != 0) {
                while ($row1 =sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
                    $finalresult[] = $row1;
                }
            }*/

    $data["error"] = false;
    $data["message"] = "List !";
    //$data["ExecWiseLossOfHoursReport"] = $finalresult;
    $data["ExecWiseLossOfHoursReport"] = getMultiQueryData($con, $query);
    runquery($con, "DROP TABLE ##LossOfHour$User_Id;");
    }else{
        $data["error"] = true;
        $data["message"] = "Select executive name ! ALL not allowed!";
        $data["ExecWiseLossOfHoursReport"] = $empty;
    }
} else {
    $data["error"] = true;
    $data["message"] = "Required parameters are missing !".$User_Id;
    $data["ExecWiseLossOfHoursReport"] = $empty;
}

sqlsrv_close($con); 
echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>