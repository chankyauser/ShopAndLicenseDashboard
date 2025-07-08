<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $updatedByUser = $userName;
    
    $action = '';
    $Shop_Cd = '';
    $Status = '';
    $remark = '';

    $UpdateStatusRemark = array();

    $action = $_POST['action'];
    $Shop_Cd = $_POST['Shop_Cd'];
    $Status = $_POST['status'];
    $remark = $_POST['remark'];
            
    $querySel = "SELECT Shop_Cd FROM ShopMaster WHERE Shop_Cd = $Shop_Cd AND IsActive = 1";
    $dataSel = $db->ExecutveQuerySingleRowSALData($querySel, $electionName, $developmentMode);

    if(sizeof($dataSel)>0)
    {
        $sql2 = "UPDATE ShopMaster 
                    SET 
                        ShopStatus = '$Status',
                        ShopStatusRemark = N'$remark',
                        ShopStatusDate = GETDATE(),
                        UpdatedDate  = GETDATE(),
                        UpdatedByUser = '$updatedByUser'
                    WHERE Shop_Cd = $Shop_Cd;";
        $executeStatusShop = $db->RunQueryData($sql2, $electionName, $developmentMode);

        if($executeStatusShop){
            $UpdateStatusRemark = array('Flag' => 'U' );
        }  
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error!! Data Not Updated!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success);
    }


    if (sizeof($UpdateStatusRemark) > 0) {

        $flag = $UpdateStatusRemark['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success);
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success);
        } 
    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success);
    }

// header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');
?>
