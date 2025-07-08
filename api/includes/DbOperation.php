<?php
 
class DbOperation
{
    private $con;
    private $con_user;
 
    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        require_once dirname(__FILE__) . '/config.php';

        $db = new DbConnect();
        $this->con_user = $db->connect_db_user();
    }

    
     //This method will connect to the database
    function getDBConnect($servername,$dbname,$dbusername,$dbpassword)
    {
        try  
        {  

            $connectionString = array("Database"=> $dbname, "CharacterSet" => "UTF-8",   
                    "Uid"=> $dbusername, "PWD"=>$dbpassword);

            //connecting to sql database
            $conn = sqlsrv_connect($servername, $connectionString); 
     
            //Checking if any error occured while connecting

            if ($conn == false) {
                die(sqlsrv_errors());
                return null;
            }

         }  
        catch(Exception $e)  
        {  
            echo("Error!");  
        }  
 
        //finally returning the connection link
        return $conn;

    }

    // function getDBConnectByUserNameAndAppName($userName, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_211_PHP_CCR_GetConnectionUsingUserNameAndAppName(?, ?)}';
    //     $params = array($userName, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);  

    //     if(sizeof($dbDetail)>0){
    //         $serverName = trim($dbDetail['ServerName']);
    //         $dbName = trim($dbDetail['DbName']);
    //         $serverUser = trim($dbDetail['ServerUser']);
    //         $serverPwd = trim($dbDetail['ServerPwd']);  
    //         $data["error"] = false;
    //         $data["message"] = "Connected to Database Succesfully!";
    //         $data["conn"] = $this->getDBConnect($serverName,$dbName,$serverUser,$serverPwd);
    //     }else{
    //         $data["error"] = true;
    //         $data["message"] = "Not Connected to Database!";
    //     }
       

    //    return $data;
    // }

    function getSALDBConnectByElectionName($electionName, $developmentMode){
        $data = array();
        $conn = $this->con_user;
        $tsql = '{CALL Sp_268_PHP_CHCC_GetConnectionUsingElectionNameSAL(?, ?)}';
        $params = array($electionName, $developmentMode);
        $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);  

        if(sizeof($dbDetail)>0){
            $serverName = trim($dbDetail['ServerName']);
            $dbName = trim($dbDetail['DbName']);
            $serverId = trim($dbDetail['ServerId']);
            $serverPwd = trim($dbDetail['ServerPwd']);  
            $data["error"] = false;
            $data["message"] = "Connected to Database Succesfully!";
            $data["conn"] = $this->getDBConnect($serverName,$dbName,$serverId,$serverPwd);
        }else{
            $data["error"] = true;
            $data["message"] = "Not Connected to Database!";
        }
       

       return $data;
    }
    
   


