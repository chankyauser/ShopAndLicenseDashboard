<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];


    $query12 = "SELECT Document_Cd, DocumentName
            FROM ShopDocumentMaster WHERE IsActive = 1;";

    $DocumentUploadList = $db->ExecutveQueryMultipleRowSALData($query12, $electionName, $developmentMode);

    $updatedByUser = $userName;
    
    $Shop_Cd = '';

    $FileURL = '';
    
    $UploadShopDocuments = array();
    $action = '';
    $ShopName = '';    

    $Shop_Cd = $_POST['Shop_Cd'];
    $ShopName = $_POST['ShopName'];
    $action = $_POST['action'];

    $ShopNewName = preg_replace('/\s+/', '', $ShopName);


    foreach($DocumentUploadList as $list){

                $Document_Cd = $list['Document_Cd'];
                $DocumentName = $list['DocumentName'];
      
    // if(isset($_POST["fileupload_$Document_Cd"])){
        
         if(isset($_FILES["fileupload_$Document_Cd"]['name']))
        {
            
            $temp = explode(".", $_FILES["fileupload_$Document_Cd"]["name"]);
            $DocumentNameNew = preg_replace('/\s+/', '', $DocumentName);
            $DocumentNameNew = substr($DocumentNameNew, 0, -5); 
            
            $target_path1 = "../uploads/ShopDocuments/".$ShopNewName."/";

            if(!is_dir($target_path1)){
                mkdir($target_path1, 0755);
              }

            $NewDocCd = $Document_Cd;

            $target_filename = round(microtime(true)) . '_' . $electionName . '_' .$ShopNewName. '_' .$DocumentNameNew.'_'.$Document_Cd. '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;
            
            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            // Valid extensions
            $valid_ext = array("jpg","png","jpeg","pdf");
            

            if(in_array($file_extension,$valid_ext))
            {            
                if (move_uploaded_file($_FILES["fileupload_$Document_Cd"]['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $FileURL = $new_link . $target_path1;
                }
            }
        }

    }


    $querySel= "SELECT TOP (1) * FROM ShopDocuments
            WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $NewDocCd AND IsActive = 1;";
    $dbDoc = new DbOperation();
    $getShopDoc = $dbDoc->ExecutveQuerySingleRowSALData($querySel, $electionName, $developmentMode);

    if(sizeof($getShopDoc)>0){
        $dbDoc1 = new DbOperation();
        $sql2 = "UPDATE ShopDocuments SET FileURL = N'$FileURL', UpdatedByUser = '$updatedByUser', UpdatedDate = GETDATE() 
            WHERE Shop_Cd = $Shop_Cd AND Document_Cd = $NewDocCd AND IsActive = 1;";
        $executeDocUploadShop = $dbDoc1->RunQueryData($sql2, $electionName, $developmentMode);
        if($executeDocUploadShop){
            $UploadShopDocuments = array('Flag' => 'U' );
        }
    }else{
        $dbDoc1 = new DbOperation();
        $sql2 = "INSERT INTO ShopDocuments (Shop_Cd, Document_Cd, FileURL, IsActive, UpdatedDate, UpdatedByUser)
                VALUES ($Shop_Cd, $NewDocCd, N'$FileURL', 1, GETDATE(), '$updatedByUser');";
        $executeDocUploadShop = $dbDoc1->RunQueryData($sql2, $electionName, $developmentMode);
        if($executeDocUploadShop){
            $UploadShopDocuments = array('Flag' => 'I' );
        }
    }


    // $UploadShopDocuments = $db->UploadShopDocuments($userName, $appName, $electionName, $developmentMode,
    //             $Shop_Cd, $action, $FileURL, $NewDocCd, $updatedByUser);




    if (sizeof($UploadShopDocuments) > 0) {

        $flag = $UploadShopDocuments['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success1='.$success."&tab=upload");
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success1='.$success."&tab=upload");
        } 
    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success1='.$success."&tab=upload");
    }
?>