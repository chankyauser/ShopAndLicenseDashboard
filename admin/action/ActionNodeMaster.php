<?php

session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkNode = array();

include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];



        if  (
            (isset($_POST['node_Name']) && !empty($_POST['node_Name'])) && 
            (isset($_POST['wardNo']) && !empty($_POST['wardNo'])) && 
            (isset($_POST['area']) && !empty($_POST['area'])) 
          
        )
        {
    
            $node_Cd = $_POST['nodeCd'];
            if(empty($node_Cd)){
                $node_Cd = 0;
            }
            $nodeName = $_POST['node_Name'];
            $nodeNameMar = $_POST['nodeNameMar'];
            $assembly_no = $_POST['assembly_no'];
            $wardNo = $_POST['wardNo'];
            $address = $_POST['address'];
            $area = $_POST['area'];
            $remark = $_POST['remark'];
            $IsActive = $_POST['IsActive'];

            
                $query ="SELECT Node_Cd FROM NodeMaster WHERE Node_Cd = $node_Cd;";
                $chkNode = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                if (sizeof($chkNode) > 0) 
                {
                    $query1 ="UPDATE NodeMaster SET
                    NodeName = '$nodeName',
                    NodeNameMar = N'$nodeNameMar',
                    Ac_No = '$assembly_no',
                    Ward_No = '$wardNo',
                    Address = '$address',
                    Area = '$area',
                    Remark = N'$remark',
                    IsActive = $IsActive,
                    UpdatedByUser = '$userName',
                    UpdatedDate = GETDATE()
                    WHERE Node_Cd = $node_Cd;";

                   $UpdateNode = $db->RunQueryData($query1, $electionName, $developmentMode);
                   if($UpdateNode){
                        $data["error"] = false;
                        $data["message"] = "Node Updated successfully!";
                    } 
                }else{

                    $query1 ="SELECT Node_Cd FROM NodeMaster WHERE NodeName = '$nodeName' AND Ward_No = $wardNo AND IsActive = 1 ;";
                    $chkNode = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);
                    // echo $query1;
                    if (sizeof($chkNode) > 0) 
                    {
                        $data["error"] = true;
                        $data["message"] = "Node already present!";

                    }
                    else
                    {

                        $query2 ="INSERT INTO NodeMaster (NodeName, NodeNameMar, Ac_No, Ward_No, Address, Area, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ('$nodeName', N'$nodeNameMar', '$assembly_no', '$wardNo', '$address', '$area', N'$remark', $IsActive, GETDATE(), '$userName');";
                        $InsertNode = $db->RunQueryData($query2, $electionName, $developmentMode);   
                        // echo $query2;
                        if($InsertNode){
                            $data["error"] = false;
                            $data["message"] = "Node Added successfully!";
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
