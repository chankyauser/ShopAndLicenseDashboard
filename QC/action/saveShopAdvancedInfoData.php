<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $updatedByUser = $userName;
    

    
    $Shop_Cd = '';

    $ParwanaType = '';
    $NewRegistrationofParwana = '';
    $EstablishmentCategory = '';

    $BoardID1 = '';
    $BoardType1 = '';
    $BoardHeight1 = '';
    $BoardWidth1 = '';
    $BoardType1Image = '';

    $BoardID2 = '';
    $BoardType2 = '';
    $BoardHeight2 = '';
    $BoardWidth2 = '';
    $BoardType2Image = '';

    $BoardID3 = '';
    $BoardType3 = '';
    $BoardHeight3 = '';
    $BoardWidth3 = '';
    $BoardType3Image = '';

    $MunicipalWardNumber = '';
    $ShopOwnerHomeAddress = '';
    $EstablishmentArea = '';
    $EstablishmentAreaCategory = '';
    $Owned_Rented = '';
    $Owned_RentedTime = '';
    $ImagesofEstablishment = '';
    $ImagesofEstablishment2 = '';


    $UploadShopAdvancedInfoData = array();
 
        $action = '';
        $action = $_POST['action'];
        
        $Shop_Cd = $_POST['Shop_Cd'];
        $ParwanaType = $_POST['ParwanaType'];
        $NewRegistrationofParwana = $_POST['NewRegistrationofParwana'];
        $EstablishmentCategory = $_POST['EstablishmentCategory'];
        
        $BoardID1 = $_POST['BoardID1'];
        $BoardType1 = $_POST['BoardType1'];
        $BoardHeight1 = $_POST['BoardHeight1'];
        $BoardWidth1 = $_POST['BoardWidth1'];

        $BoardID2 = $_POST['BoardID2'];
        $BoardType2 = $_POST['BoardType2'];
        $BoardHeight2 = $_POST['BoardHeight2'];
        $BoardWidth2 = $_POST['BoardWidth2'];

        $BoardID3 = $_POST['BoardID3'];
        $BoardType3 = $_POST['BoardType3'];
        $BoardHeight3 = $_POST['BoardHeight3'];
        $BoardWidth3 = $_POST['BoardWidth3'];

        $MunicipalWardNumber = $_POST['MunicipalWardNumber'];
        $ShopOwnerHomeAddress = $_POST['ShopOwnerHomeAddress'];
        $EstablishmentArea = $_POST['EstablishmentArea'];
        $EstablishmentAreaCategory = $_POST['EstablishmentAreaCategory'];
        $Owned_Rented = $_POST['Owned_Rented'];
        $Owned_RentedTime = $_POST['Owned_RentedTime'];

        $oldBoardType1Image = $_POST['oldBoardType1Image'];
        $oldBoardType2Image = $_POST['oldBoardType2Image'];
        $oldBoardType3Image = $_POST['oldBoardType3Image'];

        $oldImagesofEstablishment = $_POST['oldImagesofEstablishment'];
        $oldImagesofEstablishment2 = $_POST['oldImagesofEstablishment2'];
        

