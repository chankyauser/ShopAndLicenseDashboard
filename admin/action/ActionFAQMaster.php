<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$InsertFAQ = false;
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    


        if  (
            (isset($_POST['question']) && !empty($_POST['question'])) && 
            (isset($_POST['answer']) && !empty($_POST['answer'])) &&
            (isset($_POST['usertype']) && !empty($_POST['usertype'])) 
        )
        {
    
            $FAQ_Cd = $_POST['FAQ_Cd'];
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $usertype = $_POST['usertype'];
            $remark = $_POST['remark'];
            $IsActive = $_POST['IsActive'];

            $query1 ="SELECT FAQ_Cd FROM FAQMaster WHERE FAQ_Cd = $FAQ_Cd;";
            $chkFAQ = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkFAQ) > 0) 
            {
                
                $query1 ="UPDATE FAQMaster SET
                Question = '$question',
                Answer = '$answer',
                UserType = '$usertype',
                Remark = N'$remark',
                IsActive = $IsActive,
                UpdatedByUser = '$userName',
                UpdatedDate = GETDATE()
                WHERE FAQ_Cd = $FAQ_Cd;";

                $UpdateFAQ = $db->RunQueryData($query1, $electionName, $developmentMode);
                if($UpdateFAQ){
                    $data["error"] = false;
                    $data["message"] = "FAQ entry updated successfully!";
                }

            }else{
                
                $query1 ="SELECT FAQ_Cd FROM FAQMaster WHERE Question = '$question' AND UserType = '$usertype' AND IsActive = 1 ;";
                $chkFAQ = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

                if (sizeof($chkFAQ) > 0) 
                {
                    $data["error"] = true;
                    $data["message"] = "Question already present!";

                }
                else
                {

                    $query2 ="INSERT INTO FAQMaster (Question, Answer, UserType, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ('$question', '$answer', '$usertype', N'$remark', $IsActive , GETDATE() , '$userName');";
                    $InsertFAQ = $db->RunQueryData($query2, $electionName, $developmentMode);

                    if($InsertFAQ){
                        $data["error"] = false;
                        $data["message"] = "FAQ entry added successfully!";   
                    }
                    
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
