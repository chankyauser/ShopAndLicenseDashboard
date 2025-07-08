<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$dataLoginMaster = array();
$dataLogin = array();
$chkUser = array();
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    if  (
            (isset($_POST['user_name']) && !empty($_POST['user_name'])) && 
            (isset($_POST['user_Type']) && !empty($_POST['user_Type'])) && 
            (isset($_POST['user_designation']) && !empty($_POST['user_designation']))
        )
        {

        $user_id = $_POST['user_name'];
        $userType = $_POST['user_Type'];



            $query1 ="SELECT User_Cd FROM LoginMaster WHERE User_Cd = $user_id";
            $dataLogin = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($dataLogin) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "User already present!";

            }
            else
            {
                $query2 = "SELECT 
                em.ExecutiveName, em.MobileNo, em.Executive_Cd
                FROM Survey_Entry_Data..Executive_Master as em
                INNER JOIN Survey_Entry_Data..User_Master as um ON um.Executive_Cd = em.Executive_Cd 
                WHERE um.User_Id = $user_id";

                $chkUser = $db->ExecutveQuerySingleRowSALData($query2, $electionName, $developmentMode);

                if (sizeof($chkUser) > 0) 
                {
                    $executive_cd = $chkUser['Executive_Cd']; 
                    $user_mobile = $chkUser['MobileNo'];

                    $query3 ="INSERT INTO LoginMaster (User_Cd, Executive_Cd, User_Type, Mobile_No, Remark, UpdatedDate, UpdatedByUser)
                    VALUES($user_id, $executive_cd, '$userType', '$user_mobile', NULL, GETDATE(), '$userName' );";
                    $InsertLogin = $db->RunQuerySALData($query3, $electionName, $developmentMode);

                    $data["error"] = false;
                    $data["message"] = "User added successfully!";
    
                }

            }
        }
        else 
        {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
