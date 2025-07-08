
<section id="dashboard-analytics">

<?php
    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $postUserId = '';
    $DateFormat = '';
    $User_Id = '';
    $currentDate = date("Y-m-d");
    $Date = '';
    $filterType = 'ShopList';
  
    $Date = $currentDate;
    
    
    
    if(isset($_GET['date'])){
        $Date = $_GET['date'];
    }
    if(isset($_GET['filterType'])){
        $filterType = $_GET['filterType'];
    }

    if(isset($_GET['User_Id']) && !empty($_GET['User_Id'])){
        $User_Id = $_GET['User_Id'];
    }
        


    $ExecutiveName = "";
    $LossofHoursTableData = array();
    

    if($User_Id > 0){
        if($filterType == 'ShopList'){
            $AddedBy = "";
            $AddedByUserName = array();
            $AddedByQuery = "SELECT UserName, ExecutiveName FROM Survey_Entry_Data..User_Master WHERE User_Id = $User_Id";
            $AddedByUserName = $db->ExecutveQuerySingleRowSALData($AddedByQuery, $electionName, $developmentMode);    
            $AddedBy = $AddedByUserName['UserName'];
            $ExecutiveName = $AddedByUserName['ExecutiveName'];

            $dbConn = $db->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];

                $dropQuery = "DROP TABLE ##LossOfHour$User_Id;";
                $result = sqlsrv_query($conn, $dropQuery);

                $createtablequery = "CREATE TABLE ##LossOfHour$User_Id (ExecutiveName VARCHAR(100), Shop_Cd INT, ShopName NVARCHAR(500), Lattitude1 DECIMAL(12,7), Longitude1 DECIMAL(12,7), AddedDate1 DATETIME, Lattitude2 DECIMAL(12,7), Longitude2 DECIMAL(12,7), AddedDate2 DATETIME,  EntryDiff INT, Distance INT, TravelTime INT, FinalTime INT);";
                $result1 = sqlsrv_query($conn, $createtablequery);

                $Insertquery = "INSERT INTO ##LossOfHour$User_Id (ExecutiveName, Shop_Cd, ShopName, Lattitude1, Longitude1, AddedDate1, Lattitude2, Longitude2, AddedDate2) 
                SELECT t1.ExecutiveName, t1.Shop_Cd, t1.ShopName, t1.Lattitude1, t1.Longitude1, t1.AddedDate1,
                    (SELECT T.ShopLatitude
                        FROM (SELECT Shop_Cd, AddedBy, ShopLatitude, ShopLongitude, AddedDate,
                                     row_number() over(partition by AddedBy ORDER BY AddedDate ASC) as RNN
                              FROM ShopMaster WHERE AddedBy= '$AddedBy' AND CONVERT(VARCHAR, AddedDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS Lattitude2,
                    (SELECT T.ShopLongitude
                        FROM (SELECT Shop_Cd, AddedBy, ShopLatitude, ShopLongitude, AddedDate,
                                     row_number() over(partition by AddedBy ORDER BY AddedDate ASC) as RNN
                              FROM ShopMaster WHERE AddedBy= '$AddedBy' AND CONVERT(VARCHAR, AddedDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS Longitude2,
                    (SELECT T.AddedDate
                        FROM (SELECT Shop_Cd, AddedBy, ShopLatitude, ShopLongitude, AddedDate,
                                     row_number() over(partition by AddedBy ORDER BY AddedDate ASC) as RNN
                              FROM ShopMaster WHERE AddedBy= '$AddedBy' AND CONVERT(VARCHAR, AddedDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS AddedDate2 
                FROM ( SELECT TOP((SELECT COUNT(*) - 1 AS cnt FROM ShopMaster WHERE AddedBY= '$AddedBy' AND CONVERT(VARCHAR, AddedDate, 23) = '$Date')) um.ExecutiveName, sm.Shop_Cd, sm.ShopName, sm.ShopLatitude AS Lattitude1, sm.ShopLongitude AS Longitude1, AddedDate AS AddedDate1, row_number() over(partition by sm.AddedBY order by sm.AddedDate ASC) as RN
                    FROM ShopMaster AS sm 
                    INNER JOIN Survey_Entry_Data..User_Master AS um ON (sm.AddedBy = um.UserName) 
                    WHERE AddedBY= '$AddedBy' AND CONVERT(VARCHAR, AddedDate, 23) = '$Date'
                    ORDER BY um.ExecutiveName, sm.AddedDate 
                ) AS t1 ;";
                $result2 = sqlsrv_query($conn, $Insertquery);
                // echo $Insertquery;
                $updatequery1 = "UPDATE ##LossOfHour$User_Id SET EntryDiff = DATEDIFF(SECOND, AddedDate1, AddedDate2), Distance = CASE WHEN Lattitude1 = Lattitude2 AND Lattitude1 = Lattitude1 THEN 0 ELSE CAST((((acos(sin((Lattitude1*pi()/180)) * 
                    sin((Lattitude2*pi()/180)) + cos((Lattitude1*pi()/180)) * cos((Lattitude2*pi()/180)) * cos(((Longitude1- Longitude2) * pi()/180)))) 
                    * 180/pi()) * 60 * 1.1515 * 1.609344) * 1000 AS int) END;";
                $result3 = sqlsrv_query($conn, $updatequery1);

                $updatequery2 = "UPDATE ##LossOfHour$User_Id SET TravelTime = ((Distance/25)*15);";
                $result4 = sqlsrv_query($conn, $updatequery2);

                $updatequery3 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN EntryDiff > TravelTime THEN EntryDiff - TravelTime ELSE TravelTime - EntryDiff END;";
                $result5 = sqlsrv_query($conn, $updatequery3);

                $updatequery4 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN FinalTime > 1050 THEN FinalTime - 150 ELSE 0 END;";
                $result6 = sqlsrv_query($conn, $updatequery4);

            }

            $LossofHoursTableData = array();
            $LossofHoursquery = "SELECT ExecutiveName, Shop_Cd, ShopName, Lattitude1, Longitude1, CONVERT(VARCHAR, AddedDate1, 0) AS AddedDate1, 
                    Lattitude2, Longitude2, CONVERT(VARCHAR, AddedDate2, 0) AS AddedDate2, Distance,  
                    CONCAT((EntryDiff / 60) / 60, ':', ((EntryDiff / 60) % 60), ':', EntryDiff % 60) AS EntryDiff,
                    CONCAT((TravelTime / 60) / 60, ':', ((TravelTime / 60) % 60), ':', TravelTime % 60) AS TravelTime,
                    CONCAT((FinalTime / 60) / 60, ':', ((FinalTime / 60) % 60), ':', FinalTime % 60) AS FinalTimeDiff
                    FROM  ##LossOfHour$User_Id;";
            // echo $LossofHoursquery;
            $LossofHoursTableData = $db->ExecutveQueryMultipleRowSALData($LossofHoursquery, $electionName, $developmentMode);
            // print_r($LossofHoursTableData);

            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                $droptablequery = "DROP TABLE ##LossOfHour$User_Id;";
                $result7 = sqlsrv_query($conn, $droptablequery);
            }
        }else if($filterType == 'ShopSurvey'){

            $SurveyByQuery = "SELECT UserName, ExecutiveName FROM Survey_Entry_Data..User_Master WHERE User_Id = $User_Id";
            $SurveyByUserName = $db->ExecutveQuerySingleRowSALData($SurveyByQuery, $electionName, $developmentMode);    
            $SurveyBy = $SurveyByUserName['UserName'];
            $ExecutiveName = $SurveyByUserName['ExecutiveName'];

            $dbConn = $db->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];

                $dropQuery = "DROP TABLE ##LossOfHour$User_Id;";
                $result = sqlsrv_query($conn, $dropQuery);

                $createtablequery = "CREATE TABLE ##LossOfHour$User_Id (ExecutiveName VARCHAR(100), Shop_Cd INT, ShopName NVARCHAR(500), Lattitude1 DECIMAL(12,7), Longitude1 DECIMAL(12,7), AddedDate1 DATETIME, Lattitude2 DECIMAL(12,7), Longitude2 DECIMAL(12,7), AddedDate2 DATETIME,  EntryDiff INT, Distance INT, TravelTime INT, FinalTime INT);";
                $result1 = sqlsrv_query($conn, $createtablequery);

                $Insertquery = "INSERT INTO ##LossOfHour$User_Id (ExecutiveName, Shop_Cd, ShopName, Lattitude1, Longitude1, AddedDate1, Lattitude2, Longitude2, AddedDate2) 
                SELECT t1.ExecutiveName, t1.Shop_Cd, t1.ShopName, t1.Lattitude1, t1.Longitude1, t1.AddedDate1,
                    ( SELECT T.ShopLatitude
                        FROM (SELECT Shop_Cd, SurveyBy, ShopLatitude, ShopLongitude, SurveyDate,
                                     row_number() over(partition by SurveyBy ORDER BY SurveyDate ASC) as RNN
                              FROM ShopMaster WHERE SurveyBy= '$SurveyBy' AND CONVERT(VARCHAR, SurveyDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS Lattitude2,
                    ( SELECT T.ShopLongitude
                        FROM (SELECT Shop_Cd, SurveyBy, ShopLatitude, ShopLongitude, SurveyDate,
                                     row_number() over(partition by SurveyBy ORDER BY SurveyDate ASC) as RNN
                              FROM ShopMaster WHERE SurveyBy= '$SurveyBy' AND CONVERT(VARCHAR, SurveyDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS Longitude2,
                    ( SELECT T.SurveyDate
                        FROM (SELECT Shop_Cd, SurveyBy, ShopLatitude, ShopLongitude, SurveyDate,
                                     row_number() over(partition by SurveyBy ORDER BY SurveyDate ASC) as RNN
                              FROM ShopMaster WHERE SurveyBy= '$SurveyBy' AND CONVERT(VARCHAR, SurveyDate, 23) = '$Date' ) as T
                        WHERE T.RNN = t1.RN+1
                    )  AS AddedDate2 
                FROM ( 
                    SELECT TOP((SELECT COUNT(*) - 1 AS cnt FROM ShopMaster WHERE SurveyBy= '$SurveyBy' AND CONVERT(VARCHAR, SurveyDate, 23) = '$Date')) um.ExecutiveName, sm.Shop_Cd, sm.ShopName, sm.ShopLatitude AS Lattitude1, sm.ShopLongitude AS Longitude1, SurveyDate AS AddedDate1, row_number() over(partition by sm.SurveyBy order by sm.SurveyDate ASC) as RN
                    FROM ShopMaster AS sm 
                    INNER JOIN Survey_Entry_Data..User_Master AS um ON (sm.SurveyBy = um.UserName) 
                    WHERE sm.SurveyBy= '$SurveyBy' AND CONVERT(VARCHAR, sm.SurveyDate, 23) = '$Date'
                    ORDER BY um.ExecutiveName, sm.SurveyDate
                ) AS t1 ;";
                $result2 = sqlsrv_query($conn, $Insertquery);
                // echo $Insertquery;
                $updatequery1 = "UPDATE ##LossOfHour$User_Id SET EntryDiff = DATEDIFF(SECOND, AddedDate1, AddedDate2), Distance = CASE WHEN Lattitude1 = Lattitude2 AND Lattitude1 = Lattitude1 THEN 0 ELSE CAST((((acos(sin((Lattitude1*pi()/180)) * 
                    sin((Lattitude2*pi()/180)) + cos((Lattitude1*pi()/180)) * cos((Lattitude2*pi()/180)) * cos(((Longitude1- Longitude2) * pi()/180)))) 
                    * 180/pi()) * 60 * 1.1515 * 1.609344) * 1000 AS int) END;";
                $result3 = sqlsrv_query($conn, $updatequery1);

                $updatequery2 = "UPDATE ##LossOfHour$User_Id SET TravelTime = ((Distance/25)*15);";
                $result4 = sqlsrv_query($conn, $updatequery2);

                $updatequery3 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN EntryDiff > TravelTime THEN EntryDiff - TravelTime ELSE TravelTime - EntryDiff END;";
                $result5 = sqlsrv_query($conn, $updatequery3);

                $updatequery4 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN FinalTime > 1050 THEN FinalTime - 150 ELSE 0 END;";
                $result6 = sqlsrv_query($conn, $updatequery4);

            }

            $LossofHoursTableData = array();
            $LossofHoursquery = "SELECT ExecutiveName, Shop_Cd, ShopName, Lattitude1, Longitude1, CONVERT(VARCHAR, AddedDate1, 0) AS AddedDate1, 
                    Lattitude2, Longitude2, CONVERT(VARCHAR, AddedDate2, 0) AS AddedDate2, Distance,  
                    CONCAT((EntryDiff / 60) / 60, ':', ((EntryDiff / 60) % 60), ':', EntryDiff % 60) AS EntryDiff,
                    CONCAT((TravelTime / 60) / 60, ':', ((TravelTime / 60) % 60), ':', TravelTime % 60) AS TravelTime,
                    CONCAT((FinalTime / 60) / 60, ':', ((FinalTime / 60) % 60), ':', FinalTime % 60) AS FinalTimeDiff
                    FROM  ##LossOfHour$User_Id ;";

               


            // echo $LossofHoursquery;
            $LossofHoursTableData = $db->ExecutveQueryMultipleRowSALData($LossofHoursquery, $electionName, $developmentMode);
            // print_r($LossofHoursTableData);

            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                $droptablequery = "DROP TABLE ##LossOfHour$User_Id;";
                $result7 = sqlsrv_query($conn, $droptablequery);
            }
        }else if($filterType == 'ShopCalling'){

            $AddedBy = "";
            $AddedByUserName = array();
            $AddedByQuery = "SELECT UserName, ExecutiveName FROM Survey_Entry_Data..User_Master WHERE User_Id = $User_Id";
            $AddedByUserName = $db->ExecutveQuerySingleRowSALData($AddedByQuery, $electionName, $developmentMode);    
            $AddedBy = $AddedByUserName['UserName'];
            $ExecutiveName = $AddedByUserName['ExecutiveName'];

            $dbConn = $db->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];

                $dropQuery = "DROP TABLE ##LossOfHour$User_Id;";
                $result = sqlsrv_query($conn, $dropQuery);

                $createtablequery = "CREATE TABLE ##LossOfHour$User_Id (ExecutiveName VARCHAR(100), Calling_Cd INT, AddedDate1 DATETIME,  AddedDate2 DATETIME,  EntryDiff INT, CallingTime INT, FinalTime INT);";
                $result1 = sqlsrv_query($conn, $createtablequery);

                $Insertquery = "INSERT INTO ##LossOfHour$User_Id (ExecutiveName, Calling_Cd, CallingTime, AddedDate1, AddedDate2) 
                SELECT TOP((SELECT COUNT(*) - 1 AS cnt FROM CallingDetails WHERE AddedByUser= '$AddedBy' AND CONVERT(VARCHAR, Call_DateTime, 23) = '$Date'))  um.ExecutiveName, cd.Calling_Cd, 
                    CAST ((CAST( TRIM(SUBSTRING (cd.AudioDuration,0,CHARINDEX(':',cd.AudioDuration)-0)) AS INT) * 60 ) AS  INT) + CAST( (CASE WHEN len(TRIM(RIGHT(cd.AudioDuration,CHARINDEX(':',REVERSE(cd.AudioDuration))-1)))=1 THEN '0'+TRIM(RIGHT(cd.AudioDuration,CHARINDEX(':',REVERSE(cd.AudioDuration))-1)) ELSE TRIM(RIGHT(AudioDuration,CHARINDEX(':',REVERSE(AudioDuration))-1)) END) AS INT) as CallingTime,
                    Call_DateTime AS AddedDate1, (SELECT TOP(1) Call_DateTime FROM CallingDetails WHERE Calling_Cd > cd.Calling_Cd AND AddedByUser = cd.AddedByUser AND CONVERT(VARCHAR, Call_DateTime, 105) = CONVERT(VARCHAR, cd.Call_DateTime, 105) ORDER BY Call_DateTime) AS AddedDate2  FROM CallingDetails AS cd INNER JOIN Survey_Entry_Data..User_Master AS um ON (cd.AddedByUser = um.UserName) WHERE AddedByUser = '$AddedBy' AND CONVERT(VARCHAR, Call_DateTime, 23) = '$Date' AND Call_Response_Cd=4 ORDER BY ExecutiveName, Call_DateTime;";
                $result2 = sqlsrv_query($conn, $Insertquery);
                // echo $Insertquery;
                $updatequery1 = "UPDATE ##LossOfHour$User_Id SET EntryDiff = DATEDIFF(SECOND, AddedDate1, AddedDate2)";
                $result3 = sqlsrv_query($conn, $updatequery1);

               
                $updatequery3 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN EntryDiff > CallingTime THEN EntryDiff - CallingTime ELSE CallingTime - EntryDiff END;";
                $result5 = sqlsrv_query($conn, $updatequery3);

                $updatequery4 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN FinalTime > 1050 THEN FinalTime - 150 ELSE 0 END;";
                $result6 = sqlsrv_query($conn, $updatequery4);
            }

            $LossofHoursTableData = array();
            $LossofHoursquery = "SELECT ExecutiveName, Calling_Cd, CONVERT(VARCHAR, AddedDate1, 0) AS AddedDate1, CONVERT(VARCHAR, AddedDate2, 0) AS AddedDate2,  
                    CONCAT((EntryDiff / 60) / 60, ':', ((EntryDiff / 60) % 60), ':', EntryDiff % 60) AS EntryDiff,
                    CONCAT((CallingTime / 60) / 60, ':', ((CallingTime / 60) % 60), ':', CallingTime % 60) AS CallingTime,
                    CONCAT((FinalTime / 60) / 60, ':', ((FinalTime / 60) % 60), ':', FinalTime % 60) AS FinalTimeDiff
                    FROM  ##LossOfHour$User_Id;";
            // echo $LossofHoursquery;
            $LossofHoursTableData = $db->ExecutveQueryMultipleRowSALData($LossofHoursquery, $electionName, $developmentMode);
            // print_r($LossofHoursTableData);

            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                $droptablequery = "DROP TABLE ##LossOfHour$User_Id;";
                $result7 = sqlsrv_query($conn, $droptablequery);
            }
        }else if($filterType == 'ShopQC'){

            $AddedBy = "";
            $AddedByUserName = array();
            $AddedByQuery = "SELECT UserName, ExecutiveName FROM Survey_Entry_Data..User_Master WHERE User_Id = $User_Id";
            $AddedByUserName = $db->ExecutveQuerySingleRowSALData($AddedByQuery, $electionName, $developmentMode);    
            $AddedBy = $AddedByUserName['UserName'];
            $ExecutiveName = $AddedByUserName['ExecutiveName'];

            $dbConn = $db->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];

                $dropQuery = "DROP TABLE ##LossOfHour$User_Id;";
                $result = sqlsrv_query($conn, $dropQuery);

                $createtablequery = "CREATE TABLE ##LossOfHour$User_Id (ExecutiveName VARCHAR(100), Shop_Cd INT, ShopName VARCHAR(250), AddedDate1 DATETIME,  AddedDate2 DATETIME,  EntryDiff INT, QCTime INT, FinalTime INT, RN INT);";
                $result1 = sqlsrv_query($conn, $createtablequery);

                $createtablequery2 = "CREATE TABLE ##LossOfHour2_$User_Id (  AddedDate2 DATETIME, RNN INT);";
                $result1 = sqlsrv_query($conn, $createtablequery2);

                $Insertquery = "INSERT INTO ##LossOfHour$User_Id (ExecutiveName, Shop_Cd, ShopName, AddedDate1, RN) 
                SELECT TOP ((SELECT COUNT(*) - 1 AS cnt FROM (SELECT Shop_Cd FROM QCDetails WHERE QC_UpdatedByUser= '$AddedBy' AND CONVERT(VARCHAR, QC_DateTime, 23) = '$Date' GROUP BY Shop_Cd ) a)) t.ExecutiveName, t.Shop_Cd, t.ShopName, t.AddedDate1,t.RN
                    FROM (SELECT qd.QC_UpdatedByUser as ExecutiveName, qd.Shop_Cd, sm.ShopName, (SELECT max(QC_DateTime) FROM QCDetails WHERE Shop_Cd = qd.Shop_Cd AND QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, QC_DateTime, 23) = '$Date'  ) AS AddedDate1, row_number() over(partition by qd.QC_UpdatedByUser order by (SELECT max(QC_DateTime) FROM QCDetails WHERE Shop_Cd = qd.Shop_Cd AND QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, QC_DateTime, 23) = '$Date'  ) ASC) as RN
                    FROM QCDetails AS qd INNER JOIN ShopMaster sm on sm.Shop_Cd = qd.Shop_Cd WHERE qd.QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, qd.QC_DateTime, 23) = '$Date'
                    GROUP BY qd.QC_UpdatedByUser, qd.Shop_Cd, sm.ShopName
                ) t GROUP BY t.ExecutiveName, t.Shop_Cd, t.ShopName, t.AddedDate1,t.RN
                ORDER BY t.ExecutiveName,t.AddedDate1;";
                $result2 = sqlsrv_query($conn, $Insertquery);
                // echo $Insertquery;

                $Insertquery_2 = "INSERT INTO ##LossOfHour2_$User_Id (AddedDate2, RNN)
                SELECT T.AddedDate2, T.RNN FROM ( SELECT qdd.QC_UpdatedByUser, qdd.Shop_Cd, (SELECT max(QC_DateTime) FROM QCDetails WHERE Shop_Cd = qdd.Shop_Cd AND QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, QC_DateTime, 23) = '$Date'  ) AS AddedDate2, row_number() over(partition by qdd.QC_UpdatedByUser order by (SELECT max(QC_DateTime) FROM QCDetails WHERE Shop_Cd = qdd.Shop_Cd AND QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, QC_DateTime, 23) = '$Date'  ) ASC) as RNN FROM QCDetails AS qdd WHERE qdd.QC_UpdatedByUser = '$AddedBy' AND CONVERT(VARCHAR, qdd.QC_DateTime, 23) = '$Date'
                    GROUP BY qdd.QC_UpdatedByUser, qdd.Shop_Cd ) AS T "; 
                $result2_2 = sqlsrv_query($conn, $Insertquery_2);
                // echo $Insertquery_2;

                $updatequery0 = "UPDATE ##LossOfHour$User_Id SET AddedDate2 = ( SELECT AddedDate2 FROM ##LossOfHour2_$User_Id WHERE RNN = ##LossOfHour$User_Id.RN + 1 ) ";
                $result0 = sqlsrv_query($conn, $updatequery0);

                $updatequery1 = "UPDATE ##LossOfHour$User_Id SET EntryDiff = DATEDIFF(SECOND, AddedDate1, AddedDate2), QCTime = DATEDIFF(SECOND, AddedDate1, AddedDate2)";
                $result3 = sqlsrv_query($conn, $updatequery1);

               
                $updatequery3 = "UPDATE ##LossOfHour$User_Id SET FinalTime = QCTime;";
                $result5 = sqlsrv_query($conn, $updatequery3);

                $updatequery4 = "UPDATE ##LossOfHour$User_Id SET FinalTime = CASE WHEN FinalTime > 1050 THEN FinalTime - 150 ELSE 0 END;";
                $result6 = sqlsrv_query($conn, $updatequery4);
            }

            $LossofHoursTableData = array();
            $LossofHoursquery = "SELECT ExecutiveName, Shop_Cd, ShopName, CONVERT(VARCHAR, AddedDate1, 0) AS AddedDate1, CONVERT(VARCHAR, AddedDate2, 0) AS AddedDate2,  
                    CONCAT((EntryDiff / 60) / 60, ':', ((EntryDiff / 60) % 60), ':', EntryDiff % 60) AS EntryDiff,
                    CONCAT((QCTime / 60) / 60, ':', ((QCTime / 60) % 60), ':', QCTime % 60) AS QCTime,
                    CONCAT((FinalTime / 60) / 60, ':', ((FinalTime / 60) % 60), ':', FinalTime % 60) AS FinalTimeDiff
                    FROM  ##LossOfHour$User_Id;";
            // echo $LossofHoursquery;
            $LossofHoursTableData = $db->ExecutveQueryMultipleRowSALData($LossofHoursquery, $electionName, $developmentMode);
            // print_r($LossofHoursTableData);

            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                $droptablequery = "DROP TABLE ##LossOfHour$User_Id;";
                $droptablequery2 = "DROP TABLE ##LossOfHour2_$User_Id;";
                $result7 = sqlsrv_query($conn, $droptablequery);
                $result72 = sqlsrv_query($conn, $droptablequery2);
            }
        }      




    }