/*New Login Start*/


    // function checkMobileIsPresentInDb($umobile, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1000_PHP_CCR_AuthenticateUserWOPwd(?, ?)}';
    //     $params = array($umobile, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         $Mobile = trim($dbDetail['Mobile']);
    //         $UserName = trim($dbDetail['UserName']);
    //         $User_Cd = trim($dbDetail['User_Cd']);
    //         $ExpDate = trim($dbDetail['ExpDate']);
    //         $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         $data["message"] = "Mobile No Is Present In DB!";
    //         $userDetails = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'Mobile Number Verified!', 'userDetails'=>$userDetails));
    //     } else {
    //         $data["error"] = true;
    //         $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'Mobile Number Not Found!'));

    //     }

    //     return $data;
    // }


    // function checkIsUserVerified($umobile, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1001_PHP_CCR_CheckIsVerifiedUser(?, ?)}';
    //     $params = array($umobile, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'User Is Verified!'));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'User Is Not Verified!'));

    //     }

    //     return $data;
    // }

    // function updateOTPForUser($mobile, $otp, $UserName, $userCd, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1001_PHP_CCR_UpdateOTPForUser(?, ?, ?, ?, ?)}';
    //     $params = array($mobile, $otp, $UserName, $userCd, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 208, 'msg' => 'OTP Update Successfully!'));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'OTP Not Updated!'));

    //     }

    //     return $data;
    // }


    // function checkOTPForUser($mobile, $otp, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1001_PHP_CCR_CheckOTPForUser(?, ?, ?)}';
    //     $params = array($mobile, $otp, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'OTP Match Successfully!'));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'OTP Does Not Updated!'));

    //     }

    //     return $data;
    // }


    // function updateVerifiedPinForUser($umobile, $upassword, $userName, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1001_PHP_CCR_UpdateVerifiedPinForUser(?, ?, ?, ?)}';
    //     $params = array($umobile, $upassword, $userName, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'Pin Generated Successfully!', 'data'=>$dbDetail));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'Pin Generation Failed!'));
    //     }
    //     return $data;
    // }

    // function getPinFromDB($umobile, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1000_PHP_CCR_AuthenticateUserWOPwd(?, ?)}';
    //     $params = array($umobile, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'Updated isVerified User Successfully!', 'data'=>$dbDetail));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'Updation isVerified Failed!'));
    //     }
    //     return $data;
    // }



    // function updateIsVerifiedForUser($umobile, $isVerified, $userName, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1001_PHP_CCR_UpdateIsVerifiedForUser(?, ?, ?, ?)}';
    //     $params = array($umobile, $isVerified, $userName, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 400, 'msg' => 'Updated isVerified User Successfully!'));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'Updation isVerified Failed!'));
    //     }
    //     return $data;
    // }

    // //Corona Care Application
    // function getLoggedInUsersDetails($mobile, $appName){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1002_PHP_CHCC_GetLoggedInUserDetailsForWebsite(?, ?)}';
    //     $params = array($mobile, $appName);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'Updated isVerified User Successfully!', 'data' => $dbDetail));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'No Records Found!'));
    //     }
    //     return $data;
    // }

    // function uploadLoginEntryForUser($srNo, $userName, $user_Cd, $ipAddress, $latitude, $longitude, $entry_Date, $loc_Address){
    //     $data = array();
    //     $conn = $this->con_user;
    //     $tsql = '{CALL Sp_1003_PHP_CCR_UploadLoginEntryForUser(?, ?, ?, ?, ?, ?, ?, ?)}';
    //     $params = array($srNo, $userName, $user_Cd, $ipAddress, $latitude, $longitude, $entry_Date, $loc_Address);
    //     $dbDetail = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $tsql, $params);
    //     if (sizeof($dbDetail) > 0) {
    //         // $Mobile = trim($dbDetail['Mobile']);
    //         // $UserName = trim($dbDetail['UserName']);
    //         // $User_Cd = trim($dbDetail['User_Cd']);
    //         // $ExpDate = trim($dbDetail['ExpDate']);
    //         // $AppName = trim($dbDetail['AppName']);
    //         $data["error"] = false;
    //         // $data["message"] = "Mobile No Is Present In DB!";
    //         // $data = [$Mobile, $UserName, $User_Cd, $ExpDate, $AppName];
    //         $data = json_encode(array('statusCode' => 200, 'msg' => 'User Logged In details Successfully Uploaded!', 'data' => $dbDetail));
    //     } else {
    //         $data["error"] = true;
    //         // $data["message"] = "Mobile No Not Present!";
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'Uploaded User Logged In details Fails!'));
    //     }
    //     return $data;
    // }


    // function requestOTPForVerification($mobile, $message){
    //     $data = array();
    //     $message = urlencode($message);
    //     $url = 'http://173.45.76.227/send.aspx?username=ornettech&pass=Orc2829tech&route=trans1&senderid=ORNETT&numbers='.$mobile.'&message='.$message;
    //     $response = file_get_contents($url);
    //     $ary = explode("|",$response);
    //     if($ary[0] == 1){
    //         $url2 = 'http://173.45.76.227/status.aspx?username=ornettech&pass=Orc2829tech&msgid='.$ary[2];
    //         $response2 = file_get_contents($url2);
    //         $ary2 = explode("|",$response2);
    //         if($ary2[0] == 1){
    //             $data["error"] = false;
    //             $data = json_encode(array('statusCode' => 200, 'msg' => 'OTP Sent!!'));
    //             // $errmsg = '{"error" : false, "message" : "OTP sent !"}';
    //         }else{
    //             $data["error"] = false;
    //             $data = json_encode(array('statusCode' => 200, 'msg' => 'OTP Sent!!'));
    //             // $errmsg = '{"error" : false, "message" : "OTP sent !"}';
    //         }
    //     }else{
    //         $data["error"] = true;
    //         $data = json_encode(array('statusCode' => 404, 'msg' => 'OTP Not Sent!!'));
    //         // $errmsg = '{"error" : false, "message" : "OTP not sent !"}';
    //     }

    //     return $data;
    // }