//Board Type 1 Image 1 Upload Code Starts-----------------------------------------------------------------------------------
        if(isset($_FILES['BoardType1Image']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopAdvanceInfo/Board_Type_1_Image/";

            $temp = explode(".", $_FILES["BoardType1Image"]["name"]);
            $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;

            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
         
            // Valid extensions
            $valid_ext = array("jpg","png","jpeg");

            if(in_array($file_extension,$valid_ext))
            {
                if (move_uploaded_file($_FILES['BoardType1Image']['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $BoardType1Image = $new_link . $target_path1;
                }
            }
        }

        if(isset($_FILES['BoardType1Image']['name']) && empty($_FILES['BoardType1Image']['name']))
        {
            $BoardType1Image = $oldBoardType1Image;
        }

//Board Type 1 Image 1 Upload Code Ends-----------------------------------------------------------------------------------

//Board Type 2 Image 2 Upload Code Starts----------------------------------------------------------------------------------------------

        if(isset($_FILES['BoardType2Image']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopAdvanceInfo/Board_Type_2_Image/";

            $temp = explode(".", $_FILES["BoardType2Image"]["name"]);
            $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;

            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
         
            // Valid extensions
            $valid_ext = array("jpg","png","jpeg");

            if(in_array($file_extension,$valid_ext))
            {
                if (move_uploaded_file($_FILES['BoardType2Image']['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $BoardType2Image = $new_link . $target_path1;
                }
            }
        }
        if(isset($_FILES['BoardType2Image']['name']) && empty($_FILES['BoardType2Image']['name']))
        {
            $BoardType2Image = $oldBoardType2Image;
        }

//Board Type 2 Image 2 Upload Code Ends----------------------------------------------------------------------------------------------

//Board Type 3 Image 3 Upload Code Starts----------------------------------------------------------------------------------------------

if(isset($_FILES['BoardType3Image']['name']))
{
    //Starts from here 
    $target_path1 = "../uploads/ShopAdvanceInfo/Board_Type_3_Image/";

    $temp = explode(".", $_FILES["BoardType3Image"]["name"]);
    $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
    $target_path1 = $target_path1 . $target_filename;

    // file extension
    $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
 
    // Valid extensions
    $valid_ext = array("jpg","png","jpeg");

    if(in_array($file_extension,$valid_ext))
    {
        if (move_uploaded_file($_FILES['BoardType3Image']['tmp_name'], $target_path1)) 
        {

            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                    "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI'];
    
            $file_Name_php = basename($link);
            $new_link = str_replace($file_Name_php, '', $link);
    
            $BoardType3Image = $new_link . $target_path1;
        }
    }
}

    if(isset($_FILES['BoardType3Image']['name']) && empty($_FILES['BoardType3Image']['name']))
    {
        $BoardType3Image = $oldBoardType3Image;
    }
    
//Board Type 3 Image 3 Upload Code Ends----------------------------------------------------------------------------------------------

//Establishment Image 1 Inside Upload Code Starts----------------------------------------------------------------------------------------------

if(isset($_FILES['ImagesofEstablishment']['name']))
{
    //Starts from here 
    $target_path1 = "../uploads/ShopAdvanceInfo/Establishment_Image_1_Inside/";

    $temp = explode(".", $_FILES["ImagesofEstablishment"]["name"]);
    $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
    $target_path1 = $target_path1 . $target_filename;

    // file extension
    $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
 
    // Valid extensions
    $valid_ext = array("jpg","png","jpeg");

    if(in_array($file_extension,$valid_ext))
    {
        if (move_uploaded_file($_FILES['ImagesofEstablishment']['tmp_name'], $target_path1)) 
        {

            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                    "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI'];
    
            $file_Name_php = basename($link);
            $new_link = str_replace($file_Name_php, '', $link);
    
            $ImagesofEstablishment = $new_link . $target_path1;
        }
    }
}
    if(isset($_FILES['ImagesofEstablishment']['name']) && empty($_FILES['ImagesofEstablishment']['name']))
    {
        $ImagesofEstablishment = $oldImagesofEstablishment;
    }

//Establishment Image 1 Inside Upload Code Ends----------------------------------------------------------------------------------------------

//Establishment Image 2 Inside Upload Code Starts----------------------------------------------------------------------------------------------

if(isset($_FILES['ImagesofEstablishment2']['name']))
{
    //Starts from here 
    $target_path1 = "../uploads/ShopAdvanceInfo/Establishment_Image_2_Inside/";

    $temp = explode(".", $_FILES["ImagesofEstablishment2"]["name"]);
    $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
    $target_path1 = $target_path1 . $target_filename;

    // file extension
    $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
 
    // Valid extensions
    $valid_ext = array("jpg","png","jpeg");

    if(in_array($file_extension,$valid_ext))
    {
        if (move_uploaded_file($_FILES['ImagesofEstablishment2']['tmp_name'], $target_path1)) 
        {

            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                    "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI'];
    
            $file_Name_php = basename($link);
            $new_link = str_replace($file_Name_php, '', $link);
    
            $ImagesofEstablishment2 = $new_link . $target_path1;
        }
    }
}
    if(isset($_FILES['ImagesofEstablishment2']['name']) && empty($_FILES['ImagesofEstablishment2']['name']))
    {
        $ImagesofEstablishment2 = $oldImagesofEstablishment2;
    }

//Establishment Image 2 Inside Upload Code Ends----------------------------------------------------------------------------------------------





$sql1 = "SELECT top (1) Shop_Cd FROM ShopMaster
            WHERE Shop_Cd = $Shop_Cd ; ";
$executeSql2=false;
$db1=new DbOperation();
$isShopExists = $db1->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
    $ParwanaDetCd=0;
    if( sizeof($isShopExists) > 0 )
    {
        $dbPRSel=new DbOperation();
        $querySelParwanaDet = "SELECT ParwanaDetCd FROM ParwanaDetails WHERE Parwana_Cd = $ParwanaType AND IsRenewal = $NewRegistrationofParwana AND IsActive = 1";
        $dataSelParwanaDet = $dbPRSel->ExecutveQuerySingleRowSALData($querySelParwanaDet, $electionName, $developmentMode);
        $ParwanaDetCd = $dataSelParwanaDet["ParwanaDetCd"];

   
        $dbsql12=new DbOperation();
        $sql2 = "UPDATE ShopMaster SET
                    ParwanaDetCd = $ParwanaDetCd,  
                    ShopCategory = '$EstablishmentCategory',
                    MuncipalWN = '$MunicipalWardNumber',
                    ShopOwnerAddress = N'$ShopOwnerHomeAddress',
                    ShopDimension = '$EstablishmentArea',
                    ShopArea_Cd = $EstablishmentAreaCategory,
                    ShopOwnStatus = '$Owned_Rented',
                    ShopOwnPeriod = $Owned_RentedTime,
                    ShopInsideImage1 = N'$ImagesofEstablishment',
                    ShopInsideImage2 = N'$ImagesofEstablishment2',
                    UpdatedByUser = N'$updatedByUser',
                    UpdatedDate = GETDATE()
                WHERE Shop_Cd = $Shop_Cd;";
        
        $executeSql2 = $dbsql12->RunQueryData($sql2, $electionName, $developmentMode);

        if(!empty($BoardType1) ){
            if(empty($BoardID1) ){
                $BoardID1 = 0;
            }
            $selB1Query = "SELECT BoardID FROM ShopBoardDetails WHERE BoardID = $BoardID1 AND Shop_Cd = $Shop_Cd AND IsActive = 1";
            $dbB1=new DbOperation();
            $dataSingleB1 = $dbB1->ExecutveQuerySingleRowSALData($selB1Query, $electionName, $developmentMode);
            if(sizeof($dataSingleB1)>0){

                $B1Query = "UPDATE ShopBoardDetails SET
                                BoardType = '$BoardType1',
                                BoardHeight = '$BoardHeight1',
                                BoardWidth = '$BoardWidth1',
                                BoardPhoto = N'$BoardType1Image',
                                UpdatedByUser = N'$updatedByUser',
                                UpdatedDate = GETDATE()
                            WHERE BoardID = $BoardID1 AND Shop_Cd = $Shop_Cd AND IsActive = 1;";
            }else{
                $B1Query = "INSERT INTO ShopBoardDetails(BoardType,BoardHeight,BoardWidth,Shop_Cd,BoardPhoto,IsActive,UpdatedDate,UpdatedByUser)
                            VALUES('$BoardType1', '$BoardHeight1', '$BoardWidth1', $Shop_Cd, N'$BoardType1Image',1,GETDATE(),N'$updatedByUser')";
            }
            
            $executeB1 = $dbB1->RunQueryData($B1Query, $electionName, $developmentMode);
        }

        if(!empty($BoardType2)){
            if(empty($BoardID2) ){
                $BoardID2 = 0;
            }
            $selB2Query = "SELECT BoardID FROM ShopBoardDetails WHERE BoardID = $BoardID2 AND Shop_Cd = $Shop_Cd AND IsActive = 1";
            $dbB2=new DbOperation();
            $dataSingleB2 = $dbB2->ExecutveQuerySingleRowSALData($selB2Query, $electionName, $developmentMode);
        
            if(sizeof($dataSingleB2)>0){
                $B2Query = "UPDATE ShopBoardDetails SET
                                BoardType = '$BoardType2',
                                BoardHeight = '$BoardHeight2',
                                BoardWidth = '$BoardWidth2',
                                BoardPhoto = N'$BoardType2Image',
                                UpdatedByUser = N'$updatedByUser',
                                UpdatedDate = GETDATE()
                            WHERE BoardID = $BoardID2 AND Shop_Cd = $Shop_Cd AND IsActive = 1";
            }else{
                $B2Query = "INSERT INTO ShopBoardDetails(BoardType,BoardHeight,BoardWidth,Shop_Cd,BoardPhoto,IsActive,UpdatedDate,UpdatedByUser)
                            VALUES('$BoardType2', '$BoardHeight2', '$BoardWidth2', $Shop_Cd, N'$BoardType2Image',1,GETDATE(),N'$updatedByUser')";
            }

            $executeB2 = $dbB2->RunQueryData($B2Query, $electionName, $developmentMode);
        }

        if(!empty($BoardType3)){
            if(empty($BoardID2) ){
                $BoardID3 = 0;
            }
            $selB3Query = "SELECT BoardID FROM ShopBoardDetails WHERE BoardID = $BoardID3 AND Shop_Cd = $Shop_Cd AND IsActive = 1";
            $dbB3=new DbOperation();
            $dataSingleB3 = $dbB3->ExecutveQuerySingleRowSALData($selB3Query, $electionName, $developmentMode);

            if(sizeof($dataSingleB3)>0){
                $B3Query = "UPDATE ShopBoardDetails SET
                                BoardType = '$BoardType3',
                                BoardHeight = '$BoardHeight3',
                                BoardWidth = '$BoardWidth3',
                                BoardPhoto = N'$BoardType3Image',
                                UpdatedByUser = N'$updatedByUser',
                                UpdatedDate = GETDATE()
                            WHERE BoardID = $BoardID3 AND Shop_Cd = $Shop_Cd AND IsActive = 1";
            }else{
                $B3Query = "INSERT INTO ShopBoardDetails(BoardType,BoardHeight,BoardWidth,Shop_Cd,BoardPhoto,IsActive,UpdatedDate,UpdatedByUser)
                            VALUES('$BoardType3', '$BoardHeight3', '$BoardWidth3', $Shop_Cd, N'$BoardType3Image',1,GETDATE(),N'$updatedByUser')";
            }    

            $executeB3 = $dbB3->RunQueryData($B3Query, $electionName, $developmentMode);
        }
        

        if($executeSql2){
            $UploadShopAdvancedInfoData = array('Flag' => 'U' );
        }


    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error!! Shop Not Found!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=advance-info");
    }


    if (sizeof($UploadShopAdvancedInfoData) > 0) {

        $flag = $UploadShopAdvancedInfoData['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=advance-info");
        } else if($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=advance-info");
        } 
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=advance-info");
    }

    // header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');
?>
