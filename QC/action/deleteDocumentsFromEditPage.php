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
    $DocumentName = '';
    $DeleteDocumentofShop = array();

    $action = $_GET['action'];
    $Shop_Cd = $_GET['Shop_Cd'];
    $Document_Cd = $_GET['Document_Cd'];


    $querySel = "SELECT Shop_Cd FROM ShopMaster WHERE Shop_Cd = $Shop_Cd AND IsActive = 1";
    $dataSel = $db->ExecutveQuerySingleRowSALData($querySel, $electionName, $developmentMode);

    if(sizeof($dataSel)>0)
    {
            $sql2 = "UPDATE ShopDocuments SET IsActive = 0, 
                UpdatedByUser = '$updatedByUser', UpdatedDate = GETDATE() 
                WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $Document_Cd AND IsActive = 1";
            $executeDeleteDocShop = $db->RunQueryData($sql2, $electionName, $developmentMode);

            if($executeDeleteDocShop){
                $DeleteDocumentofShop = array('Flag' => 'D' );
            }

        // $DeleteDocumentofShop = $db->DeleteDocumentofShop($userName, $appName, $electionName, $developmentMode,
        //                     $Shop_Cd, $Document_Cd, $updatedByUser);
    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error!! Document Not Deleted!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success2='.$success."&tab=upload");
        echo "";
    }



    if (sizeof($DeleteDocumentofShop) > 0) {

        $flag = $DeleteDocumentofShop['Flag'];

        if($flag == 'D') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Document Deleted!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success2='.$success."&tab=upload");
        }
    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success2='.$success."&tab=upload");
    }

    // header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');
?>