/*New Login  End*/


/*SAL Code Start*/

    function getSALCorporationElectionData($appName, $developmentMode){
        $data = array();
        $conn = $this->con_user;
        $tsql = '{CALL Sp_267_PHP_CHCC_GetSALCorporationElectionNames(?, ?)}';
        $params = array($appName, $developmentMode);
        $data = $this->getDataInRowWithConnAndQueryAndParams($conn, $tsql, $params);  
        
       return $data;
    }

    
    function authenticateUser($mobile, $password, $appName)
    {
        $sql1 = "SELECT Mobile, UserName, ExpDate, AppName FROM User_Master 
        where Mobile = '$mobile' AND APK_Password = '$password' AND AppName = '$appName';";
        $conn = $this->con_user;
        $result1 = sqlsrv_query($conn, $sql1);
        $numrows1 = sqlsrv_has_rows($result1);
        
        if ($numrows1 > 0) {
            if (!$this->checkUserDeActiveStatus($mobile, $password, $appName)) {
                if (!$this->checkUserLicenseStatus($mobile, $password, $appName)) {
                    $result = USER_LOGIN_SUCCESS;
                } else {
                    $result = USER_LICENSE_EXPIRED;
                }
            } else {
                $result = USER_STATUS_NOT_ACTIVE;
            }
        }else{
            $result = USER_LOGIN_FAILED;
        }

        return $result;
    }


    function checkUserDeActiveStatus($mobile, $password, $appName){
        $result = false;

        $tsql = "SELECT Mobile, UserName, ClientName, ExpDate, AppName FROM User_Master 
        WHERE Mobile = '$mobile' AND APK_Password = '$password' AND AppName = '$appName' AND DeactiveFlag = 'D'";
        $conn = $this->con_user;
        $result1 = sqlsrv_query($conn, $tsql);
        $numrows1 = sqlsrv_has_rows($result1);

        if ($numrows1 > 0) {
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    function checkUserLicenseStatus($mobile, $password, $appName){
        $today = date("Y-m-d");
        $result = false;
        $conn = $this->con_user;
        $tsql = "SELECT Mobile, UserName, ClientName, ExpDate, AppName FROM User_Master 
        WHERE Mobile = '$mobile' AND APK_Password = '$password' AND AppName = '$appName' 
          AND CONVERT(date, ExpDate, 103) <  '$today';";

        $result1 = sqlsrv_query($conn, $tsql);
        $numrows1 = sqlsrv_has_rows($result1);

        if ($numrows1 > 0) {
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    function ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode){
        $data = array();
        $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
        if(!$dbConn["error"]){
            $conn = $dbConn["conn"];
            // echo $query;
            $tsql = '{CALL Sp_SAL_0001_PHP_Execute_Query(?)}';
            $params = array($query);
            $data = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $tsql, $params);
         }
        return $data;
    }

    function ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode){
        $data = array();
        $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
        if(!$dbConn["error"]){
            $conn = $dbConn["conn"];
            //echo $query;
            $tsql = '{CALL Sp_SAL_0001_PHP_Execute_Query(?)}';
            $params = array($query);
            $data = $this->getDataInRowWithConnAndQueryAndParams($conn, $tsql, $params);
         }
        return $data;
    }

    function RunQuerySALData($query, $electionName, $developmentMode){
        $data = array();
        $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
        if(!$dbConn["error"]){
            $conn = $dbConn["conn"];
            // echo $query;
            $tsql = '{CALL Sp_SAL_0002_PHP_Run_Query(?)}';
            $params = array($query);
            $data = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $tsql, $params);
         }
        return $data;
    }

    function RunQueryData($query, $electionName, $developmentMode){
        $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
        if(!$dbConn["error"]){
            $conn = $dbConn["conn"];
            if (sqlsrv_query($conn, $query) !== false) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function getCheckLoggedInUserDetails($mobile, $appName)
    {
        $data = array();
        $query = "SELECT User_Id, UserName, ISNULL(ElectionName,'') as ElectionName FROM Survey_Entry_Data..User_Master 
                    WHERE Mobile = '$mobile' AND AppName = '$appName'";
        $conn = $this->con_user;
        $tsql = '{CALL Sp_0001_PHP_Execute_Query(?)}';
               
        // echo $query;
        $params = array($query);
        $data = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $tsql, $params);
        return $data;
    }

    
    function getLoggedInUserDetails($mobile, $password, $appName, $appKey, $electionName, $developmentMode, $loginMode, $userId)
    {
        $data = array();
        $query = "SELECT TOP(1) COALESCE(lm.Login_Cd, 0) as Login_Cd,
                    COALESCE(lm.User_Cd, 0) as User_Cd,
                    COALESCE(lm.Executive_Cd, 0) as Executive_Cd,
                    COALESCE(lm.User_Type, '') as User_Type,
                    COALESCE(lm.IsVerified, 0) as IsVerified,
                    COALESCE(lm.Mobile_No, '') as Mobile_No,
                    COALESCE(ld.Firebase_ID, '') as Firebase_ID,
                    COALESCE(um.UserName, '') as UserName,
                    COALESCE(um.AppName, '') as AppName,
                    COALESCE(um.User_Id, 0) as User_Id,
                    COALESCE(um.ElectionName, '') as DefaultElectionName,
                    COALESCE(um.UserType, '') as UMUserType,
                    COALESCE(um.Remarks, '') as ExecutiveName,
                    COALESCE(lm.User_Type, '') as User_Type,
                    COALESCE(em.MobileNo2, '') as Mobile_No_2,
                    COALESCE(em.Email, '') as Email_ID,
                    COALESCE(CONVERT(VARCHAR,um.ExpDate,23), '') as Expiry_Date,
                    COALESCE(um.DeactiveFlag, '') as DeactiveFlag,
                    COALESCE(em.IsBlocked, 0) as IsBlocked,
                    COALESCE(CONVERT(VARCHAR,em.UnBlockedDate,121), '') as UnBlockDate
                    FROM Survey_Entry_Data..User_Master AS um 
                    INNER JOIN LoginMaster AS lm ON (um.User_Id = lm.User_Cd) 
                    INNER JOIN LoginDetails AS ld ON (lm.User_Cd = ld.User_Cd) 
                    LEFT JOIN Survey_Entry_Data..Executive_Master AS em ON (lm.Executive_Cd = em.Executive_Cd) 
                    WHERE lm.Mobile_No = '$mobile' AND ld.LoginMode = '$loginMode'
                    AND lm.User_Cd = $userId
                    ORDER BY ld.UpdatedDate DESC;";
        $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
        if(!$dbConn["error"]){
            $conn = $dbConn["conn"];

            $tsql = '{CALL Sp_SAL_0001_PHP_Execute_Query(?)}';
               
            // echo $query;
            $params = array($query);
            $data = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $tsql, $params);

            if (sizeof($data) > 0) {
                if($loginMode == "WebAdmin"){
                    if($data["IsVerified"] == 0){
                        $otp = rand(1000, 9999);
                        $User_Id = $data["User_Id"];
                        // $sendOTP= $this->sendOTP($mobile, $otp, $User_Id, $appKey, $appName, $electionName, $developmentMode);   
                    }
                }else{
                    $otp = rand(1000, 9999);
                    $User_Id = $data["User_Id"];
                    $sendOTP= $this->sendOTP($mobile, $otp, $User_Id, $appKey, $appName, $electionName, $developmentMode);    
                }
                
            }
        }

        return $data;
    }


    function sendOTP($mobileNo, $otp, $User_Id, $appKey, $appName, $electionName, $developmentMode){
        $data = array();
        if(sqlsrv_query($this->con_user,"UPDATE Survey_Entry_Data..User_Master set OTP = '$otp'
                    where User_Id = $User_Id;") !== false){
            $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                if(sqlsrv_query($conn,"UPDATE LoginMaster set OTP = '$otp'
                        where User_Cd = $User_Id;") !== false){
                        $data = $this->requestMobileOTPForVerification($mobileNo, $otp, $appKey);
                    }
                }
            }
        return $data;
    }

    function requestMobileOTPForVerification($mobileNo, $otp, $appKey){
        $data = array();

        $msg = '<#> Your OTP is: '.$otp.' '.$appKey.',Chanakya';
        $message = urlencode($msg);

        $url = 'http://173.45.76.227/send.aspx?username=ornettech&pass=Orc2829tech&route=trans1&templateid=1707161579329093013&senderid=CHANKR&numbers='.$mobileNo.'&message='.$message;
        $response1 = file_get_contents($url);
        $ary = explode("|",$response1);
        if($ary[0] === 1){
            $url2 = 'http://173.45.76.227/status.aspx?username=ornettech&pass=Orc2829tech&msgid='.$ary[2];
            $response2 = file_get_contents($url2);
            $ary2 = explode("|",$response2);
            if($ary2[0] === 1){
                $data['error'] = false;
                $data['message'] = 'Message Sent Succesfully';
                $data['otp'] = $otp;
            }else{
                $data['error'] = false;
                $data['message'] = 'Message Sent Succesfully';
                $data['otp'] = $otp;
            }
        }else{
            $data['error'] = true;
            $data['message'] = 'Message not sent!';
            $data['otp'] = $otp;
        }

        return $data;
    }


    function checkOTP($mobile, $otp, $appname, $electionname, $developmentmode){
        $result = false;
        $query = "SELECT TOP(1) COALESCE(OTP, '0000') AS OTP FROM User_Master 
            WHERE Mobile = '$mobile' AND AppName = '$appname';";
        $conn = $this->con_user;
        $result1 = sqlsrv_query($conn, $query);
        $numrows = sqlsrv_has_rows($result1);
        $dbConn = $this->getSALDBConnectByElectionName($electionname, $developmentmode);
            if(!$dbConn["error"]){
                $SALCon = $dbConn["conn"];
                if ($numrows > 0) {
                    while ($row =sqlsrv_fetch_array($result1)) {
                        $OTP1 = $row['OTP'];
                        if($OTP1 == $otp){
                            sqlsrv_query($conn, "UPDATE User_Master SET OTP = NULL 
                            WHERE Mobile = '$mobile' AND OTP = '$otp' AND AppName = '$appname';");
                             sqlsrv_query($SALCon, "UPDATE LoginMaster SET IsVerified = 1 
                            WHERE Mobile_No = (Select Mobile FROM User_Master WHERE Mobile= '$mobile' AND AppName = '$appname');");
                            $result = true;
                        }else{
                            $result = false;
                        }
                    }
                }
            sqlsrv_close($conn); 
            sqlsrv_close($SALCon); 
        }
        return $result;
    }

/*SAL Code End*/


    function getDataInRowWithConnAndQuery($conn, $query){
        $getDetail = sqlsrv_query($conn, $query); 
        if ($getDetail == FALSE)  
                die(sqlsrv_errors());  
             $row_count = sqlsrv_num_rows( $getDetail ); 
            
            $data = array();

            while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data[] = $row;
                } 

            sqlsrv_free_stmt($getDetail);  
            sqlsrv_close($conn); 
        return $data;
    }

    function getDataInRowWithConnAndQueryAndParams($conn, $query, $params){
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getDetail = sqlsrv_query($conn, $query, $params); 

        if ($getDetail == FALSE)  {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
            }  else{

        $row_count = sqlsrv_num_rows( $getDetail ); 

        $data = array();

            while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data[] = $row;
                } 
        }
            sqlsrv_free_stmt($getDetail);  
            sqlsrv_close($conn); 

        return $data;
    }

    function getDataInRowWithConnAndQueryAndParamsWOCloseConn($conn, $query, $params){
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getDetail = sqlsrv_query($conn, $query, $params); 

        if ($getDetail == FALSE)  {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
            }  else{

        $row_count = sqlsrv_num_rows( $getDetail ); 

        $data = array();

            while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data[] = $row;
                } 
        }
            // sqlsrv_free_stmt($getDetail);  
            // sqlsrv_close($conn); 

        return $data;
    }


    function getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $query, $params){
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getDetail = sqlsrv_query($conn, $query, $params); 

        if ($getDetail == FALSE)  {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
            }  else{

        $row_count = sqlsrv_num_rows( $getDetail ); 

        $data = array();

            while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data = $row;
                } 
        }
            sqlsrv_free_stmt($getDetail);  
            sqlsrv_close($conn); 

        return $data;
    }

     function getDataInRowWithConnAndQueryAndParamsForSingleRecordForLogin($conn, $query, $params){
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getDetail = sqlsrv_query($conn, $query, $params); 

        if ($getDetail == FALSE)  {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
            }  else{

        $row_count = sqlsrv_num_rows( $getDetail ); 

        $data = array();

            while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data = $row;
                } 
        }
          /*  sqlsrv_free_stmt($getDetail);  
            sqlsrv_close($conn); */

        return $data;
    }

    function getRandomPassword($length) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 

    function getRandomNumber($length) { 
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 

    function getRandomCharacters($length) { 
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 

    
    
    //function to check parameters
    function isTheseParametersAvailable($required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = $_REQUEST;
        //print_r($request_params);
     
        foreach ($required_fields as $field) {
            //print_r($field);
            // print_r($request_params[$field]);
            //print_r(strlen(trim($request_params[$field])));
            //print_r($request_params[$field]);
            
            /*if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
               
            }*/

            if (!isset($request_params[$field]) || strlen($request_params[$field]) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
               
            }
        }
     
        if ($error) {
            $response = array();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            echo json_encode($response);
            return false;
        }
        return $request_params[$field];
    }

    function isTheseParametersAvailableWithOutEmpty($required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = $_REQUEST;
      //  print_r($request_params);
     
        foreach ($required_fields as $field) {
            //print_r($field);
            // print_r($request_params[$field]);
            //print_r(strlen(trim($request_params[$field])));
            //print_r($request_params[$field]);
            /*if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
               
            }*/
        }
     
        if ($error) {
            $response = array();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            echo json_encode($response);
            return false;
        }
        return $request_params[$field];
    }



    
        // Start Pocket Assign 
    
        function getShoplicenseExecutiveData($query, $userName, $appName, $electionName, $developmentMode){
            $data = array();
            $dbConn = $this->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"];
                //echo $query;
                $tsql = '{CALL Sp_0001_PHP_Execute_Query(?)}';
                $params = array($query);
                $data = $this->getDataInRowWithConnAndQueryAndParams($conn, $tsql, $params);
             }
            return $data;
        }
    

        function getSALCorporationElectionByCdData($userName, $appName, $electionCd){
            $data = array();
            $conn = $this->con_user;
            $tsql = '{CALL Sp_269_PHP_CHCC_GetSALCorporationElectionByCd(?, ?, ?)}';
            $params = array($userName, $appName, $electionCd);
            $data = $this->getDataInRowWithConnAndQueryAndParamsForSingleRecord($conn, $tsql, $params);  
            
           return $data;
        }

        
        function RunSEDQueryData($userName, $appName, $query){
            $conn = $this->con_user;
            if (sqlsrv_query($conn, $query) !== false) {
                return true;
            } else {
                return false;
            }
            
            return false;
        }
        // Ends Pocket Assign

        function getMultiRecordsAJAXDatatable($query){
            $conn = $this->con_user;
            $params = array();
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $getDetail = sqlsrv_query($conn, $query, $params); 
          
            if ($getDetail == FALSE) {  
                echo "Error in executing statement 3.\n";  
                die( print_r( sqlsrv_errors(), true));  
            }else{
                $row_count = sqlsrv_num_rows( $getDetail ); 
                $data = array();
    
                while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data[] = $row;
                }
            }
                sqlsrv_free_stmt($getDetail);  
                // sqlsrv_close($conn);
    
            return $data;
        }
    
        function getSingleAJAXDatatable($query){
            $conn = $this->con_user;
            $params = array();
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    
            $getDetail = sqlsrv_query($conn, $query, $params); 
    
            if ($getDetail == FALSE){
                echo "Error in executing statement 3.\n";  
                die( print_r( sqlsrv_errors(), true));  
            }else{
                $row_count = sqlsrv_num_rows( $getDetail ); 
                $data = array();
                while($row = sqlsrv_fetch_array($getDetail, SQLSRV_FETCH_ASSOC)){
                    $data = $row;
                } 
            }
            return $data;
        }
}