?>




   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <?php 
                            if($filterType == 'ShopList'){
                                echo "Shop Listing - ".$ExecutiveName." on ".date('d/m/Y',strtotime($Date));
                            }else if($filterType == 'ShopSurvey'){
                                echo "Shop Survey - ".$ExecutiveName." on ".date('d/m/Y',strtotime($Date));
                            }else if($filterType == 'ShopCalling'){
                                echo "Shop Calling - ".$ExecutiveName." on ".date('d/m/Y',strtotime($Date));
                            }else if($filterType == 'ShopQC'){
                                echo "Shop QC - ".$ExecutiveName." on ".date('d/m/Y',strtotime($Date));
                            }
                        ?>
                    </h5>
                </div>
               <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered complex-headers zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <?php if($filterType == 'ShopCalling'){ ?> 
                                            <th>Calling</th>
                                        <?php }else if($filterType == 'ShopQC'){ ?> 
                                            <th>ShopName</th>
                                        <?php }else if($filterType == 'ShopList' || $filterType == 'ShopSurvey'){ ?> 
                                            <th>ShopName</th>
                                            <th>Distance</th>
                                            <th>Travelling</th>
                                        <?php } ?>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Time Diff</th>
                                        <th>Loss Time</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($LossofHoursTableData)){
                                        $srNo = 1;
                                        
                                        foreach ($LossofHoursTableData as $key => $value) {

                                            $date1 = date_create($value['AddedDate1']);
                                            $AddedDate1 =  date_format($date1,"g:i A");

                                            $date2 = date_create($value['AddedDate2']);
                                            $AddedDate2 =  date_format($date2,"g:i A");

                                        ?> 
                                            <tr>
                                                <td><?php echo $srNo++; ?></td>
                                                
                                                <?php if($filterType == 'ShopCalling'){ ?> 
                                                    <td><?php echo $value["CallingTime"]; ?></td>
                                                <?php }else if($filterType == 'ShopQC'){ ?> 
                                                    <td><?php echo $value["ShopName"]; ?></td>
                                                <?php }else if($filterType == 'ShopList' || $filterType == 'ShopSurvey'){ ?> 
                                                    <td><?php echo $value["ShopName"]; ?></td>
                                                    <td><?php echo $value["Distance"]; ?></td>
                                                    <td><?php echo $value["TravelTime"]; ?></td>
                                                <?php } ?>
                                                
                                                <td><?php echo $AddedDate1; ?></td>
                                                <td><?php echo $AddedDate2;?></td>
                                                <td><?php echo $value["EntryDiff"]; ?></td>
                                                <td>
                                                    <?php if($value["FinalTimeDiff"] == '0:0:0'){?>
                                                        <?php echo $value["FinalTimeDiff"];?> 
                                                    <?php } else {?>
                                                        <span style="font-size:15px;"class="badge badge-danger"><?php echo $value["FinalTimeDiff"];?> </span>    
                                                    <?php } ?>
                                                    
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
